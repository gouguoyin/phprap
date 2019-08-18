<?php
namespace app\controllers\home;

use Yii;
use yii\web\Response;
use app\models\Project;
use app\models\module\CreateModule;
use app\models\module\UpdateModule;
use app\models\module\DeleteModule;

class ModuleController extends PublicController
{
    /**
     * 添加模块
     * @param $project_id 项目ID
     * @return array|string
     */
    public function actionCreate($project_id)
    {
        $request = Yii::$app->request;

        $project = Project::findModel(['encode_id' => $project_id]);

        if($request->isPost){

            Yii::$app->response->format = Response::FORMAT_JSON;

            $model = new CreateModule();

            $model->project_id = $project->id;

            if(!$model->load($request->post())){
                return ['status' => 'error', 'message' => '数据加载失败'];
            }

            if ($model->store()) {
                return ['status' => 'success', 'message' => '添加成功'];
            }

            return ['status' => 'error', 'message' => $model->getErrorMessage(), 'label' => $model->getErrorLabel()];

        }

        return $this->display('create');
    }

    /**
     * 更新模块
     * @param $id 模块ID
     * @return array|string
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;

        $model = UpdateModule::findModel(['encode_id' => $id]);

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

        return $this->display('update', ['module' => $model]);
    }

    /**
     * 删除模块
     * @param $id 模块ID
     * @return array|string
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;

        $model  = DeleteModule::findModel(['encode_id' => $id]);

        if($request->isPost){

            Yii::$app->response->format = Response::FORMAT_JSON;

            if (!$model->load($request->post())) {
                return ['status' => 'error', 'message' => '数据加载失败'];
            }

            if ($model->delete()) {
                return ['status' => 'success', 'message' => '删除成功'];
            }

            return ['status' => 'error', 'message' => $model->getErrorMessage(), 'label' => $model->getErrorLabel()];

        }

        return $this->display('delete', ['module' => $model]);
    }


}
