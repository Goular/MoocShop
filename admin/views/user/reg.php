<!-- main container -->
<div class="content">
    <div class="container-fluid">
        <div id="pad-wrapper" class="new-user">
            <div class="row-fluid header">
                <h3>添加新用户</h3></div>
            <div class="row-fluid form-wrapper">
                <!-- left column -->
                <div class="span9 with-sidebar">
                    <div class="container">
                        <form id="w0" class="new_user_form inline-input" action="/index.php?r=admin%2Fuser%2Freg"
                              method="post">
                            <input type="hidden" name="_csrf"
                                   value="TDdVOGxYYWg.eTJeFGpMAn0PNGgULhQ9PQc0dDk7KR4ocARBXiwiGg==">

                            <div class="form-group field-user-username">
                                <div class="span12 field-box">
                                    <label class="control-label" for="user-username">用户名</label>
                                    <input type="text" id="user-username" class="span9" name="User[username]"></div>
                                <p class="help-block help-block-error"></p>
                            </div>
                            <div class="form-group field-user-useremail">
                                <div class="span12 field-box">
                                    <label class="control-label" for="user-useremail">电子邮箱</label>
                                    <input type="text" id="user-useremail" class="span9" name="User[useremail]"></div>
                                <p class="help-block help-block-error"></p>
                            </div>
                            <div class="form-group field-user-userpass">
                                <div class="span12 field-box">
                                    <label class="control-label" for="user-userpass">用户密码</label>
                                    <input type="password" id="user-userpass" class="span9" name="User[userpass]"
                                           value=""></div>
                                <p class="help-block help-block-error"></p>
                            </div>
                            <div class="form-group field-user-repass">
                                <div class="span12 field-box">
                                    <label class="control-label" for="user-repass">确认密码</label>
                                    <input type="password" id="user-repass" class="span9" name="User[repass]" value="">
                                </div>
                                <p class="help-block help-block-error"></p>
                            </div>
                            <div class="span11 field-box actions">
                                <button type="submit" class="btn-glow primary">添加</button>
                                <span>OR</span>
                                <button type="reset" class="reset">取消</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- side right column -->
                <div class="span3 form-sidebar pull-right">
                    <div class="alert alert-info hidden-tablet">
                        <i class="icon-lightbulb pull-left"></i>请在左侧表单当中填入要添加的用户信息,包括用户名,密码,电子邮箱
                    </div>
                    <h6>商城用户说明</h6>

                    <p>可以在前台进行登录并且进行购物</p>

                    <p>前台也可以注册用户</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end main container -->