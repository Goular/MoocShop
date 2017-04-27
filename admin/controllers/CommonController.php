<?php

namespace app\admin\controllers;

class CommonController extends \yii\web\Controller
{
    public function init()
    {
        echo \Yii::$app->session['admin']['isLogin'];
        if (\Yii::$app->session['admin']['isLogin'] != 1) {
            return $this->redirect(['/admin/public/login']);
        }
    }
}
