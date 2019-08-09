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
            return $this->redirect(['home/account/login'])->send();
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

        if($account->id){
            $params['check_status'] = Apply::CHECK_STATUS;
            $params['order_by']     = 'id desc';

            $notify = Apply::findModel()->search($params);

            $params['notify']  = $notify;
            $params['account'] = $account;
        }
        
        exit($this->render($view . '.html', $params));
    }

    /**
     * 成功消息提示
     * @param $message 提示信息
     * @param int $jumpSeconds 延迟时间
     * @param string $jumpUrl 跳转链接
     * @param null $model
     * @return string
     */
    public function success($message, $jumpSeconds = 1, $jumpUrl = '')
    {
        $jumpUrl = $jumpUrl ? Url::toRoute($jumpUrl) : \Yii::$app->request->referrer;

        return $this->display('/home/public/message', ['flag' => 'success', 'message' => $message, 'time' => $jumpSeconds, 'url' => $jumpUrl]);
    }

    /**
     * 错误消息提示
     * @param $message
     * @param int $jumpSeconds
     * @param string $jumpUrl
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
