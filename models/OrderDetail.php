<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%order_detail}}".
 *
 * @property string $detailid
 * @property string $productid
 * @property string $price
 * @property string $productnum
 * @property string $orderid
 * @property string $createtime
 */
class OrderDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_detail}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['productid', 'productnum', 'orderid', 'createtime'], 'integer'],
            [['price'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'detailid' => '订单详情ID',
            'productid' => '商品ID',
            'price' => '价格',
            'productnum' => '商品数量',
            'orderid' => '订单ID',
            'createtime' => '创建时间',
        ];
    }

    //添加订单
    public function add($data)
    {
        if ($this->load($data) && $this->save()) {
            return true;
        }
        return false;
    }
}
