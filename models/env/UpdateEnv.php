<?php
namespace app\models\env;

use Yii;
use app\models\Env;

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
            ['id', 'validateProject'],
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
    public function validateProject($attribute)
    {
        if(!$this->project->hasRule('env', 'update')){
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

        $env->base_url   = trim($this->base_url, '/');
        $env->updater_id = Yii::$app->user->identity->id;
        $env->updated_at = date('Y-m-d H:i:s');

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
