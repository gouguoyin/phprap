<?php
namespace app\models\api;

use Yii;
use app\models\Module;
use app\models\Api;

class UpdateApi extends Api
{

    /**
     * 验证规则
     */
    public function rules()
    {
        return [
            [['title', 'uri', 'sort','project_id','module_id','request_method'], 'required'],
            [['request_method', 'response_format'], 'string', 'max' => 20],
            [['title', 'uri', 'remark'], 'string', 'max' => 250],
            [['sort', 'project_id', 'module_id'], 'integer'],

            ['id', 'validateProject'],
        ];
    }

    /**
     * 验证是否有项目操作权限
     * @param $attribute
     */
    public function validateProject($attribute)
    {
        if(!$this->project->hasRule('api', 'update')){
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
        $api = &$this;

        $module = Module::findModel(['encode_id' => $this->module_id]);

        $api->module_id  = $module->id;
        $api->updater_id = Yii::$app->user->identity->id;
        $api->updated_at = date('Y-m-d H:i:s');

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
