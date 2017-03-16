<?php

namespace app\admin\controllers;

class ProductController extends \yii\web\Controller
{
    public function actionAdd()
    {
        return $this->render('add');
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionList()
    {
        return $this->render('list');
    }

}
