<?php
namespace app\models\env;

use Yii;
use app\models\Env;
use app\models\Project;
use app\models\projectLog\CreateLog;

class CreateEnv extends Env
{
    /**
     * 验证规则
     */
    public function rules()
    {
        return [
            [['project_id', 'title', 'name', 'base_url'], 'required'],

            [['title'], 'string', 'max' => 50],
            [['name'], 'string', 'max' => 10],
            [['project_id', 'sort'], 'integer'],

            ['name', 'validateName'],
            ['project_id', 'validateAuth'],
        ];
    }

    /**
     * 验证环境名是否唯一
     * @param $attribute
     */
    public function validateName($attribute)
    {
        $query = Env::find();

        $query->andFilterWhere([
            'project_id' => $this->project_id,
            'status' => Env::ACTIVE_STATUS,
            'name'   => $this->name,
        ]);

        if($query->exists()){
            $this->addError($attribute, '抱歉，该环境已存在');
            return false;
        }
    }

    /**
     * 验证是否有项目操作权限
     * @param $attribute
     */
    public function validateAuth($attribute)
    {
        $project = Project::findModel($this->project_id);

        if(!$project->hasAuth(['env' => 'create'])){
            $this->addError($attribute, '抱歉，您没有操作权限');
            return false;
        }
    }

    /**
     * 保存环境
     * @return bool
     */
    public function store()
    {
        if(!$this->validate()){
            return false;
        }

        // 开启事务
        $transaction = Yii::$app->db->beginTransaction();

        // 保存环境
        $env = &$this;

        $env->encode_id  = $this->createEncodeId();
        $env->project_id = $this->project_id;
        $env->title      = $this->title;
        $env->name       = $this->name;
        $env->base_url   = trim($this->base_url, '/');
        $env->status     = self::ACTIVE_STATUS;
        $env->sort       = $this->sort?:0;
        $env->creater_id = Yii::$app->user->identity->id;
        $env->created_at = date('Y-m-d H:i:s');

        if(!$env->save()){
            $this->addError($env->getErrorLabel(), $env->getErrorMessage());
            $transaction->rollBack();
            return false;
        }

        // 保存操作日志
        $log = new CreateLog();
        $log->project_id  = $env->project_id;
        $log->object_name = 'env';
        $log->object_id   = $env->id;
        $log->type        = 'create';
        $log->content     = '添加了 环境 ' . '<code>' . $env->title . '(' . $env->name. ')' . '</code>';

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
