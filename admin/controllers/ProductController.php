<?php

namespace app\admin\controllers;

use app\models\Category;
use app\models\Product;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use Qiniu\Storage\BucketManager;
use yii\data\Pagination;

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
            if (!$pics) {
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
        return $this->render("add", ['opts' => $list, 'model' => $model]);
    }

    /**
     * 上传代码
     */
    public function unload()
    {
        if ($_FILES['Product']['error']['cover'] > 0) {
            return false;
        }
        //实现七牛云存储
        // 构建鉴权对象
        $auth = new Auth(\Yii::$app->params['qiniu']['accessKey'], \Yii::$app->params['qiniu']['secretKey']);
        // 要上传的空间
        $bucket = \Yii::$app->params['qiniu']['bucket'];
        // 生成上传 Token
        $token = $auth->uploadToken($bucket);
        // 初始化 UploadManager 对象并进行文件的上传
        $uploadMgr = new UploadManager();
        $pics = [];//用于保存并返回相关的图片的路径

        //上传商品的封面
        // 要上传文件的本地路径
        $filePath = $_FILES['Product']['tmp_name']['cover'];
        // 上传到七牛后保存的文件名
        $key = uniqid();//获取上传的文件名
        list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
        if ($err !== null) {
            return false;
        } else {
            $coverPath = \Yii::$app->params['qiniu']['domain'] . $key;
        }

        foreach ($_FILES['Product']['tmp_name']['pics'] as $k => $file) {
            if ($_FILES['Product']['error']['pics'][$k] > 0) {
                continue;
            }
            $key = uniqid();
            list($ret, $err) = $uploadMgr->putFile($token, $key, $file);
            if ($err !== null) {
                continue;
            } else {
                $pics[$key] = \Yii::$app->params['qiniu']['domain'] . $key;
            }
        }
        return ['cover' => $coverPath, 'pics' => json_encode($pics)];
    }


    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionProducts()
    {
        $model = Product::find();
        $count = $model->count();
        $pageSize = \Yii::$app->params['pageSize']['product'];
        $pager = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $products = $model->offset($pager->offset)->limit($pager->limit)->all();
        return $this->render('products', ['pager' => $pager, 'products' => $products]);
    }

    //修改商品的内容
    public function actionMod()
    {
        $cate = new Category();
        $list = $cate->getOptions();
        unset($list[0]);//删除第0个，"请选择分类的选项"
        //获取商品的ID
        $productId = \Yii::$app->request->get("productid");
        $model = Product::find()->where('productid=:id', [':id' => $productId])->one();
        if (\Yii::$app->request->isPost) {
            $post = \Yii::$app->request->post();
            // 构建鉴权对象
            $auth = new Auth(\Yii::$app->params['qiniu']['accessKey'], \Yii::$app->params['qiniu']['secretKey']);
            // 要上传的空间
            $bucket = \Yii::$app->params['qiniu']['bucket'];
            // 生成上传 Token
            $token = $auth->uploadToken($bucket);
            // 初始化 UploadManager 对象并进行文件的上传
            $uploadMgr = new UploadManager();
            $bucketMgr = new BucketManager($auth);
            $pics = [];//用于保存并返回相关的图片的路径
            $post['Product']['cover'] = $model->cover;
            if ($_FILES['Product']['error']['cover'] == 0) {
                $key = uniqid();
                $fileName = $_FILES['Product']['tmp_name']['cover'];
                list($ret, $err) = $uploadMgr->putFile($token, $key, $fileName);
                if ($err !== null) {
                    $post['Product']['cover'] = \Yii::$app->params['qiniu']['domain'] . $key;
                    //删除原来的封面
                    $err = $bucketMgr->delete($bucket, basename($key));
                    if ($err !== null) {
                    } else {
                    }
                }
            }
            foreach ($_FILES['Product']['tmp_name']['pics'] as $k => $file) {
                if ($_FILES['Product']['error']['pics'][$k] > 0) {
                    continue;
                }
                $key = uniqid();
                list($ret, $err) = $uploadMgr->putFile($token, $key, $file);
                if ($err !== null) {
                    continue;
                } else {
                    $pics[$key] = \Yii::$app->params['qiniu']['domain'] . $key;
                }

            }
            $post['Product']['pics'] = json_encode(array_merge((array)json_decode($model->pics, true), $pics));
            if ($model->load($post) && $model->save()) {
                \Yii::$app->session->setFlash('info', '修改成功');
            }
        }
        //转跳到添加的页面
        return $this->render('add', ['model' => $model, 'opts' => $list]);
    }

    //删除指定的图片
    public function actionRemovepic()
    {
        $key = \Yii::$app->request->get('key');
        $productId = \Yii::$app->request->get('productid');
        $model = Product::find()->where('productid = :id', [':id' => $productId])->one();
        //七牛移除代码
        // 构建鉴权对象
        $auth = new Auth(\Yii::$app->params['qiniu']['accessKey'], \Yii::$app->params['qiniu']['secretKey']);
        // 要上传的空间
        $bucket = \Yii::$app->params['qiniu']['bucket'];
        // 生成上传 Token
        $token = $auth->uploadToken($bucket);
        // 初始化 UploadManager 对象并进行文件的上传
        $bucketMgr = new BucketManager($auth);
        $err = $bucketMgr->delete($bucket, $key);
        if ($err !== null) {
        } else {}
        $pics = json_decode($model->pics, true);
        unset($pics[$key]);
        Product::updateAll(['pics' => json_encode($pics)], 'productid = :pid', [':pid' => $productId]);
        return $this->redirect(['product/mod', 'productid' => $productId]);
    }

    //删除指定的商品的记录
    public function actionDel()
    {
        $productId = \Yii::$app->request->get("productid");
        $model = Product::find()->where('productid = :id', [':pid' => $productId])->one();
        //basename() 函数返回路径中的文件名部分。
        $key = basename($model->cover);
        //七牛删除图片

        //删除商品的记录
        Product::deleteAll('productid = :pid', [':pid' => $productId]);
        return $this->redirect(['product/list']);
    }

    //商品上架操作
    public function actionOn()
    {
        $productId = \Yii::$app->request->get("productid");
        Product::updateAll(['ison' => '1'], 'productid = :pid', [':pid' => $productId]);
        return $this->redirect(['product/products']);
    }

    //商品下架操作
    public function actionOff()
    {
        $productid = \Yii::$app->request->get("productid");
        Product::updateAll(['ison' => '0'], 'productid = :pid', [':pid' => $productid]);
        return $this->redirect(['product/products']);
    }
}
