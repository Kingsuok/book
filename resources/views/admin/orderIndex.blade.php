@extends('layouts.master')
@section('title')
   <title>order list</title>
@endsection
@section('headAndMenu')
    @parent
@endsection
@section('content')
    <section class="Hui-article-box">
        <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> Home <span class="c-gray en">&gt;</span> Order <span class="c-gray en">&gt;</span> Order List <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="refresh" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
        <div class="Hui-article">
            <div >
                <div class="pd-20">
                    <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> Batch Delete</a></span> <span class="r">Total：<strong>{{$orders->count()}}</strong></span> </div>
                    <div class="mt-20">
                        <table class="table table-border table-bordered table-bg table-hover table-sort">
                            <thead>
                            <tr class="text-c">
                                <th width="10"><input name="" type="checkbox" value=""></th>
                                <th width="20">ID</th>
                                <th width="40">Name</th>
                                <th width="50">No</th>
                                <th width="30">Price</th>
                                <th width="40">Method</th>
                                <th width="25">Status</th>
                                <th width="25">Created</th>
                                <th width="25">Updated</th>
                                <th width="35">Receiver</th>
                                <th width="30">Phone</th>
                                <th width="60">Address</th>
                                <th width="40">Delivery</th>
                                <th width="40">Received</th>
                                <th width="60">Operation</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                            <tr class="text-c va-m">
                                <td><input name="" type="checkbox" value=""></td>
                                <td>{{$order->id}}</td>
                                <td>{{$order->name}}</td>
                                <td>{{$order->order_no}}</td>
                                <td>{{$order->total_price}}</td>
                                <td>{{$order->pay_method == 1? 'credit card':''}}</td>
                                <td><span class="label {{$order->status == 0? 'label-success' : 'label-fail'}} radius">{{$order->status == 1? 'unpaid':'paid'}}</span></td>
                                <td>{{$order->created_at}}</td>
                                <td>{{$order->updated_at}}</td>
                                <td>{{$order->delivery_receiver}}</td>
                                <td>{{$order->delivery_phone}}</td>
                                <td>{{$order->delivery_address}}</td>
                                <td><span class="label {{$order->delivery == 0? 'label-success' : 'label-fail'}} radius">{{$order->delivery == 1? 'No':'Yes'}}</span></td>
                                <td><span class="label {{$order->received == 0? 'label-success' : 'label-fail'}} radius">{{$order->received == 1? 'No':'Yes'}}</span></td>
                                <td class="td-manage"><a title="orderItems" href="javascript:;"
                                                         onclick="order_detail('order items','{{url('admin/order/'.$order->id)}}')"
                                                         class="ml-5" style="text-decoration:none"><i
                                                class="Hui-iconfont">&#xe695;</i></a><a style="text-decoration:none" class="ml-5" onClick="order_edit('edit order','{{url('admin/order/'.$order->id.'/edit')}}','650','450')" href="javascript:;" title="edit"><i class="Hui-iconfont">&#xe6df;</i></a> <a style="text-decoration:none" class="ml-5" onClick="order_del('ID: {{$order->id}}','{{$order->id}}')" href="javascript:;" title="delete"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div style="float: right" >{!! $orders->links() !!}</div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
@section('my-js')
<script>

    // delete order
    function order_del(title,id){
        layer.confirm('delete " '+ title + ' "？',{
            btn: ['Yes','No'] //按钮
        },function(index){
            //此处请求后台程序，下方是成功后的前台处理……
            $.ajax({
                type : 'post',
                url : "{{url('admin/service/order/delete')}}",
                dataType : 'json',
                data : {'_token': '{{csrf_token()}}','id':id},
                success : function(data){
                    if(data == null) {
                        layer.msg('server error', {icon:2, time:2000});
                        return;
                    }
                    if(data.status != 0) {
                        layer.msg(data.message, {icon:2, time:2000});
                        return;
                    }

                    layer.msg(data.message, {icon:1, time:2000});
                    location.replace(location.href);// 成功后要将自己的窗口进行刷新
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
        });
    }

    //edit order
    function order_edit(title,url,w,h){
        layer_show(title,url,w,h);
    }
    // order items
    function order_detail(title,url,w,h){
        layer_show(title,url,w,h);
    }
</script>
@endsection