<?php
namespace app\models\project;

use Yii;
use app\models\Project;
use app\models\projectLog\CreateLog;

class CreateProject extends Project
{
    /**
     * 验证规则
     */
    public function rules()
    {
        return [
            [['title', 'remark', 'type'], 'required'],

            [['title', 'remark'], 'string', 'max' => 250],
            [['sort', 'type'], 'integer'],

            ['title', 'validateTitle'],
        ];
    }
    
    /**
     * 验证项目名是否唯一
     * @param $attribute
     */
    public function validateTitle($attribute)
    {
        $query = Project::find();

        $query->andFilterWhere([
            'creater_id' => Yii::$app->user->identity->id,
            'status'     => Project::ACTIVE_STATUS,
            'title'      => $this->title,
        ]);

        if($query->exists()) {
            $this->addError($attribute, '抱歉，该项目名称已存在');
            return false;
        }
    }

    /**
     * 保存项目
     * @return bool
     */
    public function store()
    {
        if(!$this->validate()) {
            return false;
        }

        // 开启事务
        $transaction = Yii::$app->db->beginTransaction();
        
        // 保存项目
        $project = &$this;

        $project->encode_id  = $this->createEncodeId();
        $project->title      = $this->title;
        $project->remark     = $this->remark;
        $project->status     = Project::ACTIVE_STATUS;
        $project->type       = $this->type;
        $project->sort       = $this->sort;
        $project->creater_id = Yii::$app->user->identity->id;
        $project->created_at = date('Y-m-d H:i:s');

        if(!$project->save()) {
            $this->addError($project->getErrorLabel(), $project->getErrorMessage());
            $transaction->rollBack();
            return false;
        }

        // 保存操作日志
        $log = new CreateLog();
        $log->project_id  = $project->id;
        $log->object_name = 'project';
        $log->object_id   = $project->id;
        $log->type        = 'create';
        $log->content     = '创建了 项目 ' . '<code>' . $project->title . '</code>';

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