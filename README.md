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