<!-- main container -->
<div class="content">
    <div class="container-fluid">
        <div id="pad-wrapper" class="users-list">
            <div class="row-fluid header">
                <h3>管理员列表</h3>

                <div class="span10 pull-right">
                    <a href="/index.php?r=admin%2Fmanage%2Freg" class="btn-flat success pull-right">
                        <span>&#43;</span>添加新管理员</a></div>
            </div>
            <!-- Users table -->
            <div class="row-fluid table">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="span2">管理员ID</th>
                        <th class="span2">
                            <span class="line"></span>管理员账号
                        </th>
                        <th class="span2">
                            <span class="line"></span>管理员邮箱
                        </th>
                        <th class="span3">
                            <span class="line"></span>最后登录时间
                        </th>
                        <th class="span3">
                            <span class="line"></span>最后登录IP
                        </th>
                        <th class="span2">
                            <span class="line"></span>添加时间
                        </th>
                        <th class="span2">
                            <span class="line"></span>操作
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- row -->
                    <tr>
                        <td>1</td>
                        <td>admin</td>
                        <td>86267659@qq.com</td>
                        <td>2016-06-29 08:50:04</td>
                        <td>192.168.199.227</td>
                        <td>2016-04-07 21:56:14</td>
                        <td class="align-right">
                            <a href="/index.php?r=admin%2Fmanage%2Fdel&adminid=1">删除</a></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="pagination pull-right"></div>
            <!-- end users table --></div>
    </div>
</div>
<!-- end main container -->
