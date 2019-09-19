<?php
namespace app\models\env;

use Yii;
use app\models\Env;
use app\models\projectLog\CreateLog;

class UpdateEnv extends Env
{
    /**
     * 验证规则
     */
    public function rules()
    {
        return [
            [['title', 'name', 'base_url'], 'required'],

            [['title'], 'string', 'max' => 50],
            [['name'], 'string', 'max' => 10],
            [['sort','id'], 'integer'],

            ['name', 'validateName'],
            ['id', 'validateAuth'],
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
            'status'     => Env::ACTIVE_STATUS,
            'name'       => $this->name,
        ]);

        $query->andFilterWhere([
            '<>','id', $this->id,
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
        if(!$this->project->hasAuth(['env' => 'update'])){
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

        $env->title    = $this->title;
        $env->name     = $this->name;
        $env->base_url = trim($this->base_url, '/');

        // 如果有更改，保存操作日志
        if(array_filter($env->dirtyAttributes)) {
            $log = new CreateLog();
            $log->project_id  = $env->project->id;
            $log->object_name = 'env';
            $log->object_id   = $env->id;
            $log->type        = 'update';
            $log->content     = $env->getUpdateContent();

            if(!$log->store()){
                $this->addError($log->getErrorLabel(), $log->getErrorMessage());
                $transaction->rollBack();
                return false;
            }
        }

        // 保存环境更新内容
        $env->updater_id = Yii::$app->user->identity->id;
        if(!$env->save()){
            $this->addError($env->getErrorLabel(), $env->getErrorMessage());
            $transaction->rollBack();
            return false;
        }

        // 事务提交
        $transaction->commit();

        return true;
    }

}
