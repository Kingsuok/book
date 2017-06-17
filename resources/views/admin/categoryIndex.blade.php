@extends('layouts.master')
@section('title')
   <title>category</title>
@endsection
@section('headAndMenu')
    @parent
@endsection
@section('content')
    <section class="Hui-article-box">
        <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> Home <span class="c-gray en">&gt;</span> Product <span class="c-gray en">&gt;</span> Category <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="refresh" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
        <div class="Hui-article">
            <div >
                <div class="pd-20">
                    <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> Batch Delete</a> <a class="btn btn-primary radius" onclick="category_add('add category','{{url('admin/category/create')}}','500','450')" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> Add Category</a></span> <span class="r">Total：<strong>{{$categorys->total()}}</strong></span> </div>
                    <div class="mt-20">
                        <table class="table table-border table-bordered table-bg table-hover table-sort">
                            <thead>
                            <tr class="text-c">
                                <th width="40"><input name="" type="checkbox" value=""></th>
                                <th width="40">ID</th>
                                <th width="80">Name</th>
                                <th width="40">No</th>
                                <th width="80">Parent Name</th>
                                <th width="80">Preview</th>
                                <th width="100">Operation</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categorys as $category)
                            <tr class="text-c va-m">
                                <td><input name="" type="checkbox" value=""></td>
                                <td>{{$category->id}}</td>
                                <td>{{$category->category_name}}</td>
                                <td>{{$category->category_no}}</td>
                                <td>{{$category->parent_id != 0 ? $parentsArray[$category->parent_id]: ''}}</td>
                                <td>
                                    @if($category->preview != '')
                                        <img src="{{url($category->preview)}}" style="width: 50px; height: 50px;">
                                    @endif
                                </td>
                                <td class="td-manage"><a style="text-decoration:none" class="ml-5" onClick="category_edit('edit category','{{url('admin/category/'.$category->id.'/edit')}}','500','450')" href="javascript:;" title="edit"><i class="Hui-iconfont">&#xe6df;</i></a> <a style="text-decoration:none" class="ml-5" onClick="category_del('{{$category->category_name}}','{{$category->id}}')" href="javascript:;" title="delete"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div style="float: right" >{!! $categorys->links() !!}</div>

                    </div>
                </div>
            </div>

        </div>

    </section>

@endsection
@section('my-js')
<script>
    //add category
    function category_add(title,url,w,h){
        layer_show(title,url,w,h);
    }
    // delete category
    function category_del(title,id){
        layer.confirm('delete " '+ title + ' "？',{
            btn: ['Yes','No'] //按钮
        },function(index){
            //此处请求后台程序，下方是成功后的前台处理……
            $.ajax({
                type : 'post',
                url : "{{url('admin/service/category/delete')}}",
                dataType : 'json',
                data : {'_token': '{{csrf_token()}}','id':id,'parentId':'{{$category->parent_id}}'},
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

    //edit category
    function category_edit(title,url,w,h){
        layer_show(title,url,w,h);
    }

</script>
@endsection