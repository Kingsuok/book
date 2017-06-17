@extends('layouts.master')
@section('title')
    <title>index</title>
@endsection
@section('headAndMenu')
    @parent
@endsection
@section('content')
    <section class="Hui-article-box">
        <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> Home <span class="c-gray en">&gt;</span> Product
            <span class="c-gray en">&gt;</span> Book <a class="btn btn-success radius r"
                                                            style="line-height:1.6em;margin-top:3px"
                                                            href="javascript:location.replace(location.href);"
                                                            title="refresh"><i class="Hui-iconfont">&#xe68f;</i></a>
        </nav>
        <div class="Hui-article">
            <div>
                <div class="pd-20">
                    <div class="cl pd-5 bg-1 bk-gray mt-20">
  		<span class="l">
  			<a href="javascript:;" onclick="product_add('add product','{{url('/admin/product/create')}}','800','600')"
               class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> add product</a>
  		</span>
                        <span class="r">Total：<strong>{{$products->count()}}</strong></span>
                    </div>
                    <div class="mt-20">
                        <table class="table table-border table-bordered table-hover table-bg table-sort">
                            <thead>
                            <tr class="text-c">
                                <th width="40">ID</th>
                                <th width="100">Name</th>
                                <th width="40">Brief</th>
                                <th width="90">Price</th>
                                <th width="90">Category</th>
                                <th width="50">Preview</th>
                                <th width="20">new</th>
                                <th width="20">hot</th>
                                <th width="100">Options</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $product)
                                <tr class="text-c">
                                    <td>{{$product->id}}</td>
                                    <td>{{$product->product_name}}</td>
                                    <td>{{$product->summary}}</td>
                                    <td>{{$product->price}}</td>
                                    <td>{{$product->category->category_name}}</td>
                                    <td>@if($product->preview != '')
                                            <img src="{{url($product->preview)}}" alt=""
                                                 style="width: 40px; height: 50px;">
                                        @endif</td>
                                    <td>{{$product->new}}</td>
                                    <td>{{$product->hot}}</td>
                                    <td class="td-manage">
                                        <a title="detail" href="javascript:;"
                                           onclick="product_detail('product detail','{{url('admin/product/'.$product->id)}}')"
                                           class="ml-5" style="text-decoration:none"><i
                                                    class="Hui-iconfont">&#xe695;</i></a>
                                        <a title="edit" href="javascript:;"
                                           onclick="product_edit('edit product','{{url('/admin/product/'.$product->id.'/edit')}}')"
                                           class="ml-5" style="text-decoration:none"><i
                                                    class="Hui-iconfont">&#xe6df;</i></a>
                                        <a title="delete" href="javascript:;"
                                           onclick='product_del("{{$product->product_name}}", "{{$product->id}}")'
                                           class="ml-5" style="text-decoration:none"><i
                                                    class="Hui-iconfont">&#xe6e2;</i></a>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                        <div style="float: right" >{!! $products->links() !!}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
    @section('my-js')
        <!--请在下方写此页面业务相关的脚本-->
        <script type="text/javascript">
            //add product
            function product_add(title,url,w,h){
                layer_show(title,url,w,h);
            }
            // delete product
            function product_del(title,id){
                layer.confirm('delete [ '+ title + ' ]？',{
                    btn: ['Yes','No'] //按钮
                },function(index){
                    //此处请求后台程序，下方是成功后的前台处理……
                    $.ajax({
                        type : 'post',
                        url : "{{url('admin/service/product/delete')}}",
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

            //edit product
            function product_edit(title,url,w,h){
                layer_show(title,url,w,h);
            }
           // product detail
            function product_detail(title,url,w,h){
                layer_show(title,url,w,h);
            }
        </script>
        <!--/请在上方写此页面业务相关的脚本-->
    @endsection

