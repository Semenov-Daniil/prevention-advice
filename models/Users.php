<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use app\components\PasswordValidator;

/**
 * This is the model class for table "pa_users".
 *
 * @property int $id
 * @property string $login
 * @property string $password
 * @property int $roles_id
 * @property string|null $token
 *
 * @property Roles $roles
 */
class Users extends ActiveRecord implements IdentityInterface
{
    const SCENARIO_REGISTER = 'register';

    public $role;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pa_users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['login', 'password'], 'required'],
            [['roles_id'], 'integer'],
            [['login', 'password', 'token'], 'string', 'max' => 255],
            [['token'], 'unique'],
            [['roles_id'], 'exist', 'skipOnError' => true, 'targetClass' => Roles::class, 'targetAttribute' => ['roles_id' => 'id']],

            [['login'], 'unique', 'on' => static::SCENARIO_REGISTER],
            [['password'], PasswordValidator::class, 'on' => static::SCENARIO_REGISTER],
        ];
    }

    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Логин',
            'password' => 'Пароль',
            'roles_id' => 'Роль',
            'role' => 'Роль',
            'token' => 'Токен',
        ];
    }

    /**
     * Gets query for [[Roles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRoles()
    {
        return $this->hasOne(Roles::class, ['id' => 'roles_id']);
    }

    public function getTitleRoles()
    {
        return Roles::findOne($this->roles_id)->title;
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['token' => $token]);
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string|null current user auth key
     */
    public function getAuthKey()
    {
        // return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return bool|null if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        // return $this->getAuthKey() === $authKey;
    }
}
