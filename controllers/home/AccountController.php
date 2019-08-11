<?php
namespace app\controllers\home;

use Yii;
use yii\helpers\Url;
use yii\web\Response;
use app\models\Config;
use app\models\account\LoginForm;
use app\models\account\PasswordForm;
use app\models\account\ProfileForm;
use app\models\account\RegisterForm;

class AccountController extends PublicController
{
    public $checkLogin = false;

    /**
     * 会员注册
     * @return array|string
     */
    public function actionRegister()
    {
        $request  = Yii::$app->request;

        if($request->isPost){

            Yii::$app->response->format = Response::FORMAT_JSON;

            $model = new RegisterForm();

            if(!$model->load($request->post())){
                return ['status' => 'error', 'message' => '加载数据失败'];
            }

            if ($model->register()) {
                return ['status' => 'success', 'message' => '注册成功', 'callback' => Url::toRoute(['project/select'])];
            }

            return ['status' => 'error', 'message' => $model->getErrorMessage(), 'label' => $model->getErrorLabel()];
        }

        $config = Config::findOne(['type' => 'safe']);

        return $this->display('register', ['config' => $config]);
    }

    /**
     * 会员登录
     * @return array|string|Response
     */
    public function actionLogin()
    {
        $request = Yii::$app->request;

        // 已登录用户直接挑转到项目选择页
        if(!Yii::$app->user->isGuest){
            return $this->redirect(['home/project/select']);
        }

        if($request->isPost){

            Yii::$app->response->format = Response::FORMAT_JSON;

            $model = new LoginForm();

            if(!$model->load($request->post())){
                return ['status' => 'error', 'message' => '加载数据失败'];
            }

            if ($model->login()) {
                $callback = $model->callback ? $model->callback : Url::toRoute(['home/project/select']);
                return ['status' => 'success', 'message' => '登录成功', 'callback' => $callback];
            }

            return ['status' => 'error', 'message' => $model->getErrorMessage(), 'label' => $model->getErrorLabel()];
        }

        $config = Config::findOne(['type' => 'safe']);

        return $this->render('login', ['callback' => $request->get('callback', ''), 'config' => $config]);
    }

    /**
     * 退出登录
     * @return Response
     */
    public function actionLogout()
    {
        if (Yii::$app->user->isGuest || Yii::$app->user->logout()) {
            return $this->redirect(['account/login']);
        }
    }

    /**
     * 个人主页
     * @return string
     */
    public function actionHome()
    {
        if(Yii::$app->user->isGuest) {
            return $this->redirect(['home/account/login','callback' => Url::current()]);
        }

        return $this->display('home');
    }

    /**
     * 个人资料
     * @return array|string
     */
    public function actionProfile()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['home/account/login','callback' => Url::current()]);
        }

        $request = Yii::$app->request;

        $model = ProfileForm::findModel(Yii::$app->user->identity->id);

        if($request->isPost){

            $model->scenario = 'home';

            Yii::$app->response->format = Response::FORMAT_JSON;

            if (!$model->load($request->post())) {
                return ['status' => 'error', 'message' => '加载数据失败', 'model' => 'ProfileForm'];
            }

            if ($model->store()) {
                return ['status' => 'success', 'message' => '修改成功'];
            }

            return ['status' => 'error', 'message' => $model->getErrorMessage(), 'label' => $model->getErrorLabel()];
        }

        return $this->display('profile');
    }

    /**
     * 修改密码
     * @return array|string
     */
    public function actionPassword()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['home/account/login','callback' => Url::current()]);
        }

        $request = Yii::$app->request;

        $model = PasswordForm::findModel(Yii::$app->user->identity->id);

        if($request->isPost){

            Yii::$app->response->format = Response::FORMAT_JSON;

            $model->scenario = 'home';

            if (!$model->load($request->post())) {
                return ['status' => 'error', 'message' => '加载数据失败', 'model' => 'PasswordForm'];
            }

            if ($model->store()) {
                return ['status' => 'success', 'message' => '密码修改成功，请重新登录'];
            }

            return ['status' => 'error', 'message' => $model->getErrorMessage(), 'label' => $model->getErrorLabel()];

        }

        return $this->display('password');
    }

}
