<?php
namespace app\models;

use Yii;
use app\widgets\LinkPager;
use yii\data\Pagination;

/**
 * This is the model class for table "{{%apply}}".
 *
 * @property int $id
 * @property int $project_id 项目id
 * @property int $user_id 申请用户id
 * @property int $status 审核状态
 * @property string $ip IP
 * @property string $location ip定位地址
 * @property string $created_at 申请日期
 * @property string $updated_at 更新时间
 * @property string $checked_at 处理日期
 */
class Apply extends Model
{
    const CHECK_STATUS = 10; //待审核状态
    const PASS_STATUS  = 20; //审核通过状态
    const REFUSE_STATUS = 30; //审核拒绝状态

    public $statusLabels = [
        self::CHECK_STATUS => '审核中',
        self::PASS_STATUS => '审核通过',
        self::REFUSE_STATUS => '审核拒绝',
    ];

    /**
     * 绑定数据表
     */
    public static function tableName()
    {
        return '{{%apply}}';
    }

    /**
     * 验证规则
     */
    public function rules()
    {
        return [
            [['project_id', 'user_id', 'ip', 'location'], 'required'],
            [['project_id', 'user_id', 'status'], 'integer'],
            [['created_at', 'updated_at', 'checked_at'], 'safe'],
            [['ip', 'location'], 'string', 'max' => 250],
        ];
    }

    /**
     * 字段标签
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project_id' => '项目id',
            'user_id' => '申请用户id',
            'status' => '审核状态',
            'ip' => 'IP',
            'location' => 'ip定位地址',
            'created_at' => '申请日期',
            'updated_at' => '更新时间',
            'checked_at' => '处理日期',
        ];
    }

    /**
     * 获取项目
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(),['id'=>'project_id']);
    }

    /**
     * 获取申请者
     * @return \yii\db\ActiveQuery
     */
    public function getApplier()
    {
        return $this->hasOne(Account::className(),['id'=>'user_id']);
    }

    /**
     * 申请搜索
     * @param array $params
     * @return $this
     * @throws \Exception
     */
    public function search($params = [])
    {
        $this->params = array2object($params);

        $query = self::find()->joinWith('project');

        if(!$this->params->order_by){
            $this->params->order_by = 'id DESC';
        }

        $query->andFilterWhere(['like', '{{%project}}.title', trim($this->params->title)]);

        $query->andFilterWhere([
            '{{%project}}.creater_id' => $this->params->creater_id,
        ]);

        $query->andFilterWhere([
            '{{%apply}}.project_id' => $this->params->project_id,
        ]);

        // 审核状态搜索
        $query->andFilterWhere([
            '{{%apply}}.status' => $this->params->status,
        ]);

        // 获取我创建的项目
        $account = Yii::$app->user->identity;

        $project_ids = $account->getCreatedProjects(Project::ACTIVE_STATUS)->select('id')->column();
        $project_ids = $project_ids ? : [-1];

        $query->andFilterWhere(['in', '{{%apply}}.project_id', $project_ids]);

        // 申请人搜索
        if($this->params->user->name){

            $user_ids = Account::find()
                ->andFilterWhere([
                    'or',
                    ['like','name', $this->params->user->name],
                    ['like','email', $this->params->user->name],
                ])
                ->select('id')->column();

            $user_ids = $user_ids ? : [-1];

            $query->andFilterWhere(['in', '{{%apply}}.user_id', $user_ids]);
        }

        $status = [];
        $this->params->check_status && $status[]  = $this->params->check_status;
        $this->params->pass_status && $status[]   = $this->params->pass_status;
        $this->params->refuse_status && $status[] = $this->params->refuse_status;

        $query->andFilterWhere(['in', '{{%apply}}.status', $status]);

        $this->count = $query->count();

        $pagination = new Pagination([
            'pageSizeParam' => false,
            'totalCount' => $this->count,
            'pageSize'   => $this->pageSize,
            'validatePage' => false,
        ]);

        $this->models = $query
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->orderBy($this->params->order_by)
            ->all();

        $this->sql = $query->createCommand()->getRawSql();

        $this->pages = LinkPager::widget([
            'pagination' => $pagination,
            'nextPageLabel' => '下一页',
            'prevPageLabel' => '上一页',
            'firstPageLabel' => '首页',
            'lastPageLabel' => '尾页',
            'hideOnSinglePage' => true,
            'maxButtonCount' => 5,
        ]);

        return $this;
    }
}
