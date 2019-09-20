<?php
namespace app\models;

use Yii;
use yii\data\Pagination;
use app\widgets\LinkPager;

/**
 * This is the model class for table "{{%doc_template}}".
 *
 * @property int $id
 * @property string $encode_id 加密id
 * @property int $project_id 项目id
 * @property string $header_fields header参数，json格式
 * @property string $request_fields 请求参数，json格式
 * @property string $response_fields 响应参数，json格式
 * @property int $status 模板状态
 * @property int $creater_id 创建者id
 * @property int $updater_id 更新者id
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 */
class Template extends Model
{
    /**
     * 绑定数据表
     */
    public static function tableName()
    {
        return '{{%template}}';
    }

    /**
     * 验证规则
     */
    public function rules()
    {
        return [
            [['encode_id', 'project_id', 'status'], 'required'],
            [['project_id', 'status', 'creater_id', 'updater_id'], 'integer'],
            [['header_fields', 'request_fields', 'response_fields'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['encode_id'], 'string', 'max' => 50],
            [['encode_id'], 'unique'],
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
            'project_id' => '项目id',
            'header_fields' => 'header参数，json格式',
            'request_fields' => '请求参数，json格式',
            'response_fields' => '响应参数，json格式',
            'status' => '模板状态',
            'creater_id' => '创建者id',
            'updater_id' => '更新者id',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * 获取header参数数组
     * @return object
     */
    public function getHeaderAttributes()
    {
        return json_decode($this->header_fields);
    }

    /**
     * 获取请求参数数组
     * @return object
     */
    public function getRequestAttributes()
    {
        return json_decode($this->request_fields);
    }

    /**
     * 获取响应参数数组
     * @return object
     */
    public function getResponseAttributes()
    {
        return json_decode($this->response_fields);
    }

    /**
     * 获取所属项目
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(),['id'=>'project_id']);
    }

    /** 模板搜索
     * @param array $params
     * @return $this
     * @throws \Exception
     */
    public function search($params = [])
    {
        $this->params = array2object($params);

        $query = static::find();

        $pagination = new Pagination([
            'pageSizeParam' => false,
            'totalCount' => $query->count(),
            'pageSize'   => $this->pageSize,
            'validatePage' => false,
        ]);

        $this->models = $query
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->orderBy('id DESC')
            ->all();

        $this->count = $query->count();

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
