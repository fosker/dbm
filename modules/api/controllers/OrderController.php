<?php
namespace app\modules\api\controllers;

use yii\rest\ActiveController;
use yii\web\Controller;
use yii\web\UploadedFile;
use app\models\Order;
use Yii;

class OrderController extends ActiveController
{
    public $modelClass = 'app\models\Order';
    public $format = 'json';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        return $actions;
    }

    public function actionCreate()
    {
        $model = new Order;
        if ($model->load(Yii::$app->request->getBodyParams(), ''))
        {
            $model->file = UploadedFile::getInstance($model, 'file');
            var_dump(Yii::$app->request->getBodyParams());
            Yii::$app->end();

            if($model->file != null)
            {
                $model->file->saveAs('img/orders/'.$model->file->name);
                $model->picture = 'img/orders/'.$model->file->name;
            }

            if($model->save())
                return ['success'=>true];
        }
        else return $model;
    }
}