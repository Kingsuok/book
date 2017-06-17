@extends('layouts.master')
@section('title')
   <title>member list</title>
@endsection
@section('headAndMenu')
    @parent
@endsection
@section('content')
    <section class="Hui-article-box">
        <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> Home <span class="c-gray en">&gt;</span> Member <span class="c-gray en">&gt;</span> member list<a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="refresh" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
        <div class="Hui-article">
            <article class="cl pd-20">
                <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i>Batch Delete</a> </span> <span class="r">Total：<strong>{{$members->count()}}</strong> </span> </div>
                <div class="mt-20">
                    <table class="table table-border table-bordered table-hover table-bg table-sort">
                        <thead>
                        <tr class="text-c">
                            <th width="25"><input type="checkbox" name="" value=""></th>
                            <th width="80">ID</th>
                            <th width="100">Name</th>

                            <th width="90">Phone</th>
                            <th width="150">Email</th>

                            <th width="130">Birthday</th>
                            <th width="70">Status</th>
                            <th width="100">Operation</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($members as $member)
                        <tr class="text-c">
                            <td><input type="checkbox" value="1" name=""></td>
                            <td>{{$member->id}}</td>
                            <td><u style="cursor:pointer" class="text-primary" onclick="member_show('{{$member->nickname}}','member-show.html','10001','360','400')">{{$member->nickname}}</u></td>
                            <td>{{$member->phone}}</td>
                            <td>{{$member->email}}</td>

                            <td>{{$member->created_at}}</td>
                            <td class="td-status"><span class="label {{$member->email_active == 1? 'label-success' : 'label-fail'}} radius">{{$member->email_active == 1? 'active' : 'inactive'}}</span></td>
                            <td class="td-manage"><a title="delete" href="javascript:;" onclick="member_del('ID: {{$member->id}}','{{$member->id}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
                        </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div style="float: right" >{!! $members->links() !!}</div>
                </div>
            </article>
        </div>
    </section>
@endsection
@section('my-js')
<script>
//    //add member
//    function member_add(title,url,w,h){
//        layer_show(title,url,w,h);
//    }
    // delete member
    function member_del(title,id){
        layer.confirm('delete " '+ title + ' "？',{
            btn: ['Yes','No'] //按钮
        },function(index){
            //此处请求后台程序，下方是成功后的前台处理……
            $.ajax({
                type : 'post',
                url : "{{url('admin/service/member/delete')}}",
                dataType : 'json',
                data : {'_token': '{{csrf_token()}}','id':id},
                success : function(data){
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

//    //edit member
//    function member_edit(title,url,w,h){
//        layer_show(title,url,w,h);
//    }

</script>
@endsection