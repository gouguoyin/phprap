<?php
namespace app\models\member;

use Yii;
use app\models\Apply;
use app\models\Member;

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
            [['project_rule', 'module_rule', 'api_rule', 'member_rule', 'env_rule'], 'string', 'max' => 100],

            ['project_id', 'validateProject'],
        ];

    }

    /**
     * 字段字典
     */
    public function attributeLabels()
    {
        return [
            'project_id' => '项目ID',
            'user_id' => '用户ID',
            'project_rule' => '项目权限',
            'env_rule' => '环境权限',
            'module_rule' => '模块权限',
            'api_rule' => '接口权限',
            'member_rule' => '成员权限',
        ];
    }

    /**
     * 验证是否有项目操作权限
     * @param $attribute
     */
    public function validateProject($attribute)
    {
        if(!$this->project->hasRule('member', 'create')){
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
        // 事务提交
        $transaction->commit();

        return true;

    }

}
