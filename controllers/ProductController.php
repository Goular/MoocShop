<?php

namespace app\controllers;

class ProductController extends \yii\web\Controller
{
    public $layout = "layout_parent_nav";

    public function actionDetail()
    {
        return $this->render('detail');
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

}
