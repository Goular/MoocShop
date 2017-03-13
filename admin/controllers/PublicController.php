<?php

namespace app\admin\controllers;

use app\admin\models\Admin;

class PublicController extends \yii\web\Controller
{
    public $layout = false;//不使用模板
    public $defaultAction = 'login';

    public function actionLogin()
    {
        //创建对象，让ActiveForm表单能够进行显示并处理
        $model = new Admin();
        //判断是否来自Post请求，是的话说明是点击了登录操作，不是说明是来自网址的访问
        if(\Yii::$app->request->isPost){
            //获取Post请求的参数数组
            $post = \Yii::$app->request->post();
            //var_dump($post);
            if($model->login($post)){//有异常返回false，否则返回mixed
                //校验登录成功，直接转跳到后台的首页
                $this->redirect(['index/index']);
                \Yii::$app->end();
            }
        }
        return $this->render('login',['model'=>$model]);
    }

    public function actionSeekpassword()
    {
        return $this->render('seekpassword');
    }

    public function actionLogout(){
        \Yii::$app->session->removeAll();//清空所有的session，但是我们不能进行
        if(!isset(\Yii::$app->session['admin']['isLogin'])){
            $this->redirect(['public/login']);
            \Yii::$app->end();
        }
        //gohome 回主页
        //goback 返回上一页
        $this->goBack();
    }
}
