<?php
namespace app\models\apply;

use Yii;
use app\models\Project;
use app\models\Apply;

class CreateApply extends Apply
{
    /**
     * 验证规则
     */
    public function rules()
    {
        return [
            [['project_id'], 'required'],

            [['project_id', 'user_id', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],

            ['project_id', 'validateAuth'],
            [['ip', 'location'], 'string', 'max' => 250],
        ];
    }

    /**
     * 验证申请是否唯一
     * @param $attribute
     */
    public function validateAuth($attribute)
    {
        $project = Project::findModel($this->project_id);

        if($project->status != Project::ACTIVE_STATUS){
            $this->addError($attribute, '该项目已禁用或删除，无法提交加入申请');
            return false;
        }

        if($project->isJoiner()){
            $this->addError($attribute, '您已是该项目成员，请不要重复申请');
            return false;
        }

        $apply = Apply::find()->where([
            'user_id'    => Yii::$app->user->identity->id,
            'project_id' => $this->project_id,
        ])->orderBy(['id' => SORT_DESC])->one();

        if($apply->status == Apply::CHECK_STATUS){
            $this->addError($attribute, '您已提交过加入申请，请耐心等待审核结果');
            return false;
        }
    }

    /**
     * 保存申请
     * @return bool
     */
    public function store()
    {
        // 开启事务
        $transaction = Yii::$app->db->beginTransaction();

        if(!$this->validate()){
            return false;
        }

        $apply = &$this;

        $apply->project_id = $this->project_id;
        $apply->user_id    = Yii::$app->user->identity->id;
        $apply->status     = self::CHECK_STATUS;
        $apply->ip         = $this->getUserIp();
        $apply->location   = $this->getLocation();
        $apply->created_at = date('Y-m-d H:i:s');

        if(!$apply->save()){
            $this->addError($apply->getErrorLabel(), $apply->getErrorMessage());
            $transaction->rollBack();
            return false;
        }
        
        // 事务提交
        $transaction->commit();

        return true;
    }

}
