<?php
namespace app\models\env;

use Yii;
use app\models\Env;

/**
 * This is the model class for form "DeleteEnv".
 *
 * @property string $password 登录密码
 */
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
            ['id', 'validateProject'],
        ];
    }

    /**
     * 字段字典
     */
    public function attributeLabels()
    {

        return [
            'password' => '登录密码',
        ];
    }

    /**
     * 验证密码是否正确
     * @param $attribute
     */
    public function validatePassword($attribute)
    {
        $user = Yii::$app->user->identity;

        if(!$user->id || !$user->validatePassword($this->password))
        {

            $this->addError($attribute, '登录密码验证失败');
        }
    }

    /**
     * 验证是否有项目操作权限
     * @param $attribute
     */
    public function validateProject($attribute)
    {

        if(!$this->project->hasRule('env', 'delete')){
            $this->addError($attribute, '抱歉，您没有操作权限');
        }
    }

    public function delete()
    {
        // 开启事务
        $transaction  = Yii::$app->db->beginTransaction();

        $env = &$this;

        $count = Env::find()->where(['project_id' => $env->project_id,'status' => Env::ACTIVE_STATUS])->count();

        if($count < 2){
            $this->addError('count', '亲，至少保留一个环境');
            return false;
        }

        $env->status = Env::DELETED_STATUS;
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
