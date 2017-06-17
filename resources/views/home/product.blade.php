@extends('layouts.home')

@section('title','index')

@section('content')

    <div class="weui_cells weui_cells_access">
        @foreach($products as $product)
        <a class="weui_cell" href="{{url('product/pdtId').'/'.$product->id}}">
            <div class="weui_cell_hd"><img class="bk_preview"  src="{{$product->preview}}" alt="" ></div>
            <div class="weui_cell_bd weui_cell_primary">
                <div style="margin-bottom: 10px;">
                    <span class="bk_title">{{$product->product_name}}</span>
                    <span class="bk_price">$ {{$product->price}}</span>
                </div>
                <p class="bk_summary">{{$product->summary}}</p>
            </div>
            <div class="weui_cell_ft"></div>
        </a>
        @endforeach
    </div>

@endsection

@section('my-js')
@endsection