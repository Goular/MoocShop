<?php

namespace app\controllers;

class ProductController extends \yii\web\Controller
{
    public function actionDetail()
    {
        return $this->renderPartial('detail');
    }

    public function actionIndex()
    {
        return $this->renderPartial('index');
    }

}
