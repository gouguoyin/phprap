<?php
namespace app\controllers\home;

use Yii;
use yii\web\Response;
use app\models\Api;
use app\models\Project;
use app\models\template\UpdateTemplate;

/**
 * Site controller
 */
class TemplateController extends PublicController
{

    /**
     * 更新模板
     * @param $id
     * @return array|string
     */
    public function actionForm($project_id)
    {

        $request = Yii::$app->request;

        $project = Project::findModel(['encode_id' => $project_id]);

        $template = UpdateTemplate::findModel(['project_id' => $project->id]);

        $api = Api::findModel();

        if($request->isPost){

            Yii::$app->response->format = Response::FORMAT_JSON;

            if(!$template->load($request->post())){

                return ['status' => 'error', 'message' => '加载数据失败'];

            }

            $template->project_id = $project->id;

            if ($template->store()) {

                return ['status' => 'success', 'message' => '保存成功'];

            }

            return ['status' => 'error', 'message' => $template->getErrorMessage(), 'label' => $template->getErrorLabel()];

        }

        return $this->display('form', ['project' => $project, 'template' => $template, 'api' => $api]);

    }

}
