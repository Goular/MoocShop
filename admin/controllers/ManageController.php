<?php
/**
 * Created by PhpStorm.
 * User: lotus
 * Date: 2017/3/15
 * Time: 16:03
 */

namespace app\admin\controllers;

use app\admin\models\Admin;
use Symfony\Component\Yaml\Tests\A;
use yii\data\Pagination;
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

    public function actionMailchangepass()
    {
        $this->layout = false;
        //获取时间戳
        $time = \Yii::$app->request->get("timestamp");
        //获取用户名
        $adminuser = \Yii::$app->request->get("adminuser");
        $token = \Yii::$app->request->get("token");
        $model = new Admin();
        $myToken = $model->createToken($adminuser, $time);
        if ($token != $myToken) {
            //判读token是否一致
            $this->redirect(['public/login']);
            \Yii::$app->end();
        }
        if (time() - $time > 300) {
            //若有效期超过5分钟
            $this->redirect(['public/login']);
            \Yii::$app->end();
        }
        if (\Yii::$app->request->isPost) {
            //若当前的请求是post请求，即点击修改密码按钮
            $post = \Yii::$app->request->post();
            if ($model->changePass($post)) {
                //若改变密码成功，同时展示出来
                \Yii::$app->session->setFlash('info', '密码修改成功');
            }
        }
        $model->adminuser = $adminuser;
        return $this->render("mailchangepass", ['model' => $model]);
    }

    public function actionManagers()
    {
        //1.设置父模板（这里已经设置了）
        //2.设置$model
        $model = Admin::find();//这个仅仅汇创建一个活动记录而不会马上到数据库进行查询，只有遇到类似one(),all(),count()这样的方法，才回进行数据库的搜索
        $count = $model->count();
        $pageSize = \Yii::$app->params['pageSize']['manage'];
        $pager = new Pagination(['totalCount'=>$count,'pageSize'=>$pageSize]);//获取分页对象
        $managers = $model->offset($pager->offset)->limit($pager->limit)->all();
        return $this->render("managers",["managers"=>$managers,"pager"=>$pager]);
    }

    public function actionReg()
    {
        //1.设置父模板
        $this->layout = "admin_main";
        $model = new Admin();
        if(\Yii::$app->request->isPost){
            $post = \Yii::$app->request->post();
            if($model->reg($post)){
                \Yii::$app->session->setFlash('info','添加成功!');
            }else{
                \Yii::$app->session->setFlash('info','添加失败!');
            }
        }

        return $this->render("reg",['model'=>$model]);
    }

    public function actionChangeemail()
    {
        return $this->render("changeemail");
    }

    public function actionChangepass()
    {
        return $this->render("changepass");
    }
}