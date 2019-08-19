<?php
namespace app\models;

use Yii;
use Jenssegers\Agent\Agent;
use itbdw\Ip\IpLocation;

class Model extends \yii\db\ActiveRecord
{
    public $models;
    public $pages;
    public $params;
    public $query;
    public $count;
    public $sql;
    public $pageSize = 20;

    const ACTIVE_STATUS  = 10; //启用状态
    const DISABLE_STATUS = 20; //禁用状态
    const DELETED_STATUS = 30; //删除状态

    public $statusLabels = [
        self::ACTIVE_STATUS  => '正常',
        self::DISABLE_STATUS => '禁用',
        self::DELETED_STATUS => '删除',
    ];

    /**
     * 实例化模型
     * @param null $condition
     * @return Model|null
     */
    public static function findModel($condition = null)
    {
        if(!$condition){
            return new static();
        }

        if (($model = static::findOne($condition)) !== null) {
            return $model;
        }
    }

    /**
     * 获取错误字段
     * @return int|null|string
     */
    public function getErrorLabel()
    {
        return key($this->getFirstErrors());
    }

    /**
     * 获取错误信息
     * @return mixed
     */
    public function getErrorMessage()
    {
        return current($this->getFirstErrors());
    }

    /**
     * 创建加密id
     * @return string
     */
    public function createEncodeId()
    {
        return date('Y').substr(time(),-5).substr(microtime(),2,5);
    }

    /**
     * 获取状态文案
     * @return mixed
     */
    public function getStatusLabel()
    {
        return $this->statusLabels[$this->status];
    }

    /**
     * 获取创建者
     * @return \yii\db\ActiveQuery
     */
    public function getCreater()
    {
        return $this->hasOne(Account::className(),['id'=>'creater_id']);
    }

    /**
     * 获取更新者
     * @return \yii\db\ActiveQuery
     */
    public function getUpdater()
    {
        return $this->hasOne(Account::className(),['id'=>'updater_id']);
    }

    /**
     * 获取当前格式化时间
     * @param string $format
     * @return false|string
     */
    public function getNowTime($format = '')
    {
        $format = $format ? : 'Y-m-d H:i:s';
        return date($format);
    }

    /**
     * 获取友好的时间，如5分钟前
     * @return string
     */
    public function getFriendTime($time = null)
    {
        $time = $time ? strtotime($time) : time();
        return Yii::$app->formatter->asRelativeTime($time);
    }

    /**
     * 获取程序安装时间
     * @return mixed
     */
    public function getInstallTime()
    {
        $file = Yii::getAlias("@runtime") .'/install/install.lock';
        if(file_exists($file)){
            $install = file_get_contents($file);
            return json_decode($install)->installed_at;
        }
    }

    /**
     * 获取客户端IP
     * @return mixed|string|null
     */
    public function getUserIp()
    {
        return Yii::$app->request->userIP;
    }

    /**
     * 获取ip地理位置
     * @param null $ip
     * @return string
     */
    public function getLocation($ip = null)
    {
        $ip = $ip ? : $this->getUserIp();

        $location = IpLocation::getLocation($ip);

        $country  = $location['country'];
        $province = $location['province'];
        $city     = $location['city'] ? : $province;

        return $country . ' ' . $province . ' ' . $city;
    }

    /**
     * 获取访问者的操作系统
     * @return string
     */
    public function getOs()
    {
        $agent = new Agent();

        $platform = $agent->platform();
        $version  = $agent->version($platform);

        return $platform . '(' . $version . ')';
    }

    /**
     * 获取访问者浏览器
     * @return string
     */
    public function getBrowser()
    {
        $agent = new Agent();

        $browser = $agent->browser();
        $version = $agent->version($browser);

        return $browser . '(' . $version . ')';
    }

}
