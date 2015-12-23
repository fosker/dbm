<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;
use yii\base\InvalidParamException;

class Recover extends Model
{   
    public $password;
    public $secret_key;
    
    public function rules()
    {
        return[
            [['password', 'secret_key'],'required'],
            ['secret_key', 'exist',
                'targetClass' => User::className(),      
                'message' => 'Не верный ключ. '
            ],
        ];
    }
    
    public function attributeLabels()
    {
        return[
            'password' => 'Пароль'
        ];
    }
    
    public function resetPassword()
    {
        $user = User::findBySecretKey($this->secret_key);
        $user->setPassword($this->password);
        $user->removeSecretKey();
        
        return $user->save(false);
    }
}