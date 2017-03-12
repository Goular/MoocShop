<?php

namespace app\admin\controllers;

use app\admin\models\Admin;

class PublicController extends \yii\web\Controller
{
    public $layout = false;//不使用模板
    public $defaultAction = 'login';

    public function actionLogin()
    {
        $model = new Admin();
        return $this->render('login',['model'=>$model]);
    }

    public function actionSeekpassword()
    {
        return $this->render('seekpassword');
    }

}
