<?php
namespace app\models\project;

use Yii;
use app\models\Project;
use app\models\User;

class TransferProject extends Project
{

    public $user_id;
    public $password;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            ['user_id', 'required', 'message'  => '请选择成员'],
            ['password', 'required', 'message' => '登录密码不可以为空'],
            ['password', 'validatePassword'],
            ['user_id', 'validateJoiner'],
        ];
    }

    /**
     * 验证密码是否正确
     * @param $attribute
     */
    public function validatePassword($attribute)
    {
        $account = Yii::$app->user->identity;

        if(!$account->id || !$account->validatePassword($this->password)) {
            $this->addError($attribute, '登录密码验证失败');
            return false;
        }
    }

    /**
     * 验证选择用户是不是项目成员
     * @param $attribute
     */
    public function validateJoiner($attribute)
    {
        if(!$this->isJoiner($this->user_id)){
            $this->addError($attribute, '抱歉，该用户不是该项目成员，无法转让');
            return false;
        }
    }

    /**
     * 转让项目
     * @return bool|mixed
     */
    public function transfer()
    {
        if(!$this->validate()){
            return false;
        }

        // 开启事务
        $transaction = Yii::$app->db->beginTransaction();

        $user = User::findModel($this->user_id);

        $this->creater_id = $user->id;

        if(!$this->save(false)){
            $transaction->rollBack();
            return false;
        }

        // 事务提交
        $transaction->commit();

        return true;
    }

}
