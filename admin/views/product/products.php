<!-- main container -->
<div class="content">
    <div class="container-fluid">
        <div id="pad-wrapper" class="users-list">
            <div class="row-fluid header">
                <h3>商品列表</h3>

                <div class="span10 pull-right">
                    <a href="/index.php?r=admin%2Fproduct%2Fadd" class="btn-flat success pull-right">
                        <span>&#43;</span>添加新商品</a></div>
            </div>
            <!-- Users table -->
            <div class="row-fluid table">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="span6 sortable">
                            <span class="line"></span>商品名称
                        </th>
                        <th class="span2 sortable">
                            <span class="line"></span>商品库存
                        </th>
                        <th class="span2 sortable">
                            <span class="line"></span>商品单价
                        </th>
                        <th class="span2 sortable">
                            <span class="line"></span>是否热卖
                        </th>
                        <th class="span2 sortable">
                            <span class="line"></span>是否促销
                        </th>
                        <th class="span2 sortable">
                            <span class="line"></span>促销价
                        </th>
                        <th class="span2 sortable">
                            <span class="line"></span>是否上架
                        </th>
                        <th class="span2 sortable">
                            <span class="line"></span>是否推荐
                        </th>
                        <th class="span3 sortable align-right">
                            <span class="line"></span>操作
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- row -->
                    <tr class="first">
                        <td>
                            <img src="http://o7zgluxwg.bkt.clouddn.com/5764d1a56497b-coversmall"
                                 class="img-circle avatar hidden-phone"/>
                            <a href="#" class="name">黑色长裙</a></td>
                        <td>93</td>
                        <td>10.00</td>
                        <td>热卖</td>
                        <td>促销</td>
                        <td>10.00</td>
                        <td>上架</td>
                        <td>推荐</td>
                        <td class="align-right">
                            <a href="/index.php?r=admin%2Fproduct%2Fmod&productid=3">编辑</a>
                            <a href="/index.php?r=admin%2Fproduct%2Fon&productid=3">上架</a>
                            <a href="/index.php?r=admin%2Fproduct%2Foff&productid=3">下架</a>
                            <a href="/index.php?r=admin%2Fproduct%2Fdel&productid=3">删除</a></td>
                    </tr>
                    <tr class="first">
                        <td>
                            <img src="http://o7zgluxwg.bkt.clouddn.com/57663c9bd20ec-coversmall"
                                 class="img-circle avatar hidden-phone"/>
                            <a href="#" class="name">长裙</a></td>
                        <td>86</td>
                        <td>0.01</td>
                        <td>热卖</td>
                        <td>促销</td>
                        <td>0.01</td>
                        <td>上架</td>
                        <td>推荐</td>
                        <td class="align-right">
                            <a href="/index.php?r=admin%2Fproduct%2Fmod&productid=4">编辑</a>
                            <a href="/index.php?r=admin%2Fproduct%2Fon&productid=4">上架</a>
                            <a href="/index.php?r=admin%2Fproduct%2Foff&productid=4">下架</a>
                            <a href="/index.php?r=admin%2Fproduct%2Fdel&productid=4">删除</a></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="pagination pull-right"></div>
            <!-- end users table --></div>
    </div>
</div>
<!-- end main container -->