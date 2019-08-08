<?php
namespace app\models\api;

use Yii;
use app\models\Api;

class DeleteApi extends Api
{

    public $password;

    public function rules()
    {
        return [
            ['password', 'required', 'message' => '密码不可以为空'],

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
    public function validateProject($attribute)
    {
        if(!$this->project->hasRule('api', 'delete')){
            $this->addError($attribute, '抱歉，您没有操作权限');
            return false;
        }
    }

    /**
     * 删除接口
     * @return bool
     */
    public function delete()
    {
        if(!$this->validate()){
            return false;
        }

        // 开启事务
        $transaction = Yii::$app->db->beginTransaction();

        // 保存接口
        $api = &$this;

        $api->status = self::DELETED_STATUS;

        $api->updater_id = Yii::$app->user->identity->id;
        $api->updated_at = date('Y-m-d H:i:s');

        if(!$api->save()){
            $this->addError($api->getErrorLabel(), $api->getErrorMessage());
            $transaction->rollBack();
            return false;
        }

        // 事务提交
        $transaction->commit();

        return true;

    }

}
