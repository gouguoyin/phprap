<?php
namespace app\models\module;

use Yii;
use app\models\Module;
use app\models\projectLog\CreateLog;

class DeleteModule extends Module
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
     * 验证登录密码是否正确
     * @param $attribute
     */
    public function validatePassword($attribute)
    {
        $account = Yii::$app->user->identity;

        if (!$account->id || !$account->validatePassword($this->password)) {
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
        if(!$this->project->hasAuth(['module' => 'delete'])){
            $this->addError($attribute, '抱歉，您没有操作权限');
            return false;
        }
    }

    /**
     * 删除模块
     * @return bool
     */
    public function delete()
    {
        if(!$this->validate()){
            return false;
        }

        // 开启事务
        $transaction = Yii::$app->db->beginTransaction();

        $module = &$this;

        $module->status     = self::DELETED_STATUS;
        $module->updater_id = Yii::$app->user->identity->id;

        if(!$module->save()){
            $this->addError($module->getErrorLabel(), $module->getErrorMessage());
            $transaction->rollBack();
            return false;
        }

        // 保存操作日志
        $log = new CreateLog();
        $log->project_id  = $module->project->id;
        $log->object_name = 'module';
        $log->object_id   = $module->id;
        $log->type        = 'delete';
        $log->content     = '删除了 模块 ' . '<code>' . $module->title . '</code>';

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
