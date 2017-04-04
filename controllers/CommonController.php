<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\Category;
use app\models\Cart;
use app\models\User;
use app\models\Product;
use Yii;

class CommonController extends Controller
{
    public function init()
    {
        //获取菜单
        $menu = Category::getMenu();
        //设置菜单内容参数
        $this->view->params['menu'] = $menu;
        //设置购物车的数据
        $data = [];
        //为购物车商品创建数组
        $data['products'] = [];
        //购物车总价
        $total = 0;
        //判断是否登陆成功
        if (Yii::$app->session['isLogin']) {
            $usermodel = User::find()->where('username = :name', [":name" => Yii::$app->session['loginname']])->one();
            if (!empty($usermodel) && !empty($usermodel->userid)) {
                $userid = $usermodel->userid;
                $carts = Cart::find()->where('userid = :uid', [':uid' => $userid])->asArray()->all();
                //添加购物车商品
                foreach ($carts as $k => $pro) {
                    $product = Product::find()->where('productid = :pid', [':pid' => $pro['productid']])->one();
                    $data['products'][$k]['cover'] = $product->cover;
                    $data['products'][$k]['title'] = $product->title;
                    $data['products'][$k]['productnum'] = $pro['productnum'];
                    $data['products'][$k]['price'] = $pro['price'];
                    $data['products'][$k]['productid'] = $pro['productid'];
                    $data['products'][$k]['cartid'] = $pro['cartid'];
                    $total += $data['products'][$k]['price'] * $data['products'][$k]['productnum'];
                }
            }
        }
        //设置购物车总价
        $data['total'] = $total;
        //购物车数据添加到页面参数
        $this->view->params['cart'] = $data;
        $tui = Product::find()->where('istui = "1" and ison = "1"')->orderby('createtime desc')->limit(3)->all();
        $new = Product::find()->where('ison = "1"')->orderby('createtime desc')->limit(3)->all();
        $hot = Product::find()->where('ison = "1" and ishot = "1"')->orderby('createtime desc')->limit(3)->all();
        $sale = Product::find()->where('ison = "1" and issale = "1"')->orderby('createtime desc')->limit(3)->all();
        //添加推荐商品，作为页面参数
        $this->view->params['tui'] = (array)$tui;
        //添加新建商品，作为页面参数
        $this->view->params['new'] = (array)$new;
        //添加热卖商品，作为页面参数
        $this->view->params['hot'] = (array)$hot;
        //添加售价商品，作为页面参数
        $this->view->params['sale'] = (array)$sale;
    }
}