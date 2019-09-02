<?php
namespace app\controllers\home;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use app\models\Apply;
use app\models\Config;

class PublicController extends Controller
{
    /**
     * 是否启用布局
     * @var bool
     */
    public $layout = false;

    /**
     * 是否检测登录
     * @var bool
     */
    public $checkLogin = true;

    public function beforeAction($action)
    {
        if(!$this->isInstalled()){
            return $this->redirect(['home/install/step1'])->send();
        }

        $config = Config::findOne(['type' => 'safe']);

        $ip_white_list = array_filter(explode("\r\n", trim($config->ip_white_list)));
        $ip_black_list = array_filter(explode("\r\n", trim($config->ip_black_list)));

        $ip = Yii::$app->request->userIP;

        if($ip_white_list && !in_array($ip, $ip_white_list)){
            return $this->error('抱歉，该IP不在可访问IP段内');
        }

        if($ip_black_list && in_array($ip, $ip_black_list)){
            return $this->error('抱歉，该IP不允许访问');
        }

        if($this->checkLogin && Yii::$app->user->isGuest){
            return $this->redirect(['home/account/login','callback' => Url::current()])->send();
        }

        return true;
    }

    /** 展示模板
     * @param string $view 视图路径
     * @param array $params
     * @return string
     */
    public function display($view, $params = [])
    {
        if(!Yii::$app->user->isGuest){
            $notify  = Apply::findModel()->search(['check_status' => Apply::CHECK_STATUS, 'order_by' => 'id desc']);
            $account = Yii::$app->user->identity;

            $params['notify']  = $notify;
            $params['account'] = $account;
        }

        exit($this->render($view . '.html', $params));
    }

    /**
     * 成功消息提示
     * @param string $message 成功信息
     * @param int $jumpSeconds 延迟时间，单位秒
     * @param string $jumpUrl 跳转链接
     * @return string
     */
    public function success($message, $jumpSeconds = 1, $jumpUrl = '')
    {
        $jumpUrl = $jumpUrl ? Url::toRoute($jumpUrl) : \Yii::$app->request->referrer;

        return $this->display('/home/public/message', ['flag' => 'success', 'message' => $message, 'time' => $jumpSeconds, 'url' => $jumpUrl]);
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
