<?php
namespace app\controllers\home;

use Yii;
use app\models\Apply;
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
        $params = Yii::$app->request->queryParams;
        $params['user_id'] = Yii::$app->user->identity->id;

        $model = LoginLog::findModel()->search($params);

        return $this->display('login', ['model' => $model]);
    }

    /**
     * 申请历史
     * @return string
     */
    public function actionApply()
    {
        $params = Yii::$app->request->queryParams;

        $params['creater_id'] = Yii::$app->user->identity->id;
        $params['pass_status'] = Apply::PASS_STATUS;
        $params['refuse_status'] = Apply::REFUSE_STATUS;
        $params['order_by'] = 'checked_at desc';

        $model = Apply::findModel()->search($params);

        return $this->display('apply', ['model' => $model]);
    }

}
