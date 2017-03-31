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
            'detailid' => 'Detailid',
            'productid' => 'Productid',
            'price' => 'Price',
            'productnum' => 'Productnum',
            'orderid' => 'Orderid',
            'createtime' => 'Createtime',
        ];
    }
}
