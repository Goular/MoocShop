<!-- main container -->
<div class="content">
    <div class="container-fluid">
        <div id="pad-wrapper" class="new-user">
            <div class="row-fluid header">
                <h3>添加新管理员</h3></div>
            <div class="row-fluid form-wrapper">
                <!-- left column -->
                <div class="span9 with-sidebar">
                    <div class="container">
                        <form id="w0" class="new_user_form inline-input" action="/index.php?r=admin%2Fmanage%2Freg"
                              method="post">
                            <input type="hidden" name="_csrf"
                                   value="My1Fc0FTZ2JBYyIVOWFKCAIVJCM5JRI3Qh0kPxQwLxRXahQKcyckEA==">

                            <div class="form-group field-admin-adminuser">
                                <div class="span12 field-box">
                                    <label class="control-label" for="admin-adminuser">管理员账号</label>
                                    <input type="text" id="admin-adminuser" class="span9" name="Admin[adminuser]"></div>
                                <p class="help-block help-block-error"></p>
                            </div>
                            <div class="form-group field-admin-adminemail">
                                <div class="span12 field-box">
                                    <label class="control-label" for="admin-adminemail">管理员邮箱</label>
                                    <input type="text" id="admin-adminemail" class="span9" name="Admin[adminemail]">
                                </div>
                                <p class="help-block help-block-error"></p>
                            </div>
                            <div class="form-group field-admin-adminpass">
                                <div class="span12 field-box">
                                    <label class="control-label" for="admin-adminpass">管理员密码</label>
                                    <input type="password" id="admin-adminpass" class="span9" name="Admin[adminpass]"
                                           value=""></div>
                                <p class="help-block help-block-error"></p>
                            </div>
                            <div class="form-group field-admin-repass">
                                <div class="span12 field-box">
                                    <label class="control-label" for="admin-repass">确认密码</label>
                                    <input type="password" id="admin-repass" class="span9" name="Admin[repass]"
                                           value=""></div>
                                <p class="help-block help-block-error"></p>
                            </div>
                            <div class="span11 field-box actions">
                                <button type="submit" class="btn-glow primary">创建</button>
                                <span>或者</span>
                                <button type="reset" class="reset">取消</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- side right column -->
                <div class="span3 form-sidebar pull-right">
                    <div class="alert alert-info hidden-tablet">
                        <i class="icon-lightbulb pull-left"></i>请在左侧填写管理员相关信息，包括管理员账号，电子邮箱，以及密码
                    </div>
                    <h6>重要提示：</h6>

                    <p>管理员可以管理后台功能模块</p>

                    <p>请谨慎添加</p>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- end main container -->