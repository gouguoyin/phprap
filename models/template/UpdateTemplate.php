<?php
namespace app\models\template;

use Yii;
use app\models\Template;

class UpdateTemplate extends Template
{

    /**
     * 保存模板
     * @return bool
     */
    public function store()
    {

        if(!$this->validate()){
            return false;
        }

        // 开启事务
        $transaction = Yii::$app->db->beginTransaction();

        $this->creater_id = Yii::$app->user->identity->id;
        $this->created_at = date('Y-m-d H:i:s');

        if(!$this->save()){
            $this->addError($this->getErrorLabel(), $this->getErrorMessage());
            $transaction->rollBack();
            return false;
        }

        // 事务提交
        $transaction->commit();

        return true;

    }

}
