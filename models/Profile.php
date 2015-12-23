<?php

namespace app\models;

use Yii;
use app\models\User;
/**
 * This is the model class for table "profile".
 *
 * @property integer $id
 * @property string $name
 * @property string $surname
 * @property string $gender
 * @property integer $age
 *
 * @property Order[] $orders
 * @property User $user
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public $email, $username;

    public static function tableName()
    {
        return 'profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'gender', 'age'], 'required'],
            [['age'], 'integer'],
            [['name', 'surname'], 'string', 'max' => 30],
            [['gender'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'surname' => 'Surname',
            'gender' => 'Gender',
            'age' => 'Age',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['profile_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id']);
    }

    public function extraFields()
    {
        return ['orders', 'user'];
    }

    public function createProfile($id)
    {
        $profile = new Profile;
        $profile->id = $id;
        $profile->save(false);
    }
    public function fields()
    {
        return [
            'id',
            'name',
            'surname',
            'gender',
            'age',
            'username' => function () {
                return User::findOne($this->id)->username;
            },
            'email' => function () {
                return User::findOne($this->id)->email;
            },
        ];
    }

}
