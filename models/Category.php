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
            ['parentid', 'required', 'message' => '上级分类不能为空'],
            ['title', 'required', 'message' => '标题名称不能为空'],
            ['createtime', 'safe']
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

    //添加分类的内容
    public function add($data){
        //在添加分类的时候我们都需要添加创建时间
        $data['Category']['createtime'] = time();
        if($this->load($data) && $this->save()){
            return true;
        }
        return false;
    }

    //获取选择分类的选项
    public function getOptions(){
        $options = ['添加顶级分类'];
        return $options;
    }

}
