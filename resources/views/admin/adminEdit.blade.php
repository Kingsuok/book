@extends('layouts.master')
@section('title')
   <title>edit admin</title>
@endsection
@section('headAndMenu')
@endsection
@section('content')
    <article class="cl pd-20">
        <form action="" method="post" class="form form-horizontal" id="form-admin-edit">
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>Name：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{session('admin')->name}}" placeholder="" id="adminName" name="adminName">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>old password：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="password" class="input-text" autocomplete="off" value="" placeholder="oldPassword" id="oldPassword" name="oldPassword">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>new password：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="password" class="input-text" autocomplete="off" value="" placeholder="newPassword" id="newPassword" name="newPassword">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>confirm password：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="password" class="input-text" autocomplete="off"  placeholder="confirmPassword" id="confirmPassword" name="confirmPassword">
                </div>
            </div>

            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;submit&nbsp;&nbsp;">
                </div>
            </div>
        </form>
    </article>
@endsection
@section('my-js')
    <script>
        // submit table
    $("#form-admin-edit").validate({
        rules:{
            adminName:{
                required:true,
            },
            oldPassword:{
                required:true,
                minlength:6,
                maxlength:16,
            },
            newPassword:{
                required:true,
                minlength:6,
                maxlength:16,
            },
            confirmPassword:{
                required:true,
                equalTo: "#newPassword",
            },

        },
        onkeyup:false,
        focusCleanup:true,
        success:"valid",
        submitHandler:function(form){
//            $(form).ajaxSubmit();
//            var index = parent.layer.getFrameIndex(window.name);
//            parent.$('.btn-refresh').click();
//            parent.layer.close(index);
            $('#form-admin-edit').ajaxSubmit({
                type: 'post', // 提交方式 get/post
                url: "{{url('admin/service/admin/edit')}}", // 需要提交的 url
                dataType: 'json',
                data: {
                    'adminName': $('input[name=adminName]').val(),
                    'oldPassword': $('input[name=oldPassword]').val(),
                    'newPassword': $('input[name=newPassword]').val(),
                    'confirmPassword': $('input[name=confirmPassword]').val(),
                    '_token':"{{csrf_token()}}",
                },
                success: function(data) {
                    if(data == null) {
                        layer.msg('server error', {icon:2, time:2000});
                        return;
                    }
                    if(data.status != 0) {
                        layer.msg(data.message, {icon:2, time:2000});
                        return;
                    }

                    layer.msg(data.message, {icon:1, time:2000});
                    parent.location.reload();// 成功后要将父窗口进行刷新
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    layer.msg('ajax error', {icon:2, time:2000});
                },
                beforeSend: function(xhr){
                    layer.load(0, {shade: false});
                }
            });
            return false;// return fasle 意思是表单自身不需要在操作submit了
        }
    });
</script>

@endsection