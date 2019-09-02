<?php
namespace app\models\account;

use Yii;
use app\models\Account;

class ProfileForm extends Account
{
    public $password; // 登录密码

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'email'], 'filter', 'filter' => 'trim'],
            [['status'], 'integer'],
            ['name', 'required', 'message' => '用户昵称不可以为空'],
            ['name', 'string', 'min' => 2, 'max' => 50, 'message' => '用户昵称至少包含2个字符，最多50个字符'],
            ['email', 'required', 'message' => '登录邮箱不能为空'],
            ['email', 'email','message' => '邮箱格式不合法'],
            ['email', 'validateEmail'],

            ['password', 'required', 'message' => '登录密码不可以为空', 'on' => 'home'],
            ['password', 'validatePassword', 'on' => 'home'],
        ];
    }

    /**
     * 字段字典
     */
    public function attributeLabels()
    {
        return parent::attributeLabels() + ['password' => '登录密码'];
    }

    /**
     * 验证登录邮箱是否唯一
     * @param $attribute
     */
    public function validateEmail($attribute)
    {
        $query = self::find();

        $query->andFilterWhere([
            'email' => $this->email,
        ]);

        $query->andFilterWhere([
            '<>','id', $this->id,
        ]);

        if($query->exists()){
            $this->addError($attribute, '抱歉，该邮箱已被注册');
            return false;
        }
    }

    /**
     * 验证密码是否正确
     * @param $attribute
     */
    public function validatePassword($attribute)
    {
        $account = Account::findModel($this->id);

        if(!$account->id || !$account->validatePassword($this->password)) {
            $this->addError($attribute, '登录密码验证失败');
            return false;
        }
    }

    public function store()
    {
        if (!$this->validate()) {
            return false;
        }

        // 开启事务
        $transaction = Yii::$app->db->beginTransaction();

        $account = &$this;

        $account->name  = $this->name;
        $account->email = $this->email;
        $account->updated_at = date('Y-m-d H:i:s');

        if(!$account->save()) {
            $this->addError($account->getErrorLabel(), $account->getErrorMessage());
            $transaction->rollBack();
            return false;
        }

        // 事务提交
        $transaction->commit();

        return true;
    }

}
