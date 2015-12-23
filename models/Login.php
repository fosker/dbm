<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;
use yii\base\InvalidParamException;

class Login extends Model
{   
    public $username;
    public $password;
    public $access_token;
    public $id;
    
    public function rules()
    {
        return[
            [['username', 'password'],'required'],
            ['username', 'findUsername'],
            ['password', 'findUserPassword'],
        ];
    }
    
    public function findUsername($attribute, $params){
           $user = User::findOne([
                'username' => $this->username
                ]);
           if(!$user)
                $this->addError($attribute,'Пользователя с таким именем нет.');

    }
    
    public function findUserPassword($attribute, $params){
           $user = User::findOne([
                'username' => $this->username
                ]);
           if($user)
           {
                $this->access_token = $user->access_token;
                $this->id = $user->id;
                if(!$user->validatePassword($this->password))
                    $this->addError($attribute,'Неправильный пароль.');
           }
    }
    
    public function attributeLabels()
    {
        return[
            'password' => 'Пароль',
            'username' => 'Имя пользователя'
        ];
    }
    
}