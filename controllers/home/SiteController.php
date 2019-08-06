<?php
namespace app\controllers\home;

use Yii;

class SiteController extends PublicController
{

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {

        return $this->redirect(['project/select']);

    }

}
