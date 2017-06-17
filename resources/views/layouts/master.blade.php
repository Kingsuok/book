<!--_meta 作为公共模版分离出去-->
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="Bookmark" href="{{asset('_admin/favicon.ico')}}" >
    <link rel="Shortcut Icon" href="{{asset('_admin/favicon.ico')}}" />
    <!--[if lt IE 9]>
    <script type="text/javascript" src="{{asset('_admin/lib/html5.js')}}"></script>
    <script type="text/javascript" src="{{asset('_admin/lib/respond.min.js')}}"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="{{asset('_admin/static/h-ui/css/H-ui.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('_admin/static/h-ui.admin/css/H-ui.admin.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('_admin/lib/Hui-iconfont/1.0.8/iconfont.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('_admin/static/h-ui.admin/skin/default/skin.css')}}" id="skin" />
    <link rel="stylesheet" type="text/css" href="{{asset('_admin/static/h-ui.admin/css/style.css')}}" />
    <!--[if IE 6]>
    <script type="text/javascript" src="http://lib.h-ui.net/DD_belatedPNG_0.0.8a-min.js" ></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <!--/meta 作为公共模版分离出去-->

    @yield('title')

    <meta name="keywords" content="book">
    <meta name="description" content="book">
</head>
<body>
@section('headAndMenu')
<!--_header 作为公共模版分离出去-->
<header class="navbar-wrapper">
    <div class="navbar navbar-fixed-top">
        <div class="container-fluid cl"> <a class="logo navbar-logo f-l mr-10 hidden-xs" href="{{url('admin/index')}}">Book.admin</a> <a class="logo navbar-logo-m f-l mr-10 visible-xs" href="">book</a>
            <span class="logo navbar-slogan f-l mr-10 hidden-xs">v1.0</span>
            <a aria-hidden="false" class="nav-toggle Hui-iconfont visible-xs" href="javascript:;">&#xe667;</a>
            <nav id="Hui-userbar" class="nav navbar-nav navbar-userbar hidden-xs">
                <ul class="cl">
                    <li>SuperAdmin</li>
                    <li class="dropDown dropDown_hover"> <a href="#" class="dropDown_A">{{session('admin')->name}} <i class="Hui-iconfont">&#xe6d5;</i></a>
                        <ul class="dropDown-menu menu radius box-shadow">
                            <li><a href="javascript:admin_edit('edit admin','{{url('admin/admin/edit')}}',600,400);">password</a></li>
                            <li><a href="javascript:_logout();">quit</a></li>
                        </ul>
                    </li>
                    <li id="Hui-msg"> <a href="#" title="msg"><span class="badge badge-danger">1</span><i class="Hui-iconfont" style="font-size:18px">&#xe68a;</i></a> </li>

                </ul>
            </nav>
        </div>
    </div>
</header>
<!--/_header 作为公共模版分离出去-->

<!--_menu 作为公共模版分离出去-->
<aside class="Hui-aside">

    <div class="menu_dropdown bk_2">

        <dl id="menu-product">
            <dt><i class="Hui-iconfont">&#xe620;</i> Product<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>

                    <li><a href="{{url('admin/category')}}" title="categoryManagement">category</a></li>
                    <li><a href="{{url('admin/product')}}" title="bookManagemen">products</a></li>
                </ul>
            </dd>
        </dl>

        <dl id="menu-member">
            <dt><i class="Hui-iconfont">&#xe60d;</i> Member<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li><a href="{{url('admin/member')}}" title="members">members</a></li>

                </ul>
            </dd>
        </dl>
        <dl id="menu-order">
            <dt><i class="Hui-iconfont">&#xe687;</i> Order<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li><a href="{{url('admin/order')}}" title="orders">orders</a></li>

                </ul>
            </dd>
        </dl>

    </div>
</aside>
<div class="dislpayArrow hidden-xs"><a class="pngfix" href="javascript:void(0);" onClick="displaynavbar(this)"></a></div>
<!--/_menu 作为公共模版分离出去-->
@show

@yield('content')

<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="{{asset('_admin/lib/jquery/1.9.1/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('_admin/lib/layer/2.4/layer.js')}}"></script>
<script type="text/javascript" src="{{asset('_admin/static/h-ui/js/H-ui.js')}}"></script>
<script type="text/javascript" src="{{asset('_admin/static/h-ui.admin/js/H-ui.admin.page.js')}}"></script>
<!--/_footer /作为公共模版分离出去-->
<!--_自己添加用的比较多的js-->
<script type="text/javascript" src="{{asset('_admin/lib/jquery.validation/1.14.0/validate-methods.js')}}"></script>
<script type="text/javascript" src="{{asset('_admin/lib/jquery.validation/1.14.0/jquery.validate.js')}}"></script>
<script type="text/javascript" src="{{asset('_admin/lib/jquery.form.js')}}"></script>
<!--/_自己添加用的比较多的js-->
@yield('my-js')

<script type="text/javascript">
    function _logout() {
        $.ajax({
            type : "GET",
            url : '{{url('admin/service/admin/logout')}}',
            dataType: 'json',
            cache : false,
            success : function (data){
                if(data == null) {
                    layer.msg('server error', {icon:2, time:2000});
                    return;
                }
                if(data.status != 0) {
                    layer.msg(data.message, {icon:2, time:2000});
                    return;
                }

                layer.msg(data.message, {icon:1, time:2000});
                location.href = "{{url('admin')}}";// 成功后就跳到登录界面
            },
            error : function (xhr, status, error){
                console.log(xhr);
                console.log(status);
                console.log(error);
                layer.msg('ajax error', {icon:2, time:2000});
            }
        });
    }
    //edit category
    function admin_edit(title,url,w,h){
        layer_show(title,url,w,h);
    }
</script>
{{--分页显示--}}
<style>
    .pagination li {float: left; margin-left:10px;}
</style>
</body>
</html>
