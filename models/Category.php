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
            if ($cate['parentid'] == $pid) {
                $tree[] = $cate;
                $tree = array_merge($tree, $this->getTree($cates, $cate['cateid']));
            }
        }
        return $tree;
    }

    /**
     * 注意，这里是为排序好的队列进行处理
     * @param $data
     * @param string $p
     * @return array
     * 排序的顺序为
     * 1
     * 1-2
     * 1-3
     * 2
     * 2-1
     * 2-2
     * 2-3
     * 3
     * ...
     */
    public function setPrefix($data, $p = "|----")
    {
        $tree = [];
        $num = 1;
        $prefix = [0 => 1];
        while ($val = current($data)) {
            $key = key($data);
            if ($key > 0) {
                //如果排序好的上一个的父级ID与当前元素的父级ID不一样，那么就会为当前的num+1
                if ($data[$key - 1]['parentid'] != $val['parentid']) {
                    $num++;
                }
            }
            if (array_key_exists($val['parentid'], $prefix)) {
                $num = $prefix[$val['parentid']];
            }
            $val['title'] = str_repeat($p, $num) . $val['title'];
            $prefix[$val['parentid']] = $num;
            $tree[] = $val;
            next($data);
        }
        return $tree;
    }

    //获取在添加下拉列表时需要显示的内容
    public function getOptions()
    {
        $data = $this->getData();
        $tree = $this->getTree($data);
        $tree = $this->setPrefix($tree);
        $options = ['添加顶级分类'];//第一个的显示内容，用于添加顶级的分类
        foreach ($tree as $cate) {
            $options[$cate['cateid']] = $cate['title'];
        }
        return $options;//返回显示的分类的内容
    }

    public function getTreeList()
    {
        $data = $this->getData();//获取原始数据
        $tree = $this->getTree($data);//排序
        return $tree = $this->setPrefix($tree);
    }
}
