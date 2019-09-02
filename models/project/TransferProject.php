<?php
namespace app\models\project;

use Yii;
use app\models\Account;
use app\models\Project;
use app\models\projectLog\CreateLog;

class TransferProject extends Project
{
    public $user_id;
    public $password;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            ['user_id', 'required', 'message'  => '请选择成员'],
            ['password', 'required', 'message' => '登录密码不可以为空'],
            ['password', 'validatePassword'],
            ['user_id', 'validateAuth'],
        ];
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
     * 验证选择用户是不是项目成员
     * @param $attribute
     */
    public function validateAuth($attribute)
    {
        if($this->hasAuth(['project' => 'transfer'])) {
            $this->addError($attribute, '抱歉，您没有操作权限');
            return false;
        }
        if(!$this->isJoiner($this->user_id)){
            $this->addError($attribute, '抱歉，该用户不是该项目成员，无法转让');
            return false;
        }
    }

    /**
     * 转让项目
     * @return bool|mixed
     */
    public function transfer()
    {
        if(!$this->validate()){
            return false;
        }

        // 开启事务
        $transaction = Yii::$app->db->beginTransaction();

        $account = Account::findModel($this->user_id);

        $project = &$this;

        $project->creater_id = $account->id;

        if(!$project->save(false)){
            $this->addError($project->getErrorLabel(), $project->getErrorMessage());
            $transaction->rollBack();
            return false;
        }

        // 保存操作日志
        $log = new CreateLog();
        $log->project_id  = $project->id;
        $log->object_name = 'project';
        $log->object_id   = $project->id;
        $log->type        = 'transfer';
        $log->content     = '转让 项目 ' . '<code>' . $project->title . '</code>' . '给 成员 <code>' . $account->fullName . '</code>';

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
