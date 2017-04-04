<?php

namespace app\admin\controllers;

use yii\web\Controller;

class IndexController extends CommonController
{
    public $defaultAction = 'index';
    public $layout = "admin_main";

    public function actionIndex()
    {
        //$this->layouts = 'layout_parent_none';
        return $this->render('index');
    }
}
