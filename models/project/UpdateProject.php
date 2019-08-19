<?php
namespace app\models\project;

use Yii;
use app\models\Project;

class UpdateProject extends Project
{
    /**
     * 验证规则
     */
    public function rules()
    {
        return [
            [['title', 'sort', 'type'], 'required'],

            [['title', 'remark'], 'string', 'max' => 250],
            [['sort','type'], 'integer'],

            ['title', 'validateTitle'],
            ['id', 'validateProject'],
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

        $query->andFilterWhere([
            '<>','id', $this->id,
        ]);

        if($query->exists()){
            $this->addError($attribute, '抱歉，该项目名称已存在');
            return false;
        }
    }

    /**
     * 验证是否有项目操作权限
     * @param $attribute
     */
    public function validateProject($attribute)
    {
        if(!$this->hasAuth(['project' => 'update'])){
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

        // 保存项目
        $project = &$this;

        $project->title  = $this->title;
        $project->remark = $this->remark;
        $project->type   = $this->type;
        $project->sort   = $this->sort;
        $project->updater_id = Yii::$app->user->identity->id;
        $project->updated_at = date('Y-m-d H:i:s');

        if(!$project->save()){
            $this->addError($project->getErrorLabel(), $project->getErrorMessage());
            $transaction->rollBack();
            return false;
        }

        // 事务提交
        $transaction->commit();

        return true;
    }

}