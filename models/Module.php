<?php
namespace app\models;

use Yii;
use app\widgets\LinkPager;
use yii\data\Pagination;

/**
 * This is the model class for table "doc_module".
 *
 * @property int $id
 * @property string $encode_id 加密id
 * @property int $project_id 项目id
 * @property string $title 模块名称
 * @property string $remark 项目描述
 * @property int $status 模块状态
 * @property int $sort 模块排序
 * @property int $creater_id 创建者id
 * @property int $updater_id 更新者id
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 */
class Module extends Model
{
    /**
     * 绑定数据表
     */
    public static function tableName()
    {
        return '{{%module}}';
    }

    /**
     * 验证规则
     */
    public function rules()
    {
        return [
            [['encode_id', 'project_id', 'title', 'status', 'creater_id'], 'required'],

            [['project_id', 'status', 'sort', 'creater_id', 'updater_id'], 'integer'],
            [['encode_id'], 'string', 'max' => 50],
            [['title'], 'string', 'max' => 50],
            [['remark'], 'string', 'max' => 250],
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
            'encode_id'  => '加密id',
            'project_id' => '项目id',
            'version_id' => '版本id',
            'title'  => '模块名称',
            'remark' => '项目描述',
            'status' => '模块状态',
            'sort'   => '模块排序',
            'creater_id' => '创建者id',
            'updater_id' => '更新者id',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * 获取所属项目
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(),['id'=>'project_id']);
    }

    /**
     * 获取模块接口
     * @return \yii\db\ActiveQuery
     */
    public function getApis()
    {
        $filter = [
            'status' => Api::ACTIVE_STATUS
        ];

        $sort = [
            'sort' => SORT_DESC,
            'id'   => SORT_DESC
        ];

        return $this->hasMany(Api::className(), ['module_id' => 'id'])->where($filter)->orderBy($sort);
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

    /**
     * 模块搜索
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
            'totalCount'    => $this->count,
            'pageSize'      => $this->pageSize,
            'validatePage'  => false,
        ]);

        $this->models = $query
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->orderBy('id DESC')
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
