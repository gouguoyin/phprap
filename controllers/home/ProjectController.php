<?php
namespace app\controllers\home;

use Yii;
use yii\helpers\Url;
use yii\web\Response;
use app\models\Project;
use app\models\Template;
use app\models\Member;
use app\models\project\CreateProject;
use app\models\project\UpdateProject;
use app\models\project\QuitProject;
use app\models\project\TransferProject;
use app\models\project\DeleteProject;

class ProjectController extends PublicController
{
    public $checkLogin = false;

    /**
     * 选择项目
     * @return string
     */
    public function actionSelect()
    {
        if(Yii::$app->user->isGuest) {
            return $this->redirect(['home/account/login','callback' => Url::current()]);
        }

        return $this->display('select');
    }

    /**
     * 搜索项目
     * @return string
     */
    public function actionSearch()
    {
        $params = Yii::$app->request->queryParams;

        $params['status'] = Project::ACTIVE_STATUS;
        $params['type']   = Project::PUBLIC_TYPE;

        $model = Project::findModel()->search($params);

        return $this->display('search', ['project' => $model]);
    }

    /**
     * 添加项目
     * @return string
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;

        if(Yii::$app->user->isGuest) {
            return $this->redirect(['home/account/login']);
        }

        $model = CreateProject::findModel();

        if($request->isPost) {

            Yii::$app->response->format = Response::FORMAT_JSON;

            if(!$model->load($request->post())) {
                return ['status' => 'error', 'message' => '加载数据失败'];
            }

            if($model->store()) {
                return ['status' => 'success', 'message' => '添加成功'];
            }

            return ['status' => 'error', 'message' => $model->getErrorMessage(), 'label' => $model->getErrorLabel()];

        }

        return $this->display('create', ['project' => $model]);
    }

    /**
     * 编辑项目
     * @param $id
     * @return array|string
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;

        if(Yii::$app->user->isGuest) {
            return $this->redirect(['home/account/login']);
        }

        $model = UpdateProject::findModel(['encode_id' => $id]);

        if($request->isPost) {

            Yii::$app->response->format = Response::FORMAT_JSON;

            if(!$model->load($request->post())) {
                return ['status' => 'error', 'message' => '加载数据失败'];
            }

            if($model->store()) {
                return ['status' => 'success', 'message' => '编辑成功'];
            }

            return ['status' => 'error', 'message' => $model->getErrorMessage(), 'label' => $model->getErrorLabel()];

        }

        return $this->display('update', ['project' => $model]);
    }

    /**
     * 项目详情
     * @param $token
     * @param string $tab
     * @return string
     */
    public function actionShow($id, $tab = 'home')
    {
        $project = Project::findModel(['encode_id' => $id]);

        if($project->isPrivate()) {

            if(Yii::$app->user->isGuest) {
                return $this->redirect(['home/account/login','callback' => Url::current()]);
            }

            if(!$project->hasAuth(['project' => 'look'])) {
                return $this->error('抱歉，您无权查看');
            }
        }

        $params['project_id'] = $project->id;

        $data['project'] = $project;

        switch ($tab) {
            case 'home':

                $view  = '/home/project/home';

                break;

            case 'template':

                if(!$project->hasAuth(['template' => 'look'])) {
                    return $this->error('抱歉，您无权查看');
                }

                $data['template'] = Template::findModel(['project_id' => $project->id]);

                $view  = '/home/template/home';

                break;

            case 'env':

                $view = '/home/env/index';

                break;

            case 'member':

                if(!$project->hasAuth(['member' => 'look'])) {
                    return $this->error('抱歉，您无权查看');
                }

                $data['member'] = Member::findModel()->search($params);

                $view  = '/home/member/index';

                break;
        }

        return $this->display($view, $data);
    }

    /**
     * 项目成员
     * @param $id
     * @param null $name
     * @return array
     */
    public function actionMember($id, $name = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $project = Project::findModel(['encode_id' => $id]);

        $members = $project->members;

        $user = [];

        foreach ($members as $k => $member){
            if(strpos($member->account->name, $name) !== false || strpos($member->account->email, $name) !== false){
                $user[$k]['id']   = $member->account->id;
                $user[$k]['name'] = $member->account->fullName;
            }
        }
        // 重建索引
        return array_values($user);
    }

    /**
     * 转让项目
     * @return string
     */
    public function actionTransfer($id)
    {
        $request = Yii::$app->request;

        $model   = TransferProject::findModel(['encode_id' => $id]);

        if($request->isPost) {

            Yii::$app->response->format = Response::FORMAT_JSON;

            if (!$model->load($request->post())) {
                return ['status' => 'error', 'message' => '加载数据失败'];
            }

            if ($model->transfer()) {
                $callback = url('home/project/select');
                return ['status' => 'success', 'message' => '转让成功', 'callback' => $callback];
            }

            return ['status' => 'error', 'message' => $model->getErrorMessage(), 'label' => $model->getErrorLabel()];

        }

        return $this->display('transfer', ['project' => $model]);
    }

    /**
     * 导出项目
     * @param $id
     * @return string
     */
    public function actionExport($id)
    {
        $project = Project::findModel(['encode_id' => $id]);

        if(!$project->hasAuth(['project' => 'export'])){
            return $this->error("抱歉，您没有操作权限!");
        }

        $account = Yii::$app->user->identity;
        $cache   = Yii::$app->cache;

        $cache_key = 'project_' . $id . '_' . $account->id;
        $cache_interval = 60;

        if($cache->get($cache_key) !== false){
            $remain_time = $cache->get($cache_key)  - time();
            if($remain_time < $cache_interval){
                $this->error("抱歉，导出太频繁，请{$remain_time}秒后再试!", 5);
            }
        }

        $file_name = $project->title . '接口离线文档.html';

        header ("Content-Type: application/force-download");
        header ("Content-Disposition: attachment;filename=$file_name");

        // 限制导出频率, 60秒一次
        Yii::$app->cache->set($cache_key, time() + $cache_interval, $cache_interval);

        return $this->display('export', ['project' => $project]);
    }

    /**
     * 删除项目
     * @param $id
     * @return array|string
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;

        $model = DeleteProject::findModel(['encode_id' => $id]);

        if($request->isPost) {

            Yii::$app->response->format = Response::FORMAT_JSON;

            if(!$model->load($request->post())) {
                return ['status' => 'error', 'message' => '数据加载失败'];
            }

            if($model->delete()) {
                return ['status' => 'success', 'message' => '删除成功'];
            }

            return ['status' => 'error', 'message' => $model->getErrorMessage(), 'label' => $model->getErrorLabel()];

        }

        return $this->display('delete', ['project' => $model]);
    }

    /**
     * 退出项目
     * @param $id
     * @return array|string
     */
    public function actionQuit($id)
    {
        $request = Yii::$app->request;

        $model  = QuitProject::findModel(['encode_id' => $id]);

        $member = Member::findModel(['project_id' => $model->id, 'user_id' => Yii::$app->user->identity->id]);

        if($request->isPost) {

            Yii::$app->response->format = Response::FORMAT_JSON;

            if(!$model->load($request->post())) {
                return ['status' => 'error', 'message' => '数据加载失败'];
            }

            if($model->quit()) {
                return ['status' => 'success', 'message' => '退出成功'];
            }

            return ['status' => 'error', 'message' => $model->getErrorMessage(), 'label' => $model->getErrorLabel()];

        }

        return $this->display('quit', ['project' => $model, 'member' => $member]);
    }
}
