# Yii2�߼�ģ��ѧϰ
### ����Yii����Ŀ�İ汾
<pre>
    1.������Ҫ���¾�̬��Դ������
        composer global require "fxp/composer-asset-plugin:~1.3"
    2.����������ҳ�棬��һ�������������ݣ�ͨ��composer���ɽ�������
        composer update yiisoft/yii2 yiisoft/yii2-composer bower-asset/jquery.inputmask
</pre>

### Yii�鿴��ǰ�汾�ķ���
<pre>
    ֱ��ʹ����CMD��ʹ��Yii�����
</pre>

### Ŀ¼�ṹ
<pre>
    ����Ҫ��������Ŀ¼:backend����̨����common(����)�� frontend��ǰ̨��
    environments���ļ�����ʵ����ֱ���úͷ��ʣ�����Ϊ����init.batֱ��ʹ�õģ������Ϳ��Կ����ǿ���ģʽ��������ģʽ,
    ѡ��ģʽ�󣬻��Զ����ļ����ǵ�backend�ļ��к�frontend�ļ��е�����
</pre>

### host�ļ������÷���·��
<pre>
    ��C:\Windows\System32\drivers\etc\hosts ��������븴�Ƶ�hosts�ļ���
        127.0.0.1   admin.demo.com  
        127.0.0.1   www.demo.com 
</pre>

### apache��vhost����
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
     
     ע��F:\advancedΪ���˵ı��ػ�����Ŀ¼�����ݸ��Ի�����ʵ���������
</pre>

### ���û������� / ����Yii�߼�ģ���������������ǿ���ģʽ
<pre>
    ��php.exe����ϵͳ��������   
    ���裺   
    1.�һ��ҵĵ���-����-�߼�-��������   
    2.�ҵ� Path ��һ�������Ҫ���¹��������ҵ��������˫�� Path ��һ������������ PHP Ŀ¼��������ڵ�·��������ǰ��ġ�;�������磺;C:\php;C:\php\ext��   
    3.������½�����ť���ڡ��������������롰PHPRC�����ڡ�����ֵ�������� php.ini �ļ����ڵ�Ŀ¼�����磺C:\php�� ,���������Ϊ����windows�ҵ�php.ini.  
    4.����CMD ���밲װĿ¼�У�ִ��init���ڰ�װĿ¼������init.bat��ѡ�� 0 ����ģʽ���а�װ,�����ظ�ʹ�ã������Ḳ���ļ����ѣ�����˵����/��������������������л�
</pre>