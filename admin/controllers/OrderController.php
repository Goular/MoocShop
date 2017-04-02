<?php

namespace app\admin\controllers;

use app\models\Order;
use yii\data\Pagination;

class OrderController extends \yii\web\Controller
{
    public $layout = "admin_main";

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionList()
    {
        $model = Order::find();
        $count = $model->count();
        $pageSize = \Yii::$app->params['pageSize']['order'];
        $pager = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $data = $model->offset($pager->offset)->limit($pager->limit)->all();
        $data = Order::getDetail($data);
        return $this->render('list', ['pager' => $pager, 'orders' => $data]);
    }

    /**
     * 读取订单详情的页面
     */
    public function actionDetail()
    {
        $orderid = (int)\Yii::$app->request->get('orderid');
        $order = Order::find()->where('orderid = :oid', [':oid' => $orderid])->one();
        $data = Order::getData($order);
        return $this->render('detail', ['order' => $data]);
    }

}
