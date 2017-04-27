<?php

namespace app\controllers;

use app\models\Test;
use Yii;

/**
 * Class IndexController
 * @package app\controllers
 * 由于继承了CommonController的内容，所以我们的相关的前置操作都移动到CommonController的init()方法中执行
 */
class IndexController extends CommonController
{
    public function actionIndex()
    {
        $this->layout = "layout_parent_none";
        return $this->render("index");
    }

}
