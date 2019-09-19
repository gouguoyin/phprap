<?php
namespace app\models\field;

use app\models\projectLog\CreateLog;
use Yii;
use app\models\Api;
use app\models\Field;

class CreateField extends Field
{
    /**
     * 验证规则
     */
    public function rules()
    {
        return [
            [['api_id'], 'required'],
            [['header_fields', 'request_fields', 'response_fields'], 'string'],
            ['api_id', 'validateAuth'],
        ];
    }

    /**
     * 检测是否有操作权限
     * @param $attribute
     */
    public function validateAuth($attribute)
    {
        $api = Api::findOne($this->api_id);

        if(!$api->project->hasAuth(['api' => 'update'])){
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

        // 保存接口
        $field = new Field();

        $field->header_fields   = $this->header_fields;
        $field->request_fields  = $this->request_fields;
        $field->response_fields = $this->response_fields;

        if(array_sum([strlen($this->header_fields), strlen($this->request_fields), strlen($this->response_fields)]) == 0){
            $this->addError($field->getErrorLabel(), '至少填写一个字段');
            $transaction->rollBack();
            return false;
        }

        // 保存操作日志
        if(array_filter($field->dirtyAttributes)) {
            $log = new CreateLog();

            $api = Api::findOne($this->api_id);

            $log->project_id  = $api->project->id;
            $log->object_name = 'api';
            $log->object_id   = $api->id;
            $log->type        = 'update';
            $log->content     = $field->getUpdateContent();

            if(!$log->store()){
                $this->addError($log->getErrorLabel(), $log->getErrorMessage());
                $transaction->rollBack();
                return false;
            }
        }

        $field->encode_id  = $this->createEncodeId();
        $field->api_id     = $this->api_id;
        $field->creater_id = Yii::$app->user->identity->id;
        $field->created_at = $this->getNowTime();

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
