<?php
namespace app\models\member;

use Yii;
use app\models\Apply;
use app\models\Member;
use app\models\projectLog\CreateLog;

class CreateMember extends Member
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

            ['project_id', 'validateAuth'],
        ];
    }

    /**
     * 验证是否有项目操作权限
     * @param $attribute
     */
    public function validateAuth($attribute)
    {
        if(!$this->project->hasAuth(['member' => 'create'])){
            $this->addError($attribute, '抱歉，您没有操作权限');
            return false;
        }
    }
    
    /**
     * 保存环境
     * @return bool
     */
    public function store()
    {
        if(!$this->validate()){
            return false;
        }

        // 开启事务
        $transaction = Yii::$app->db->beginTransaction();

        // 保存会员
        $member = &$this;

        $member->encode_id    = $this->createEncodeId();
        $member->project_id   = $this->project_id;
        $member->user_id      = $this->user_id;
        $member->join_type    = $this->join_type;
        $member->project_rule = $this->project_rule;
        $member->env_rule     = $this->env_rule;
        $member->template_rule = $this->template_rule;
        $member->module_rule  = $this->module_rule;
        $member->api_rule     = $this->api_rule;
        $member->member_rule  = $this->member_rule;
        $member->creater_id   = Yii::$app->user->identity->id;
        $member->created_at   = date('Y-m-d H:i:s');

        if(!$member->save()){
            $this->addError($member->getErrorLabel(), $member->getErrorMessage());
            $transaction->rollBack();
            return false;
        }

        // 如果有加入申请，将申请状态设为审核通过
        $apply = Apply::find()->where(['user_id' => $this->user_id, 'project_id' => $this->project_id])->orderBy(['id' => SORT_DESC])->one();
        if($apply->id){
            
            $apply->status = Apply::PASS_STATUS;

            if(!$apply->save()){
                $this->addError($apply->getErrorLabel(), $apply->getErrorMessage());
                $transaction->rollBack();
                return false;
            }
        }

        // 保存操作日志
        $log = new CreateLog();
        $log->project_id  = $member->project_id;
        $log->object_name = 'member';
        $log->object_id   = $member->id;
        $log->type        = 'create';
        $log->content     = '添加了 成员 ' . '<code>' . $member->account->fullName . '</code>';

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
