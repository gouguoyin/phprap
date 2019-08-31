<?php
namespace app\controllers\home;

use Yii;
use yii\web\Response;
use app\models\Member;
use app\models\Project;
use app\models\member\CreateMember;
use app\models\member\UpdateMember;
use app\models\member\RemoveMember;

class MemberController extends PublicController
{
    /**
     * 添加成员
     * @param $project_id 项目ID
     * @return array|string
     */
    public function actionCreate($project_id)
    {
        $request = Yii::$app->request;

        $project = Project::findModel(['encode_id' => $project_id]);

        $model   = new CreateMember();

        if($request->isPost){

            Yii::$app->response->format = Response::FORMAT_JSON;

            $model->project_id = $project->id;
            $model->join_type  = Member::PASSIVE_JOIN_TYPE;

            if(!$model->load($request->post())){
                return ['status' => 'error', 'message' => '数据加载失败'];
            }

            if ($model->store()) {
                return ['status' => 'success', 'message' => '添加成功'];
            }

            return ['status' => 'error', 'message' => $model->getErrorMessage(), 'label' => $model->getErrorLabel()];

        }

        return $this->display('create', ['project' => $project, 'member' => $model]);
    }

    /**
     * 编辑成员
     * @param $id 成员ID
     * @return array|string
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;

        $model   = UpdateMember::findModel(['encode_id' => $id]);

        if($request->isPost){

            Yii::$app->response->format = Response::FORMAT_JSON;

            if(!$model->load($request->post())){
                return ['status' => 'error', 'message' => '数据加载失败'];
            }

            if ($model->store()) {
                return ['status' => 'success', 'message' => '编辑成功'];
            }

            return ['status' => 'error', 'message' => $model->getErrorMessage(), 'label' => $model->getErrorLabel()];

        }

        return $this->display('update', ['member' => $model]);
    }

    /**
     * 选择成员
     * @param $project_id 项目ID
     * @param $name 搜索词
     * @return array
     */
    public function actionSelect($project_id, $name)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $project = Project::findModel(['encode_id' => $project_id]);

        $notMembers = $project->getNotMembers(['name' => $name]);

        $user = [];

        foreach ($notMembers as $k => $member){
            $user[$k]['id']   = $member->id;
            $user[$k]['name'] = $member->fullName;
        }

        return $user;
    }

    /**
     * 移除成员
     * @param $id 成员ID
     * @return array
     */
    public function actionRemove($id)
    {
        $request = Yii::$app->request;

        $model = RemoveMember::findModel(['encode_id' => $id]);

        if($request->isPost){

            Yii::$app->response->format = Response::FORMAT_JSON;

            if (!$model->load($request->post())) {
                return ['status' => 'error', 'message' => '数据加载失败'];
            }

            if ($model->remove()) {
                return ['status' => 'success', 'message' => '移出成功'];
            }

            return ['status' => 'error', 'message' => $model->getErrorMessage(), 'label' => $model->getErrorLabel()];
        }

        return $this->display('remove', ['member' => $model]);
    }

    /**
     * 成员详情
     * @param $id 成员ID
     * @return string
     */
    public function actionShow($id)
    {
        $member = Member::findModel(['encode_id' => $id]);

        return $this->display('show', ['member' => $member]);
    }

}
