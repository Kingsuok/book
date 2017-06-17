@extends('layouts.home')

@section('title','order list')
@section('content')
    @foreach($orders as $order)
        <div class="weui_cells_title">
            <span>Order No: {{$order->order_no}}</span>

            @if($order->status == 1)
                <span style="float: right;" class="bk_price">
            waiting to pay
          </span>
            @else
                <span style="float: right;" class="bk_important">
                @if($order->delivery == 1)
                    paid
                @elseif($order->received == 1 )
                    delivery
                @else
                    received
                @endif
          </span>
            @endif

        </div>
        <div class="weui_cells_title">
            <span>Receiver: {{$order->delivery_receiver}}</span>
        </div>
        <div class="weui_cells_title">
            <span>Phone: {{$order->delivery_phone}}</span>
        </div>
        <div class="weui_cells_title">
            <span>Address: {{$order->delivery_address}}</span>
            {{--<div><span>{{$order->delivery_address}}</span></div>--}}
        </div>
        <div class="weui_cells">
            @foreach($order->orderItems as $orderItem)
                <div class="weui_cell">
                    <div class="weui_cell_hd">
                        <img src="{{$orderItem->product->preview}}" alt="" class="bk_icon">
                    </div>
                    <div class="weui_cell_bd weui_cell_primary">
                        <p class="bk_summary">{{$orderItem->product->product_name}}</p>
                    </div>
                    <div class="weui_cell_ft">
                        <span class="bk_summary">$ {{$orderItem->product->price}}</span>
                        <span> x </span>
                        <span class="bk_important">{{$orderItem->count}}</span>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="weui_cells_tips" style="text-align: right;" >
            SUM: <span class="bk_price" >$ {{$order->total_price}}</span>
        </div>
        <div class="weui_cells_tips" style="text-align: right;" >
            @if($order->status == 1)
                <a href="javascript:$('#payOrder{{$order->id}}').submit();" class="weui_btn weui_btn_mini weui_btn_primary" id="payNow"  >pay now</a>
                <form action="{{url('/payOrder')}}" method="post" id="payOrder{{$order->id}}">
                    {{csrf_field()}}
                    <input type="hidden" name="orderId" value="{{$order->id}}">
                </form>
            @endif

        </div>
        <hr>
    @endforeach

@endsection

@section('my-js')
    <script type="text/javascript">

    </script>
@endsection