<?php

namespace app\models\account;

use Yii;
use app\models\Config;
use app\models\Account;
use app\models\loginLog\CreateLog;

class RegisterForm extends Account
{

    public $name;
    public $email;
    public $password;
    public $registerToken;
    public $verifyCode;

    public function rules()
    {
        return [
            [['name', 'email', 'password'], 'required'],

            [['name', 'email', 'verifyCode', 'registerToken'], 'filter', 'filter' => 'trim'],
            ['name', 'string', 'min' => 2, 'max' => 50, 'message' => '用户昵称至少包含2个字符，最多50个字符'],
            ['email', 'email','message' => '邮箱格式不合法'],
            ['email', 'unique', 'targetClass' => '\app\models\Account', 'message' => '该邮箱已被注册'],
            ['password', 'string', 'min' => 6, 'tooShort' => '密码至少填写6位'],
            ['verifyCode', 'required', 'message' => '验证码不能为空', 'on' => 'verifyCode'],
            ['verifyCode', 'captcha', 'captchaAction' => 'home/captcha/register', 'on' => 'verifyCode'],
            ['registerToken', 'required', 'message' => '注册口令不能为空', 'on' => 'registerToken'],

            ['email', 'validateEmail'],
            ['registerToken', 'validateToken', 'on' => 'registerToken'],
        ];
    }

    public function validateToken($attribute)
    {

        $token = config('safe', 'register_token');

        if (!$token || $token != $this->registerToken) {
            $this->addError($attribute, '注册口令错误');
        }
    }

    /**
     * 验证邮箱是否合法
     * @param $attribute
     */
    public function validateEmail($attribute){

        $config = Config::findOne(['type' => 'safe'])->getField();

        $email_white_list = array_filter(explode("\r\n", trim($config->email_white_list)));
        $email_black_list = array_filter(explode("\r\n", trim($config->email_black_list)));

        $register_email_suffix = '@' . explode('@', $this->email)[1];

        if($email_white_list && !in_array($register_email_suffix, $email_white_list)){

            $this->addError($attribute, '该邮箱后缀不在可注册名单中');
        }

        if($email_black_list && in_array($register_email_suffix, $email_black_list)){

            $this->addError($attribute, '该邮箱后缀不允许注册');
        }
    }

    public function register()
    {

        $config = Config::findOne(['type' => 'safe']);

        $token   = $config->getField('register_token');
        $captcha = $config->getField('register_captcha');

        if($token){
            $this->scenario = 'registerToken';
        }

        if($captcha){
            $this->scenario = 'verifyCode';
        }

        if (!$this->validate()) {
            return false;
        }

        // 开启事务
        $transaction = Yii::$app->db->beginTransaction();

        $account = new Account();

        $account->name   = $this->name;
        $account->email  = $this->email;
        $account->ip     = Yii::$app->request->userIP;
        $account->location = $this->getLocation();
        $account->status   = Account::ACTIVE_STATUS;
        $account->type   = Account::USER_TYPE;
        $account->created_at = date('Y-m-d H:i:s');

        $account->setPassword($this->password);
        $account->generateAuthKey();

        if(!$account->save()) {
            $this->addError($account->getErrorLabel(), $account->getErrorMessage());
            $transaction->rollBack();
            return false;
        }

        // 记录日志
        $loginLog = new CreateLog();

        $loginLog->user_id    = $account->id;
        $loginLog->user_name  = $account->name;
        $loginLog->user_email = $account->email;

        if(!$loginLog->store()) {
            $this->addError($loginLog->getErrorLabel(), $loginLog->getErrorMessage());
            $transaction->rollBack();
            return false;
        }

        // 事务提交
        $transaction->commit();

        $login_keep_time = $config->getField('login_keep_time');

        return Yii::$app->user->login($account, 60*60*$login_keep_time);

    }

}
