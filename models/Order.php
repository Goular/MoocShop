<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property string $orderid
 * @property string $userid
 * @property string $addressid
 * @property string $amount
 * @property string $status
 * @property string $expressid
 * @property string $expressno
 * @property string $createtime
 * @property string $updatetime
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'addressid', 'status', 'expressid', 'createtime'], 'integer'],
            [['amount'], 'number'],
            [['updatetime'], 'safe'],
            [['expressno'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'orderid' => '订单ID',
            'userid' => '用户ID',
            'addressid' => '地址ID',
            'amount' => '总额',
            'status' => '订单状态',
            'expressid' => '有效期',
            'expressno' => '邮递号码',
            'createtime' => '创建时间',
            'updatetime' => '更新时间',
        ];
    }
}
