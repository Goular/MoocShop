<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property string $cateid
 * @property string $title
 * @property string $parentid
 * @property string $createtime
 */
class Category extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{%category}}';
    }

    public function rules()
    {
        return [
            [['parentid', 'createtime'], 'integer'],
            [['title'], 'string', 'max' => 32],
        ];
    }

    public function attributeLabels()
    {
        return [
            'cateid' => '分类ID',
            'title' => '分类名称',
            'parentid' => '上次分类的ID',
            'createtime' => '创建时间',
        ];
    }
}
