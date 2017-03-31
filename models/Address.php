<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%address}}".
 *
 * @property string $addressid
 * @property string $firstname
 * @property string $lastname
 * @property string $company
 * @property string $address
 * @property string $postcode
 * @property string $email
 * @property string $telephone
 * @property string $userid
 * @property string $createtime
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%address}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['address'], 'string'],
            [['userid', 'createtime'], 'integer'],
            [['firstname', 'lastname'], 'string', 'max' => 32],
            [['company', 'email'], 'string', 'max' => 100],
            [['postcode'], 'string', 'max' => 6],
            [['telephone'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'addressid' => 'Addressid',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'company' => 'Company',
            'address' => 'Address',
            'postcode' => 'Postcode',
            'email' => 'Email',
            'telephone' => 'Telephone',
            'userid' => 'Userid',
            'createtime' => 'Createtime',
        ];
    }
}
