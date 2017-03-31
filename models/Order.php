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
    const CREATEORDER = 0;
    const CHECKORDER = 100;
    const PAYFAILED = 201;
    const PAYSUCCESS = 202;
    const SENDED = 220;
    const RECEIVED = 260;

    public static $status = [
        self::CREATEORDER => '订单初始化',
        self::CHECKORDER => '待支付',
        self::PAYFAILED => '支付失败',
        self::PAYSUCCESS => '等待发货',
        self::SENDED => '已发货',
        self::RECEIVED => '订单完成',
    ];

    public $products;
    public $zhstatus;
    public $username;
    public $address;

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
            [['userid', 'status'], 'required', 'on' => ['add']],
            [['addressid', 'expressid', 'amount', 'status'], 'required', 'on' => ['update']],
            ['expressno', 'required', 'message' => '请输入快递单号', 'on' => 'send'],
            ['createtime', 'safe', 'on' => ['add']]
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
            'expressno' => '快递号码',
            'createtime' => '创建时间',
            'updatetime' => '更新时间',
        ];
    }
}
