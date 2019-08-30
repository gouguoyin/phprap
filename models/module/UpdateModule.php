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

            ['id', 'validateAuth'],
        ];
    }

    /**
     * 验证是否有项目操作权限
     * @param $attribute
     */
    public function validateAuth($attribute)
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

        $module = &$this;

        $module->title      = $this->title;
        $module->remark     = $this->remark;
        $module->sort       = (int)$this->sort;

        // 如果有更改，保存操作日志
        if(array_filter($module->dirtyAttributes)) {
            $log = new CreateLog();
            $log->project_id  = $module->project->id;
            $log->object_name = 'module';
            $log->object_id   = $module->id;
            $log->type        = 'update';
            $log->content     = $module->getUpdateContent();

            if(!$log->store()){
                $this->addError($log->getErrorLabel(), $log->getErrorMessage());
                $transaction->rollBack();
                return false;
            }
        }

        // 保存模块更新
        $module->updater_id = Yii::$app->user->identity->id;
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