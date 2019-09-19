<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "doc_field".
 *
 * @property int $id
 * @property string $encode_id 加密id
 * @property int $api_id 接口ID
 * @property string $header_fields header字段
 * @property string $request_fields 请求字段
 * @property string $response_fields 响应字段
 * @property int $creater_id 创建者id
 * @property int $updater_id 更新者id
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 */
class Field extends Model
{
    /**
     * 字段类型标签
     * @var array
     */
    public $fieldTypeLabels = [
        'string' => '字符串',
        'integer' => '整数',
        'float'   => '小数',
        'boolean' => '布尔',
        'object'  => '对象',
        'array'   => '数组',
    ];

    /**
     * 是否必须标签
     * @var array
     */
    public $requiredLabels = [
        '10' => '是',
        '20' => '否',
    ];

    /**
     * 默认header参数
     * @var array
     */
    public $defaultHeaderParams = [
        'Accept','Accept-Charset','Accept-Encoding','Accept-Language','Accept-Datetime','Accept-Ranges','Authorization',
        'Cache-Control','Connection','Cookie','Content-Disposition','Content-Length','Content-Type','Content-MD5',
        'Referer',
        'User-Agent',
        'X-Requested-With','X-Forwarded-For','X-Forwarded-Host','X-Csrf-Token'
    ];

    /**
     * 指定数据表
     */
    public static function tableName()
    {
        return '{{%field}}';
    }

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['api_id', 'creater_id', 'updater_id'], 'integer'],
            [['creater_id', 'created_at'], 'required'],
            [['header_fields', 'request_fields', 'response_fields'], 'string'],
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
            'id' => 'ID',
            'api_id' => '接口ID',
            'header_fields' => 'header字段',
            'request_fields' => '请求字段',
            'response_fields' => '响应字段',
            'creater_id' => '创建者id',
            'updater_id' => '更新者id',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * 判断字段是否是复合类型
     * @param $field
     * @return bool
     */
    public function isCompositeType($type)
    {
        return in_array($type, ['array', 'object']) ? true : false;
    }

    /**
     * 获取所属接口
     * @return \yii\db\ActiveQuery
     */
    public function getApi()
    {
        return $this->hasOne(Api::className(),['id'=>'api_id']);
    }

    /**
     * 获取header数组
     * @return array
     */
    public function getHeaderAttributes()
    {
        return json_decode($this->header_fields);
    }

    /**
     * 获取请求参数数组
     * @return array
     */
    public function getRequestAttributes()
    {
        return json_decode($this->request_fields);
    }

    /**
     * 获取响应参数数组
     * @return array
     */
    public function getResponseAttributes()
    {
        return json_decode($this->response_fields);
    }

    /**
     * 获取更新内容
     * @return string
     */
    public function getUpdateContent()
    {
        $content = '';
        foreach (array_filter($this->dirtyAttributes) as $name => $value) {

            $label = '<code>' .  $this->getAttributeLabel($name) . '</code>';

            if(isset($this->oldAttributes[$name])){
                $content .= '更新了  ' . $label . ',';
            }else{
                $content .= '添加了  ' . $label . ',';
            }

        }

        return trim($content, ',');
    }

}
