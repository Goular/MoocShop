<?php

namespace app\admin\models;

use Yii;

/**
 * This is the model class for table "shop_admin".
 *
 * @property string $adminid
 * @property string $adminuser
 * @property string $adminpass
 * @property string $adminemail
 * @property string $logintime
 * @property string $loginip
 * @property string $createtime
 */
class Admin extends \yii\db\ActiveRecord
{
    public $rememberMe = true;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['logintime', 'loginip', 'createtime'], 'integer'],
            [['adminuser', 'adminpass'], 'string', 'max' => 32],
            [['adminemail'], 'string', 'max' => 50],
            [['adminuser', 'adminpass'], 'unique', 'targetAttribute' => ['adminuser', 'adminpass'], 'message' => 'The combination of 管理员账号 and 管理员密码 has already been taken.'],
            [['adminuser', 'adminemail'], 'unique', 'targetAttribute' => ['adminuser', 'adminemail'], 'message' => 'The combination of 管理员账号 and 管理员电子邮箱 has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'adminid' => '主键ID',
            'adminuser' => '管理员账号',
            'adminpass' => '管理员密码',
            'adminemail' => '管理员电子邮箱',
            'logintime' => '登录时间',
            'loginip' => '登录IP',
            'createtime' => '创建时间',
        ];
    }
}
