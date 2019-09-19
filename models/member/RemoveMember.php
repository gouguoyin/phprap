<?php
namespace app\models\member;

use Yii;
use app\models\Member;
use app\models\projectLog\CreateLog;

class RemoveMember extends Member
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
            ['id', 'validateAuth'],
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
    public function validateAuth($attribute)
    {
        if(!$this->project->hasAuth(['member' => 'remove'])){
            $this->addError($attribute, '抱歉，您没有操作权限');
            return false;
        }
    }

    /**
     * 移除成员
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\Exception
     * @throws \yii\db\StaleObjectException
     */
    public function remove()
    {
        if(!$this->validate()){
            return false;
        }

        // 开启事务
        $transaction = Yii::$app->db->beginTransaction();

        $member = &$this;

        if(!$member->delete()){
            $this->addError($member->getErrorLabel(), $member->getErrorMessage());
            $transaction->rollBack();
            return false;
        }

        // 保存操作日志
        $log = new CreateLog();
        $log->project_id  = $member->project_id;
        $log->object_name = 'member';
        $log->object_id   = $member->id;
        $log->type        = 'remove';
        $log->content     = '移除了 成员 ' . '<code>' . $member->account->fullName . '</code>';

        if(!$log->store()){
            $this->addError($log->getErrorLabel(), $log->getErrorMessage());
            $transaction->rollBack();
            return false;
        }

        // 事务提交
        $transaction->commit();

        return true;
    }

}
