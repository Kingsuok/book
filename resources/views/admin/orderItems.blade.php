@extends('layouts.master')
@section('title')
    <title>order items</title>
@endsection
@section('headAndMenu')
@endsection
@section('content')
    <style>
        .red
    </style>
    <article class="cl pd-20">
        <form action="" method="post" class="form form-horizontal" id="form-order-edit">
            <div class="row cl">
                <label class="form-label col-xs-2 col-sm-4">ID：</label>
                <div class="formControls col-xs-10 col-sm-8" >
                    {{$id}}
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-2 col-sm-4">No：</label>
                <div class="formControls col-xs-10 col-sm-8" >
                    {{$orderNo->order_no}}
                </div>
            </div>
            @foreach($orderItems as $orderItem)
            <div class="row cl">
                <label class="form-label col-xs-2 col-sm-4">Item {{++$count}}：</label>
                <div class="formControls col-xs-10 col-sm-8">

      	            {{$orderItem->product->product_name}} --- $ {{$orderItem->product->price}} x {{$orderItem->count}}

                </div>
            </div>
            @endforeach

        </form>
    </article>
@endsection
@section('my-js')

@endsection