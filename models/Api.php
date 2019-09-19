<?php
namespace app\models;

use Yii;
use yii\data\Pagination;
use app\widgets\LinkPager;

/**
 * This is the model class for table "doc_api".
 *
 * @property int $id
 * @property string $encode_id 加密id
 * @property int $project_id 项目id
 * @property int $module_id 模块id
 * @property string $title 接口名
 * @property string $request_method 请求方式
 * @property string $response_format 响应格式
 * @property string $uri 接口路径
 * @property string $remark 接口简介
 * @property int $status 接口状态
 * @property int $sort 接口排序
 * @property int $creater_id 创建者id
 * @property int $updater_id 更新者id
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 */
class Api extends Model
{
    /**
     * 请求方式标签
     * @var array
     */
    public $requestMethodLabels = [
        'get'    => 'GET',
        'post'   => 'POST',
        'put'    => 'PUT',
        'delete' => 'DELETE',
    ];

    /**
     * 响应格式标签
     * @var array
     */
    public $responseFormatLabels = [
        'json'=> 'JSON',
        'xml' => 'XML',
    ];

    /**
     * 绑定数据表
     */
    public static function tableName()
    {
        return '{{%api}}';
    }

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['encode_id', 'project_id', 'module_id', 'title', 'request_method', 'response_format', 'status', 'sort', 'creater_id'], 'required'],

            [['project_id', 'module_id', 'status', 'sort', 'creater_id','updater_id'], 'integer'],
            [['encode_id', 'request_method', 'response_format'], 'string', 'max' => 20],
            [['title', 'uri', 'remark'], 'string', 'max' => 250],
            [['encode_id'], 'unique'],

            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * 字段字典
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => '接口id',
            'encode_id' => '加密id',
            'project_id' => '项目id',
            'module_id' => '模块id',
            'title' => '接口名',
            'request_method' => '请求方式',
            'response_format' => '响应格式',
            'uri' => '接口路径',
            'remark' => '接口简介',
            'status' => '接口状态',
            'sort' => '接口排序',
            'creater_id' => '创建者id',
            'updater_id' => '更新者id',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * 获取接口地址
     * @return string
     */
    public function getUrl($scheme = false)
    {
        return url('home/api/show', ['id' => $this->encode_id], $scheme);
    }

    /**
     * 获取当前请求方式标签
     * @return mixed
     */
    public function getRequestMethodLabel()
    {
        return $this->requestMethodLabels[$this->request_method];
    }

    /**
     * 获取当前响应格式标签
     * @return mixed
     */
    public function getResponseFormatLabel()
    {
        return $this->responseFormatLabels[$this->response_format];
    }

    /**
     * 获取关联项目
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(),['id'=>'project_id']);
    }

    /**
     * 获取关联模块
     * @return \yii\db\ActiveQuery
     */
    public function getModule()
    {
        return $this->hasOne(Module::className(),['id'=>'module_id']);
    }

    /**
     * 获取关联接口
     * @return \yii\db\ActiveQuery
     */
    public function getField()
    {
        return $this->hasOne(Field::className(),['api_id'=>'id']);
    }

    /**
     * 获取更新内容
     * @return string
     */
    public function getUpdateContent()
    {
        $content = '';
        foreach (array_filter($this->dirtyAttributes) as $name => $value) {

            $label = '<strong>' .  $this->getAttributeLabel($name) . '</strong>';

            if(isset($this->oldAttributes[$name])){

                switch ($name) {
                    case 'status':
                        $oldValue = '<code>' . $this->statusLabels[$this->oldAttributes[$name]] . '</code>';
                        $newValue = '<code>' . $this->statusLabels[$this->dirtyAttributes[$name]] . '</code>';
                        break;
                    default:
                        $oldValue = '<code>' . $this->oldAttributes[$name] . '</code>';
                        $newValue = '<code>' . $value . '</code>';
                }

                $content .= '将  ' . $label . ' 从' . $oldValue . '更新为' . $newValue . ',';
            }

        }

        return trim($content, ',');
    }

    /**
     * 接口搜素
     * @param array $params
     * @return $this
     * @throws \Exception
     */
    public function search($params = [])
    {
        $this->params = array2object($params);

        $query = self::find();

        $this->params->status && $query->andFilterWhere([
            'status' => $this->params->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->params->title]);

        $this->params->start_date && $query->andFilterWhere(['>=', 'created_at', $this->params->start_date . ' 00:00:00']);
        $this->params->end_date && $query->andFilterWhere(['<=', 'created_at', $this->params->end_date . ' 23:59:59']);

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
            ->orderBy('id DESC')
            ->all();

        $this->sql = $query->createCommand()->getRawSql();

//        dump($this->sql);

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
