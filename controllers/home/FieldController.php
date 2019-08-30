<?php
namespace app\controllers\home;

use Yii;
use yii\web\Response;
use app\models\field\UpdateField;

class FieldController extends PublicController
{
    /**
     * 更新字段
     * @param $id
     * @param string $method
     * @return array|string
     */
    public function actionUpdate($id, $method = 'form')
    {
        $request = Yii::$app->request;

        $model = UpdateField::findModel(['encode_id' => $id]);

        if($request->isPost){

            Yii::$app->response->format = Response::FORMAT_JSON;

            if(!$model->load($request->post())){
                return ['status' => 'error', 'message' => '数据加载失败'];
            }

            if($model->store()) {
                $callback = url('home/api/show', ['id' => $model->api->encode_id, 'tab' => 'field']);
                return ['status' => 'success', 'message' => '编辑成功', 'callback' => $callback];
            }

            return ['status' => 'error', 'message' => $model->getErrorMessage(), 'label' => $model->getErrorLabel()];

        }

        return $this->display('/home/field/' . $method, ['field' => $model, 'project' => $model->api->project]);
    }

}
