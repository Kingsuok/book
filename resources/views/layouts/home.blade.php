<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    {{--set the parameter to be for the mobile phone--}}
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <title>@yield('title')</title>
    <!--import the css 注意： 使用asset则是www.book.com/css/weui.css的路径，而在配置www.book.com时是在public目录下-->
    <link rel="stylesheet" href="{{asset('_home/css/weui.css')}}">
    <link rel="stylesheet" href="{{asset('_home/css/book.css')}}">
</head>
<body>
<div class="bk_title_bar">
    <img class='bk_back' src="{{url('_home/images/back.png')}}" alt="" onclick="history.go(-1);">
    <p class="bk_title_content"></p>
    <img class="bk_menu" src="{{url('_home/images/menu.png')}}" alt="" onclick="onMenuClick();">
</div>
<!--generally. weui's UI, the content needs to be in a div-->
<div class="page">
    @yield('content')
</div>

<!-- tooltips 弹出提示框 -->
<div class="bk_toptips"><span></span></div>

{{--<div id="global_menu" onclick="onMenuClick();">--}}
    {{--<div></div>--}}
{{--</div>--}}

<!--BEGIN actionSheet-->
<div id="actionSheet_wrap" style="display: none" >
    <div class="weui_mask_transition" id="mask"  ></div>
    <div class="weui_actionsheet" id="weui_actionsheet">
        <div class="weui_actionsheet_menu">
            <div class="weui_actionsheet_cell" onclick="onMenuItemClick(1)">home page</div>
            <div class="weui_actionsheet_cell" onclick="onMenuItemClick(2)">book category</div>
            <div class="weui_actionsheet_cell" onclick="onMenuItemClick(3)">shopping cart</div>
            <div class="weui_actionsheet_cell" onclick="onMenuItemClick(4)">my order</div>
            @if(session('member') != '')
                <div class="weui_actionsheet_cell" onclick="onMenuItemClick(5)">log out</div>
            @else
                <div class="weui_actionsheet_cell" onclick="onMenuItemClick(5)">log in</div>
            @endif
        </div>
        <div class="weui_actionsheet_action">
            <div class="weui_actionsheet_cell" id="actionsheet_cancel">cancle</div>
        </div>
    </div>
</div>

</body>
<script type="text/javascript" src="{{asset('/js/jquery-3.2.1.min.js')}}"></script>
<script type="text/javascript">
    function hideActionSheet(weuiActionsheet, mask) {
        weuiActionsheet.removeClass('weui_actionsheet_toggle');
        mask.removeClass('weui_fade_toggle');
        weuiActionsheet.on('transitionend', function () {
            mask.hide();
        }).on('webkitTransitionEnd', function () {
            mask.hide();
        })
    }
    function onMenuClick () {
        $('#actionSheet_wrap').show(); // show the actionSheet_wrap
        var mask = $('#mask');
        var weuiActionsheet = $('#weui_actionsheet');
        weuiActionsheet.addClass('weui_actionsheet_toggle');
        mask.show().addClass('weui_fade_toggle').click(function () {
            hideActionSheet(weuiActionsheet, mask);
        });
        $('#actionsheet_cancel').click(function () {
            hideActionSheet(weuiActionsheet, mask);
        });
        weuiActionsheet.unbind('transitionend').unbind('webkitTransitionEnd');
    }

    function onMenuItemClick(index) {
        var mask = $('#mask');
        var weuiActionsheet = $('#weui_actionsheet');
        hideActionSheet(weuiActionsheet, mask);
        if(index == 1) {
            $('.bk_toptips').show();
            $('.bk_toptips span').html("Welcome to Book Market!");
            setTimeout(function() {$('.bk_toptips').hide();}, 2000);
            location.href = '{{url('/')}}';
        } else if(index == 2) {
            location.href = '{{url('/category')}}';
        } else if(index == 3) {
            location.href = '{{url('/cart')}}';
        }else if(index == 4){
            location.href = '{{url('/orderList')}}';
        } else {
            if ('{{session('member')}}' != ''){
                $.ajax({
                    type: "get",
                    url: '{{url('service/logout')}}',
                    dataType: 'json',
                    cache: false,
                    data: { '_token': "{{csrf_token()}}"},
                    success: function(data) {
                        if(data == null) {
                            $('.bk_toptips').show();
                            $('.bk_toptips span').html('server error');
                            setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                            return;
                        }
                        if(data.status != 0) {
                            $('.bk_toptips').show();
                            $('.bk_toptips span').html(data.message);
                            setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                            return;
                        }

                        $('.bk_toptips').show();
                        $('.bk_toptips span').html('register successfully');
                        setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                        // jump to login web
                        location.href = "{{url('category')}}";
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr);
                        console.log(status);
                        console.log(error);
                    }
                });
            }else{
                location.href = '{{url('login')}}';
            }
        }
    }
    // set the title_content
    $('.bk_title_content').html(document.title);
    // show tip message
    function showTip(message){
        $('.bk_toptips').show();
        $('.bk_toptips span').html(message);
        setTimeout(function () {
            $('.bk_toptips').hide();
        }, 2000);
    }
</script>
<script type="text/javascript" src="https://js.stripe.com/v3/"></script>
@yield('my-js')
</html>