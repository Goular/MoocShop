<?php
/**
 * Created by PhpStorm.
 * User: lotus
 * Date: 2017/3/15
 * Time: 16:03
 */

namespace app\admin\controllers;

use app\admin\models\Admin;
use yii\web\Controller;

/**
 * Class ManagerController
 * @package app\admin\controllers
 * 用户管理的控制器类
 */
class ManageController extends Controller
{
    //设置默认不需要模板
    public $layout = "admin_main";

    public function actionMailchangepass(){
        $this->layout = false;
        //获取时间戳
        $time = \Yii::$app->request->get("timestamp");
        //获取用户名
        $adminuser = \Yii::$app->request->get("adminuser");
        $token = \Yii::$app->request->get("token");
        $model = new Admin();
        $myToken = $model->createToken($adminuser,$time);
        if($token != $myToken){
            //判读token是否一致
            $this->redirect(['public/login']);
            \Yii::$app->end();
        }
        if(time()-$time>300){
            //若有效期超过5分钟
            $this->redirect(['public/login']);
            \Yii::$app->end();
        }
        if(\Yii::$app->request->isPost){
            //若当前的请求是post请求，即点击修改密码按钮
            $post = \Yii::$app->request->post();
            if($model->changePass($post)){
                //若改变密码成功，同时展示出来
                \Yii::$app->session->setFlash('info','密码修改成功');
            }
        }
        $model->adminuser = $adminuser;
        return $this->render("mailchangepass",['model'=>$model]);
    }

    public function actionReg(){
        return $this->render("reg");
    }

    public function actionManagers(){
        return $this->render("managers");
    }
}