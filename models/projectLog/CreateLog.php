<?php
namespace app\models\projectLog;

use Yii;
use app\models\ProjectLog;

class CreateLog extends ProjectLog
{
    public function store()
    {
        $log = &$this;

        $log->user_id    = Yii::$app->user->identity->id;
        $log->project_id = $this->project_id;
        $log->type       = $this->type;
        $log->content    = $this->content;
        $log->created_at = date('Y-m-d H:i:s');

        if(!$log->save()) {
            $this->addError($log->getErrorLabel(), $log->getErrorMessage());
            return false;
        }

        return true;
    }
}