<?php
namespace app\models\template;

use app\models\Project;
use Yii;
use app\models\Template;
use app\models\projectLog\CreateLog;

class CreateTemplate extends Template
{
    /**
     * 验证规则
     */
    public function rules()
    {
        return [
            [['project_id'], 'required'],
            [['header_fields', 'request_fields', 'response_fields'], 'string'],
            ['project_id', 'validateAuth'],
        ];
    }

    /**
     * 检测是否有操作权限
     * @param $attribute
     */
    public function validateAuth($attribute)
    {
        $project = Project::findOne($this->project_id);

        if(!$project->hasAuth(['template' => 'create'])){
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
        $template = new Template();

        if(array_sum([strlen($this->header_fields), strlen($this->request_fields), strlen($this->response_fields)]) == 0){
            $this->addError($template->getErrorLabel(), '至少填写一个字段');
            $transaction->rollBack();
            return false;
        }

        $template->encode_id  = $this->createEncodeId();
        $template->project_id = $this->project_id;
        $template->header_fields   = $this->header_fields;
        $template->request_fields  = $this->request_fields;
        $template->response_fields = $this->response_fields;
        $template->status     = $template::ACTIVE_STATUS;
        $template->creater_id = Yii::$app->user->identity->id;
        $template->created_at = $this->getNowTime();

        if(!$template->save()){
            $this->addError($template->getErrorLabel(), $template->getErrorMessage());
            $transaction->rollBack();
            return false;
        }

        // 事务提交
        $transaction->commit();

        return true;
    }

}
