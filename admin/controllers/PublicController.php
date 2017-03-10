<?php

namespace app\admin\controllers;

class PublicController extends \yii\web\Controller
{
    public $layout = false;//不使用模板
    public $defaultAction = 'login';

    public function actionLogin()
    {
        return $this->render('login');
    }

    public function actionSeekpassword()
    {
        return $this->render('seekpassword');
    }

}
