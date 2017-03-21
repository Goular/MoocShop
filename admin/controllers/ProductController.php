<?php

namespace app\admin\controllers;

use app\models\Category;
use app\models\Product;

class ProductController extends \yii\web\Controller
{
    public $layout = "admin_main";

    public function actionAdd()
    {
        $model = new Product();
        $cate = new Category();
        $list = $cate->getOptions();
        unset($list[0]);
        if (\Yii::$app->request->isPost) {
            $post = \Yii::$app->request->post();
            $pics = $this->unload();
            //判断图片是否上传成功
            if (!pics) {
                $model->addError('cover', '封面不能为空');
            } else {
                $post['Product']['cover'] = $pics['cover'];
                $post['Product']['pics'] = $pics['pics'];
            }
            if ($pics && $model->add($post)) {
                \Yii::$app->session->setFlash('info', '添加成功');
            } else {
                \Yii::$app->session->setFlash('info', '添加失败');
            }
        }
    }

    /**
     * 上传代码
     */
    public function unload()
    {
        
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionProducts()
    {
        return $this->render('products');
    }
}
