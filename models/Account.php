<?php
namespace app\models;

use Yii;
use app\widgets\LinkPager;
use yii\data\Pagination;

class Account extends User
{
    const USER_TYPE  = 10; // 普通用户类型
    const ADMIN_TYPE = 20; // 管理员类型

    /**
     * 通过email查找用户
     * @param $email
     * @return Account|User|null
     */
    public static function findByEmail($email)
    {
        return self::findOne(['email' => $email]);
    }

    /**
     * 获取用户全名(昵称+邮箱)
     * @return string
     */
    public function getFullName()
    {
        return $this->name . '(' . $this->email . ')';
    }

    /**
     * 获取最近登录
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getLastLogin()
    {
        $filter = [
            'user_id' => $this->id,
        ];

        $sort = [
            'id' => SORT_DESC
        ];

        return LoginLog::find()->where($filter)->orderBy($sort)->one();
    }

    /**
     * 获取创建项目
     * @param null $type 项目类型
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedProjects($type = null)
    {
        return $this->hasMany(Project::className(),['creater_id'=>'id'])
            ->where(['status' => self::ACTIVE_STATUS])
            ->andFilterWhere(['type' => $type])
            ->orderBy(['sort' => SORT_DESC, 'id' => SORT_DESC]);
    }

    /**
     * 获取参与项目
     * @param null $type 项目类型
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getJoinedProjects($type = null)
    {
        return $this->hasMany(Project::className(), ['id' => 'project_id'])
            ->viaTable('{{%member}}', ['user_id' => 'id'])
            ->where(['status' => self::ACTIVE_STATUS])
            ->andFilterWhere(['type' => $type])
            ->orderBy(['sort' => SORT_DESC, 'id' => SORT_DESC]);
    }

    /**
     * 判断是否是系统管理员
     * @return bool
     */
    public function getIsAdmin()
    {
        return $this->type == self::ADMIN_TYPE ? true : false;
    }

    /**
     * 账户搜索
     * @param array $params
     * @return $this
     * @throws \Exception
     */
    public function search($params = [])
    {
        $this->params = array2object($params);

        $query = self::find();

        $query->andFilterWhere([
            'type' => $this->params->type
        ]);

        $this->params->start_date && $query->andFilterWhere(['>=', '{{%user}}.created_at', $this->params->start_date . ' 00:00:00']);
        $this->params->end_date && $query->andFilterWhere(['<=', '{{%user}}.created_at', $this->params->end_date . ' 23:59:59']);

        $this->params->status && $query->andFilterWhere([
            'status' => $this->params->status,
        ]);

        if($this->params->project_id){

            $project  = Project::findModel(['encode_id' => $this->params->project_id]);

            $user_ids = Member::find()->where(['project_id' => $project->id])->select('user_id')->column();

            if(!$user_ids){
                $user_ids = [0];
            }
            $query->andFilterWhere(['in', 'id', $user_ids]);
        }

        $query->andFilterWhere([
            'or',
            ['like','name', $this->params->name],
            ['like','email', $this->params->name],
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
            ->orderBy('id DESC')
            ->all();

        $this->sql = $query->createCommand()->getRawSql();

        $this->pages = LinkPager::widget([
            'pagination' => $pagination,
            'nextPageLabel' => '下一页',
            'prevPageLabel' => '上一页',
            'firstPageLabel' => '首页',
            'lastPageLabel'  => '尾页',
            'hideOnSinglePage' => true,
            'maxButtonCount'   => 5,
        ]);

        return $this;
    }

}
