<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

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

    public function attributeLabels()
    {
        return [
            'cateid' => '分类ID',
            'title' => '分类名称',
            'parentid' => '上次分类的ID',
            'createtime' => '创建时间',
        ];
    }

    public function rules()
    {
        return [
            ['parentid', 'required', 'message' => '上级分类不能为空'],
            ['title', 'required', 'message' => '标题名称不能为空'],
            ['createtime', 'safe']
        ];
    }

    //添加分类的内容
    public function add($data)
    {
        //在添加分类的时候我们都需要添加创建时间
        $data['Category']['createtime'] = time();
        if ($this->load($data) && $this->save()) {
            return true;
        }
        return false;
    }

    //获取所有的数据
    public function getData()
    {
        $cates = self::find()->all();
        //利用帮助类将对象列表转为数组
        $cates = ArrayHelper::toArray($cates);
        return $cates;
    }

    //获取分类的树状图

    //其实传智的ThinkPHP中rbac更好
    //即在创建时，添加好分层分级
    //101-105,101-105-110,这样使用orderBy来进行获去，就不用每次都排序了，毕竟递归的内容的消耗重复很厉害
    public function getTree($cates, $pid = 0)
    {
        $tree = [];
        foreach ($cates as $cate) {
            //遍历统一等级，同时做一个
            if ($cate['parentid'] == $pid) {
                $tree[] = $cate;
            }
        }
    }

}
