<?php
namespace app\models\module;

use Yii;
use app\models\Module;
use app\models\projectLog\CreateLog;

class UpdateModule extends Module
{
    /**
     * 验证规则
     */
    public function rules()
    {
        return [
            [['title'], 'required'],

            [['title', 'remark'], 'string', 'max' => 250],
            [['sort'], 'integer'],

            ['id', 'validateProject'],
        ];
    }

    /**
     * 验证是否有项目操作权限
     * @param $attribute
     */
    public function validateProject($attribute)
    {
        if(!$this->project->hasAuth(['module' => 'update'])){
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

        $module->title      = $this->title;
        $module->remark     = $this->remark;
        $module->sort       = (int)$this->sort;

        if($module->dirtyAttributes) {
            $log = new CreateLog();
            $log->project_id = $module->project->id;
            $log->type       = 'update';
            $log->content    = $module->getUpdateContent();

            // 保存操作日志
            if(!$log->store()){
                $this->addError($log->getErrorLabel(), $log->getErrorMessage());
                $transaction->rollBack();
                return false;
            }
        }

        $module->updater_id = Yii::$app->user->identity->id;
        $module->updated_at = date('Y-m-d H:i:s');

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