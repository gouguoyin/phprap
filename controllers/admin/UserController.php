<?php
namespace app\controllers\admin;

use app\models\Account;
use app\models\account\PasswordForm;
use app\models\account\ProfileForm;
use app\models\account\RegisterForm;
use app\models\account\SearchForm;
use app\models\account\UpdateForm;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Response;

/**
 * Site controller
 */
class UserController extends PublicController
{

    /**
     * 成员列表
     * @return string
     */
    public function actionIndex()
    {

        $params = Yii::$app->request->queryParams;
        $params['type'] = Account::USER_TYPE;

        $model = Account::findModel()->search($params);

        return $this->display('index', ['model' => $model]);

    }

    /**
     * 编辑账号
     * @return string
     */
    public function actionProfile($id)
    {

        $request  = Yii::$app->request;
        $response = Yii::$app->response;

        $model = ProfileForm::findModel($id);

        if($request->isPost){

            $response->format = Response::FORMAT_JSON;

            if(!$model->load($request->post())){

                return ['status' => 'error', 'message' => '加载数据失败', 'model' => 'ProfileForm'];

            }

            if($model->store()) {

                return ['status' => 'success', 'message' => '编辑成功'];

            }

            return ['status' => 'error', 'message' => $model->getErrorMessage(), 'label' => $model->getErrorLabel()];

        }

        return $this->display('profile', ['model' => $model]);

    }

    /**
     * 修改密码
     * @return array|string
     */
    public function actionPassword($id)
    {

        $request = Yii::$app->request;

        $model = PasswordForm::findModel($id);

        if($request->isPost){

            Yii::$app->response->format = Response::FORMAT_JSON;

            if(!$model->load($request->post())){

                return ['status' => 'error', 'message' => '加载数据失败', 'model' => 'PasswordForm'];

            }

            if ($model->store()) {

                return ['status' => 'success', 'message' => '密码重置成功'];

            } else {

                return ['status' => 'error', 'message' => $model->getErrorMessage(), 'label' => $model->getErrorLabel()];

            }

        }

        return $this->display('password', ['model' => $model]);
    }

}
