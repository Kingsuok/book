<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <!--[if lt IE 9]>
    <script type="text/javascript" src="{{asset('_admin/lib/html5shiv.js')}}"></script>
    <script type="text/javascript" src="{{asset('_admin/lib/respond.min.js')}}"></script>
    <![endif]-->
    <link href="{{asset('_admin/static/h-ui/css/H-ui.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('_admin/static/h-ui.admin/css/H-ui.login.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('_admin/static/h-ui.admin/css/style.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('_admin/lib/Hui-iconfont/1.0.8/iconfont.css')}}" rel="stylesheet" type="text/css" />
    <!--[if IE 6]>
    <script type="text/javascript" src="{{asset('_admin/lib/DD_belatedPNG_0.0.8a-min.js')}}" ></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <title>Management.admin v3.0</title>
    <meta name="keywords" content="book">
    <meta name="description" content="book">
</head>
<body>
<input type="hidden" id="TenantId" name="TenantId" value="" />
<div class="header"></div>
<div class="loginWraper">
    <div id="loginform" class="loginBox">
        <form class="form form-horizontal" action="" method="post" id="form-admin-login">
            {{csrf_field()}}
            <div class="row cl">
                <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60d;</i></label>
                <div class="formControls col-xs-8">
                    <input id="" name="account" type="text" placeholder="account" class="input-text size-L">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60e;</i></label>
                <div class="formControls col-xs-8">
                    <input id="" name="password" type="password" placeholder="password" class="input-text size-L">
                </div>
            </div>
            <div class="row cl">
                <div class="formControls col-xs-8 col-xs-offset-3">
                    <input class="input-text size-L" type="text" name="code" placeholder="code" onblur="if(this.value==''){this.value='code'}" onclick="if(this.value=='code'){this.value='';}" value="code" style="width:150px;">
                    <img src="{{url('service/validateCode/code')}}" id="validateCode">  </div>
            </div>
            {{--<div class="row cl">--}}
                {{--<div class="formControls col-xs-8 col-xs-offset-3">--}}
                    {{--<label for="online">--}}
                        {{--<input type="checkbox" name="online" id="online" value="">--}}
                        {{--keep login status</label>--}}
                {{--</div>--}}
            {{--</div>--}}
            <div class="row cl">
                <div class="formControls col-xs-8 col-xs-offset-3">
                    <input name="" type="submit" class="btn btn-success radius size-L" value="&nbsp;&nbsp; login &nbsp;&nbsp;">
                    <input name="" type="reset" class="btn btn-default radius size-L" value="&nbsp;cancel&nbsp;">
                </div>
            </div>
        </form>
    </div>
</div>
<div class="footer">Copyright book by xxx</div>
<script type="text/javascript" src="{{asset('_admin/lib/jquery/1.9.1/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('_admin/static/h-ui/js/H-ui.min.js')}}"></script>

<script type="text/javascript" src="{{asset('_admin/lib/jquery.validation/1.14.0/validate-methods.js')}}"></script>
<script type="text/javascript" src="{{asset('_admin/lib/jquery.validation/1.14.0/jquery.validate.js')}}"></script>
<script type="text/javascript" src="{{asset('_admin/lib/jquery.form.js')}}"></script>
<script type="text/javascript" src="{{asset('_admin/lib/layer/2.4/layer.js')}}"></script>
<script type="text/javascript">

    $('#validateCode').click(function () {
        $(this).attr('src', '{{url('/service/validateCode/code?random=')}}' + Math.random());
    });

    $("#form-admin-login").validate({
        rules:{
            account:{
                required:true,
            },
            password:{
                required:true,
                minlength:4,
                maxlength:16,
            },
            code:{
                required:true,
                minlength:4,
                maxlength:4,
            },
        },
        onkeyup:false,
        focusCleanup:true,
        success:"valid",
        submitHandler:function(form){
            var account = ($('input[name=account]').val()).trim();
            var password =  ($('input[name=password]').val()).trim();
            var code =  ($('input[name=code]').val()).trim();
            $('#form-admin-login').ajaxSubmit({
                type: 'post', // 提交方式 get/post
                url: "{{url('admin/service/login')}}", // 需要提交的 url
                dataType: 'json',
                data:{
                    '_token': '{{csrf_token()}}',
                    'account':account,
                    'password':password,
                    'code':code
                },
                success: function(data) {
                    console.log(data);
                    if(data == null) {
                        layer.msg('server error', {icon:2, time:2000});
                        return;
                    }
                    if(data.status != 0) {
                        layer.msg(data.message, {icon:2, time:2000});
                        return;
                    }

                    layer.msg(data.message, {icon:1, time:2000});
                    location.href = "{{url('admin/index')}}";// 成功后就跳到index
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    layer.msg('ajax error', {icon:2, time:2000});
                },
//                beforeSend: function(xhr){
//                    layer.load(0, {shade: false});
//                }
            });
            return false;// return fasle 意思是表单自身不需要在操作submit了
        }
    });

</script>
</body>
</html>