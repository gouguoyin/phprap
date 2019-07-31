<?php
namespace app\controllers\home;

use app\models\Api;
use app\models\api\CreateApi;
use app\models\api\DeleteApi;
use app\models\api\UpdateApi;
use app\models\Module;
use app\models\Template;
use itbdw\Ip\IpLocation;
use Jenssegers\Agent\Agent;
use Yii;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class DemoController extends PublicController
{
    public $checkLogin = false;

    public function actionIndex()
    {

        exit( "没有可写权限<br>");
        $ip = Yii::$app->request->userIP;
        
        $a = IpLocation::getLocation($ip);
        dump($a);
        return $this->display('index');

    }

    /**
     * 添加接口
     * @return string
     */
    public function actionCreate($module_id)
    {

        $request = Yii::$app->request;

        $module = Module::findModel(['encode_id' => $module_id]);

        $api = new CreateApi();

        if($request->isPost){

            Yii::$app->response->format = Response::FORMAT_JSON;

            $api->module_id = $module->id;

            if(!$api->load($request->post())){

                return ['status' => 'error', 'message' => '数据加载失败'];

            }

            if(!$api->store()){

                return ['status' => 'error', 'message' => $api->getErrorMessage(), 'label' => $api->getErrorLabel()];

            }

            $callback = url('home/api/show', ['id' => $api->encode_id]);

            return ['status' => 'success', 'message' => '创建成功', 'callback' => $callback];

        }

        return $this->display('create', ['api' => $api, 'module' => $module]);

    }

    /**
     * 更新接口
     * @param $id
     * @return array|string
     */
    public function actionUpdate($id)
    {

        $request = Yii::$app->request;

        $api = UpdateApi::findModel(['encode_id' => $id]);

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

        return $this->display('update', ['api' => $api, 'module' => $api->module]);

    }

    /**
     * 编辑字段
     * @param $id
     * @return string
     */
    public function actionField($id)
    {

        $request = Yii::$app->request;

        $api = UpdateApi::findModel(['encode_id' => $id]);

        if($request->isPost){

            Yii::$app->response->format = Response::FORMAT_JSON;

            // 开启事务
            $transaction = Yii::$app->db->beginTransaction();

            if(!$api->load($request->post())){

                return ['status' => 'error', 'message' => '加载数据失败'];

            }

            if(!$api->store()){

                $transaction->rollBack();
                return ['status' => 'error', 'message' => $api->getErrorMessage(), 'label' => $api->getErrorLabel()];

            }

            // 事务提交
            $transaction->commit();

            return ['status' => 'success', 'message' => '编辑成功'];

        }

        $project = $api->module->project;

        return $this->display('/home/field/update', ['api' => $api, 'project' => $project]);
    }

    /**
     * 删除接口
     * @param $id
     * @return array|string
     */
    public function actionDelete($id)
    {

        $request = Yii::$app->request;

        $api = DeleteApi::findModel(['encode_id' => $id]);

        if($request->isPost){

            Yii::$app->response->format = Response::FORMAT_JSON;

            if(!$api->load($request->post())){

                return ['status' => 'error', 'message' => '加载数据失败'];

            }

            if ($api->delete()) {

                $callback = url('home/project/show', ['id' => $api->module->project->encode_id]);

                return ['status' => 'success', 'message' => '删除成功', 'callback' => $callback];

            }

            return ['status' => 'error', 'message' => $api->getErrorMessage(), 'label' => $api->getErrorLabel()];

        }

        return $this->display('delete', ['api' => $api]);

    }

    /**
     * 接口详情
     * @param $id
     * @return string
     */
    public function actionShow($id, $tab = 'home')
    {

        $api = Api::findModel(['encode_id' => $id]);

        $project = $api->module->project;

        switch ($tab) {
            case 'home':
                $view  = '/home/api/home';
                break;
            case 'field':
                $view  = '/home/field/home';
                break;
            case 'debug':
                $view  = '/home/api/debug';
                break;
            default:
                $view  = '/home/api/home';
                break;
        }

        return $this->display($view, ['project' => $project, 'api' => $api]);

    }
}
