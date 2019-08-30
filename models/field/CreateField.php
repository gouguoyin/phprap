<?php
namespace app\models\field;

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
            [['api_id'], 'integer'],
            [['header_fields', 'request_fields', 'response_fields'], 'string'],
            ['api_id', 'checkAuth'],
        ];
    }

    /**
     * 检测是否有操作权限
     * @param $attribute
     */
    public function checkAuth($attribute)
    {
        $api = Api::findOne($this->api_id);

        if(!$api->project->hasAuth(['api' => 'create'])){
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
        $field = &$this;

        $field->encode_id  = $this->createEncodeId();
        $field->api_id     = $this->api_id;
        $field->header_fields   = $this->header_fields;
        $field->request_fields  = $this->request_fields;
        $field->response_fields = $this->response_fields;
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
