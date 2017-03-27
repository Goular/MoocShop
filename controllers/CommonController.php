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
        $menu = Category::getMenu();
        //为页面添加分类基类内容
        $this->view->params['menu'] = $menu;
//        $data = [];
//        $data['products'] = [];
//        $total = 0;
//      添加的内容为购物车的逻辑
//        if (\Yii::$app->session['isLogin']) {
//            $usermodel = User::find()->where('username = :name', [":name" => \Yii::$app->session['loginname']])->one();
//            if (!empty($usermodel) && !empty($usermodel->userid)) {
//                $userid = $usermodel->userid;
//                //$carts =
//                //foreach ($carts as $k => $pro)
//            }
//        }

    }
}