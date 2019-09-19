<?php
namespace app\controllers\home;

use Yii;
use yii\web\Response;
use app\models\Project;
use app\models\env\CreateEnv;
use app\models\env\DeleteEnv;
use app\models\env\UpdateEnv;

class EnvController extends PublicController
{
    /**
     * 创建环境
     * @param $project_id 项目id
     * @return array|string
     */
    public function actionCreate($project_id)
    {
        $request = Yii::$app->request;

        $project = Project::findModel(['encode_id' => $project_id]);

        $model   = new CreateEnv();
        $model->project_id = $project->id;

        if($request->isPost){

            Yii::$app->response->format = Response::FORMAT_JSON;

            if (!$model->load($request->post())) {
                return ['status' => 'error', 'message' => '加载数据失败', 'model' => 'CreateEnv'];
            }

            if ($model->store()) {
                return ['status' => 'success', 'message' => '创建成功'];
            }

            return ['status' => 'error', 'message' => $model->getErrorMessage(), 'label' => $model->getErrorLabel()];

        }

        return $this->display('create', ['env' => $model->getNextEnv()]);
    }

    /**
     * 更新环境
     * @param $id 环境ID
     * @return array|string
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;

        $model   = UpdateEnv::findModel(['encode_id' => $id]);

        if($request->isPost){

            Yii::$app->response->format = Response::FORMAT_JSON;

            if(!$model->load($request->post())){
                return ['status' => 'error', 'message' => '加载数据失败', 'model' => 'UpdateEnv'];
            }

            if ($model->store()) {
                return ['status' => 'success', 'message' => '编辑成功'];
            }

            return ['status' => 'error', 'message' => $model->getErrorMessage(), 'label' => $model->getErrorLabel()];

        }

        return $this->display('update', ['env' => $model]);
    }

    /**
     * 删除环境
     * @param $id 环境ID
     * @return array|string
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;

        $model   = DeleteEnv::findModel(['encode_id' => $id]);

        if($request->isPost){

            Yii::$app->response->format = Response::FORMAT_JSON;

            if(!$model->load($request->post())) {
                return ['status' => 'error', 'message' => '数据加载失败', 'model' => 'DeleteEnv'];
            }

            if ($model->delete()) {
                return ['status' => 'success', 'message' => '删除成功'];
            }

            return ['status' => 'error', 'message' => $model->getErrorMessage(), 'label' => $model->getErrorLabel()];

        }

        return $this->display('delete', ['env' => $model]);
    }

}
