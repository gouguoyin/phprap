<?php
namespace app\models\module;

use Yii;
use app\models\Module;

/**
 * This is the model class for form "UpdateModule".
 *
 */
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
     * 字段字典
     */
    public function attributeLabels()
    {

        return [
            'title' => '模块名称',
            'remark' => '模块描述',
            'sort' => '模块排序',
        ];
    }

    /**
     * 验证是否有项目操作权限
     * @param $attribute
     */
    public function validateProject($attribute)
    {
        if(!$this->project->hasRule('module', 'update')){
            $this->addError($attribute, '抱歉，您没有操作权限');
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

        $module->title  = $this->title;
        $module->remark = $this->remark;
        $module->sort   = $this->sort;
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