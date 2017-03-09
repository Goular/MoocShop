<?php

namespace app\controllers;

class CartController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $this->layout = 'layout_parent_none';
        return $this->render('index');
    }

}
