<?php
namespace app\models\api;

use Yii;
use app\models\Module;
use app\models\Api;
use app\models\field\CreateField;
use app\models\projectLog\CreateLog;

class CreateApi extends Api
{
    /**
     * 验证规则
     */
    public function rules()
    {
        return [
            [['module_id', 'title', 'sort'], 'required'],
            [['title', 'uri', 'remark'], 'string', 'max' => 250],
            [['request_method', 'response_format'], 'string', 'max' => 20],
            [['project_id', 'module_id','sort'], 'integer'],
            ['id', 'validateAuth'],
        ];
    }

    /**
     * 验证是否有项目操作权限
     * @param $attribute
     */
    public function validateAuth($attribute)
    {
        $module = Module::findModel(['encode_id' => $this->module_id]);

        if(!$module->project->hasAuth(['api' => 'create'])){
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

        $api->encode_id  = $this->createEncodeId();
        $api->title      = $this->title;
        $api->request_method = $this->request_method;
        $api->project_id = $module->project_id;
        $api->module_id  = $module->id;
        $api->uri        = $this->uri ? '/' . ltrim($this->uri, '/') : $this->uri;
        $api->remark     = $this->remark;
        $api->status     = Api::ACTIVE_STATUS;
        $api->creater_id = Yii::$app->user->identity->id;
        $api->created_at = $this->getNowTime();

        if(!$api->save()){
            $this->addError($api->getErrorLabel(), $api->getErrorMessage());
            $transaction->rollBack();
            return false;
        }

        // 保存操作日志
        $log = new CreateLog();
        $log->project_id  = $api->project_id;
        $log->object_name = 'api';
        $log->object_id   = $api->id;
        $log->type        = 'create';
        $log->content     = '创建了 接口 ' . '<code>' . $api->title . '</code>';

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
