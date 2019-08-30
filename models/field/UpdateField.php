<?php

namespace app\models\field;

use Yii;
use app\models\Field;
use app\models\projectLog\CreateLog;

class UpdateField extends Field
{
    /**
     * 验证规则
     */
    public function rules()
    {
        return [
            ['id', 'checkAuth'],
            [['header_fields', 'request_fields', 'response_fields'], 'string'],
        ];
    }

    /**
     * 检测是否有操作权限
     * @param $attribute
     */
    public function checkAuth($attribute)
    {
        if(!$this->api->project->hasAuth(['api' => 'update'])){
            $this->addError($attribute, '抱歉，您没有操作权限');
            return false;
        }
    }

    /**
     * 保存接口
     * @return bool
     */
    public function store()
    {
        if(!$this->validate()){
            return false;
        }

        // 开启事务
        $transaction = Yii::$app->db->beginTransaction();

        $field = &$this;

        $field->header_fields   = $this->header_fields;
        $field->request_fields  = $this->request_fields;
        $field->response_fields = $this->response_fields;

        // 如果有更改，保存操作日志
        if(array_filter($field->dirtyAttributes)) {
            $log = new CreateLog();
            $log->project_id  = $field->api->project->id;
            $log->object_name = 'api';
            $log->object_id   = $field->api->id;
            $log->type        = 'update';
            $log->content     = $field->getUpdateContent();

            if(!$log->store()){
                $this->addError($log->getErrorLabel(), $log->getErrorMessage());
                $transaction->rollBack();
                return false;
            }
        }

        // 保存字段更新
        $field->updater_id = Yii::$app->user->identity->id;
        if(!$field->save()){
            $this->addError($field->getErrorLabel(), $field->getErrorMessage());
            $transaction->rollBack();
            return false;
        }

        // 事务提交
        $transaction->commit();

        return true;

    }

}
