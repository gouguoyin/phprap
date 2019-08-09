<?php
namespace app\controllers\home;

use Yii;
use app\models\Project;
use app\models\Api;

class ImportController extends PublicController
{
    /**
     * 导入项目
     * @param $id
     * @return string
     */
    public function actionProject($id)
    {
        $project = Project::findModel(['encode_id' => $id]);

        return $this->display('project', ['project' => $project]);
    }

    /**
     * 导入接口
     * @param $id
     * @return string
     */
    public function actionApi($id)
    {
        $api = Api::findModel(['encode_id' => $id]);

        return $this->display('api', ['api' => $api]);
    }

}
