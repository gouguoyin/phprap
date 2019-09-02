<?php

namespace app\models;

use Yii;
use yii\data\Pagination;
use app\widgets\LinkPager;

/**
 * This is the model class for table "doc_project_log".
 *
 * @property int $id
 * @property int $project_id 项目id
 * @property string $object_name 操作对象
 * @property int $object_id 操作对象ID
 * @property int $user_id 操作人id
 * @property string $type 操作类型
 * @property string $content 操作内容
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 */
class ProjectLog extends Model
{
    /**
     * 绑定数据表
     */
    public static function tableName()
    {
        return '{{%project_log}}';
    }

    /**
     * 验证规则
     */
    public function rules()
    {
        return [
            [['project_id', 'user_id', 'type', 'content'], 'required'],
            [['project_id', 'user_id', 'object_id'], 'integer'],
            [['content'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['type', 'object_name'], 'string', 'max' => 10],
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
            'object_name' => '操作对象',
            'object_id' => '操作对象ID',
            'user_id' => '操作人id',
            'type' => '操作类型',
            'content' => '操作内容',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * 操作对象标签
     */
    public function getObjectLabels()
    {
        return [
            'project' => '项目',
            'module' => '模块',
            'env' => '环境',
            'api' => '接口',
            'member' => '成员',
        ];
    }

    /**
     * 操作类型标签
     */
    public function getTypeLabels()
    {
        return [
            'create' => '创建',
            'update' => '更新',
            'delete' => '删除',
            'export' => '导出',
            'transfer' => '转移',
            'remove' => '移除',
            'quit' => '退出',
        ];
    }

    public function getAccount()
    {
        return $this->hasOne(Account::className(),['id'=>'user_id']);
    }

    public function search($params = [])
    {
        $this->params = array2object($params);

        $query = self::find();

        $query->andFilterWhere([
            'type'        => $this->params->type,
            'object_id'   => $this->params->object_id,
            'user_id'     => $this->params->user_id,
            'project_id'  => $this->params->project_id,
        ]);

        $query->andFilterWhere(['in', 'object_name', explode(',', $this->params->object_name)]);

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