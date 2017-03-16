<?php

namespace app\admin\controllers;

class CategoryController extends \yii\web\Controller
{
    public $layout = "admin_main";

    public function actionAdd()
    {
        return $this->render('add');
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCates()
    {
        return $this->render('cates');
    }

}
