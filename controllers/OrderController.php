<?php

namespace app\controllers;

use app\models\Address;
use app\models\Cart;
use app\models\Order;
use app\models\OrderDetail;
use app\models\Product;
use app\models\User;
use yii\base\Exception;

class OrderController extends \yii\web\Controller
{
    public $layout = "layout_parent_nav";

    /**
     * @return string
     * 前台订单列表的显示
     */
    public function actionIndex()
    {
        if (\Yii::$app->session['isLogin'] != 1) {
            return $this->redirect(['member/auth']);
        }
        $loginname = \Yii::$app->session['loginname'];
        $userid = User::find()->where('username = :name or useremail = :email', [':name' => $loginname, 'email' => $loginname])->one()->userid;
        $orders = Order::getProducts($userid);
        return $this->render('index', ['order' => $orders]);
    }

    /**
     * 进入订单详情页面
     */
    public function actionCheck()
    {
        $this->layout = "layout_parent_none";
        if (\Yii::$app->session['isLogin'] != 1) {
            return $this->redirect(['member/auth']);
        }
        $orderid = \Yii::$app->request->get('orderid');
        $status = Order::find()->where('orderid = :oid', [':oid' => $orderid])->one()->status;
        if ($status != Order::CREATEORDER && $status != Order::CHECKORDER) {
            return $this->redirect(['order/index']);
        }
        $loginname = \Yii::$app->session['loginname'];
        $userid = User::find()->where('username = :name or useremail = :email', [':name' => $loginname, ':email' => $loginname])->one()->userid;
        $addresses = Address::find()->where('userid = :uid', [':uid' => $userid])->asArray()->all();
        $details = OrderDetail::find()->where('orderid = :oid', [':oid' => $orderid])->asArray()->all();
        $data = [];
        foreach ($details as $detail) {
            $model = Product::find()->where('productid = :pid', [':pid' => $detail['productid']])->one();
            $detail['title'] = $model->title;
            $detail['cover'] = $model->cover;
            $data[] = $detail;
        }
        $express = \Yii::$app->params['express'];
        $expressPrice = \Yii::$app->params['expressPrice'];
        return $this->render("check", ['express' => $express, 'expressPrice' => $expressPrice, 'addresses' => $addresses, 'products' => $data]);
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

    //确认订单
    public function actionConfirm()
    {
        //addressid, expressid, status, amount(orderid,userid)
        try {
            //判断是否进行了登录的操作
            if (\Yii::$app->session['isLogin'] != 1) {
                return $this->redirect(['member/auth']);
            }
            //判断是否是post请求
            if (!\Yii::$app->request->isPost) {
                throw new \Exception();
            }
            //获取表单的post对象
            $post = \Yii::$app->request->post();
            //获取用户的登录名
            $loginname = \Yii::$app->session['loginname'];
            //获取用户模型
            $usermodel = User::find()->where('username = :name or useremail = :email', [':name' => $loginname, ':email' => $loginname])->one();
            //如果获取不到用户模型，直接退出当前方法
            if (empty($usermodel)) {
                throw new \Exception();
            }
            //获取用户的ID
            $userid = $usermodel->userid;
            //获取当前用户的订单模型
            $model = Order::find()->where('orderid = :oid and userid = :uid', [':oid' => $post['orderid'], ':uid' => $userid])->one();
            //没有获取到模型，直接退出
            if (empty($model)) {
                throw new \Exception();
            }
            //填写"update"的场景
            $model->scenario = "update";
            //设定订单的状态为"待支付"状态
            $post['status'] = Order::CHECKORDER;
            //获取订单的详情
            $details = OrderDetail::find()->where('orderid = :oid', [':oid' => $post['orderid']])->all();
            //总价定价
            $amount = 0;
            //轮询订单细节，计算出产品总价
            foreach ($details as $detail) {
                //计算产品数量
                $amount += $detail->productnum * $detail->price;
            }
            //如果总价为负数，直接报错
            if ($amount <= 0) {
                throw new \Exception();
            }
            //获取邮费选项
            $express = \Yii::$app->params['expressPrice'][$post['expressid']];
            //如果运费小于0，直接报错
            if ($express < 0) {
                throw new \Exception();
            }
            //计算总价加运费
            $amount += $express;
            //为post内容添加总额
            $post['amount'] = $amount;
            //添加订单数据到$data
            $data['Order'] = $post;
            //如果地址ID为空的时候
            if (empty($post['addressid'])) {
                //若地址ID为空，直接订单支付页面
                return $this->redirect(['order/pay', 'orderid' => $post['orderid'], 'paymethod' => $post['paymethod']]);
            }
            //加载$data加载到模型类同时保存类并校验数据
            if ($model->load($data) && $model->save()) {
                //return $this->redirect(['order/pay', 'orderid' => $post['orderid'], 'paymethod' => $post['paymethod']]);
                echo "添加成功!";
            }
        } catch (Exception $e) {
            return $this->redirect(['index/index']);//出现异常，直接返回前台首页
        }
    }
}
