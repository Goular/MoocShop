<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%cart}}".
 *
 * @property string $cartid
 * @property string $productid
 * @property string $productnum
 * @property string $price
 * @property string $userid
 * @property string $createtime
 */
class Cart extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cart}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['productid', 'productnum', 'userid', 'createtime'], 'integer'],
            [['price'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cartid' => '购物车ID',
            'productid' => '商品ID',
            'productnum' => '商品数量',
            'price' => '价格',
            'userid' => '用户ID',
            'createtime' => '创建时间',
        ];
    }
}
