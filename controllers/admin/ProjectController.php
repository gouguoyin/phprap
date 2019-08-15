<?php
namespace app\controllers\admin;

use Yii;
use yii\web\Response;
use app\models\Project;
use app\models\project\DeleteProject;
use app\models\project\RecoverProject;

class ProjectController extends PublicController
{
    /**
     * 搜索项目
     * @return string
     */
    public function actionIndex()
    {
        $params = Yii::$app->request->queryParams;
        $params['status'] = Project::ACTIVE_STATUS;

        $model = Project::findModel()->search($params);

        return $this->display('index', ['project' => $model]);
    }

    /**
     * 回收站
     * @return string
     * @throws \Exception
     */
    public function actionRecycle()
    {
        $params = Yii::$app->request->queryParams;
        $params['status']  = Project::DELETED_STATUS;
        $params['orderBy'] = 'updated_at desc';

        $model = Project::findModel()->search($params);

        return $this->display('recycle', ['project' => $model]);
    }

    /**
     * 删除项目
     * @param $id
     * @return array|string
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;

        $model = DeleteProject::findModel(['encode_id' => $id]);

        if($request->isPost) {

            Yii::$app->response->format = Response::FORMAT_JSON;

            if(!$model->load($request->post())) {
                return ['status' => 'error', 'message' => '数据加载失败'];
            }

            if($model->delete()) {
                return ['status' => 'success', 'message' => '删除成功'];
            }

            return ['status' => 'error', 'message' => $model->getErrorMessage(), 'label' => $model->getErrorLabel()];
        }

        return $this->display('delete', ['project' => $model]);
    }

    /**
     * 删除项目
     * @param $id
     * @return array|string
     */
    public function actionRecover($id)
    {
        $request = Yii::$app->request;

        $model = RecoverProject::findModel(['encode_id' => $id]);

        if($request->isPost) {

            Yii::$app->response->format = Response::FORMAT_JSON;

            if(!$model->load($request->post())) {
                return ['status' => 'error', 'message' => '数据加载失败'];
            }

            if($model->delete()) {
                return ['status' => 'success', 'message' => '恢复成功'];
            }

            return ['status' => 'error', 'message' => $model->getErrorMessage(), 'label' => $model->getErrorLabel()];
        }

        return $this->display('recover', ['project' => $model]);
    }

}
