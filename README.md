### 慕课网YII2.O电商项目的源码的归档

### 使用时，记得使用在目录中使用composer install命令，不然会打不开.

### 安装
<pre>
    安装完Composer，运行下面的命令来安装Composer Asset插件(可以快速下载npm静态资源包):
    php composer.phar global require "fxp/composer-asset-plugin:^1.2.0"
    php composer.phar create-project yiisoft/yii2-app-basic basic 2.0.11
</pre>

### 部分Action中不渲染layout的方法
<pre>
    方法(1):在Action中添加一句$this->layout = false;
    方法(2)：使用$this->renderPartial()方法即可.
</pre>

### 公用的页头与页尾如何解决？
<pre>
    使用yii2的组件layout即可实现，具体步骤如下:
    1.在view/layout/文件夹中创建父布局文件;
    2.在父布局文件中直接输出<?=$content?>(注意:$content为当前对象的内置对象)

    注意:当前的对象存在两种的布局内容，一种是带导航条的头尾布局，另一种的不带导航条的头尾布局
    (1)带导航条的布局名称:layout_parent_nav
    (2)不带导航条的布局名称:layout_parent_none

    使用方式:
    1.控制器全局范围使用，即在当前类中添加覆盖属性layout的语句即可:public $layout = "layout_parent_none";
    2.局部使用:在action的范围内使用$layout = "layout_parent_nav"即可;
</pre>

### GII异机使用时，需要添加允许IP操作Gii的IP地址
<pre>
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
</pre>

### 利用GII创建后台模块
<pre>
    1.使用generate Module即可，会生成一个文件夹放置到module中，访问形式index.php?r=admin/controller/action

    2.模块默认的layout会选取父项目的view文件夹的layout中的main.php,所以需要自己覆盖view文件夹的内容

    (注意)创建的时候 Modals Class填写:app/admin/modules,app/mobile/modules(不要为了其他模块统一，写成app/modules/admin,app/modules/mobile,这种写法慕课网是教错了) ,注意，这里默认会以第二个单词作为根目录的文件夹名字，如果第二个单词重复，就会出现覆盖现象，看了文档，我发现第二个单词写我们的模块内容名字是正确的，慕课在这个位置是有问题的。
    (注意)ModuleID我们写:admin 即可

    （重点）默认内容，view中除了错误页面(view/site/error)会被继承，父文件夹的view的内容都不可以被子view文件夹调用


    记得到项目的config/web.php添加模块配置，不要加到gii的if代码段中，因为那是开发模式，调到生产模式就会找不到的.

    3.模块创建//从config.php加载配置来初始化模块
        \Yii::configure($this, require(__DIR__ . '/config.php'));

    4.模块设置默认内容:
        class IndexController extends Controller
        {
            public $defaultAction = 'index';
            /**
             * Renders the index view for the module
             * @return string
             */
            public function actionIndex()
            {
                $this->layout = 'layout_parent_none';
                return $this->render('index');
            }
        }

    模块设置默认的控制器(config.php)，文档有教
        return [
            'components' => [
                // list of component configurations
            ],
            'params' => [
                // list of parameters
            ],
            'defaultRoute'=>'index'
        ];

    gii创建页面:
    （注意）View Path: 可以使用相对路径，不然在这里写的内容，都会生成到根目录下的web目录
</pre>

### 添加平台(admin)后资源文件如何读取和访问
<pre>
    总的来说，还是放到/web/assets中，但是我们的要专门为admin在assets文件中添加admin文件夹，再去放置js/css/jq等文件
    这样能达到分模块的思想
</pre>

### web/assets中.gitignore文件启示录
<pre>
    需要值得注意的一件事是web/assets文件夹中，会自动产生一些yii2生成的文件内容,都是关于js/css渲染的临时文件，这样不应该提交到源码库，
    但是我们不能直接把assets在顶层的.gitIgnore文件直接忽略，因为那里有我们写的jss/css的文件与内容，所以，解决办法就是在asset文件夹中
    添加.gitIngore文件夹，并在第一行协商忽略所有文件，同时在文件中添加那些不要被忽略，即在不要被忽略的文件中添加"!"即可，例如：
    在我的asset的.ignore中添加下面语句:
        *               //这句是忽略当前文件夹的所有文件
        !.gitignore     //这句是说不要忽略.gitIgnore文件，注意这里仅仅是文件夹，我们还需要它的内容不要被忽略
        !/js            //这句是说不要忽略js文件夹，注意这里仅仅是文件夹，我们还需要它的内容不要被忽略
        !/css           //这句是说不要忽略css文件夹，注意这里仅仅是文件夹，我们还需要它的内容不要被忽略
        !/admin         //这句是说不要忽略admin文件夹，注意这里仅仅是文件夹，我们还需要它的内容不要被忽略
        !/js/*          //不要忽略文件夹内部内容，若还有三级四级目录和文件，这些文件还是会被忽略的
        !/css/*         //不要忽略文件夹内部内容，若还有三级四级目录和文件，这些文件还是会被忽略的
        !/admin/*       //不要忽略文件夹内部内容，若还有三级四级目录和文件，这些文件还是会被忽略的

    按照上面那样做，我们就能处理好assets文件的内容的处理，有用的上传代码，其他忽略
    !一定要紧贴着写，不然无效

    (重点)目前这种写法仅仅只能保证二级目录的内容不被忽略，三级目录及更多还是会被忽略的，所以我们只能继续添加不要不略三级目录的需求，毕竟无用的代码多，有用的代码少，
    所以这样做没什么关系了,写多点.gitIgnore规则而已，最好还是看我自己写的放置到web/asset的.gitIgnore文件的写法还好
</pre>

### 获取模块名/控制器名/方法名
<pre>
    Yii2 获取模块名、控制器名、方法名
    在视图中：
        模块名  $this->context->module->id
        控制器名 $this->context->id
        方法名 $this->context->action->id

    在控制器中
         模块名   Yii::$app->controller->module->id; //这个实测过，好像无效
         控制器名   Yii::$app->controller->id
         方法名  Yii::$app->controller->action->id;
    或
        模块名 $this->module->id;  //这个实测过，有效！
        控制器名 $this->id;
         方法名  $this->action->id;

    在控制器的 beforeAction 方法中（方法接收$action参数）
        模块名  $action->controller->module->id;
        控制器名 $action->controller->id;
        方法名  $action->id;
</pre>

### 默认控制器的创建
<pre>
    在web.php中添加defaultRoute属性即可达到默认控制器的变更
</pre>

### 在活动记录类中添加不是数据库字段的属性
<pre>
    在登录页中，存在一个"记住我"的选项，但是并没有在数据表中保存，此时我们应该添加属性，让activeform访问的到就可以了，不会影响写入数据库
</pre>

### ActiveForm
<pre>
    使用的是yii/bootstrap/ActiveForm,而不是yii/widget/form

    默认直接使用textInput()的方法，会产生一个label包裹，但是我们可以在全局文件
    ActiveForm::begin([
                    "fieldConfig"=>[
                        "template"=>"{error}{input}"//这里可以控制，不输出默认的label标签内容，这样是让每一个可以使用默认的模板样式
                    ]
                ]);
</pre>

### HTML工具类
<pre>
    任何一个 web 应用程序会生成很多 HTMl 超文本标记。如果超文本标记是静态的， 那么将 PHP 和 HTML 混合在一个文件里 这种做法是非常高效的。但是，如果这些超文本标记是动态生成的，那么如果没有额外的辅助工具，这个过程将会变得复杂。 Yii 通过 HTML 帮助类来提供生成超文本标记的方法。这个帮助类包含有一系列的用于处理通用的 HTML 标签和其属性以及内容的静态方法。
    HTML::encode()
</pre>

### 判断是否是POST方法的请求(一般用于是否是表单的提交)
<pre>
    yii::$app->request->isPost;
</pre>

### 将IP转为Long，将Long转为IP地址的方法
<pre>
    PHP方法：
        ip2Long();
        long2Ip();
</pre>

### 帮助类 Url
<pre>
    能够动态的读取当前的地址，防止因地址写死，在配置路由重写的时候会报错的问题。
</pre>

### Yii中的die()/exit()方法
<pre>
    Yii::app()->end();
</pre>

### ActiveRecord的rules()，能作为校验的方法，校验的内容，可以使方法，可以使标识，即"require"等
<pre>
    public function rules()
    {
        //不用gii默认生成的规则，我们自己写规则，来处理post表单的数据是否出现问题,例如对比密码等
        //validatePass为方法名
        return [
            [
               ['adminuser','required','message'=>"管理员账号不能为空"],
               ['adminpass','required','message'=>"管理员密码不能为空"],
               ['rememberMe','boolean'],
               ['adminpass','validatePass'] //这个是方法的名称
            ]
        ];
    }

    public function validatePass(){
        //在其他器情况并没有出现异常的情况下，才去执行下面的一步
        if(!$this->hasErrors()){
            $data = self::find()->where("adminuser= :user and adminpass= :pass",[":user"=>$this->adminuser,":pass"=>md5($this->adminpass)])->one();
            if(is_null($data)){
                $this->addError("adminpass","用户名或密码错误");
            }
        }
    }
</pre>

### 为模型添加数据并进行校验
<pre>
    注意一点，就是$model->load($data)方法并不会自动执行校验的方法，此时我们可以这样写，一般都会这样去写的，在登录的页面中,
    if ($this->load($data) && $this->validate()) {}

    $model->getErrors();//会返回异常的内容
</pre>

### 在Controller中进行转跳，并结束后面的代码操作
<pre>
    $this->redirect(['index/index']);
    \Yii::$app->end();
</pre>

### session_set_cookie_params
<pre>
    为sessionID创建cookie属性内容，这些会在各自的浏览器上去呈现出来
</pre>

### 场景
<pre>
     由于的model的是分不同的层次和方法，校验的内容也是不一样，所以rules()不是每一次都是全部检测，不然
     就会出现每一次都会报错，因为不是每次提交表单的数量都是全部表单，所以需要分场景，按场景来确定点钱rules()方法，
     执行当次方法是需要校验多少种变量，还是全部变量，所以这个是需要通过场景来控制的。
</pre>

### 使用自带的Mailer发送邮件
<pre>
    配置文件:/config/web.config
    //这是我配置需要配置的效果
    'mailer' => [
                'class' => 'yii\swiftmailer\Mailer',
                // send all mails to a file by default. You have to set
                // 'useFileTransport' to false and configure a transport
                // for the mailer to send real emails.
                'useFileTransport' => false, //记住这个位置需要设置为false，下面的transposrt才能执行
                'transport' => [
                    'class' => 'Swift_SmtpTransport',
                    'host' => 'smtp.163.com',
                    'username' => 'imooc_shop@163.com',
                    'password' => 'imooc123',
                    'port' => '465',
                    'encryption' => 'ssl',
                ],

    ]

    在vendor文件夹中Mailer类中，在类的前面有教程使用:
     * Mailer implements a mailer based on SwiftMailer.
     *
     * To use Mailer, you should configure it in the application configuration like the following,
     *
     * ~~~
     * 'components' => [
     *     ...
     *     'mailer' => [
     *         'class' => 'yii\swiftmailer\Mailer',
     *         'transport' => [
     *             'class' => 'Swift_SmtpTransport',
     *             'host' => 'localhost',
     *             'username' => 'username',
     *             'password' => 'password',
     *             'port' => '587',
     *             'encryption' => 'tls',
     *         ],
     *     ],
     *     ...
     * ],


    发送邮件的教程:
     * To send an email, you may use the following code:
     *
     * ~~~
     * Yii::$app->mailer->compose('contact/html', ['contactForm' => $form])
     *     ->setFrom('from@domain.com')
     *     ->setTo($form->email)
     *     ->setSubject($form->subject)
     *     ->send();
     * ~~~
</pre>

### 邮件模板(文件夹为@app/mail),即根目录的mail文件夹
<pre>
    为了通过视图文件撰写正文可传递视图名称到 compose() 方法中：

    home-link的访问路径为:@app/mail/home-link
    会自动加载模板

    Yii::$app->mailer->compose('home-link') // 渲染一个视图作为邮件内容
        ->setFrom('from@domain.com')
        ->setTo('to@domain.com')
        ->setSubject('Message subject')
        ->send();
        
    你可以指定不同的视图文件的 HTML 和纯文本邮件内容：
    
    Yii::$app->mailer->compose([
        'html' => 'contact-html',
        'text' => 'contact-text',
    ]);
</pre>

### 设置全局的参数(电子邮箱，key等配置内容)
<pre>
    配置在@app/config/params.php里，读取方式为Yii::$app->params['paramsName']。
    比如Yii::$app->params['sitename']
</pre>

### Flash 数据(Session下只有一次使用寿命的数据)
<pre>
    设置好之后，会藏在model中，在view中使用getFlash()方法即可
    Flash数据是一种特别的session数据，它一旦在某个请求中设置后， 只会在下次请求中有效，然后该数据就会自动被删除。 常用于实现只需显示给终端用户一次的信息， 如用户提交一个表单后显示确认信息。

    可通过session应用组件设置或访问session

    \Yii::$app->session->setFlash('info','电子邮件已经成功发送，请查收!');
    Yii::$app->session->hasFlash('info')
    Yii::$app->session->getFlash('info')
</pre>

### UrlManager 和 Url的区别
<pre>
    Url创建的是相对路径
    UrlManager创建的是绝对路径（发送到邮箱的地址需要绝对路径，所以才使用urlmanager）
</pre>

### 一般创建对象的的流程
<pre>
    M层:
        /**
         * 创建管理员
         */
        public function reg($data){
            $this->scenario = 'adminadd';
            if($this->load($data) && $this->validate()){
                $this->adminpass = md5($this->adminpass);
                if($this->save(false)){//这个方法中的false为是否进行校验，因为之前为validate的内容
                    return true;
                }
                return false;
            }
            return false;
        }
        
    V层:
        <div class="container">
            <?php
            if (Yii::$app->session->hasFlash('info')) {
                echo Yii::$app->session->getFlash('info');
            }

            $form = ActiveForm::begin([
                'options' => ['class' => 'new_user_form inline-input'],
                'fieldConfig' => [
                    'template' => '<div class="span12 field-box">{label}{input}</div>{error}'
                ]
            ]);
            ?>
            <?php echo $form->field($model, 'adminuser')->textInput(['class' => 'span9']); ?>
            <?php echo $form->field($model, 'adminemail')->textInput(['class' => 'span9']); ?>
            <?php echo $form->field($model, 'adminpass')->passwordInput(['class' => 'span9']); ?>
            <?php echo $form->field($model, 'repass')->passwordInput(['class' => 'span9']); ?>
            <div class="span11 field-box actions">
                <?php echo Html::submitButton('创建', ['class' => 'btn-glow primary']); ?>
                <span>或者</span>
                <?php echo Html::resetButton('取消', ['class' => 'reset']); ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        
    C层:
        public function actionReg()
        {
            //1.设置父模板
            $this->layout = "admin_main";
            $model = new Admin();
            if(\Yii::$app->request->isPost){
                $post = \Yii::$app->request->post();
                if($model->reg($post)){
                    \Yii::$app->session->setFlash('info','添加成功!');
                }else{
                    \Yii::$app->session->setFlash('info','添加失败!');
                }
            }
            $model->adminpass = "";
            $model->repass = "";
            return $this->render("reg",['model'=>$model]);
        }
</pre>

### 不建议真的把数据删除，因为很容易造成关联数据的丢失。

### joinWith()
<pre>
    User模型类中使用joinwith("profile") 中的profile 会在寻找User类中的getProfile方法，然后形成leftjoin的查询，
</pre>

###　关联表删除
<pre>
    需要先删除外键表，再去删除主键表的内容，为了防止操作中断异常，记得采用事务的操作
</pre>

### 单页面多表单的显示
<pre>
    此时我们需要在ActiveForm添加action的选项:
    <?php
    if (Yii::$app->session->hasFlash('info')) {
        echo Yii::$app->session->getFlash('info');
    }
    $form = ActiveForm::begin([
        'fieldConfig' => [
            'template' => '<div class="field-row">{label}{input}</div>{error}'
        ],
        'options' => [
            'class' => 'register-form cf-style-1',
            'role' => 'form',
        ],
        'action' => ['member/reg']
    ]);
    ?>
</pre>

### ActiveForm的名字
<pre>
    ActiveForm返回的表单名字为表单数组，数组的名字为当前model::className();
    <input type="text" id="user-useremail" class="le-input" name="User[useremail]">    
</pre>