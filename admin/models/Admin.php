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
            ['adminuser', 'required', 'message' => '管理员账号不能为空', 'on' => ['login', 'seekpass']],
            ['adminpass', 'required', 'message' => '管理员密码不能为空', 'on' => ['login']],
            ['rememberMe', 'boolean', 'on' => ['login']],
            ['adminpass', 'validatePass', 'on' => ['login']],
            ['adminemail', 'required', 'message' => '电子邮箱不能为空', 'on' => 'seekpass'],
            ['adminemail', 'email', 'message' => '电子邮箱格式不正确', 'on' => 'seekpass'],
            ['adminuser', 'unique', 'message' => '管理员已被注册', 'on' => ''],
            ['adminemail', 'validateEmail', 'on' => 'seekpass'],
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

    public function validateEmail()
    {
        //在其他器情况并没有出现异常的情况下，才去执行下面的一步
        if (!$this->hasErrors()) {
            $data = self::find()->where("adminuser= :user and adminemail= :email", [":user" => $this->adminuser, ":email" => $this->adminemail])->one();
            if (is_null($data)) {
                $this->addError("adminemail", "管理员电子邮箱不匹配");
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
     * 登录
     */
    public function login($data)
    {
        //由于Rules方法的关系，我们需要为方法设置场景(因为这里有执行validate()方法)
        $this->scenario = "login";

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

    /**
     * @param $data
     *  搜索密码
     */
    public function seekPass($data)
    {
        //由于Rules方法的关系，我们需要为方法设置场景(因为这里有执行validate()方法)
        $this->scenario = "seekpass";
        if ($this->load($data) && $this->validate()) {
            //这里执行发送邮件的操作
            $time = time();
            $token = $this->createToken($data['Admin']['adminuser'], $time);
            $mailer = Yii::$app->mailer->compose();
            //邮件来源
            $mailer->setFrom(Yii::$app->params['adminEmail']);//获取全局文件\confing\params.php中的参数内容
            //邮件收件人
            $mailer->setTo($data['Admin']['adminemail']);
            //邮件主题
            $mailer->setSubject("Goular社区--找回密码");
            if($mailer->send()){
                return true;
            }
        }
        return false;
    }

    /**
     * 创建用于校验的token
     */
    public function createToken($adminuser, $time)
    {
        //base64_encode() returns 使用 base64 对 data 进行编码。设计此种编码是为了使二进制数据可以通过非纯 8-bit 的传输层传输，例如电子邮件的主体。
        //本函数将字符串以 MIME BASE64 编码。此编码方式可以让中文字或者图片也能在网络上顺利传输
        return md5(md5($adminuser) . base64_encode(Yii::$app->request->userIP) . md5($time));
    }

}
