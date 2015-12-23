<?php
namespace app\modules\api\controllers;
use yii\filters\auth\QueryParamAuth;
use app\models\User;
use app\models\Profile;

use yii\rest\ActiveController;
use yii\web\Controller;
use Yii;

class UserController extends ActiveController
{
    public $modelClass = 'app\models\User';
    public $format = 'json';
    
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['class'] = QueryParamAuth::className();
        $behaviors['authenticator']['tokenParam'] = 'access_token';
        return $behaviors;
    }

    
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        return $actions;
    }
    
    public function checkAccess($action, $model = null, $params = [])
    {
        if(User::findIdentityByAccessToken($_GET['access_token'])->id == 1)
            $isAdmin = true;
        else
            $isAdmin = false;

        if(!$isAdmin || Yii::$app->user->isGuest)
            throw new \yii\web\ForbiddenHttpException("You can't access this page.");
    }
}

