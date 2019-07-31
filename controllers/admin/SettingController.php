<?php
namespace app\controllers\admin;

use app\models\Config;
use Yii;
use yii\web\Response;

class SettingController extends PublicController
{


    /**
     * 基础设置
     *
     * @return string
     */
    public function actionApp()
    {

        $request  = Yii::$app->request;
        $response = Yii::$app->response;
        $config   = Config::findOne(['type' => 'app']);

        if($request->isPost){

            $response->format = Response::FORMAT_JSON;

            $config->content = json_encode($request->post('Config'), JSON_UNESCAPED_UNICODE);

            if ($config->save()) {

                return ['code' => 200, 'msg' => '保存成功'];

            } else {

                return ['code' => 300, 'msg' => $config->getError()];

            }

        }

        return $this->display('app', ['config' => $config]);

    }

    /**
     * 邮箱设置
     * @return array|string
     */
    public function actionEmail()
    {
        $request  = Yii::$app->request;
        $response = Yii::$app->response;
        $config   = Config::findOne(['type' => 'email']);

        if($request->isPost){

            $response->format = Response::FORMAT_JSON;

            $config->content = json_encode($request->post('Config'), JSON_UNESCAPED_UNICODE);

            if ($config->save()) {

                return ['code' => 200, 'msg' => '保存成功'];

            } else {

                return ['code' => 300, 'msg' => $config->getError()];

            }

        }

        return $this->display('email', ['config' => $config]);

    }

    /**
     * 安全设置
     * @return array|string
     */
    public function actionSafe()
    {

        $request  = Yii::$app->request;
        $response = Yii::$app->response;
        $config   = Config::findOne(['type' => 'safe']);

        if($request->isPost){

            $response->format = Response::FORMAT_JSON;

            $data = $request->post('Config');

            // 判断输入IP是否同时存在于白名单和黑名单
            $ip_white_list = explode("\r\n", trim($data['ip_white_list']));
            $ip_black_list = explode("\r\n", trim($data['ip_black_list']));

            $conflict_list = array_intersect($ip_white_list, $ip_black_list);

            if(array_filter($conflict_list)){
                return ['status' => 'error', 'message' => '黑名单和白名单里不能出现相同的IP'];
            }

            // 判断邮箱后缀是否同时存在于白名单和黑名单
            $email_white_list = explode('\r\n', trim($data['email_white_list']));
            $email_black_list = explode('\r\n', trim($data['email_black_list']));


            $conflict_list = array_intersect($email_white_list, $email_black_list);

            if(array_filter($conflict_list)){
                return ['status' => 'error', 'message' => '黑名单和白名单里不能出现相同的邮箱后缀'];
            }

            $config->content = json_encode($data, JSON_UNESCAPED_UNICODE);

            if ($config->save()) {

                return ['status' => 'success', 'message' => '保存成功'];

            } else {

                return ['status' => 'error', 'message' => $config->getErrorMessage(), 'label' => $config->getErrorLabel()];

            }

        }

        return $this->display('safe', ['config' => $config]);

    }


}
