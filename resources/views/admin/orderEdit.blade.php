@extends('layouts.master')
@section('title')
    <title>edit order</title>
@endsection
@section('headAndMenu')
@endsection
@section('content')
    <style>
        .red
    </style>
    <article class="cl pd-20">
        <form action="" method="post" class="form form-horizontal" id="form-order-edit">
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-5">Current Status：</label>
                <div class="formControls col-xs-8 col-sm-7" >
                    <span class="c-red">Unpaid</span>-><span class="{{$order->status == 0 ? 'c-red ':''}}">Paid</span>-><span class="{{ $order->delivery == 0 ? 'c-red ':''}}">Delivered</span> -><span class="{{$order->received == 0? 'c-red ':''}}">Received</span>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-5">Select Status：</label>
                <div class="formControls col-xs-8 col-sm-7">
                <span class="select-box">
      	            <select name="" class="select">
                        <option value="1" @if($order!=null && $order->status == 1 && $order->delivery == 1)
                        selected
                                @endif>Unpaid</option>
                        <option value="2" value="1" @if($order!=null && $order->status == 0 && $order->delivery == 1 )
                        selected
                                @endif>Paid</option>
                        <option value="3" {{$order != null && $order->status == 0 && $order->delivery == 0 && $order->received == 1? 'selected':''}}>delivered</option>
                        <option value="4" {{$order != null &&$order->status == 0 && $order->delivery == 0 && $order->received == 0? 'selected':''}}>received</option>
      	        </select>
             </span>
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
        $("#form-order-edit").validate({
            onkeyup:false,
            focusCleanup:true,
            success:"valid",
            submitHandler:function(form){
                var status = $('select option:selected').val();
                $("#form-order-edit").ajaxSubmit({
                    type: 'post', // 提交方式 get/post
                    url: "{{url('admin/service/order/update')}}", // 需要提交的 url
                    dataType: 'json',
                    data: {
                        'id' : '{{$order->id}}',
                        'status': status,
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
@endsection