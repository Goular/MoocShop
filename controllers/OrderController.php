<?php

namespace app\controllers;

use app\models\Cart;
use app\models\Order;
use app\models\OrderDetail;
use app\models\Product;
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
        if (\Yii::$app->session['isLogin'] != 1) {
            return $this->redirect(['member/auth']);
        }
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            if (\Yii::$app->request->isPost) {
                $post = \Yii::$app->request->post();
                $ordermodel = new Order;
                $ordermodel->scenario = 'add';
                $usermodel = User::find()->where('username = :name or useremail = :email', [':name' => \Yii::$app->session['loginname'], ':email' => \Yii::$app->session['loginname']])->one();
                if (!$usermodel) {
                    throw new \Exception();
                }
                $userid = $usermodel->userid;
                $ordermodel->userid = $userid;
                $ordermodel->status = Order::CREATEORDER;
                $ordermodel->createtime = time();
                if (!$ordermodel->save()) {
                    throw new \Exception();
                }
                $orderid = $ordermodel->getPrimaryKey();
                foreach ($post['OrderDetail'] as $product) {
                    $model = new OrderDetail;
                    $product['orderid'] = $orderid;
                    $product['createtime'] = time();
                    $data['OrderDetail'] = $product;
                    if (!$model->add($data)) {
                        throw new \Exception();
                    }
                    Cart::deleteAll('productid = :pid', [':pid' => $product['productid']]);
                    Product::updateAllCounters(['num' => -$product['productnum']], 'productid = :pid', [':pid' => $product['productid']]);
                }
            }
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollback();
            return $this->redirect(['cart/index']);
        }
        return $this->redirect(['order/check', 'orderid' => $orderid]);
    }
}
