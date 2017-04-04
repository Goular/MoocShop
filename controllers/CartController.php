<?php

namespace app\controllers;

use app\models\Cart;
use app\models\Order;
use app\models\Product;
use app\models\User;
use dzer\express\Express;
use Yii;

class CartController extends CommonController
{
    public $layout = 'layout_parent_none';

    /**
     * 首页
     * @return string
     */
    public function actionIndex()
    {
        if (\Yii::$app->session['isLogin'] != 1) {
            return $this->redirect(['member/auth']);
        }
        $userid = User::find()->where('username = :name or useremail = :email', [':name' => Yii::$app->session['loginname'], ':email' => Yii::$app->session['loginname']])->one()->userid;
        $cart = Cart::find()->where('userid = :uid', [':uid' => $userid])->asArray()->all();
        $data = [];
        foreach ($cart as $k => $pro) {
            $product = Product::find()->where('productid = :pid', [':pid' => $pro['productid']])->one();
            $data[$k]['cover'] = $product->cover;
            $data[$k]['title'] = $product->title;
            $data[$k]['productnum'] = $pro['productnum'];
            $data[$k]['price'] = $pro['price'];
            $data[$k]['productid'] = $pro['productid'];
            $data[$k]['cartid'] = $pro['cartid'];
        }
        return $this->render("index", ['data' => $data]);
    }

    /**
     * 添加商品到购物车
     */
    public function actionAdd()
    {
        //由于添加到购物车有两个渠道
        //1.从普通的推荐商品和热卖商品中添加(Get请求)
        //2.从商品详情页中添加(Post请求)
        if (\Yii::$app->session['isLogin'] != 1) {
            return $this->redirect(['member/auth']);
        }
        $userid = User::find()->where('username = :name or useremail = :email', [':name' => Yii::$app->session['loginname'], ':email' => Yii::$app->session['loginname']])->one()->userid;
        if (\Yii::$app->request->isPost) {
            $post = \Yii::$app->request->post();
            $num = \Yii::$app->request->post()['productnum'];
            $data['Cart'] = $post;
            $data['Cart']['userid'] = $userid;
        }
        if (\Yii::$app->request->isGet) {
            $productid = \Yii::$app->request->get("productid");
            $model = Product::find()->where('productid = :pid', [':pid' => $productid])->one();
            $price = $model->issale ? $model->saleprice : $model->price;
            $num = 1;
            $data['Cart'] = ['productid' => $productid, 'productnum' => $num, 'price' => $price, 'userid' => $userid];
        }
        if (!$model = Cart::find()->where('productid = :pid and userid = :uid', [':pid' => $data['Cart']['productid'], ':uid' => $data['Cart']['userid']])->one()) {
            $model = new Cart;
        } else {
            $data['Cart']['productnum'] = $model->productnum + $num;
        }
        $data['Cart']['createtime'] = time();
        $model->load($data);
        $model->save();
        return $this->redirect(['cart/index']);
    }

    /**
     * 修改购物车商品
     */
    public function actionMod()
    {
        $cartid = \Yii::$app->request->get('cartid');
        $productnum = \Yii::$app->request->get("productnum");
        Cart::updateAll(['productnum' => $productnum], 'cartid = :cid', [':cid' => $cartid]);
    }

    /**
     * 删除购物车商品
     */
    public function actionDel()
    {
        $cartid = \Yii::$app->request->get('cartid');
        Cart::deleteAll('cartid = :cid', [':cid' => $cartid]);
        return $this->redirect(['cart/index']);
    }

    /**
     * 获取邮政的内容
     */
    public function actionGetexpress()
    {
        $expressno = Yii::$app->request->get('expressno');
        $res = Express::search($expressno);
        echo $res;
        exit();
    }

    /**
     * 前台确认收货的方法
     */
    public function actionReceived()
    {
        $orderid = Yii::$app->request->get('orderid');
        $order = Order::find()->where('orderid = :oid', [':oid' => $orderid])->one();
        if (!empty($order) && $order->status == Order::SENDED) {
            $order->status = Order::RECEIVED;
            $order->save();
        }
        return $this->redirect(['order/index']);
    }
}