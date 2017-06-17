<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Book Market</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="description" content="Book Market">
    <link rel="stylesheet" href="{{asset('_home/mobile/lib/weui.min.css')}}">
    <link rel="stylesheet" href="{{asset('_home/mobile/css/jquery-weui.css')}}">
    <link rel="stylesheet" href="{{asset('_home/mobile/css/style.css')}}">
</head>
<body ontouchstart>

<!--主体-->
<div class='weui-content'>
    <!--顶部轮播-->
    <div class="swiper-container swiper-banner">
        <div class="swiper-wrapper">
            @foreach($hots as $hot)
                <div class="swiper-slide"><a href="{{url('/product/pdtId/'.$hot->id)}}" ><img  src="{{$hot->preview}}" /></a></div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
    </div>

    <div class="wy-Module">
        <div class="wy-Module-tit"><span>New</span></div>
        <div class="wy-Module-con">
            <div class="swiper-container swiper-news" style="padding-top:34px;">
                <div class="swiper-wrapper">
                    @foreach($news as $new)
                    <div class="swiper-slide"><a href="{{url('/product/pdtId/'.$new->id)}}"><img  src="{{$new->preview}}"></a></div>
                    @endforeach
                </div>
                <div class="swiper-pagination jingxuan-pagination"></div>
            </div>
        </div>
    </div>

</div>

<!--底部导航-->
<div class="foot-black"></div>
<div class="weui-tabbar wy-foot-menu">
    <a href="{{url('/')}}" class="weui-tabbar__item weui-bar__item--on">
        <div class="weui-tabbar__icon foot-menu-home"></div>
        <p class="weui-tabbar__label">Home</p>
    </a>
    <a href="{{url('/category')}}" class="weui-tabbar__item">
        <div class="weui-tabbar__icon foot-menu-list"></div>
        <p class="weui-tabbar__label">Category</p>
    </a>
    <a href="{{url('/cart')}}" class="weui-tabbar__item">
        <span class="weui-badge" style="position: absolute;top: -.4em;right: 1em;">{{$cartCount}}</span>
        <div class="weui-tabbar__icon foot-menu-cart"></div>
        <p class="weui-tabbar__label">Cart</p>
    </a>
    <a href="{{url('/login')}}" class="weui-tabbar__item">
        <div class="weui-tabbar__icon foot-menu-member"></div>
        <p class="weui-tabbar__label">Me</p>
    </a>
</div>

<script type="text/javascript" src="{{asset('_home/mobile/lib/jquery-2.1.4.js')}}"></script>
<script type="text/javascript" src="{{asset('_home/mobile/lib/fastclick.js')}}"></script>
<script type="text/javascript">
    $(function() {
        FastClick.attach(document.body);
    });
</script>
<script type="text/javascript" src="{{asset('_home/mobile/js/jquery-weui.js')}}"></script>
<script type="text/javascript" src="{{asset('_home/mobile/js/swiper.js')}}"></script>
<script type="text/javascript">
    $(".swiper-banner").swiper({
        loop: true,
        tap: true,
        autoplay: 3000
    });
    $(".swiper-news").swiper({
        pagination: '.swiper-pagination',
        loop: true,
        paginationType:'fraction',
        slidesPerView:3,
        paginationClickable: true,
        spaceBetween: 2
    });

</script>

</body>
</html>
