@extends('layouts.home')

@section('title','card payment')
@section('content')
    <link rel="stylesheet" href="{{asset('_home/css/stripe.css')}}">

    <div class="weui_cells_title">
        <div class="weui_cell">
            <div class="weui_cell_hd">
                <label class="weui_label">Order No</label>
            </div>
            <div class="weui_cell_bd weui_cell_primary">
                <span> {{$order->order_no}}</span>
            </div>

        </div>
        <div class="weui_cell">
            <div class="weui_cell_hd">
                <label class="weui_label">SUM</label>
            </div>
            <div class="weui_cell_bd weui_cell_primary">
                <span class="bk_price" >$ {{$order->total_price}}</span>
            </div>
        </div>
        {{--<div class="weui_cell"></div>--}}

        <!--cashier: stripe to deal with credit card-->
        <form action="{{'service/charge'}}" method="post" id="payment-form" onsubmit="return _check()">
            {{csrf_field()}}
            <input type="hidden" name="orderNo" value="{{$order->order_no}}">
            <input type="hidden" name="amount" value="{{$order->total_price}}">
            <input type="hidden" name="currency" value="cad">
            <div class="weui_cells_title">Delivery Info</div>
            <div class="weui_cells weui_cells_form">
                <div class="weui_cell">
                    <div class="weui_cell_hd">
                        <label class="weui_label">receiver</label>
                    </div>
                    <div class="weui_cell_bd weui_cell_primary">
                        <input class="weui_input" value="{{$order->delivery_receiver}}" name="name" type="text"  />
                    </div>
                </div>

                <div class="weui_cell">
                    <div class="weui_cell_hd">
                        <label class="weui_label">phone</label>
                    </div>
                    <div class="weui_cell_bd weui_cell_primary">
                        <input class="weui_input" name="number" value="{{$order->deliver_phone}}" type="number" pattern="[0-9]*"  />
                    </div>
                </div>
                <div class="weui_cell">
                    <div class="weui_cell_hd">
                        <label class="weui_label">address</label>
                    </div>
                    <div class="weui_cell_bd weui_cell_primary">
                        <input class="weui_input" name="address" value="{{$order->delivery_address}}" type="text"  />
                    </div>
                </div>
            </div>

            <div class="form-row">
                <label for="card-element">
                    Credit or debit card
                </label>
                <div id="card-element">
                    <!-- a Stripe Element will be inserted here. -->
                </div>

                <!-- Used to display form errors -->
                <div id="card-errors" role="alert"></div>
            </div>
            <div class="bk_fix_bottom">
                <div class="bk_btn_area">
                    <button class="weui_btn weui_btn_primary" >Submit Payment</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('my-js')
    <script id="stripe" src="{{asset('_home/js/stripe.js')}}" key ="{{ env('STRIPE_KEY') }}"></script>
    <script>
     function _check() {
        var receiver =  $('input[name=name]').val().trim();
        var phone = $('input[name=number]').val().trim();
        var address = $('input[name=address]').val().trim();
        if (receiver == '' || phone == ''||address == ''){
            var message = 'receiver, phone, address should not be empty';
            showTip(message);
            return false;
        }else if(phone.length != 10 ){
            var message = 'phone should be 10 digits';
            showTip(message);
            return false;
         }
     }
    </script>
@endsection