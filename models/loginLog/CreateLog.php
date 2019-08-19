<?php
namespace app\models\loginLog;

use Yii;
use app\models\LoginLog;

class CreateLog extends LoginLog
{
    public function store()
    {
        $log = &$this;

        $log->user_id    = $this->user_id;
        $log->user_name  = $this->user_name;
        $log->user_email = $this->user_email;
        $log->ip         = $this->getUserIp();
        $log->location   = $this->getLocation();
        $log->browser    = $this->getBrowser();
        $log->os         = $this->getOs();
        $log->created_at = date('Y-m-d H:i:s');

        if(!$log->save()){
            $this->addError($log->getErrorLabel(), $log->getErrorMessage());
            return false;
        }

        return true;
    }
}