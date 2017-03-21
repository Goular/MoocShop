<?php

namespace app\models;

use Yii;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

class Product extends \yii\db\ActiveRecord
{
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
            'productid' => '商品ID',
            'cateid' => '商品分类ID',
            'title' => '商品标题',
            'descr' => '商品描述',
            'num' => '库存数量',
            'price' => '商品价格',
            'cover' => '商品封面',
            'pics' => '商品价格',
            'issale' => '上架情况',
            'saleprice' => '销售价格',
            'ishot' => '热销商品',
            'createtime' => '创建时间',
        ];
    }
}
