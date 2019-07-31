<?php
namespace app\controllers\admin;

use app\models\Api;
use app\models\Module;
use app\models\Project;
use app\models\Tongji;
use Yii;
use yii\helpers\Url;

/**
 * Site controller
 */
class HomeController extends PublicController
{

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {

        if(Yii::$app->user->isGuest){
            return $this->redirect(['home/account/login', 'callback' => Url::current()]);
        }

        // 系统信息
        $system['installed_at'] = Project::findModel()->getInstallTime();
        $system['app_os'] = PHP_OS;
        $system['app_version'] = Yii::$app->params['app_version'];
        $system['php_version'] = PHP_VERSION;
        $system['mysql_version'] = Yii::$app->db->createCommand('select version()')->queryScalar();

        // 统计信息
        $tongji = new Tongji();

        return $this->display('index', ['system' => array2object($system), 'tongji' => $tongji]);

    }


}
