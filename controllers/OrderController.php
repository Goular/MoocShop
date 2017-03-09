<?php

namespace app\controllers;

class OrderController extends \yii\web\Controller
{
    public $layout = "layout_parent_nav";

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCheck()
    {
        return $this->render('check');
    }

}
