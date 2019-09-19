<?php
namespace app\models\account;

use Yii;
use app\models\Account;
use app\models\Config;
use app\models\loginLog\CreateLog;

class LoginForm extends Account
{
    public $email;
    public $password;
    public $verifyCode;
    public $callback;
    public $rememberMe = 1;

    public function rules()
    {
        return [
            [['email', 'verifyCode'], 'filter', 'filter' => 'trim'],
            ['email', 'required', 'message' => '登录邮箱不能为空'],
            ['email', 'email','message' => '邮箱格式不合法'],
            ['rememberMe', 'boolean'],
            ['password', 'required', 'message' => '密码不可以为空'],
            ['verifyCode', 'required', 'message' => '验证码不能为空', 'when' => function($model, $attribute){
                return trim($model->verifyCode) ? true : false;
            }],
            ['verifyCode', 'captcha', 'captchaAction' => 'home/captcha/login', 'when' => function($model, $attribute){
                return trim($model->verifyCode) ? true : false;
            }],
            ['password', 'validatePassword'],

            ['callback', 'string', 'max' => 255],
        ];
    }

    /**
     * 验证密码是否正确
     * @param $attribute
     */
    public function validatePassword($attribute)
    {
        $account = Account::findByEmail($this->email);

        if (!$account->id || !$account->validatePassword($this->password)) {
            $this->addError($attribute, '登录邮箱或密码错误');
            return false;
        }

        if ($account->status != $account::ACTIVE_STATUS) {
            $this->addError($attribute, '抱歉，该账号已被禁用，请联系管理员处理');
            return false;
        }
    }

    /**
     * 用户登录
     * @return bool
     */
    public function login()
    {
        if(!$this->validate()){
            return false;
        }

        $account = Account::findByEmail($this->email);

        // 记录日志
        $loginLog = new CreateLog();
        $loginLog->user_id    = $account->id;
        $loginLog->user_name  = $account->name;
        $loginLog->user_email = $account->email;

        if(!$loginLog->store()){
            $this->addError($loginLog->getErrorLabel(), $loginLog->getErrorMessage());
            return false;
        }

        $config = Config::findOne(['type' => 'safe']);
        $login_keep_time = $config->login_keep_time;

        return Yii::$app->user->login($account, 60*60*$login_keep_time);
    }

}
