<?php
namespace app\controllers\home;

use Yii;

class SiteController extends PublicController
{
    /**
     * 前台主页
     * @return \yii\web\Response
     */
    public function actionIndex()
    {
        return $this->redirect(['project/select']);
    }

}
