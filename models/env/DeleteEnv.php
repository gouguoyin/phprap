<?php
namespace app\models\env;

use Yii;
use app\models\Env;
use app\models\projectLog\CreateLog;

class DeleteEnv extends Env
{
    public $password; // 登录密码

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            ['password', 'required', 'message' => '登录密码不可以为空'],

            ['password', 'validatePassword'],
            ['id', 'validateAuth'],
        ];
    }

    /**
     * 字段字典
     */
    public function attributeLabels()
    {
        return parent::attributeLabels() + ['password' => '登录密码'];
    }

    /**
     * 验证密码是否正确
     * @param $attribute
     */
    public function validatePassword($attribute)
    {
        $account = Yii::$app->user->identity;

        if(!$account->id || !$account->validatePassword($this->password)) {
            $this->addError($attribute, '登录密码验证失败');
            return false;
        }
    }

    /**
     * 验证是否有项目操作权限
     * @param $attribute
     */
    public function validateAuth($attribute)
    {
        if(!$this->project->hasAuth(['env' => 'delete'])){
            $this->addError($attribute, '抱歉，您没有操作权限');
            return false;
        }
    }

    /**
     * 删除环境
     * @return bool|false|int
     * @throws \yii\db\Exception
     */
    public function delete()
    {
        // 开启事务
        $transaction  = Yii::$app->db->beginTransaction();

        $env = &$this;

        $count = Env::find()->where(['project_id' => $env->project_id,'status' => Env::ACTIVE_STATUS])->count();

        if($count < 2){
            $this->addError('count', '亲，至少要保留一个环境');
            return false;
        }

        $env->status     = Env::DELETED_STATUS;
        $env->updater_id = Yii::$app->user->identity->id;

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
        $log->content     = '删除了 环境 ' . '<code>' . $env->title . '(' . $env->name. ')' . '</code>';

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
