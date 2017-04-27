<?php

namespace app\admin\controllers;

use app\models\Order;
use yii\data\Pagination;

class OrderController extends CommonController
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

    /**
     * 订单发货
     */
    public function actionSend()
    {
        $orderid = (int)\Yii::$app->request->get('orderid');
        $model = Order::find()->where('orderid =:oid', [':oid' => $orderid])->one();
        $model->scenario = "send";
        if (\Yii::$app->request->isPost) {
            $post = \Yii::$app->request->post();
            $model->status = Order::SENDED;
            if ($model->load($post) && $model->save()) {
                \Yii::$app->session->setFlash('info', '发货成功');
            }
        }
        return $this->render('send', ['model' => $model]);
    }

}
