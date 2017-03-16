<?php

namespace app\admin\controllers;

class UserController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionReg()
    {
        return $this->render('reg');
    }

    public function actionUsers()
    {
        return $this->render('users');
    }

}
