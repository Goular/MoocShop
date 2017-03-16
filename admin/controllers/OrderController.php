<?php

namespace app\admin\controllers;

class OrderController extends \yii\web\Controller
{
    public $layout = "admin_main";

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionList()
    {
        return $this->render('list');
    }

}
