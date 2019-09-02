<?php
namespace app\controllers\home;

use Yii;
use yii\web\Response;
use app\models\Project;
use app\models\Apply;
use app\models\apply\CreateApply;
use app\models\apply\UpdateApply;
use app\models\member\CreateMember;

class ApplyController extends PublicController
{
    /**
     * 申请列表
     * @return string
     */
    public function actionIndex()
    {
        $params = Yii::$app->request->queryParams;

        $params['check_status'] = Apply::CHECK_STATUS;
        $params['order_by']     = 'id desc';

        $model = Apply::findModel()->search($params);

        return $this->display('index', ['apply' => $model]);
    }

    /**
     * 添加申请
     * @param $project_id 项目ID
     * @return array|string
     */
    public function actionCreate($project_id)
    {
        $request = Yii::$app->request;

        $model   = CreateApply::findModel();
        $project = Project::findModel(['encode_id' => $project_id]);

        if($request->isPost) {

            Yii::$app->response->format = Response::FORMAT_JSON;
            
            $model->project_id = $project->id;

            if ($model->store()) {
                return ['status' => 'success', 'message' => '申请成功，请耐心等待项目创建人审核'];
            }

            return ['status' => 'error', 'message' => $model->getErrorMessage(), 'label' => $model->getErrorLabel()];
        }

        return $this->display('create', ['apply' => $model, 'project' => $project]);
    }

    /**
     * @param $id 申请ID
     * @return array|string
     * @throws \yii\db\Exception
     */
    public function actionPass($id)
    {
        $request = Yii::$app->request;

        $model   = UpdateApply::findModel($id);

        if($request->isPost) {

            Yii::$app->response->format = Response::FORMAT_JSON;

            // 开启事务
            $transaction = Yii::$app->db->beginTransaction();

            if(!$model->load($request->post())) {
                return ['status' => 'error', 'message' => '加载数据失败','model' => 'UpdateApply'];
            }

            $model->status = Apply::PASS_STATUS;

            if(!$model->store()){
                $transaction->rollBack();
                return ['status' => 'error', 'message' => $model->getErrorMessage(), 'label' => $model->getErrorLabel()];
            }

            // 向项目成员表插入数据
            $member = CreateMember::findModel();
            $member->project_id   = $model->project_id;
            $member->user_id      = $model->user_id;
            $member->join_type    = $member::INITIATIVE_JOIN_TYPE;
            $member->project_rule = 'look';
            $member->env_rule     = 'look';
            $member->module_rule  = 'look';
            $member->api_rule     = 'look';
            $member->member_rule  = 'look';

            if(!$member->store()){
                $transaction->rollBack();
                return ['status' => 'error', 'message' => $member->getErrorMessage(), 'label' => $member->getErrorLabel()];
            }

            // 事务提交
            $transaction->commit();

            return ['status' => 'success', 'message' => '操作成功'];
        }

        return $this->display('check', ['apply' => $model]);
    }

    /**
     * 拒绝申请
     * @param $id 申请ID
     * @return array|string
     * @throws \yii\db\Exception
     */
    public function actionRefuse($id)
    {
        $request = Yii::$app->request;

        $model   = UpdateApply::findModel($id);

        if($request->isPost) {

            Yii::$app->response->format = Response::FORMAT_JSON;

            // 开启事务
            $transaction = Yii::$app->db->beginTransaction();

            if(!$model->load($request->post())) {
                return ['status' => 'error', 'message' => '加载数据失败','model' => 'UpdateApply'];
            }

            $model->status = Apply::REFUSE_STATUS;

            if(!$model->store()){
                $transaction->rollBack();
                return ['status' => 'error', 'message' => $model->getErrorMessage(), 'label' => $model->getErrorLabel()];
            }

            // 事务提交
            $transaction->commit();

            return ['status' => 'success', 'message' => '操作成功'];
        }

        return $this->display('check', ['apply' => $model]);
    }

    /**
     * 获取申请数量
     * @return array
     * @throws \Exception
     */
    public function actionNotify()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $apply = Apply::findModel()->search(['check_status' => Apply::CHECK_STATUS]);

        return ['count' => $apply->count];
    }

}
