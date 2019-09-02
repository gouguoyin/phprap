<?php
namespace app\models;

use Yii;

/**
 * This is the model class for table "doc_template".
 *
 * @property int $id
 * @property string $encode_id 加密id
 * @property int $project_id 项目id
 * @property string $header_field header字段，json格式
 * @property string $request_field 请求字段，json格式
 * @property string $response_field 响应字段，json格式
 * @property int $status 模板状态
 * @property int $creater_id 创建者id
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 */
class Template extends Module
{
    /**
     * 默认模板参数
     * @var array
     */
    public $defaultAttributes = [
        'header_field'  => [
            ['name' => 'Content-Type', 'title' => '', 'value' => 'application/json;charset=utf-8', 'remark' => ''],
            ['name' => 'Accept', 'title' => '', 'value' => 'application/json', 'remark' => ''],
        ],
        'request_field' => [
            ['name' => 'token', 'title' => '令牌', 'type' => 'string', 'required' => 10, 'default' => '' ,'remark' => ''],
        ],
        'response_field'=> [
            ['name' => 'code', 'title' => '返回状态码', 'type' => 'integer', 'mock' => ''],
            ['name' => 'message', 'title' => '返回信息', 'type' => 'string', 'mock' => ''],
            ['name' => 'data', 'title' => '数据实体', 'type' => 'array', 'mock' => '']
        ],
    ];

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
            [['project_id', 'status', 'creater_id'], 'integer'],
            [['header_field', 'request_field', 'response_field'], 'string'],
            [['encode_id'], 'string', 'max' => 10],
            [['project_id'], 'unique'],
            [['encode_id'], 'unique'],

            [['created_at', 'updated_at'], 'safe'],
            [['created_at'], 'default', 'value' => date('Y-m-d H:i:s')],
            [['status'], 'default', 'value'  => self::ACTIVE_STATUS],

            [['encode_id', 'project_id', 'header_field', 'request_field', 'response_field', 'status', 'creater_id'], 'required'],
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
            'header_field' => 'header字段',
            'request_field' => '请求字段',
            'response_field' => '响应字段',
            'status' => '模板状态',
            'creater_id' => '创建者id',
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
        return json_decode($this->header_field);

    }

    /**
     * 获取请求参数数组
     * @return object
     */
    public function getRequestAttributes()
    {
        return json_decode($this->request_field);
    }

    /**
     * 获取响应参数数组
     * @return object
     */
    public function getResponseAttributes()
    {
        return json_decode($this->response_field);
    }

    /**
     * 获取所属项目
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(),['id'=>'project_id'])->where(['status' => self::ACTIVE_STATUS])->orderBy(['sort' => SORT_DESC,'id' => SORT_DESC]);
    }

}
