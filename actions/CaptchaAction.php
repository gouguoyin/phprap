<?php

namespace app\actions;

use Yii;
use yii\web\Response;

class CaptchaAction extends \yii\captcha\CaptchaAction
{

    /**
     * 修复验证码刷新页面不会自动刷新的BUG
     */
    public function run()
    {
        $this->setHttpHeaders();
        Yii::$app->response->format = Response::FORMAT_RAW;
        return $this->renderImage($this->getVerifyCode(true));
    }

}
