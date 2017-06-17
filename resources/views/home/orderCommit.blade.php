@extends('layouts.home')

@section('title','order commit')
@section('content')
    <div class="page bk_content" style="top: 0;">
        <div class="weui_cells">
            @foreach($cartItemArray as $cartItem)
                <div class="weui_cell">
                    <div class="weui_cell_hd">
                        <img class="bk_icon" src="{{$cartItem->product->preview}}" alt="" >
                    </div>
                    <div class="weui_cell_bd weui_cell_primary">
                        <p class="bk_summary">{{$cartItem->product->product_name}}</p>
                    </div>
                    <div class="weui_cell_ft">
                        <span class="bk_price">{{$cartItem->product->price}}</span>
                        <span> x </span>
                        <span class="bk_important">{{$cartItem->count}}</span>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="weui_cells_title">payment way</div>
        <div class="weui_cells">
            <div class="weui_cell weui_cell_select">
                <div class="weui_cell_bd weui_cell_primary">
                    <select class="weui_select" name="payway">
                        <option selected="" value="1">Credit Card</option>
                        <option value="2">PayPal</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="weui_cells">
            <div class="weui_cell">
                <div class="weui_cell_bd weui_cell_primary">
                    <p>SUM:</p>
                </div>
                <div class="weui_cell_ft bk_price" style="font-size: 25px;">$ {{$sum}}</div>
            </div>
        </div>

    </div>

<form action="{{url('/payOrder')}}" method="post" id="payOrder">
{{csrf_field()}}
    <input type="hidden" name="orderId" value="{{$orderId}}">
</form>

    <div class="bk_fix_bottom">
        <div class="bk_btn_area">
            <button class="weui_btn weui_btn_primary" onclick="_onPay();">Check Out</button>
        </div>
    </div>
@endsection

@section('my-js')
    <script>
        function _onPay(){
            if ($('.weui_cells:first').children().length == 0){
                showTip('order should not be empty');
                return;
            }
            $('#payOrder').submit();
        }
    </script>
@endsection