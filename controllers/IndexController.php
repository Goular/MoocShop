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

    //提交控制的memcached的单机多实例的实验控制
    public function actionSession(){
        $session = \Yii::$app->session;
        $session->open();
        //$session['goular.name']="zhaojingtao";
        //echo $session["goular.name"];
        echo $session->getId();
        $session->close();
    }
}
