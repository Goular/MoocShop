<?php

namespace app\controllers;

use app\models\Order;
use app\models\User;
use yii\base\Exception;

class OrderController extends \yii\web\Controller
{
    public $layout = "layout_parent_nav";

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCheck()
    {
        return $this->render('check');
    }

    /**
     * 添加订单内容
     */
    public function actionAdd()
    {
        //判断是否登录
        if (\Yii::$app->session['isLogin'] != 1) {
            //没有登录的话返回登录页面
            return $this->redirect(['member/auth']);
        }
        //由于添加的时候会影响多个表,所以需要使用事务
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            if (\Yii::$app->request->isPost) {
                $post = \Yii::$app->request->post();
                $odermodel = new Order();
                $odermodel->scenario = "add";//设定场景,在校验的时候可以进行区别
                $usermodel = User::find()->where('username = :name or usermail = :email', [":name" => \Yii::$app->session['loginname'], ":email" => \Yii::$app->session['loginname']])->one();
                if (!$usermodel) {
                    throw new \Exception();
                }
                $orderid = $odermodel->getPrimaryKey();//获取主键
                foreach ($post['OrderDetail'] as $product) {

                }
            }
        } catch (Exception $e) {
            $transaction->rollBack();
            return $this->redirect(['cart/index']);
        }
        return $this->redirect(['order/check', 'orderid' => $orderid]);
    }
}
