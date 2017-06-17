@extends('layouts.home')

@section('title',$product->product_name)

@section('content')
    <!--swipe-->
    <link rel="stylesheet" href="{{asset('_home/css/swipe.css')}}">
    <div class="page" style="top: 0">
        {{--swiper--}}
        <div class="addWrap">
            <div class="swipe" id="mySwipe">
                <div class="swipe-wrap">
                    @foreach($pdtImages as $pdtImage)
                        <div>
                            <a href="{{url('category')}}"><img style="width: 180px; height:220px ;" class="img-responsive" name="img-responsive"
                                                        src="{{$pdtImage->image_path}}"></a>
                        </div>
                    @endforeach
                </div>
            </div>
            <ul id="position">
                @foreach($pdtImages as $index =>$pdtImage)
                    <li class="{{$index == 0 ? 'cur':''}}"></li>
                @endforeach
            </ul>
        </div>

        <div class="weui_cells_title">
            <span class="bk_title">{{$product->product_name}}</span>
            <span class="bk_price" style="float: right">$ {{$product->price}}</span>
        </div>
        <div class="weui_cells">
            <div class="weui_cell">
                <p class="bk_summary">{{$product->summary}}</p>
            </div>
        </div>

        <div class="weui_cells_title">Detail</div>
        <div class="weui_cells">
            <div class="bk_content" style="margin-right: 10px; margin-left: 10px;">
                {!! $pdtContent != null ? $pdtContent->content : ''!!}
            </div>
        </div>
    </div>
    <!--shopping cart-->
    <div class="bk_fix_bottom">
        <div class="bk_half_area">
            <button class="weui_btn weui_btn_primary" onclick="addCart();">add to cart</button>
        </div>
        <div class="bk_half_area">
            <button class="weui_btn weui_btn_default" onclick="toCart()">check cart (<span id="cart_num" class="m3_price">{{$count != null? $count : 0}}</span>)</button>
        </div>
    </div>
@endsection

@section('my-js')
<script type="text/javascript" src="{{asset('_home/js/swipe.js')}}"></script>
<script type="text/javascript">
    //上文中<ul id="position">DOM中Element对象，表示HTML元素。
    var bullets = document.getElementById('position').getElementsByTagName('li');
    var banner = Swipe(document.getElementById('mySwipe'), {
        //开始自动幻灯片(以毫秒为单位 幻灯片之间的时间)
        auto: 2000,
        //continuous Boolean(default:true)创建一个无线的循环(当滑动到所有动画结束时是否循环滑动)
        continuous: true,
        //disableScroll Boolean(default:false) 当滚动滚动条时 是否停止幻灯片滚动
        disableScroll:true,
        //幻灯片运行中的回调函数
        callback: function(pos) {
            var i = bullets.length;
            while (i--) {
                bullets[i].className = ' ';
            }
            bullets[pos].className = 'cur';
        }
    });
</script>
    <script type="text/javascript">
        // add to cart
        var flag = true;// 控制点击频率的标志位
        function addCart() {
            if (flag == true){// flage 为true时，可以点击
                flag = false;//点击后，把falg置false
                var pdtId = '{{$product->id}}';
                $.ajax({
                    type : "GET",
                    url : '{{url('service/cart/add')}}'+'/'+ pdtId,
                    dataType: 'json',
                    cache : false,
                    success : function (aData){
                        if(aData == null) {
                            $('.bk_toptips').show();
                            $('.bk_toptips span').html('server error');
                            setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                            return;
                        }
                        if(aData.status != 0) {
                            $('.bk_toptips').show();
                            $('.bk_toptips span').html(aData.message);
                            setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                            return;
                        }

                        $('.bk_toptips').show();
                        $('.bk_toptips span').html(aData.message);
                        setTimeout(function() {$('.bk_toptips').hide();}, 2000);

                        // update cart number
                        var count = Number($('#cart_num').html()) + 1;
                        $('#cart_num').html(count);

                    },
                    error : function (xhr, status, error){
                        console.log(xhr);
                        console.log(status);
                        console.log(error);
                    }
                });
                setTimeout('flag = true',500);// 0.5s后，把falg置为true
            }

        }
        // jump to cart 当然也可以用 a标签的href，这样就不用click事件了
        function toCart() {

            location.href = '{{url('cart')}}';
        }
    </script>
@endsection