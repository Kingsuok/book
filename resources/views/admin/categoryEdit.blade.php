@extends('layouts.master')
@section('title')
   <title>edit category</title>
@endsection
@section('headAndMenu')
@endsection
@section('content')
    <article class="cl pd-20">
        <form action="" method="post" class="form form-horizontal" id="form-category-edit">
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>Name：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text"  value="{{$category->category_name}}" placeholder="" id="categoryName" name="categoryName">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>No：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="number" class="input-text" value="{{$category->category_no}}" placeholder="" id="categoryNo" name="categoryNo">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">Parent Name：</label>
                <div class="formControls col-xs-8 col-sm-9"> <span class="select-box" style="width:150px;">
				<select class="select" name="parentId" size="1">
					<option value="0" {{$category->parent_id == 0 ? "selected" :''}}}></option>
                    @foreach($parents as $parent)
                        @if($category->category_name != $parent->category_name)
                            <option value="{{$parent->id}}" {{$category->parent_id == $parent->id ? "selected" :''}}>{{$parent->category_name}}</option>
                        @endif
                    @endforeach
				</select>
				</span> </div>
            </div>
            <div class="row cl">
                <label class="form-label  col-xs-4 col-sm-3">preview：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <img id="preview_id" src="{{url($category->preview)}}" style="border: 1px solid #B8B9B9; width: 100px; height: 100px;" onclick="$('#input_id').click()" />
                    <input type="file" name="image" id="input_id" style="display: none;" onchange="return uploadFileToServer('input_id', 'preview_id','{{url('service/upload/images')}}');" />
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
        $("#form-category-edit").validate({
            rules:{
                categoryName:{
                    required:true,
                },
                categoryNo:{
                    required:true,
                },
                parentId:{
                    required:true,
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
                $("#form-category-edit").ajaxSubmit({
                    type: 'post', // 提交方式 get/post
                    url: "{{url('admin/service/category/update')}}", // 需要提交的 url
                    dataType: 'json',
                    data: {
                        'id' : '{{$category->id}}',
                        'name': $('input[name=categoryName]').val(),
                        'category_no': $('input[name=categoryNo]').val(),
                        'parent_id': $('select[name=parentName] option:selected').val(),
                        'preview': ($('#preview_id').attr('src') != '{{url('_admin/static/h-ui.admin/images/icon-add.png')}}'? $('#preview_id').attr('src'): ''),
                        '_token': "{{csrf_token()}}"
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
    <script type="text/javascript" src="{{asset('_admin/lib/ajaxFileUpload.js')}}"></script>

    <script>
        // upload file to server
        function uploadFileToServer(fileInputId,imgId, url )
        {
            $.ajaxFileUpload
            (
                {
                    url: url, //用于文件上传的服务器端请求地址
                    secureuri: false, //是否需要安全协议，一般设置为false
                    fileElementId: fileInputId, //文件上传域的ID
                    dataType: 'json', //返回值类型 一般设置为json
                    data: {'_token':'{{csrf_token()}}'},
                    success: function (data, status)  //服务器成功响应处理函数
                    {
                        if (data.status != 0){
                            layer.msg(data.message, {icon:2, time:2000});
                            return;
                        }
                        $("#"+ imgId).attr('src','{{url('')}}'+ data.result);
                        layer.msg(data.message, {icon:1, time:1000});
                    },
                    error: function (data, status, e)//服务器响应失败处理函数
                    {   console.log(data);
                        alert(data);
                    }
                }
            );
            return false;
        }
    </script>
@endsection