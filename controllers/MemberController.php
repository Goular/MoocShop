<?php

namespace app\controllers;

use app\models\User;
use app\components\GithubAuthHandler;

class MemberController extends CommonController
{
    public function actions()
    {
        return [
            'oauth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    //登录成功回调的内容
    public function onAuthSuccess($client)
    {
        echo "<pre>";
        echo $client;
        echo "</pre>";
        //(new GithubAuthHandler($client))->handle();
    }

    public function actionAuth()
    {
        $this->layout = "layout_parent_nav";
        if (\Yii::$app->request->isGet) {
            //Request.UrlReferrer可以获取客户端上次请求的url的有关信息。
            //这样我们就可以通过这个属性返回到“上一页”，
            $url = \Yii::$app->request->referrer;
            if (empty($url)) {
                $url = '/';
            }
            \Yii::$app->session->setFlash('referrer', $url);
        }
        $model = new User();
        //如果为post请求，同时已经授权了，那么转跳到上一个保存的url地址
        if (\Yii::$app->request->isPost) {
            $post = \Yii::$app->request->post();
            if ($model->login($post)) {
                $url = \Yii::$app->session->getFlash('referrer');
                return $this->redirect($url);
            }
        }
        return $this->render("auth", ['model' => $model]);
    }

    public function actionLogout()
    {
        \Yii::$app->session->remove("loginname");
        \Yii::$app->session->remove("isLogin");
        if (!isset(\Yii::$app->session['isLogin'])) {
            return $this->goBack(\Yii::$app->request->referrer);//正常退出后返回原来的上一级的页面
        }
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

    //GitHub三方登陆
    public function actionGithub_login()
    {
        echo "332211";
        exit();
    }
}
