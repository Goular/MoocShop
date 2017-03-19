<?php

namespace app\controllers;

use app\models\User;

class MemberController extends \yii\web\Controller
{
    public function actionAuth()
    {
        $this->layout = "layout_parent_nav";


        $model = new User();
        return $this->render('auth', ['model' => $model]);
    }

    //授权页面的注册表单控制
    public function actionReg()
    {
        $model = new User();
        if (\Yii::$app->request->isPost) {
            $post = \Yii::$app->request->post();
            if ($model->regByMail($post)) {
                \Yii::$app->session->setFlash('info', "电子邮件发送成功!");
            }
        }
        $this->layout = "layout_parent_nav";
        return $this->render('auth', ['model' => $model]);
    }

}
