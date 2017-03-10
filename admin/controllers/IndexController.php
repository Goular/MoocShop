<?php

namespace app\admin\controllers;

use yii\web\Controller;

class IndexController extends Controller
{
    public $defaultAction = 'index';
    public $layout = "admin_main";

    public function actionIndex()
    {
        //$this->layout = 'layout_parent_none';
        return $this->renderPartial('index');
    }
}
