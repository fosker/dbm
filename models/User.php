<?php

namespace app\models;

use Yii;
use app\models\Profile;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $email
 * @property string $username
 * @property string $password_hash
 * @property strin $access_token
 * @property Profile $profile
 * @property string $secret_key
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */

    public $password;
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'username', 'password'], 'required'],
            [['email', 'username'], 'string', 'max' => 30],
            [['password'], 'string', 'max' => 255],
            ['email', 'email'],
            ['email', 'unique', 'message' => 'Этот email уже использован.'],
            ['username', 'unique', 'message' => 'Этот никнейм уже использован.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'username' => 'Username',
            'password' => 'Password',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'id']);
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAccessToken()
    {
        $this->access_token = Yii::$app->security->generateRandomString();
    }
    
    public static function findBySecretKey($key)
    {       
        return static::findOne(
        [
            'secret_key' => $key
        ]);
    }
    
    public function generateSecretKey()
    {
        $key = Yii::$app->security->generateRandomString();
        $this->secret_key = substr("$key", 0, 6);
    }
    
    public function removeSecretKey()
    {
        $this->secret_key = "";
    }

    public function register()
    {
        $user = new User;
        $user->email = $this->email;
        $user->username = $this->username;
        $user->setPassword($this->password);
        $user->generateAccessToken();
        $user->save(false);

        return $user->getPrimaryKey();
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }
}
