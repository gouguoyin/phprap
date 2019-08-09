<?php
namespace app\controllers\admin;

use Yii;
use app\models\LoginLog;

class HistoryController extends PublicController
{
    /**
     * 登录历史
     * @param $project_id
     * @return array|string
     */
    public function actionLogin()
    {
        $model = LoginLog::findModel()->search(Yii::$app->request->queryParams);

        return $this->display('login', ['model' => $model]);
    }
}
