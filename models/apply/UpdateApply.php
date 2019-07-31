<?php
namespace app\models\apply;

use Yii;
use app\models\Apply;

/**
 * This is the model class for form "UpdateApply".
 *
 * @property string $password 登录密码
 */
class UpdateApply extends Apply
{

    public $password; // 登录密码

    /**
     * 验证规则
     */
    public function rules()
    {

        return [
            [['status'], 'required'],

            [['status'], 'integer'],
            [['updated_at', 'expired_at', 'checked_at'], 'safe'],

            ['password', 'required', 'message' => '登录密码不可以为空'],

            ['password', 'validatePassword'],
            ['project_id', 'validateProject'],
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
     * 验证申请是否唯一
     * @param $attribute
     */
    public function validateProject($attribute)
    {
        if(!$this->project->isCreater()){
            $this->addError($attribute, '抱歉，您没有操作权限');
        }

    }

    /**
     * 保存申请
     * @return bool
     */
    public function store()
    {

        // 开启事务
        $transaction = Yii::$app->db->beginTransaction();

        if(!$this->validate()){
            return false;
        }

        $apply = &$this;

        $apply->status       = $this->status;
        $apply->checked_at   =  date('Y-m-d H:i:s');

        if(!$apply->save()){
            $this->addError($apply->getErrorLabel(), $apply->getErrorMessage());
            $transaction->rollBack();
            return false;
        }
        
        // 事务提交
        $transaction->commit();

        return true;

    }

}
