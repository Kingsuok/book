@extends('layouts.master')
@section('title')
   <title>add product</title>
@endsection
@section('headAndMenu')
@endsection
@section('content')
    <article class="cl pd-20">
        <form action="" method="post" class="form form-horizontal" id="form-product-add">
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>Name：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{$product->product_name}}" placeholder="" name="name" datatype="*"
                           nullmsg="name should not be empty">
                </div>
                <div class="col-4"></div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>Brief：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{$product->summary}}" placeholder="" name="brief" datatype="*"
                           nullmsg="brief should not be empty">
                </div>
                <div class="col-4"></div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>Price：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="number" class="input-text" value="{{$product->price}}" placeholder="" name="price" datatype="*"
                           nullmsg="price should not be empty">
                </div>
                <div class="col-4"></div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>Category：</label>
                <div class="formControls col-xs-8 col-sm-9"> <span class="select-box" style="width:150px;">
      <select class="select" name="category_id" size="1">
        @foreach($categorys as $category)
              <option value="{{$category->id}}" {{$product->category_id == $category->id? 'selected':''}}>{{$category->category_name}}</option>
          @endforeach
      </select>
      </span>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">New：</label>
                <div class="formControls col-xs-8 col-sm-9"> <span class="select-box" style="width:150px;">
                    <select class="select" name="new" size="1">
                        @for($i = 0; $i < 5; ++$i)
                    <option value="{{$i}}" {{$product->new == $i? 'selected': ''}}>{{$i}}</option>
                            @endfor
                    </select>
                    </span> </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">Hot：</label>
                <div class="formControls col-xs-8 col-sm-9"> <span class="select-box" style="width:150px;">
                    <select class="select" name="hot" size="1">
                        @for($i = 0; $i < 5; ++$i)
                            <option value="{{$i}}" {{$product->hot == $i? 'selected': ''}}>{{$i}}</option>
                        @endfor
                    </select>
                    </select>
                    </span> </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">Preview：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <img id="preview_id" src="{{$product->preview != ''? url($product->preview) : url('_admin/static/h-ui.admin/images/icon-add.png')}}"
                         style="border: 1px solid #B8B9B9; width: 80px; height: 80px;"
                         onclick="$('#input_id').click()"/>
                    <input type="file" name="image" id="input_id" style="display: none;"
                           onchange="return uploadFileToServer('input_id', 'preview_id','{{url('service/upload/images')}}');"/>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">Detail：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <script type="text/plain" id="myEditor" style="width:500px;height:240px;">
                        <p>{!! $product->content->content !!}</p>
                    </script>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">Images：</label>
                <img id="preview_id1" src="{{isset($product->images[0]) == true ? $product->images[0]['image_path']: url('_admin/static/h-ui.admin/images/icon-add.png')}}" style="border: 1px solid #B8B9B9; width: 80px; height: 80px;" onclick="$('#input_id1').click()" />
                <input type="file" name="image" id="input_id1" style="display: none;" onchange="return uploadFileToServer('input_id1','preview_id1', '{{url('service/upload/images')}}');" />
                <img id="preview_id2" src="{{isset($product->images[1]) == true ? $product->images[1]['image_path']: url('_admin/static/h-ui.admin/images/icon-add.png')}}" style="border: 1px solid #B8B9B9; width: 80px; height: 80px;" onclick="$('#input_id2').click()" />
                <input type="file" name="image" id="input_id2" style="display: none;" onchange="return uploadFileToServer('input_id2','preview_id2', '{{url('service/upload/images')}}');" />
                <img id="preview_id3" src="{{isset($product->images[2]) == true ? $product->images[2]['image_path']: url('_admin/static/h-ui.admin/images/icon-add.png')}}" style="border: 1px solid #B8B9B9; width: 80px; height: 80px;" onclick="$('#input_id3').click()" />
                <input type="file" name="image" id="input_id3" style="display: none;" onchange="return uploadFileToServer('input_id3','preview_id3', '{{url('service/upload/images')}}');" />
                <img id="preview_id4" src="{{isset($product->images[3]) == true ? $product->images[3]['image_path']: url('_admin/static/h-ui.admin/images/icon-add.png')}}" style="border: 1px solid #B8B9B9; width: 80px; height: 80px;" onclick="$('#input_id4').click()" />
                <input type="file" name="image" id="input_id4" style="display: none;" onchange="return uploadFileToServer('input_id4','preview_id4', '{{url('service/upload/images')}}');" />
                <img id="preview_id5" src="{{isset($product->images[4]) == true ? $product->images[4]['image_path']: url('_admin/static/h-ui.admin/images/icon-add.png')}}" style="border: 1px solid #B8B9B9; width: 80px; height: 80px;" onclick="$('#input_id5').click()" />
                <input type="file" name="image" id="input_id5" style="display: none;" onchange="return uploadFileToServer('input_id5','preview_id5', '{{url('service/upload/images')}}');" />
                    </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input style="margin: 20px 0; width: 200px;" class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;submit&nbsp;&nbsp;">
                </div>
            </div>
        </form>
    </article>
@endsection
@section('my-js')
    <link href="{{asset('js/umeditor1.2.3-utf8-php/themes/default/css/umeditor.css')}}" type="text/css" rel="stylesheet">
    {{--<script type="text/javascript" src="{{asset('js/umeditor1.2.3-utf8-php/third-party/jquery.min.js')}}"></script>--}}
    <script type="text/javascript" src="{{asset('js/umeditor1.2.3-utf8-php/third-party/template.min.js')}}"></script>
    <script type="text/javascript" charset="utf-8" src="{{asset('js/umeditor1.2.3-utf8-php/umeditor.config.js')}}"></script>
    <script type="text/javascript" charset="utf-8" src="{{asset('js/umeditor1.2.3-utf8-php/umeditor.min.js')}}"></script>
    <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
    <script type="text/javascript" charset="utf-8" src="{{asset('js/umeditor1.2.3-utf8-php/lang/en/en.js')}}"></script>
    <script>
        // initialize UEditor
        var um = UM.getEditor('myEditor');
        // submit table
        $("#form-product-add").validate({
            rules:{
                name:{
                    required:true,
                },
                brief:{
                    required:true,
                },
                price:{
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
                $('#form-product-add').ajaxSubmit({
                    type: 'post', // 提交方式 get/post
                    url: "{{url('admin/service/product/update')}}", // 需要提交的 url
                    dataType: 'json',
                    data: {
                        'id' : '{{$product->id}}',
                        'name': $('input[name=name]').val(),
                        'brief': $('input[name=brief]').val(),
                        'price': $('input[name=price]').val(),
                        'categoryId': $('select[name=category_id] option:selected').val(),
                        'hot': $('select[name=hot] option:selected').val(),
                        'new': $('select[name=new] option:selected').val(),
                        'preview': ($('#preview_id').attr('src') != '{{url('_admin/static/h-ui.admin/images/icon-add.png')}}'? $('#preview_id').attr('src'): ''),
                        'content': um.getContent(),
                        'image1': ($('#preview_id1').attr('src') != '{{url('_admin/static/h-ui.admin/images/icon-add.png')}}'? $('#preview_id1').attr('src'): ''),
                        'image2': ($('#preview_id2').attr('src') != '{{url('_admin/static/h-ui.admin/images/icon-add.png')}}'? $('#preview_id2').attr('src'): ''),
                        'image3': ($('#preview_id3').attr('src') != '{{url('_admin/static/h-ui.admin/images/icon-add.png')}}'? $('#preview_id3').attr('src'): ''),
                        'image4': ($('#preview_id4').attr('src') != '{{url('_admin/static/h-ui.admin/images/icon-add.png')}}'? $('#preview_id4').attr('src'): ''),
                        'image5': ($('#preview_id5').attr('src') != '{{url('_admin/static/h-ui.admin/images/icon-add.png')}}'? $('#preview_id5').attr('src'): ''),
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