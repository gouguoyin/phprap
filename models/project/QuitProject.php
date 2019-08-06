<?php
namespace app\models\project;

use Yii;
use app\models\Project;
use app\models\Member;

/**
 * This is the model class for form "QuitProject".
 *
 * @property string $password 登录密码
 */
class QuitProject extends Project
{

    public $password; // 登录密码

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            ['password', 'required', 'message' => '登录密码不可以为空'],
            
            ['password', 'validatePassword'],
            ['id', 'validateProject'],
        ];
    }

    /**
     * 字段字典
     */
    public function attributeLabels()
    {

        return [
            'password' => '登录密码',
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
     * 验证是否有项目操作权限
     * @param $attribute
     */
    public function validateProject($attribute)
    {

        if(!$this->isJoiner()){
            $this->addError($attribute, '抱歉，您没有操作权限');
        }
    }

    /**
     * 退出项目
     * @return bool
     */
    public function quit()
    {

        if(!$this->validate()){
            return false;
        }

        // 开启事务
        $transaction = Yii::$app->db->beginTransaction();

        $member = Member::findModel(['project_id' => $this->id, 'user_id' => Yii::$app->user->identity->id]);

        if(!$member->delete()){
            $this->addError($member->getErrorLabel(), $member->getErrorMessage());
            $transaction->rollBack();
            return false;
        }

        // 事务提交
        $transaction->commit();

        return true;

    }

}
