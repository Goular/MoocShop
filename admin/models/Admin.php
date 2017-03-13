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
    //登录页-记住我的选项
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
     * //不用gii默认生成的规则，我们自己写规则，来处理post表单的数据是否出现问题,例如对比密码等
     * //validatePass为方法名
     */
    public function rules()
    {
        return [
            ['adminuser', 'required', 'message' => '管理员账号不能为空'],
            ['adminpass', 'required', 'message' => '管理员密码不能为空'],
            ['rememberMe', 'boolean'],
            ['adminpass', 'validatePass']
        ];
    }

    /**
     * 在执行$this->validate()方法的时候会执行rules方法，这里包含着一种validatePass的方法的引用
     */
    public function validatePass()
    {
        //在其他器情况并没有出现异常的情况下，才去执行下面的一步
        if (!$this->hasErrors()) {
            $data = self::find()->where("adminuser= :user and adminpass= :pass", [":user" => $this->adminuser, ":pass" => md5($this->adminpass)])->one();
            if (is_null($data)) {
                $this->addError("adminpass", "用户名或密码错误");
            }
        }
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

    /**
     * @param $data 为Yii::$app->reuqest->post()返回的对象
     */
    public function login($data)
    {
        if ($this->load($data) && $this->validate()) {
            //数据能成功过关后，我们在此做有意义的操作
            $liftTime = $this->rememberMe ? 24 * 3600 : 0;//判断时候选中"记住我"，是的话，就将sessionID设定有效的时长
            $session = Yii::$app->session;
            session_set_cookie_params($liftTime);//为sessinID创建cookie属性
            //session中保存的是adminuser(管理员姓名),isLogin(是否登录的内容)
            $session['admin'] = [
                "adminuser" => $this->adminuser,
                "isLogin" => 1
            ];
            $this->updateAll(['logintime' => time(), 'loginip' => ip2long(Yii::$app->request->userIP)], 'adminuser= :user', [':user' => $this->adminuser]);
            return (bool)$session['admin']['isLogin'];
        }
        return false;
    }
}
