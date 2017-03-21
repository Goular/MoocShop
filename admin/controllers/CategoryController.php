<?php

namespace app\admin\controllers;

use app\models\Category;

class CategoryController extends \yii\web\Controller
{
    public $layout = "admin_main";

    public function actionAdd()
    {
        $model = new Category();
        $list = $model->getOptions();
        if (\Yii::$app->request->isPost) {
            $post = \Yii::$app->request->post();
            if ($model->add($post)) {
                \Yii::$app->session->setFlash('info', '添加成功!');
            }
        }
        return $this->render('add', ['list' => $list, 'model' => $model]);
    }

    public function actionCates()
    {
        $model = new Category();
        $cates = $model->getTreeList();
        return $this->render('cates',['cates'=>$cates]);
    }

}
