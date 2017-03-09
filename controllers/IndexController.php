<?php

namespace app\controllers;

use app\models\Test;
use Yii;
use \yii\web\Controller;

class IndexController extends Controller
{
    public function actionIndex()
    {
        return $this->renderPartial("index");
    }

}
