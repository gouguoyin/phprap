<?php

namespace app\controllers\home;

use Yii;
use yii\helpers\Html;
use yii\web\Response;
use app\models\Api;
use app\models\field\CreateField;
use app\models\field\UpdateField;

class FieldController extends PublicController
{
    /**
     * 添加字段
     * @param $id
     * @param string $method
     * @return array|string
     */
    public function actionCreate($api_id)
    {
        $request = Yii::$app->request;

        $params = Yii::$app->request->queryParams;

        $api = Api::findModel(['encode_id' => $api_id]);

        $model = CreateField::findModel();

        $assign['project'] = $api->project;
        $assign['api'] = $api;
        $assign['field'] = $model;

        if ($params['from'] == 'template') {
            $assign['template'] = $api->project->template;
        }

        if ($request->isPost) {

            Yii::$app->response->format = Response::FORMAT_JSON;
            $model->api_id = $api->id;
            $model->header_fields = $this->form2json($request->post('header'));
            $model->request_fields = $this->form2json($request->post('request'));
            $model->response_fields = $this->form2json($request->post('response'));

            if ($model->store()) {
                $callback = url('home/api/show', ['id' => $api->encode_id, 'tab' => 'field']);
                return ['status' => 'success', 'message' => '添加成功', 'callback' => $callback];
            }

            return ['status' => 'error', 'message' => $model->getErrorMessage(), 'label' => $model->getErrorLabel()];

        }

        return $this->display('/home/field/create', $assign);
    }

    /**
     * 更新字段
     * @param $id
     * @param string $method
     * @return array|string
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;

        $model = UpdateField::findModel(['encode_id' => $id]);

        $assign['project'] = $model->api->project;
        $assign['api'] = $model->api;
        $assign['field'] = $model;

        if ($request->isPost) {

            Yii::$app->response->format = Response::FORMAT_JSON;

            $fieldsType = $request->post('fields_type');
            if ($fieldsType == "json") {
                $model->request_fields = $this->json2SaveJson($request->post('request'));
            } else {
                $model->request_fields = $this->form2json($request->post('request'));
            }

            $model->header_fields = $this->form2json($request->post('header'));
            $model->response_fields = $this->form2json($request->post('response'));

            if ($model->store()) {
                $callback = url('home/api/show', ['id' => $model->api->encode_id, 'tab' => 'field']);
                return ['status' => 'success', 'message' => '编辑成功', 'callback' => $callback];
            }

            return ['status' => 'error', 'message' => $model->getErrorMessage(), 'label' => $model->getErrorLabel()];

        }

        return $this->display('/home/field/update', $assign);
    }

    /**
     * 将用户提交json转化为内部json
     * @param $string
     * @return false|string
     */
    private function json2SaveJson($string)
    {
        $array = json_decode($string, true);
        $return_array = $this->parseJson($array, 0, 0);
        return json_encode($return_array, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 将用户提交json转化为内部json,递归
     * @param $array
     * @param int $level
     * @param int $pid
     * @return array
     */
    private function parseJson($array, $level = 0, $pid = 0)
    {
        $field_array = [];
        if (gettype($array) == 'object') {
            $array = array($array);
        }
        
        foreach ($array as $key => $item) {
            $id = rand_id();
            $type = gettype($item);
            $recurrence = ($type == 'array' or $type == 'object');

            $field_array[] = [
                'id'        => $id,
                'level'     => strval($level),
                'parent_id' => strval($pid),
                'name'      => $key,
                'title'     => $key,
                'type'      => $recurrence ? (isset($item[0]) ? 'array' : 'object') : $type,
                'required'  => '10',
                'remark'    => '',
                'example_value' => $recurrence ? '' : $item
            ];

            if ($recurrence) {
                $field_array = array_merge($field_array, $this->parseJson($item, $level + 1, $id));
            }
        }

        return $field_array;
    }

    /**
     * 表单过滤后转json
     * @param $table
     * @return false|string
     */
    private function form2json($table)
    {
        if (!is_array($table) || !$table) {
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
