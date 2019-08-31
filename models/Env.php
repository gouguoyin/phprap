<?php
namespace app\models;

use Yii;

/**
 * This is the model class for table "doc_env".
 *
 * @property int $id
 * @property string $encode_id 加密id
 * @property string $title 环境名称
 * @property string $name 环境标识
 * @property string $base_url 环境根路径
 * @property int $sort 环境排序
 * @property int $status 环境状态
 * @property int $project_id 项目id
 * @property int $creater_id 创建者id
 * @property int $updater_id 更新者id
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 */
class Env extends Model
{
    /**
     * 默认环境
     * @var array
     */
    public $defaultEnvs = [
        1 => [
            'name'  => 'product',
            'title' => '生产环境',
        ],
        2 => [
            'name'  => 'develop',
            'title' => '开发环境',
        ],
        3 => [
            'name'  => 'test',
            'title' => '测试环境',
        ]
    ];

    /**
     * 绑定数据表
     */
    public static function tableName()
    {
        return '{{%env}}';
    }

    /**
     * 验证规则
     */
    public function rules()
    {
        return [
            [['sort', 'status', 'project_id', 'creater_id'], 'integer'],
            [['name'], 'string', 'max' => 10],
            [['title','encode_id'], 'string', 'max' => 50],
            [['base_url'], 'string', 'max' => 250],
            [['encode_id'], 'unique'],

            [['created_at', 'updated_at'], 'safe'],

            [['encode_id', 'title', 'name', 'base_url', 'project_id', 'creater_id'], 'required'],
        ];
    }

    /**
     * 字段字典
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => '环境id',
            'encode_id' => '加密id',
            'name' => '环境标识',
            'title' => '环境名称',
            'base_url' => '环境根路径',
            'status' => '环境状态',
            'sort' => '环境排序',
            'project_id' => '项目id',
            'creater_id' => '创建者id',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
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
     * 创建还不存在的下个环境
     * @return string
     */
    public function getNextEnv()
    {
        $query = self::find();

        $filter = [
            'project_id' => $this->project_id,
            'status'     => self::ACTIVE_STATUS,
        ];

        $filter['name'] = 'product';

        if(!$query->where($filter)->exists()){

            return $this->defaultEnvs[1];
        }

        $filter['name'] = 'develop';
        if(!$query->where($filter)->exists()){
            return $this->defaultEnvs[2];
        }

        $filter['name'] = 'test';
        if(!$query->where($filter)->exists()){
            return $this->defaultEnvs[3];
        }
    }

    /**
     * 获取更新内容
     * @return string
     */
    public function getUpdateContent()
    {
        $content = '';
        foreach (array_filter($this->dirtyAttributes) as $name => $value) {

            $label = '<strong>' . $this->oldAttributes['title'] . '->' . $this->getAttributeLabel($name) . '</strong>';

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

                $content .= '将 ' . $label . ' 从' . $oldValue . '更新为' . $newValue . ',';
            }

        }

        return trim($content, ',');
    }
}
