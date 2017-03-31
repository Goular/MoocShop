<?php

namespace app\controllers;

use app\models\Address;
use app\models\User;


/**
 * 地址管理控制器
 * Class AddressController
 * @package app\controllers
 */
class AddressController extends \yii\web\Controller
{
    /**
     * 添加地址
     */
    public function actionAdd()
    {
        if (\Yii::$app->session['isLogin'] != 1) {
            return $this->redirect(['member/auth']);
        }
        $loginname = \Yii::$app->session['loginname'];
        $userid = User::find()->where('username = :name or useremail = :email', [':name' => $loginname, ':email' => $loginname])->one()->userid;
        if (\Yii::$app->request->isPost) {
            $post = \Yii::$app->request->post();
            $post['userid'] = $userid;
            $post['address'] = $post['address1'] . $post['address2'];
            $data['Address'] = $post;
            $model = new Address;
            $model->load($data);
            $model->save();
        }
        return $this->redirect($_SERVER['HTTP_REFERER']);//直接返回上一个记录的页面
    }

    /**
     * 删除地址
     */
    public function actionDel()
    {
        if (\Yii::$app->session['isLogin'] != 1) {
            return $this->redirect(['member/auth']);
        }
        $loginname = \Yii::$app->session['loginname'];
        $userid = User::find()->where('username = :name or useremail = :email', [':name' => $loginname, ':email' => $loginname])->one()->userid;
        $addressid = \Yii::$app->request->get('addressid');
        if (!Address::find()->where('userid = :uid and addressid = :aid', [':uid' => $userid, ':aid' => $addressid])->one()) {
            return $this->redirect($_SERVER['HTTP_REFERER']);
        }
        Address::deleteAll('addressid = :aid', [':aid' => $addressid]);
        return $this->redirect($_SERVER['HTTP_REFERER']);
    }
}
