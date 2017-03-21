<?php

namespace app\models;

use Yii;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

class Product extends \yii\db\ActiveRecord
{
    public $cate;

    public static function tableName()
    {
        return '{{%product}}';
    }

    public function rules()
    {
        return [
            ['title', 'required', 'message' => '标题不能为空'],
            ['descr', 'required', 'message' => '描述不能为空'],
            ['cateid', 'required', 'message' => '分类不能为空'],
            ['price', 'required', 'message' => '单价不能为空'],
            [['price', 'saleprice'], 'number', 'min' => 0.01, 'message' => '价格必须是数字'],
            ['num', 'integer', 'min' => 0, 'message' => '库存必须是数字'],
            [['issale', 'ishot', 'pics', 'istui'], 'safe'],
            [['cover'], 'required']
        ];
    }

    public function attributeLabels()
    {
        return [
            'cateid' => '分类名称',
            'title' => '商品名称',
            'descr' => '商品描述',
            'price' => '商品价格',
            'ishot' => '是否热卖',
            'issale' => '是否促销',
            'saleprice' => '促销价格',
            'num' => '库存',
            'cover' => '图片封面',
            'pics' => '商品图片',
            'ison' => '是否上架',
            'istui' => '是否推荐',
        ];
    }

    //添加商品的方法
    public function add($data)
    {
        if ($this->load($data) && $this->save()) {
            return true;
        }
        return false;
    }
}
