@extends('layouts.home')
@section('title','payment status')
@section('content')
    <div class="weui_msg">
        <div class="weui_icon_area"><i class="{{$status == 0? 'weui_icon_success':'weui_icon_warn'}} weui_icon_msg"></i></div>
        <div class="weui_text_area">
            <h2 class="weui_msg_title">{{$status == 0? 'Payment Successfully':'Payment Fail'}}</h2>
            <p class="weui_msg_desc">{{$message}}</p>
        </div>

    </div>
@endsection

@section('my-js')
    <script type="text/javascript">
        function jump(count) {
            setTimeout(function () {
                location.href = '{{url('/orderList')}}';
            },count * 1000);
        }
        jump(2);
    </script>
@endsection