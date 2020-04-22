<?php

namespace app\controllers\home;

use app\models\Field;
use Yii;
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

        /** @var Api $api */
        $api = Api::findModel(['encode_id' => $api_id]);

        /** @var CreateField $model */
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
            $model->header_fields = Field::form2json($request->post('header'));
            $model->request_fields = Field::form2json($request->post('request'));
            $model->response_fields = Field::form2json($request->post('response'));

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

        /** @var UpdateField $model */
        $model = UpdateField::findModel(['encode_id' => $id]);

        $assign['project'] = $model->api->project;
        $assign['api'] = $model->api;
        $assign['field'] = $model;

        if ($request->isPost) {

            Yii::$app->response->format = Response::FORMAT_JSON;

            $fieldsType = $request->post('fields_type');
            if ($fieldsType == "json") {
                $model->request_fields = UpdateField::json2SaveJson($request->post('request'));
            } else {
                $model->request_fields = UpdateField::form2json($request->post('request'));
            }

            $model->header_fields = UpdateField::form2json($request->post('header'));
            $model->response_fields = UpdateField::form2json($request->post('response'));

            if ($model->store()) {
                $callback = url('home/api/show', ['id' => $model->api->encode_id, 'tab' => 'field']);
                return ['status' => 'success', 'message' => '编辑成功', 'callback' => $callback];
            }

            return ['status' => 'error', 'message' => $model->getErrorMessage(), 'label' => $model->getErrorLabel()];

        }

        return $this->display('/home/field/update', $assign);
    }


}
