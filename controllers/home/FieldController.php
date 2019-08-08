<?php
namespace app\controllers\home;

use Yii;
use yii\web\Response;
use app\models\api\UpdateField;

class FieldController extends PublicController
{

    /**
     * 更新表单
     * @param $id
     * @return array|string
     */
    public function actionForm($api_id)
    {

        $request = Yii::$app->request;

        $api = UpdateField::findModel(['encode_id' => $api_id]);

        if($request->isPost){

            Yii::$app->response->format = Response::FORMAT_JSON;

            if(!$api->load($request->post())){

                return ['status' => 'error', 'message' => '数据加载失败'];

            }

            if ($api->store()) {
                $callback = url('home/api/show', ['id' => $api->encode_id]);
                return ['status' => 'success', 'message' => '编辑成功', 'callback' => $callback];
            }

            return ['status' => 'error', 'message' => $api->getErrorMessage(), 'label' => $api->getErrorLabel()];

        }

        return $this->display('/home/field/form', ['api' => $api, 'project' => $api->project]);

    }

    /**
     * 更新JSON
     * @param $api_id
     * @return array|string
     */
    public function actionJson($api_id)
    {

        $request = Yii::$app->request;

        $api = UpdateField::findModel(['encode_id' => $api_id]);

        if($request->isPost){

            Yii::$app->response->format = Response::FORMAT_JSON;

            if(!$api->load($request->post())){

                return ['status' => 'error', 'message' => '数据加载失败'];

            }

            if ($api->store()) {
                $callback = url('home/api/show', ['id' => $api->encode_id]);
                return ['status' => 'success', 'message' => '编辑成功', 'callback' => $callback];
            }

            return ['status' => 'error', 'message' => $api->getErrorMessage(), 'label' => $api->getErrorLabel()];

        }

        return $this->display('/home/field/json', ['api' => $api, 'project' => $api->project]);
        
    }



}
