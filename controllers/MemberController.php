<?php

namespace app\controllers;

class MemberController extends \yii\web\Controller
{
    public function actionAuth()
    {
        $this->layout = "layout_parent_nav";
        return $this->render('auth');
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        return $this->render('login');
    }

    public function actionRegister()
    {
        return $this->render('register');
    }

}
