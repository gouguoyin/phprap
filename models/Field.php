<?php

namespace app\models;

use Yii;
use yii\helpers\Html;

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
        'float' => '小数',
        'boolean' => '布尔',
        'object' => '对象',
        'array' => '数组',
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
        'Accept', 'Accept-Charset', 'Accept-Encoding', 'Accept-Language', 'Accept-Datetime', 'Accept-Ranges', 'Authorization',
        'Cache-Control', 'Connection', 'Cookie', 'Content-Disposition', 'Content-Length', 'Content-Type', 'Content-MD5',
        'Referer',
        'User-Agent',
        'X-Requested-With', 'X-Forwarded-For', 'X-Forwarded-Host', 'X-Csrf-Token'
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
        return $this->hasOne(Api::className(), ['id' => 'api_id']);
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

            $label = '<code>' . $this->getAttributeLabel($name) . '</code>';

            if (isset($this->oldAttributes[$name])) {
                $content .= '更新了  ' . $label . ',';
            } else {
                $content .= '添加了  ' . $label . ',';
            }

        }

        return trim($content, ',');
    }


    /**
     * 将用户提交json转化为内部json
     * @param $string
     * @return false|string
     */
    public static function json2SaveJson($string)
    {
        $array = json_decode($string, true);
        $return_array = self::parseJson($array, 0, 0);
        return json_encode($return_array, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 将用户提交json转化为内部json,递归
     * @param $array
     * @param int $level
     * @param int $pid
     * @return array
     */
    private static function parseJson($array, $level = 0, $pid = 0)
    {
        $field_array = [];
        if (gettype($array) == 'object') {
            $array = array($array);
        }

        foreach ($array as $key => $item) {
            $id = rand_id();
            $type = gettype($item);
            $recurrence = ($type == 'array' or $type == 'object');

            $field_array[] = [
                'id' => $id,
                'level' => strval($level),
                'parent_id' => strval($pid),
                'name' => $key,
                'title' => $key,
                'type' => $recurrence ? (isset($item[0]) ? 'array' : 'object') : $type,
                'required' => '10',
                'remark' => '',
                'example_value' => $recurrence ? '' : $item
            ];

            if ($recurrence) {
                $field_array = array_merge($field_array, self::parseJson($item, $level + 1, $id));
            }
        }

        return $field_array;
    }

    /**
     * 表单过滤后转json
     * @param $table
     * @return false|string
     */
    public static function form2json($table)
    {
        if (!is_array($table) || !$table) {
            return;
        }
        $array = [];
        foreach ($table as $k => $v) {
            foreach ($v as $k1 => $v1) {
                $array[$k1][$k] = trim(Html::encode($v1));
            }
        }

        return json_encode($array, JSON_UNESCAPED_UNICODE);
    }


    public static function compareMergeResponseArray(array $new, array $old): array
    {
        foreach ($new as $key => $item) {
            if (!isset($old[$key])) {
                $old[$key] = $item;
            }

            if ($old[$key]['type'] != $item['type']) {
                //只有当没有手动修改过response的才会替换覆盖
                if ($old[$key]['title'] == $old[$key]['name']) {
                    //储存最新的调试结果
                    $old[$key] = $item;
                }
            }
        }
        return $old;
    }

    public function getRequestJson(): string
    {
        //$this->request_fields = '[{"id":"2","parent_id":"0","level":"0","name":"retcode","title":"错误码","type":"string","example_value":"000000","remark":""},{"id":"3","parent_id":"0","level":"0","name":"desc","title":"接口信息","type":"string","example_value":"操作成功","remark":""},{"id":"4","parent_id":"0","level":"0","name":"biz","title":"返回主体内容","type":"object","example_value":"","remark":""},{"id":"10","parent_id":"4","level":"1","name":"settleDate","title":"结算日期","type":"string","example_value":"","remark":""},{"id":"6","parent_id":"4","level":"1","name":"records","title":"列表","type":"array","example_value":"","remark":""},{"id":"8","parent_id":"6","level":"2","name":"0","title":"key","type":"object","example_value":"","remark":""},{"id":"10","parent_id":"8","level":"3","name":"incomeTypeStr","title":"结算描述符","type":"string","example_value":"incomeTypeStr","remark":""},{"id":"10","parent_id":"8","level":"3","name":"incomeType","title":"结算类型","type":"integer","example_value":"1","remark":""},{"id":"9","parent_id":"8","level":"3","name":"amount","title":"结算金额","type":"string","example_value":"","remark":""},{"id":"5","parent_id":"4","level":"1","name":"totalAmount","title":"总数","type":"float","example_value":"","remark":""}]';
        $req = json_decode($this->request_fields, true);
        return json_encode($this->getRequestParams($req));
    }

    public function getResponseJson(): string
    {
        $req = json_decode($this->response_fields, true);

        return json_encode($this->getRequestParams($req));
    }


    /**
     * 获取请求参数
     * @param $request
     * @return array
     */
    private function getRequestParams($array): array
    {
        if (!$array) {
            return [];
        }
        //  var_dump($array);
        $params = [];
        $values = [];
       // var_dump($array);
        foreach ($array as $index => $request) {
            if (isset($request['level']) and isset($request['name']) and isset($request['parent_id']) and isset($request['id']) and isset($request['example_value']) and isset($request['type'])) {
                switch ($request['type']) {
                    case 'object':
                        $value = new \stdClass();
                        break;
                    case 'array':
                        $value = [];
                        break;
                    case 'integer':
                        $value = intval($request['example_value']);
                        break;
                    case 'float':
                        $value = floatval($request['example_value']);
                        break;
                    case 'boolean':
                        $value = boolval($request['example_value']);
                        break;
                    case 'string':
                    default:
                        $value = strval($request['example_value']);
                        break;
                }

                $values[$request['id']] = $value;
                if(strval($request['parent_id']) == '0') {
                    $params[$request['name']] = $value;
                }
                $this->dpJsonView($array, $values, $request, $params);
            }
        }

        return $params;
    }

    private function dpJsonView($array, &$values, $request, &$params)
    {
        foreach ($array as $v) {
            if ($v['id'] == $request['parent_id']) {
                if (strval($v['parent_id']) != '0') {
                    if (is_object($values[$v['id']])) {
                        $values[$v['id']]->{$request['name']} = $values[$request['id']];
                    } else {
                        $values[$v['id']] = [$values[$request['id']]];
                    }
                    return $this->dpJsonView($array, $values, $v, $params);
                } else {

                    if (is_object($params[$v['name']])) {
                        $params[$v['name']]->{$request['name']} = $values[$request['id']];
                    } else {
                        $params[$v['name']][] = $values[$request['id']];
                    }
                    return;
                }

            }
        }

        return;
    }
}

