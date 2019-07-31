<?php

namespace app\models\account;

use Yii;
use app\models\Account;

class UpdateAccount extends Account
{
    
    public $password;

    public function rules()
    {
        return [
            [['status'], 'filter', 'filter' => 'intval'],
            [['name', 'email', 'password'], 'filter', 'filter' => 'trim'],
            ['name', 'required', 'message' => '用户昵称不可以为空'],
            ['name', 'string', 'min' => 2, 'max' => 50, 'message' => '用户昵称至少包含2个字符，最多50个字符'],
            ['email', 'required', 'message' => '登录邮箱不能为空'],
            ['email', 'email','message' => '邮箱格式不合法'],
            ['email', 'validateEmail'],
            ['password', 'required', 'message' => '密码不可以为空', 'on' => 'password'],
        ];
    }

    public function validateEmail($attribute)
    {
        $query = self::find();

        $query->andFilterWhere([
            'email'  => $this->email,
        ]);

        $query->andFilterWhere([
            '<>','id', $this->id,
        ]);

        if($query->exists()){
            $this->addError($attribute, '抱歉，该邮箱已被注册');
        }
    }

    public function store()
    {

        if(!$this->validate()){
            return false;
        }

        $account = &$this;
        
        $account->name = $this->name;
        $account->email = $this->email;
        $account->status = $this->status;

        if($this->password){
            $this->scenario = 'password';

            $account->setPassword($this->password);
            $account->generateAuthKey();
        }

        if(!$account->save()){
            $this->addError($account->getErrorLabel(), $account->getErrorMessage());

            return false;
        }

        return true;
    }

}
