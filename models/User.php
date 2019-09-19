<?php
namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property int $id
 * @property string $email 登录邮箱
 * @property string $name 昵称
 * @property string $password_hash 密码
 * @property string $auth_key
 * @property int $type 用户类型，10:普通用户 20:管理员
 * @property int $status 会员状态
 * @property string $ip 注册ip
 * @property string $location IP地址
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 */
class User extends Model implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['auth_key', 'status'], 'required'],
            [['type', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['email', 'name'], 'string', 'max' => 50],
            [['password_hash', 'auth_key', 'ip'], 'string', 'max' => 250],
            [['location'], 'string', 'max' => 255],
            [['email'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => '登录邮箱',
            'name' => '昵称',
            'password_hash' => '密码',
            'auth_key' => 'Auth Key',
            'type' => '用户类型，10:普通用户 20:管理员',
            'status' => '会员状态',
            'ip' => '注册ip',
            'location' => 'IP地址',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        if(file_exists(Yii::getAlias("@runtime") . '/install/install.lock')){
            return static::findOne(['id' => $id, 'status' => self::ACTIVE_STATUS]);
        }
        return null;
    }

    /**
     * 获取当前登录用户对象
     * @return null|IdentityInterface
     */
    public static function getIdentity()
    {
        return Yii::$app->account->identity;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::ACTIVE_STATUS,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

}
