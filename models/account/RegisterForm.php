<?php
namespace app\models\account;

use Yii;
use app\models\Member;
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

            ['verifyCode', 'required', 'message' => '验证码不能为空', 'when' => function($model, $attribute){
                return trim($model->verifyCode) ? true : false;
            }],
            ['verifyCode', 'captcha', 'captchaAction' => 'home/captcha/register', 'when' => function($model, $attribute){
                return trim($model->verifyCode) ? true : false;
            }],

            ['registerToken', 'required', 'message' => '注册邀请码不能为空', 'when' => function($model, $attribute){
                return trim($model->registerToken) ? true : false;
            }],

            ['registerToken', 'validateToken', 'when' => function($model, $attribute){
                return trim($model->registerToken) ? true : false;
            }],

            ['email', 'validateEmail'],
        ];
    }

    /**
     * 验证注册邀请码
     * @param $attribute
     */
    public function validateToken($attribute)
    {
        $config = Config::findOne(['type' => 'safe']);

        if (!$config->register_token || $config->register_token != $this->registerToken) {
            $this->addError($attribute, '注册邀请码错误');
            return false;
        }
    }

    /**
     * 验证邮箱是否合法
     * @param $attribute
     */
    public function validateEmail($attribute)
    {
        $config = Config::findOne(['type' => 'safe']);

        $email_white_list = array_filter(explode("\r\n", trim($config->email_white_list)));
        $email_black_list = array_filter(explode("\r\n", trim($config->email_black_list)));

        // 获取邮箱后缀，如@phprap.com
        $register_email_suffix = stristr($this->email, "@");

        if($email_white_list && !in_array($register_email_suffix, $email_white_list)){
            $this->addError($attribute, '该邮箱后缀不在可注册名单中');
            return false;
        }

        if($email_black_list && in_array($register_email_suffix, $email_black_list)){
            $this->addError($attribute, '该邮箱后缀不允许注册');
            return false;
        }
    }

    /**用户注册
     * @return bool
     * @throws \yii\db\Exception
     */
    public function register()
    {
        if (!$this->validate()) {
            return false;
        }

        // 开启事务
        $transaction = Yii::$app->db->beginTransaction();

        $account = new Account();

        $account->name       = $this->name;
        $account->email      = $this->email;
        $account->ip         = $this->getUserIp();
        $account->location   = $this->getLocation();
        $account->status     = Account::ACTIVE_STATUS;
        $account->type       = Account::USER_TYPE;
        $account->created_at = date('Y-m-d H:i:s');

        $account->setPassword($this->password);
        $account->generateAuthKey();

        if(!$account->save()) {
            $this->addError($account->getErrorLabel(), $account->getErrorMessage());
            $transaction->rollBack();
            return false;
        }

        // 默认加入测试项目
        $member = new Member();
        $member->encode_id    = $this->createEncodeId();
        $member->project_id   = 1;
        $member->user_id      = $account->id;
        $member->join_type    = $member::PASSIVE_JOIN_TYPE;
        $member->project_rule = 'look,export,history';
        $member->env_rule     = 'look';
        $member->module_rule  = 'look';
        $member->api_rule     = 'look,export,history,debug';
        $member->member_rule  = 'look';
        $member->creater_id   = 1;
        $member->created_at   = date('Y-m-d H:i:s');

        if(!$member->save()){
            $this->addError($member->getErrorLabel(), $member->getErrorMessage());
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

        $config = Config::findOne(['type' => 'safe']);
        $login_keep_time = $config->login_keep_time;

        return Yii::$app->user->login($account, 60*60*$login_keep_time);
    }

}
