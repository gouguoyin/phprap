<?php
namespace app\controllers\home;

use Yii;
use yii\db\Exception;
use yii\web\Response;
use app\models\Member;
use app\models\Account;
use app\models\loginLog\CreateLog;

class InstallController extends PublicController
{
    public function beforeAction($action)
    {
        if($this->isInstalled()){
            $app_version = Yii::$app->params['app_version'];
            exit('PHPRAP V' . $app_version . ' 已安装过，请不要重复安装，如果需要重新安装，请先删除runtime/install/install.lock');
        }
        return true;
    }

    /**
     * 安装步骤一，环境检测
     * @return array|string
     */
    public function actionStep1()
    {
        $request = Yii::$app->request;
        if($request->isPost){
            Yii::$app->response->format = Response::FORMAT_JSON;
            Yii::$app->cache->set('step', 1);
            return ['status' => 'success', 'callback' => url('home/install/step2')];
        }

        $step1 = [
            'runtime' => [
                'have_chmods'    => $this->getChmodsLabel(Yii::getAlias("@runtime")),
                'require_chmods' => '可读、可写',
                'check_chmod'    => is_writable(Yii::getAlias("@runtime")),
            ],
            'runtime/cache' => [
                'have_chmods'    => $this->getChmodsLabel(Yii::getAlias("@runtime") . '/cache'),
                'require_chmods' => '可读、可写',
                'check_chmod'    => is_writable(Yii::getAlias("@runtime") . '/cache'),
            ],
            'runtime/install' => [
                'have_chmods'    => $this->getChmodsLabel(Yii::getAlias("@runtime") . '/install'),
                'require_chmods' => '可读、可写',
                'check_chmod'    => is_writable(Yii::getAlias("@runtime") . '/install'),
            ],
            'configs/db.php' => [
                'have_chmods'    => $this->getChmodsLabel(Yii::getAlias("@app") . '/configs/db.php'),
                'require_chmods' => '可读、可写',
                'check_chmod'    => is_writable(Yii::getAlias("@app") . '/configs/db.php'),
            ],
        ];
        return $this->display('/install/step1', ['step1' => $step1]);
    }

    /**
     * 安装步骤二，初始化数据库并将数据库信息写入配置文件
     * @return array|string|\yii\web\Response
     */
    public function actionStep2()
    {
        $request = Yii::$app->request;
        if(Yii::$app->cache->get('step') != 1){
            return $this->redirect(['home/install/step1']);
        }

        if($request->isPost){
            Yii::$app->response->format = Response::FORMAT_JSON;

            $step2 = $request->post('Step2');

            $db = [
                'dsn'      => "mysql:host={$step2['host']};port={$step2['port']}}",
                'username' => $step2['username'],
                'password' => $step2['password'],
                'charset'  => 'utf8',
            ];

            // 判断数据库连接状态
            $connection = new \yii\db\Connection($db);

            try {
                $connection->open();
            } catch(Exception $e) {
                return ['status' => 'error', 'message' => '数据库连接失败，请检查数据库配置信息是否正确'];
            }

            if(!$connection->isActive){
                return ['status' => 'error', 'message' => '当前数据库连接处于非激活状态，请检查PDO安装是否正确'];
            }

            // 创建数据库
            $sql = "CREATE DATABASE IF NOT EXISTS {$step2['dbname']} CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';";

            if(!$connection->createCommand($sql)->execute()){
                return ['status' => 'error', 'message' => "数据库 {$step2['dbname']} 创建失败，没有创建数据库权限，请手动创建数据库"];
            }

            $db['dsn']         = "mysql:host={$step2['host']};port={$step2['port']};dbname={$step2['dbname']}";
            $db['tablePrefix'] = $step2['prefix'];
            $db = ['class' => 'yii\db\Connection'] + $db;

            $config = "<?php\r\nreturn\n" . var_export($db,true) . "\r\n?>";

            // 将数据库配置信息写入配置文件
            if(file_put_contents(Yii::getAlias("@app") . '/configs/db.php', $config) === false){
                return ['status' => 'error', 'message' => '数据库配置文件写入错误，请检查configs/db.php文件是否有可写权限'];
            }

            Yii::$app->cache->set('step', 2);

            return ['status' => 'success', 'callback' => url('home/install/step3')];
        }

        return $this->display('/install/step2');
    }

    /**
     * 安装步骤三，创建总管理员
     * @return string|\yii\web\Response
     */
    public function actionStep3()
    {
        $request = Yii::$app->request;

        if(Yii::$app->cache->get('step') != 2){
            return $this->redirect(['home/install/step2']);
        }

        if($request->isPost){

            Yii::$app->response->format = Response::FORMAT_JSON;

            $step3 = $request->post('Step3');

            // 开启事务
            $transaction = Yii::$app->db->beginTransaction();

            try {
                // 数据库初始化
                $init_sql = $this->getInitSql();
                Yii::$app->db->createCommand($init_sql)->execute();

                // 插入管理员
                $account = new Account();

                $account->status = $account::ACTIVE_STATUS;
                $account->type   = $account::ADMIN_TYPE;
                $account->name   = $step3['name'];
                $account->email  = $step3['email'];
                $account->ip     = $account->getUserIp();
                $account->location   = $account->getLocation();
                $account->created_at = date('Y-m-d H:i:s');

                $account->setPassword($step3['password']);
                $account->generateAuthKey();

                if(!$account->save()){
                    $transaction->rollBack();
                    return ['status' => 'error', 'message' => $account->getErrorMessage(), 'label' => $account->getErrorLabel()];
                }

                // 默认加入测试项目
                $member = new Member();
                $member->encode_id    = $member->createEncodeId();
                $member->project_id   = 1;
                $member->user_id      = $account->id;
                $member->join_type    = $member::PASSIVE_JOIN_TYPE;
                $member->project_rule = 'look,export,history';
                $member->env_rule     = 'look,create,update,delete';
                $member->module_rule  = 'look,create,update';
                $member->api_rule     = 'look,create,update,export,debug,history';
                $member->member_rule  = 'look,create,update';
                $member->template_rule  = 'look,create,update';
                $member->creater_id   = 1;
                $member->created_at   = date('Y-m-d H:i:s');

                if(!$member->save()){
                    $transaction->rollBack();
                    return ['status' => 'error', 'message' => $member->getErrorMessage(), 'label' => $member->getErrorLabel()];
                }

                // 记录日志
                $loginLog = new CreateLog();

                $loginLog->user_id    = $account->id;
                $loginLog->user_name  = $account->name;
                $loginLog->user_email = $account->email;

                if(!$loginLog->store()){
                    $transaction->rollBack();
                    return ['status' => 'error', 'message' => $loginLog->getErrorMessage(), 'label' => $loginLog->getErrorLabel()];
                }

                // 事务提交
                $transaction->commit();

                // 保存登录状态
                $login_keep_time = config('login_keep_time', 'safe');

                Yii::$app->user->login($account, 60*60*$login_keep_time);

                Yii::$app->cache->set('step', 3);

                return ['status' => 'success', 'callback' => url('home/install/step4')];

            } catch (\Exception $e) {

                $transaction->rollBack();
                return ['status' => 'error', 'message' => '数据库初始化安装失败，' . $e->getMessage()];

            } catch (\Throwable $e) {

                $transaction->rollBack();
                return ['status' => 'error', 'message' => '数据库初始化安装失败，' . $e->getMessage()];

            }

        }

        return $this->display('/install/step3');
    }

    /**
     * 安装步骤四，显示安装过程
     * @return string|\yii\web\Response
     */
    public function actionStep4()
    {
        if(Yii::$app->cache->get('step') != 3){
            return $this->redirect(['home/install/step3']);
        }

        // 创建安装锁文件
        if(file_put_contents(Yii::getAlias("@runtime") . '/install/install.lock', json_encode(['installed_at' => date('Y-m-d H:i:s')])) === false){
            return ['status' => 'error', 'message' => '数据库锁文件写入错误，请检查 runtime/install 文件夹是否有可写权限'];
        }

        Yii::$app->cache->set('step', 4);

        // 获取所有数据表
        $sql = "show tables";
        $tables = Yii::$app->db->createCommand($sql)->queryColumn();

        return $this->display('/install/step4', ['tables' => $tables]);
    }

    // 获取权限
    private function getChmodsLabel($dirName)
    {
        $chmod = '';

        is_readable ($dirName) && $chmod = '可读、';
        is_writable ($dirName) && $chmod .= '可写、';
        is_executable ($dirName) && $chmod .= '可执行、';

        return trim($chmod, '、');
    }

    // 获取安装初始化sql语句
    private function getInitSql()
    {
        // 读取初始化数据库脚本文件内容
        $lines = file(Yii::getAlias("@runtime") .'/install/db.sql');

        $sql = "";

        // 循环排除掉不合法的sql语句
        foreach($lines as $line){

            $line = trim($line);

            if($line != ""){

                if(!($line{0} == "#" || $line{0}.$line{1} == "--")){

                    // 将表前缀替换成自定义前缀
                    $line = str_replace("doc_", Yii::$app->db->tablePrefix, $line);

                    $sql .= $line;
                }
            }
        }

        return $sql;
    }

    /** 展示模板
     * @param $view
     * @param array $params
     * @return string
     */
    public function display($view, $params = [])
    {
        exit($this->render($view . '.html', $params));
    }

}
