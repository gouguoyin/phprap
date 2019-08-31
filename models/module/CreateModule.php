<?php
namespace app\models\module;

use Yii;
use app\models\Project;
use app\models\Module;
use app\models\projectLog\CreateLog;

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

            ['project_id', 'validateAuth'],
        ];
    }

    /**
     * 验证是否有项目操作权限
     * @param $attribute
     */
    public function validateAuth($attribute)
    {
        $project = Project::findModel($this->project_id);

        if(!$project->hasAuth(['module' => 'create'])){
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

        // 保存操作日志
        $log = new CreateLog();
        $log->project_id  = $module->project->id;
        $log->type        = 'create';
        $log->object_name = 'module';
        $log->object_id   = $module->id;
        $log->content     = '添加了 模块 ' . '<code>' . $module->title . '</code>';

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