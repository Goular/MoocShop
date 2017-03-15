<p>尊敬的<?php echo $adminuser?>,您好:</p>
<p>您的业务(找回密码)的链接如下</p>
<?php
    $url = Yii::$app->urlManager->createAbsoluteUrl(['admin/manage/mailchangepass','timestamp'=>$time,'adminuser'=>$adminuser,'token'=>$token]);
?>
<p><a href="<?php echo $url;?>"><?php echo $url;?></a></p>
<p>该链接5分钟有效，请勿传递给别人!</p>
<p>该邮件为系统自动发送,请勿回复.</p>
