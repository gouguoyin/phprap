<?php
namespace app\models\module;

use Yii;
use app\models\Project;
use app\models\Module;

class CreateModule extends Module
{

    /**
     * 验证规则
     */
    public function rules()
    {
        return [
            [['project_id', 'title'], 'required'],

            [['title', 'remark'], 'string', 'max' => 250],
            [['sort'], 'integer'],

            ['project_id', 'validateProject'],
        ];
    }

    /**
     * 验证是否有项目操作权限
     * @param $attribute
     */
    public function validateProject($attribute)
    {
        $project = Project::findModel($this->project_id);

        if(!$project->hasRule('module', 'create')){
            $this->addError($attribute, '抱歉，您没有操作权限');
            return false;
        }
    }

    /**
     * 保存项目
     * @return bool
     */
    public function store()
    {
        if(!$this->validate()){
            return false;
        }

        // 开启事务
        $transaction = Yii::$app->db->beginTransaction();
        
        // 保存模块
        $module = &$this;

        $module->encode_id  = $this->createEncodeId();
        $module->project_id = $this->project_id;
        $module->title      = $this->title;
        $module->remark     = $this->remark;
        $module->status     = Module::ACTIVE_STATUS;
        $module->sort       = $this->sort;
        $module->creater_id = Yii::$app->user->identity->id;
        $module->created_at = date('Y-m-d H:i:s');

        if(!$module->save()){
            $this->addError($module->getErrorLabel(), $module->getErrorMessage());
            $transaction->rollBack();
            return false;
        }
        
        // 事务提交
        $transaction->commit();

        return true;
    }

}