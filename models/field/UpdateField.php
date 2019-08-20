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
            [['header_field', 'request_field', 'response_field', 'success_example', 'error_example'], 'string'],
            [['request_method', 'response_format'], 'string', 'max' => 20],

            ['id', 'validateProject'],
            [['success_example', 'error_example'], 'validateJson'],
        ];
    }

    /**
     * 验证是否有项目操作权限
     * @param $attribute
     */
    public function validateProject($attribute)
    {
        if(!$this->project->hasAuth(['field' => 'update'])){
            $this->addError($attribute, '抱歉，您没有操作权限');
        }
    }

    /**
     * 验证JSON是否合法
     * @param $attribute
     */
    public function validateJson($attribute)
    {
        json_decode($this->$attribute);

        if(json_last_error() != JSON_ERROR_NONE){
            $this->addError($attribute,'非法JSON格式');
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

        $api = &$this;

        $api->header_field   = $this->header_field;
        $api->request_field  = $this->request_field;
        $api->response_field = $this->response_field;

        if($api->dirtyAttributes) {
            $log = new CreateLog();
            $log->project_id = $api->project->id;
            $log->type       = 'update';
            $log->content    = $api->getUpdateContent();

            // 保存操作日志
            if(!$log->store()){
                $this->addError($log->getErrorLabel(), $log->getErrorMessage());
                $transaction->rollBack();
                return false;
            }
        }

        $api->updater_id = Yii::$app->user->identity->id;
        $api->updated_at = date('Y-m-d H:i:s');

        // 保存接口
        if(!$api->save()){
            $this->addError($api->getErrorLabel(), $api->getErrorMessage());
            $transaction->rollBack();
            return false;
        }

        // 事务提交
        $transaction->commit();

        return true;
    }

}
