<?php

namespace app\admin\controllers;

use yii\web\Controller;

/**
 * Default controller for the `mobile` module
 */
class IndexController extends Controller
{
    public $defaultAction = 'index';
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'layout_parent_none';
        return $this->render('index');
    }
}
