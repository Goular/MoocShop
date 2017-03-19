<?php

namespace app\admin\controllers;

use app\models\Profile;
use app\models\User;
use yii\data\Pagination;
use yii\db\Exception;

class UserController extends \yii\web\Controller
{
    public $layout = "admin_main";

    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @return string
     * 用户列表的处理
     */
    public function actionUsers()
    {
        $model = User::find()->joinWith("profile");
        $count = $model->count();
        //进行分页显示
        $pageSize = \Yii::$app->params['pageSize']['user'];
        $pager = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $users = $model->offset($pager->offset)->limit($pager->limit)->all();
        return $this->render('users', ['users' => $users, 'pager' => $pager]);
    }

    //后台添加前台使用用户
    public function actionReg()
    {
        $model = new User();
        if (\Yii::$app->request->isPost) {
            $post = \Yii::$app->request->post();
            if ($model->reg($post)) {
                \Yii::$app->session->setFlash('info', '添加成功');
            }
        }
        $model->userpass = "";
        $model->repass = "";
        return $this->render('reg', ['model' => $model]);
    }

    //删除前台用户的列表
    public function actionDel(){
        //由于需要删除两张表中的数据，所以需要使用事务来处理
        try {
            $userId = \Yii::$app->request->get("userid");
            if(empty($userId)){
                throw new Exception();
            }
            $trans = \Yii::$app->db->beginTransaction();
            if($obj = Profile::find()->where('userid=:id',[':id'=>$userId])->one()){
                $res = Profile::deleteAll("userid = :id",[':id'=>$userId]);
                if(empty($res)){
                    throw new Exception();
                }
            }
            if(!User::deleteAll("userid = :id",[':id'=>$userId])){
                throw new Exception();
            }
            $trans->commit();
        } catch (Exception $e) {
            if(\Yii::$app->db->getTransaction()){
                $trans->rollBack();
            }
        }
        $this->redirect(['user/users']);
    }
}
