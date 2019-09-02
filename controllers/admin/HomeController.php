<?php
namespace app\controllers\admin;

use Yii;
use yii\helpers\Url;
use app\models\Project;
use app\models\Tongji;

class HomeController extends PublicController
{
    /**
     * 后台主页
     * @return string|\yii\web\Response
     * @throws \yii\db\Exception
     */
    public function actionIndex()
    {
        if(Yii::$app->user->isGuest){
            return $this->redirect(['home/account/login', 'callback' => Url::current()]);
        }

        // 系统信息
        $system['installed_at']  = Project::findModel()->getInstallTime();
        $system['app_os']        = PHP_OS;
        $system['app_version']   = Yii::$app->params['app_version'];
        $system['php_version']   = PHP_VERSION;
        $system['mysql_version'] = Yii::$app->db->createCommand('select version()')->queryScalar();

        // 统计信息
        $tongji = new Tongji();

        return $this->display('index', ['system' => array2object($system), 'tongji' => $tongji]);
    }
}
