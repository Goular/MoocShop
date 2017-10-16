# Yii2高级模板学习
### 升级Yii的项目的版本
<pre>
    1.首先需要更新静态资源的内容
        composer global require "fxp/composer-asset-plugin:~1.3"
    2.在社区下载页面，有一个是升级的内容，通过composer即可进行升级
        composer update yiisoft/yii2 yiisoft/yii2-composer bower-asset/jquery.inputmask
</pre>

### Yii查看当前版本的方法
<pre>
    直接使用在CMD下使用Yii命令即可
</pre>

### 目录结构
<pre>
    最主要的是三个目录:backend（后台）、common(公用)、 frontend（前台）
    environments的文件夹其实不是直接用和访问，而是为了让init.bat直接使用的，这样就可以控制是开发模式还是生产模式,
    选中模式后，会自动把文件覆盖到backend文件夹和frontend文件夹的内容
</pre>

### host文件的配置访问路径
<pre>
    打开C:\Windows\System32\drivers\etc\hosts 将下面代码复制到hosts文件中
        127.0.0.1   admin.demo.com  
        127.0.0.1   www.demo.com 
</pre>

### apache的vhost配置
<pre>
     <VirtualHost *:80>     
         DocumentRoot "F:\advanced\frontend\web"     
         ServerName www.demo.com     
         ServerAlias www.demo.com  
     </VirtualHost>  
     
     <VirtualHost *:80>     
         DocumentRoot "F:\advanced\backend\web"     
         ServerName admin.demo.com     
         ServerAlias admin.demo.com  
     </VirtualHost> 
     
     注：F:\advanced为本人的本地环境根目录，根据各自环境的实际情况而定
</pre>

### 配置环境变量 / 配置Yii高级模板是生产环境还是开发模式
<pre>
    把php.exe加入系统环境变量   
    步骤：   
    1.右击我的电脑-属性-高级-环境变量   
    2.找到 Path 这一项（可能需要向下滚动才能找到），鼠标双击 Path 这一项，在最后加入你的 PHP 目录和类库所在的路径，包括前面的“;”（例如：;C:\php;C:\php\ext）   
    3.点击“新建”按钮并在“变量名”中输入“PHPRC”，在“变量值”中输入 php.ini 文件所在的目录（例如：C:\php） ,这个步骤是为了让windows找到php.ini.  
    4.运行CMD 进入安装目录中，执行init或在安装目录中运行init.bat，选择 0 开发模式进行安装,可以重复使用，这样会覆盖文件而已，就是说开发/生产两个环境可以随便切换
</pre>