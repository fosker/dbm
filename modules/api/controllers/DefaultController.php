<?php

namespace app\modules\api\controllers;

use Yii;
use yii\rest\Controller;
use app\models\SendEmail;
use app\models\Recover;
use app\models\Login;
use app\models\User;
use app\models\Profile;

class DefaultController extends Controller
{
    public function actionSendEmail()
    {
        $model = new SendEmail();
        
        if ($model->load(Yii::$app->request->getBodyParams(), '') && $model->validate())
        {
            if($model->sendEmail())
                return ['success'=>true];   
        }
        else return $model;
    }
    
    public function actionRecover()
    {
        $model = new Recover();
        
        if ($model->load(Yii::$app->request->getBodyParams(), '') && $model->validate())
        {
            if($model->resetPassword())
                return ['success'=>true];   
        }
        else return $model;
    }
    
    public function actionLogin()
    {
        $model = new Login();
        
        if ($model->load(Yii::$app->request->getBodyParams(), '') && $model->validate())
        {
            if($model->validate())
            {
                return $model;  
            }                
        }
        else return $model;
    }
    
    public function actionRegister()
    {
        $model = new User;
        $profile = new Profile;
        if ($model->load(Yii::$app->request->getBodyParams(), '') && $model->validate())
        {
            if($model->validate())
            {
                $id = $model->register();
                $profile->createProfile($id);
                return ['success'=>true];
            }
        }
        else return $model;
    }
}
