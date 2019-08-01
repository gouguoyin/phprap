<?php
/**
 * 添加成员模型
 */
namespace app\models\member;

use Yii;
use app\models\Member;

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
            [['project_rule', 'module_rule', 'api_rule', 'member_rule', 'env_rule'], 'string', 'max' => 100],

            ['id', 'validateProject'],
        ];

    }

    /**
     * 验证是否有项目操作权限
     * @param $attribute
     */
    public function validateProject($attribute)
    {
        if(!$this->project->hasRule('member', 'update')){
            $this->addError($attribute, '抱歉，您没有操作权限');
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

        // 保存成员
        $member = &$this;

        $member->project_rule = $this->project_rule;
        $member->env_rule     = $this->env_rule;
        $member->module_rule  = $this->module_rule;
        $member->api_rule     = $this->api_rule;
        $member->member_rule  = $this->member_rule;
        $member->updater_id   = Yii::$app->user->identity->id;
        $member->updated_at   = date('Y-m-d H:i:s');

        if(!$member->save()){
            $this->addError($member->getErrorLabel(), $member->getErrorMessage());
            $transaction->rollBack();
            return false;
        }

        // 事务提交
        $transaction->commit();

        return true;

    }

}
