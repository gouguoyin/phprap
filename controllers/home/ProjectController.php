<?php
namespace app\controllers\home;

use Yii;
use yii\helpers\Url;
use yii\web\Response;
use app\models\Config;
use app\models\Project;
use app\models\Template;
use app\models\Member;
use app\models\Field;
use app\models\ProjectLog;
use app\models\projectLog\CreateLog;
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
        if(Yii::$app->user->isGuest) {
            return $this->redirect(['home/account/login','callback' => Url::current()]);
        }

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

        $model = new CreateProject();

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
     * @param $id 项目ID
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
     * @param $id 项目ID
     * @param string $tab
     * @return string
     */
    public function actionShow($id, $tab = 'home')
    {
        $project = Project::findModel(['encode_id' => $id]);

        if(!$project->id){
            return $this->error('抱歉，项目不存在或者已被删除');
        }

        if(!Yii::$app->user->identity->isAdmin && $project->status !== $project::ACTIVE_STATUS){
            return $this->error('抱歉，项目已被禁用或已被删除');
        }

        if($project->isPrivate()) {
            if(Yii::$app->user->isGuest) {
                return $this->redirect(['home/account/login','callback' => Url::current()]);
            }

            if(!$project->hasAuth(['project' => 'look'])) {
                return $this->error('抱歉，您无权查看');
            }
        }

        $assign['project'] = $project;

        $params = Yii::$app->request->queryParams;

        $params['project_id'] = $project->id;

        switch ($tab) {
            case 'home':

                $view  = '/home/project/home';

                break;
            case 'template':

                if(!$project->hasAuth(['template' => 'look'])) {
                    return $this->error('抱歉，您无权查看');
                }

                $assign['template'] = Template::findModel(['project_id' => $project->id]);
                $assign['field'] = new Field();

                $view  = '/home/template/home';

                break;
            case 'env':

                if(!$project->hasAuth(['env' => 'look'])) {
                    return $this->error('抱歉，您无权查看');
                }

                $view = '/home/env/index';

                break;
            case 'member':

                if(!$project->hasAuth(['member' => 'look'])) {
                    return $this->error('抱歉，您无权查看');
                }

                $assign['member'] = Member::findModel()->search($params);

                $view  = '/home/member/index';

                break;
            case 'history':

                if(!$project->hasAuth(['project' => 'history'])) {
                    return $this->error('抱歉，您无权查看');
                }

                if(empty($params['object_name'])){
                    $params['object_name'] = 'project,env,member,module';
                }

                $assign['history'] = ProjectLog::findModel()->search($params);

                $view  = '/home/history/project';

                break;
        }

        return $this->display($view, $assign);
    }

    /**
     * 项目成员
     * @param $id 项目ID
     * @param null $name 搜索词
     * @return array
     */
    public function actionMember($id, $name = null)
    {
        if(Yii::$app->user->isGuest) {
            return $this->redirect(['home/account/login']);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $project = Project::findModel(['encode_id' => $id]);

        $members = $project->members;

        $user    = [];

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
     * @param $id 项目ID
     * @return array|string|Response
     */
    public function actionTransfer($id)
    {
        if(Yii::$app->user->isGuest) {
            return $this->redirect(['home/account/login']);
        }

        $request = Yii::$app->request;

        $model   = TransferProject::findModel(['encode_id' => $id]);

        if($request->isPost) {

            Yii::$app->response->format = Response::FORMAT_JSON;

            if (!$model->load($request->post())) {
                return ['status' => 'error', 'message' => '加载数据失败'];
            }

            if ($model->transfer()) {
                return ['status' => 'success', 'message' => '转让成功', 'callback' => url('home/project/select')];
            }

            return ['status' => 'error', 'message' => $model->getErrorMessage(), 'label' => $model->getErrorLabel()];

        }

        return $this->display('transfer', ['project' => $model]);
    }

    /**
     * @param $id 项目ID
     * @param string $format 导出格式 html|json
     * @return string
     */
    public function actionExport($id, $format = 'html')
    {
        $project = Project::findModel(['encode_id' => $id]);

        if(!$project->hasAuth(['project' => 'export'])){
            return $this->error("抱歉，您没有操作权限!");
        }

        $account = Yii::$app->user->identity;
        $cache   = Yii::$app->cache;

        $config = Config::findOne(['type' => 'app']);

        $cache_key      = 'project_' . $id . '_' . $account->id;
        $cache_interval = (int)$config->export_time;

        if($cache_interval >0 && $cache->get($cache_key) !== false){
            $remain_time = $cache->get($cache_key)  - time();
            if($remain_time >0 && $remain_time < $cache_interval){
                return $this->error("抱歉，导出太频繁，请{$remain_time}秒后再试!", 5);
            }
        }

        // 限制导出频率, 60秒一次
        $cache_interval >0 && Yii::$app->cache->set($cache_key, time() + $cache_interval, $cache_interval);

        $file_name = $project->title . '离线文档' . '.' . $format;

        // 记录操作日志
        $log = new CreateLog();
        $log->project_id  = $project->id;
        $log->object_name = 'project';
        $log->object_id   = $project->id;
        $log->type        = 'export';
        $log->content     = '导出了 ' . '<code>' . $file_name . '</code>';

        if(!$log->store()){
            return $this->error($log->getErrorMessage());
        }

        header ("Content-Type: application/force-download");

        switch ($format) {
            case 'html':
                header ("Content-Disposition: attachment;filename=$file_name");
                return $this->display('export', ['project' => $project]);
            case 'json':
                header ("Content-Disposition: attachment;filename=$file_name");
                return $project->getJson();
        }

    }

    /**
     * 删除项目
     * @param $id 项目ID
     * @return array|string
     */
    public function actionDelete($id)
    {
        if(Yii::$app->user->isGuest) {
            return $this->redirect(['home/account/login']);
        }

        $request = Yii::$app->request;

        $model = DeleteProject::findModel(['encode_id' => $id]);

        if($request->isPost) {

            Yii::$app->response->format = Response::FORMAT_JSON;

            if(!$model->load($request->post())) {
                return ['status' => 'error', 'message' => '数据加载失败'];
            }

            if($model->delete()) {
                return ['status' => 'success', 'message' => '删除成功', 'callback' => url('home/project/select')];
            }

            return ['status' => 'error', 'message' => $model->getErrorMessage(), 'label' => $model->getErrorLabel()];

        }

        return $this->display('delete', ['project' => $model]);
    }

    /**
     * 退出项目
     * @param $id 项目ID
     * @return array|string
     */
    public function actionQuit($id)
    {
        if(Yii::$app->user->isGuest) {
            return $this->redirect(['home/account/login']);
        }

        $request = Yii::$app->request;

        $model  = QuitProject::findModel(['encode_id' => $id]);

        $member = Member::findModel(['project_id' => $model->id, 'user_id' => Yii::$app->user->identity->id]);

        if($request->isPost) {

            Yii::$app->response->format = Response::FORMAT_JSON;

            if(!$model->load($request->post())) {
                return ['status' => 'error', 'message' => '数据加载失败'];
            }

            if($model->quit()) {
                return ['status' => 'success', 'message' => '退出成功', 'callback' => url('home/project/select')];
            }

            return ['status' => 'error', 'message' => $model->getErrorMessage(), 'label' => $model->getErrorLabel()];
        }

        return $this->display('quit', ['project' => $model, 'member' => $member]);
    }
}
