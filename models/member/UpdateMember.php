<?php
namespace app\models\member;

use Yii;
use app\models\Member;
use app\models\projectLog\CreateLog;

class UpdateMember extends Member
{
    /**
     * 验证规则
     */
    public function rules()
    {
        return [
            [['project_id', 'user_id'], 'required'],

            [['project_id', 'user_id'], 'integer'],
            [['project_rule', 'module_rule', 'api_rule', 'member_rule', 'env_rule', 'template_rule'], 'string', 'max' => 100],

            ['id', 'validateAuth'],
        ];
    }

    /**
     * 验证是否有项目操作权限
     * @param $attribute
     */
    public function validateAuth($attribute)
    {
        if(!$this->project->hasAuth(['member' => 'update'])){
            $this->addError($attribute, '抱歉，您没有操作权限');
            return false;
        }
    }

    /**
     * 保存成员
     * @return bool
     */
    public function store()
    {
        if(!$this->validate()){
            return false;
        }

        // 开启事务
        $transaction = Yii::$app->db->beginTransaction();

        $member = &$this;

        $member->project_rule = $this->project_rule;
        $member->env_rule     = $this->env_rule;
        $member->template_rule = $this->template_rule;
        $member->module_rule  = $this->module_rule;
        $member->api_rule     = $this->api_rule;
        $member->member_rule  = $this->member_rule;
        $member->updater_id   = Yii::$app->user->identity->id;

        // 保存成员
        if(!$member->save()){
            $this->addError($member->getErrorLabel(), $member->getErrorMessage());
            $transaction->rollBack();
            return false;
        }

        // 保存操作日志
        $log = new CreateLog();
        $log->project_id  = $member->project_id;
        $log->object_name = 'member';
        $log->object_id   = $member->id;
        $log->type        = 'update';
        $log->content     = '更新了 成员 ' . '<code>' . $member->account->fullName . '</code> 操作权限';

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
