<?php
namespace app\controllers\home;

use Yii;
use yii\helpers\Html;
use yii\web\Response;
use app\models\Project;
use app\models\Field;
use app\models\template\CreateTemplate;
use app\models\template\UpdateTemplate;

class TemplateController extends PublicController
{
    /**
     * 添加项目
     * @return string
     */
    public function actionCreate($project_id)
    {
        $request = Yii::$app->request;

        $project = Project::findModel(['encode_id' => $project_id]);
        $field = new Field();

        $model = new CreateTemplate();

        if($request->isPost) {

            Yii::$app->response->format = Response::FORMAT_JSON;

            $model->project_id = $project->id;
            $model->header_fields   = $this->form2json($request->post('header'));
            $model->request_fields  = $this->form2json($request->post('request'));
            $model->response_fields = $this->form2json($request->post('response'));

            if($model->store()) {
                $callback = url('home/project/show', ['id' => $project->encode_id, 'tab' => 'template']);
                return ['status' => 'success', 'message' => '添加成功', 'callback' => $callback];
            }

            return ['status' => 'error', 'message' => $model->getErrorMessage(), 'label' => $model->getErrorLabel()];

        }

        return $this->display('create', ['project' => $project, 'field' => $field, 'template' => $model]);
    }

    /**
     * 更新模板
     * @param $id 模板ID
     * @return array|string
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;

        $model   = UpdateTemplate::findModel(['encode_id' => $id]);
        $field   = new Field();

        if($request->isPost){

            Yii::$app->response->format = Response::FORMAT_JSON;

            $model->header_fields   = $this->form2json($request->post('header'));
            $model->request_fields  = $this->form2json($request->post('request'));
            $model->response_fields = $this->form2json($request->post('response'));

            if($model->store()) {
                $callback = url('home/project/show', ['id' => $model->project->encode_id, 'tab' => 'template']);
                return ['status' => 'success', 'message' => '编辑成功', 'callback' => $callback];
            }

            return ['status' => 'error', 'message' => $model->getErrorMessage(), 'label' => $model->getErrorLabel()];
        }

        return $this->display('update', ['project' => $model->project, 'field' => $field, 'template' => $model]);

    }

    /**
     * 表单过滤后转json
     * @param $table
     * @return false|string
     */
    private function form2json($table)
    {
        if(!is_array($table) || !$table){
            return;
        }
        $array = [];
        foreach ($table as $k => $v) {
            foreach ($v as $k1 => $v1) {
                $array[$k1][$k] = trim(Html::encode($v1));
            }
        }

        return json_encode($array, JSON_UNESCAPED_UNICODE);
    }

}
