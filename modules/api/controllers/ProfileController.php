<?php
namespace app\modules\api\controllers;
use yii\filters\auth\QueryParamAuth;
use app\models\User;
use yii\rest\ActiveController;
use yii\web\Controller;
use yii\filters\auth\HttpBasicAuth;
use Yii;
use app\models\Profile;

class ProfileController extends ActiveController
{
    public $modelClass = 'app\models\Profile';
    public $format = 'json';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['class'] = QueryParamAuth::className();
        $behaviors['authenticator']['tokenParam'] = 'access_token';
        return $behaviors;
    }


    public function checkAccess($action, $model = null, $params = [])
    {
        if(User::findIdentityByAccessToken($_GET['access_token'])->id == 1)
            $isAdmin = true;
        else
            $isAdmin = false;

        if((Yii::$app->user->id != $_GET['id'] && !$isAdmin) || Yii::$app->user->isGuest)
            throw new \yii\web\ForbiddenHttpException("You can't access this page.");
    }
}