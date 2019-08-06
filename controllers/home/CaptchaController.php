<?php

namespace app\controllers\home;

use Yii;
use yii\web\Controller;

class CaptchaController extends Controller
{

    public function actions(){
        return [
            'login' => [
                'class' => 'app\actions\CaptchaAction',
                'maxLength' => 5,
                'minLength' => 5,
                'padding' => 3,
                'height' => 35,
                'width'  => 100,
                'offset' => 1
            ],
            'register' => [
                'class' => 'app\actions\CaptchaAction',
                'maxLength' => 5,
                'minLength' => 5,
                'padding' => 3,
                'height' => 35,
                'width'  => 100,
                'offset' => 2
            ]
        ];
    }

}
