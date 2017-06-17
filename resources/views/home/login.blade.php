@extends('layouts.home')

{{--@section('title')--}}
    {{--login--}}
{{--@endsection--}}
@section('title','login') {{--the codes are same to the front codes --}}
@section('content')
<div class="weui_cells_title"></div>
<div class="weui_cells weui_cells_form">
    <div class="weui_cell">
        <div class="weui_cell_hd"><label class="weui_label">Account:</label></div>
        <div class="weui_cell_bd weui_cell_primary">
            <input class="weui_input" type="text" placeholder="email or phone" name="account"/>
        </div>
    </div>
    <div class="weui_cell">
        <div class="weui_cell_hd"><label class="weui_label">Password:</label></div>
        <div class="weui_cell_bd weui_cell_primary">
            <input class="weui_input" type="password" placeholder="no less than 6 digits" name="password"/>
        </div>
    </div>
    <div class="weui_cell weui_vcode">
        <div class="weui_cell_hd"><label class="weui_label">Code:</label></div>
        <div class="weui_cell_bd weui_cell_primary">
            <input class="weui_input" type="text" placeholder="please input the code" name="code" maxlength="4"/>
        </div>
        <div class="weui_cell_ft">
            <img src="{{url("service/validateCode/code")}}"  class="bk_validate_code"/>
        </div>
    </div>
</div>
<div class="weui_cells_tips"></div>
<div class="weui_btn_area">
    <a class="weui_btn weui_btn_primary" href="javascript:" onclick="onLoginClick();">Login</a>
</div>
<a href="/register" class="bk_bottom_tips bk_important">No account? Sign up</a>
@endsection

@section('my-js')
    <script type="text/javascript">
        $('.bk_validate_code').click(function () {
            $(this).attr('src', '{{url('/service/validateCode/code?random=')}}' + Math.random());
        });
    </script>
    <script>
        function onLoginClick(event){
            var account = ($('input[name=account]').val()).trim();
            var password =  ($('input[name=password]').val()).trim();
            var code =  ($('input[name=code]').val()).trim();

            if (verifyInput(account, password, code) == false){
                return;
            }
            $.post("{{url('service/login')}}",
                {'_token': '{{csrf_token()}}','account':account,'password':password,'code':code},
                function (aData){
                    if(aData == null){
                        showTip('Server error!');
                        return;
                    }
                    if (aData.status != 0){
                        showTip(aData.message);
                        return;
                    }
                    showTip(aData.message);
                    if('{{$returnURL}}' == ''){//若为空，说明不是从购物车点击pay now跳过来的登陆
                        location.href = "{{url('category')}}";
                    }else{// 若不为空，说明是从购物车点击pay now 跳过来的登陆
                        location.href = "{{$returnURL}}";
                    }

                },
                'json'
            );
        }
        //check input
        function verifyInput(account, password, code){
            if (account == ''){
                var message = 'Account should not be empty!';
                showTip(message);
                return false;
            }
            if (account.indexOf('@') == -1){
                if (account.length != 10){
                    var message = 'Phone is wrong!';
                    showTip(message);
                    return false;
                }
            }else{
                if (account.indexOf('.') == -1){
                    var message = 'Email is wrong!';
                    showTip(message);
                    return false;
                }
            }
            if (password.length < 6){
                var message = 'Password should not be less 6 digits! ';
                showTip(message);
                return false;
            }
            if (code.length != 4 ){
                var message = 'code should be 4 digits ';
                showTip(message);
                return false;
            }
            return true;
        }
        function showTip(message){
            $('.bk_toptips').show();
            $('.bk_toptips span').html(message);
            setTimeout(function () {
                $('.bk_toptips').hide();
            }, 2000);
        }

    </script>
@endsection

