<?php

namespace app\controllers;

use app\models\Product;
use yii\data\Pagination;

class ProductController extends \yii\web\Controller
{
    public $layout = "layout_parent_nav";

    public function actionIndex()
    {
        //获取分类级别的ID
        $cid = \Yii::$app->request->get('cateid');
        $where = "cateid = :cid and ison = '1'";
        $params = [':cid' => $cid];
        $model = Product::find()->where($where, $params);
        //$all = $model->asArray()->all();

        $count = $model->count();//获取总的商品的数量
        $pageSize = \Yii::$app->params['pageSize']['frontproduct'];//获取当前接口每一页的显示数目
        $pager = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $all = $model->offset($pager->offset)->limit($pager->limit)->asArray()->all();

        //推荐商品
        $tui = $model->where($where . " and istui = '1'", $params)->orderBy('createtime desc')->limit(5)->asArray()->all();
        //热卖商品
        $hot = $model->where($where . " and ishot = '1'", $params)->orderBy('createtime desc')->limit(5)->asArray()->all();
        //特价商品
        $sale = $model->where($where . " and issale = '1'", $params)->orderBy('createtime desc')->limit(5)->asArray()->all();
        return $this->render('index', ['sale' => $sale, 'tui' => $tui, 'hot' => $hot, 'all' => $all, 'pager' => $pager, 'count' => $count]);
    }

    public function actionDetail()
    {
        $productid = \Yii::$app->request->get("productid");
        $product = Product::find()->where('productid = :id', [':id' => $productid])->asArray()->one();
        $data['all'] = Product::find()->where("ison = '1'")->orderBy('createtime desc')->limit(7)->all();
        return $this->render('detail', ['product' => $product, 'data' => $data]);
    }
}
