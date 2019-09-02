<?php
namespace app\controllers\admin;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use app\models\Apply;
use app\models\Model;

class PublicController extends Controller
{
    public $layout       = false;
    public $beforeAction = true;
    public $checkLogin   = true;

    public function beforeAction($action)
    {
        if($this->beforeAction){
            if(!$this->isInstalled()){
                return $this->redirect(['home/install/step1'])->send();
            }

            if($this->checkLogin && Yii::$app->user->isGuest){
                return $this->redirect(['home/account/login'])->send();
            }

            if(!Yii::$app->user->identity->isAdmin){
                return $this->error('抱歉，您无权访问');
            }
        }

        return true;
    }

    /** 展示模板
     * @param $view
     * @param array $params
     * @return string
     */
    public function display($view, $params = [])
    {
        $account = Yii::$app->user->identity;

        $params['creater_id'] = $account->id;
        $params['check_status'] = Apply::CHECK_STATUS;
        $params['order_by'] = 'id desc';

        $notify = Apply::findModel()->search($params);

        $params['notify']  = $notify;
        $params['account'] = $account;

        $params['installed_at'] = Model::findModel()->getInstallTime();

        exit($this->render($view . '.html', $params));
    }

    /**
     * 成功消息提示
     * @param string $message 成功信息
     * @param int $jumpSeconds 延迟时间，单位秒
     * @param string $jumpUrl 跳转链接
     * @return string
     */
    public function success($message, $jumpSeconds = 1, $jumpUrl = '', $model = null)
    {
        $jumpUrl = $jumpUrl ? Url::toRoute($jumpUrl) : \Yii::$app->request->referrer;

        return $this->display('/home/public/message', ['flag' => 'success', 'message' => $message, 'time' => $jumpSeconds, 'url' => $jumpUrl, 'model' => $model]);
    }

    /**
     * 错误消息提示
     * @param string $message 错误信息
     * @param int $jumpSeconds 延迟时间，单位秒
     * @param string $jumpUrl 跳转链接
     * @return string
     */
    public function error($message, $jumpSeconds = 3, $jumpUrl = '')
    {
        $jumpUrl = $jumpUrl ? Url::toRoute($jumpUrl) : \Yii::$app->request->referrer;

        return $this->display('/home/public/message', ['flag' => 'error', 'message' => $message, 'time' => $jumpSeconds, 'url' => $jumpUrl]);
    }

    /**
     * 判断是否已经安装过
     * @return bool
     */
    public function isInstalled()
    {
        return file_exists(Yii::getAlias("@runtime") . '/install/install.lock');
    }

}
