<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%profile}}".
 *
 * @property string $id
 * @property string $truename
 * @property integer $age
 * @property string $sex
 * @property string $birthday
 * @property string $nickname
 * @property string $company
 * @property string $userid
 * @property string $createtime
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%profile}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['age', 'userid', 'createtime'], 'integer'],
            [['sex'], 'string'],
            [['birthday'], 'safe'],
            [['truename', 'nickname'], 'string', 'max' => 32],
            [['company'], 'string', 'max' => 100],
            [['userid'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键ID',
            'truename' => '真实姓名',
            'age' => '年龄',
            'sex' => '性别',
            'birthday' => '生日',
            'nickname' => '昵称',
            'company' => '公司',
            'userid' => '用户ID',
            'createtime' => '创建时间',
        ];
    }
}
