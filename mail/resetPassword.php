<?php

/* @var $user \app\models\User */

use yii\helpers\Html;

echo 'Добрый день, '.Html::encode($user->username).'.';
echo ' Ваш код для восстановления пароля: '.Html::encode($user->secret_key);