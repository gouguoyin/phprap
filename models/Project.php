<?php
namespace app\models;

use Yii;
use app\widgets\LinkPager;
use yii\data\Pagination;

/**
 * This is the model class for table "doc_project".
 *
 * @property int $id
 * @property string $encode_id 加密id
 * @property string $title 项目名称
 * @property string $remark 项目描述
 * @property int $sort 项目排序
 * @property int $type 项目类型
 * @property int $status 项目状态
 * @property int $creater_id 创建者id
 * @property int $updater_id 更新者id
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 */
class Project extends Model
{
    const PUBLIC_TYPE  = 10;
    const AUTH_TYPE    = 20;
    const PRIVATE_TYPE = 30;

    /**
     * 绑定数据表
     */
    public static function tableName()
    {
        return '{{%project}}';
    }

    /**
     * 验证规则
     */
    public function rules()
    {
        return [
            [['encode_id', 'title', 'status', 'creater_id'], 'required'],

            [['type', 'sort'], 'filter', 'filter' => 'intval'], //此规则必须，否则就算模型里该字段没有修改，也会出现在脏属性里
            [['encode_id'], 'string', 'max' => 50],
            [['title', 'remark'], 'string', 'max' => 250],
            [['encode_id'], 'unique'],

            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * 字段字典
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'encode_id' => '加密id',
            'title' => '项目名称',
            'remark' => '项目描述',
            'sort' => '项目排序',
            'status' => '项目状态',
            'type' => '项目类型',
            'creater_id' => '创建者id',
            'updater_id' => '更新者id',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * 项目所有类型标签
     * @return array
     */
    public function getTypeLabels()
    {
        return [
            self::PUBLIC_TYPE  => '公开项目',
//            self::AUTH_TYPE    => '授权项目',
            self::PRIVATE_TYPE => '私有项目',
        ];
    }

    /**
     * 获取当前项目类型标签
     * @return mixed
     */
    public function getTypeLabel()
    {
        return $this->typeLabels[$this->type];
    }

    public function getTemplate()
    {
        return $this->hasOne(Template::className(),['project_id'=>'id']);
    }

    /**
     * 获取项目环境
     * @return \yii\db\ActiveQuery
     */
    public function getEnvs()
    {
        $filter = ['status' => Env::ACTIVE_STATUS];
        $order = [
            'sort' =>SORT_DESC,
            'id'   => SORT_ASC
        ];
        return $this->hasMany(Env::className(), ['project_id' => 'id'])->where($filter)->orderBy($order);
    }

    /**
     * 获取项目模块
     * @return \yii\db\ActiveQuery
     */
    public function getModules()
    {
        $filter = [
            'status' => Module::ACTIVE_STATUS
        ];
        $order  = [
            'sort' =>SORT_DESC,
            'id'   => SORT_DESC
        ];

        return $this->hasMany(Module::className(), ['project_id' => 'id'])->where($filter)->orderBy($order);
    }

    /**
     * 获取项目接口
     * @return \yii\db\ActiveQuery
     */
    public function getApis()
    {
        $filter = [
            'status' => Api::ACTIVE_STATUS
        ];
        $order  = [
            'sort' =>SORT_DESC,
            'id'   => SORT_DESC
        ];

        return $this->hasMany(Api::className(), ['project_id' => 'id'])->where($filter)->orderBy($order);
    }

    /**
     * 获取项目成员
     * @return \yii\db\ActiveQuery
     */
    public function getMembers()
    {
        return $this->hasMany(Member::className(), ['project_id' => 'id'])->orderBy(['id' => SORT_DESC]);
    }

    /**
     * 获取非项目成员(不包括自己)
     * @return \yii\db\ActiveQuery
     */
    public function getNotMembers($param = [])
    {
        $member_ids = $this->getMembers()->select('user_id')->column();

        $query = Account::find();

        $query->andFilterWhere(['status' => Account::ACTIVE_STATUS]);

        $query->andFilterWhere(['not in', 'id', $member_ids])
              ->andFilterWhere(['<>', 'id', $this->creater_id]);

        $query->andFilterWhere([
            'or',
            ['like','name', $param['name']],
            ['like','email', $param['name']],
        ]);

        return $query->all();
    }

    /**
     * 获取更新内容
     * @return string
     */
    public function getUpdateContent()
    {
        $content = '';

        foreach (array_filter($this->dirtyAttributes) as $name => $value) {

            $label = '<strong>' . $this->getAttributeLabel($name) . '</strong>';

            if(isset($this->oldAttributes[$name])){

                switch ($name) {
                    case 'status':
                        $oldValue = '<code>' . $this->statusLabels[$this->oldAttributes[$name]] . '</code>';
                        $newValue = '<code>' . $this->statusLabels[$this->dirtyAttributes[$name]] . '</code>';
                        break;
                    case 'type':
                        $oldValue = '<code>' . $this->typeLabels[$this->oldAttributes[$name]] . '</code>';
                        $newValue = '<code>' . $this->typeLabels[$this->dirtyAttributes[$name]] . '</code>';
                        break;
                    default:
                        $oldValue = '<code>' . $this->oldAttributes[$name] . '</code>';
                        $newValue = '<code>' . $value . '</code>';
                }

                $content .= '将 ' . $label . ' 从' . $oldValue . '更新为' . $newValue . ',';
            }

        }

        return trim($content, ',');
    }

    /**
     * 判断是否是项目创建者
     * @return bool
     */
    public function isCreater($user_id = 0)
    {
        $user_id = (int)$user_id ? $user_id : Yii::$app->user->identity->id;

        return $this->creater_id == $user_id ? true : false;
    }

    /**
     * 判断是否是项目参与者
     * @return bool
     */
    public function isJoiner($user_id = 0)
    {
        $user_id = (int)$user_id ? $user_id : Yii::$app->user->identity->id;

        $query = Member::find()->where(['project_id' => $this->id, 'user_id' => $user_id]);

        return $query->exists() ? true : false;
    }

    /**
     * 判断是否是公开项目
     * @return bool
     */
    public function isPublic()
    {
        return $this->type == self::PUBLIC_TYPE ? true : false;
    }

    /**
     * 判断是否是私有项目
     * @return bool
     */
    public function isPrivate()
    {
        return $this->type == self::PRIVATE_TYPE ? true : false;
    }

    /**
     * 获取项目地址
     * @return string
     */
    public function getUrl($scheme = false)
    {
        return url('home/project/show', ['id' => $this->encode_id], $scheme);
    }

    /**
     * 将对象转化为json
     * @return false|string
     */
    public function getJson()
    {
        $data['id']     = $this->id;
        $data['title']  = $this->title;
        $data['type']   = $this->type;
        $data['status'] = $this->status;
        $data['remark'] = $this->remark;
        $data['envs']   = $this->getEnvs()->select(['id','title','name','base_url','status'])->asArray()->all();
        foreach ($this->modules as $k1 => $v1) {
            $data['modules'][$k1]['id']     = $v1->id;
            $data['modules'][$k1]['title']  = $v1->title;
            $data['modules'][$k1]['status'] = $v1->status;
            $data['modules'][$k1]['remark'] = $v1->remark;
            foreach ($v1->apis as $k2 => $v2) {
                $data['modules'][$k1]['apis'][$k2]['id']                = $v2->id;
                $data['modules'][$k1]['apis'][$k2]['title']             = $v2->title;
                $data['modules'][$k1]['apis'][$k2]['request_method']    = $v2->requestMethodLabel;
                $data['modules'][$k1]['apis'][$k2]['response_format']   = $v2->responseFormatLabel;
                $data['modules'][$k1]['apis'][$k2]['request_url']       = $v2->url;
                $data['modules'][$k1]['apis'][$k2]['status']            = $v2->status;
                $data['modules'][$k1]['apis'][$k2]['remark']            = $v2->remark;
                $data['modules'][$k1]['apis'][$k2]['header_fields'][]   = $v2->field->headerAttributes;
                $data['modules'][$k1]['apis'][$k2]['request_fields'][]  = $v2->field->requestAttributes;
                $data['modules'][$k1]['apis'][$k2]['response_fields'][] = $v2->field->responseAttributes;
            }
        }
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 获取项目角色
     * @param int $user_id
     * @return string
     */
    public function getRole($user_id = 0)
    {
        if($this->isCreater($user_id)){
            return '创建者';
        }
        if($this->isJoiner($user_id)){
            return '项目成员';
        }

        return '普通游客';
    }

    /**
     * 检测是否有操作权限
     * @param array $auths e.g ['project' => 'look,export','module' => 'look']
     * @param int $user_id
     * @return bool
     */
    public function hasAuth($auths, $user_id = 0)
    {
        $user_id = (int)$user_id ? $user_id : Yii::$app->user->identity->id;

        $account = Account::findModel($user_id);

        // 系统管理员拥有一切权限
        if($account->isAdmin){
            return true;
        }

        // 项目创建者拥有所有权限
        if($this->isCreater($user_id)){
            return true;
        }

        $member = Member::findOne(['project_id' => $this->id, 'user_id' => $user_id]);

        if(!$member->id){
            return false;
        }

        if($member->hasAuth($auths)){
            return true;
        }

        return false;
    }

    /**
     * 项目搜索
     * @param array $params
     * @return $this
     * @throws \Exception
     */
    public function search($params = [])
    {
        $this->params = array2object($params);

        if(!$this->params->orderBy){
            $this->params->orderBy = 'id desc';
        }

        $query = self::find()->joinWith('creater');

        $query->andFilterWhere([
            '{{%project}}.creater_id' => $this->params->creater_id,
        ]);

        $this->params->status && $query->andFilterWhere([
            '{{%project}}.status' => $this->params->status,
        ]);

        $this->params->type && $query->andFilterWhere(['in', '{{%project}}.type', $this->params->type]);

        $query->andFilterWhere(['like', '{{%project}}.title', $this->params->title]);

        $this->params->start_date && $query->andFilterWhere(['>=', '{{%project}}.created_at', $this->params->start_date . ' 00:00:00']);
        $this->params->end_date && $query->andFilterWhere(['<=', '{{%project}}.created_at', $this->params->end_date . ' 23:59:59']);

        if($this->params->joiner_id){
            $project_ids = Member::find()->where(['user_id' => $this->params->joiner_id])->select('project_id')->column();

            if(!$project_ids){
                $project_ids = [-1];
            }
            $query->andFilterWhere(['in', '{{%project}}.id', $project_ids]);
        }

        $query->andFilterWhere([
            'or',
            ['like','{{%user}}.name', $this->params->user->name],
            ['like','{{%user}}.email', $this->params->user->name],
        ]);

        $this->count = $query->count();

        $pagination = new Pagination([
            'pageSizeParam' => false,
            'totalCount'    => $this->count,
            'pageSize'      => $this->pageSize,
            'validatePage'  => false,
        ]);

        $this->models = $query
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->orderBy($this->params->orderBy)
            ->all();

        $this->sql = $query->createCommand()->getRawSql();

        $this->pages = LinkPager::widget([
            'pagination'       => $pagination,
            'nextPageLabel'    => '下一页',
            'prevPageLabel'    => '上一页',
            'firstPageLabel'   => '首页',
            'lastPageLabel'    => '尾页',
            'hideOnSinglePage' => true,
            'maxButtonCount'   => 5,
        ]);

        return $this;
    }

}