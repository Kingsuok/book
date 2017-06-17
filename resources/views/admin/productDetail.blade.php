@extends('layouts.master')
@section('title')
   <title>product detail</title>
@endsection
@section('headAndMenu')
@endsection
@section('content')
    <article class="cl pd-20">
        <style>
            .row.cl {
                margin: 20px 0;
            }
        </style>

        <form class="form form-horizontal" action="" method="post">
            <div class="row cl">
                <label class="form-label col-xs-3 col-sm-2"><span class="c-red"></span>Name：</label>
                <div class="formControls col-xs-9 col-sm-10">
                    {{$product->product_name}}
                </div>
                
            </div>
            <div class="row cl">
                <label class="form-label col-xs-3 col-sm-2"><span class="c-red"></span>Brief：</label>
                <div class="formControls col-xs-9 col-sm-10">
                    {{$product->brief}}
                </div>
                
            </div>
            <div class="row cl">
                <label class="form-label col-xs-3 col-sm-2"><span class="c-red"></span>Price：</label>
                <div class="formControls col-xs-9 col-sm-10">
                    {{$product->price}}
                </div>
                
            </div>
            <div class="row cl">
                <label class="form-label col-xs-3 col-sm-2"><span class="c-red"></span>Category：</label>
                <div class="formControls col-xs-9 col-sm-10">
                    {{$product->category->category_name}}
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-3 col-sm-2"><span class="c-red"></span>Hot：</label>
                <div class="formControls col-xs-9 col-sm-10">
                    {{$product->hot}}
                </div>
                
            </div>
            <div class="row cl">
                <label class="form-label col-xs-3 col-sm-2"><span class="c-red"></span>New：</label>
                <div class="formControls col-xs-9 col-sm-10">
                    {{$product->new}}
                </div>
                
            </div>
            <div class="row cl">
                <label class="form-label col-xs-3 col-sm-2">Preview：</label>
                <div class="formControls col-xs-9 col-sm-10">
                    @if($product->preview != '')
                        <img id="preview_id" src="{{url($product->preview)}}" style="border: 1px solid #B8B9B9; width: 60px; height: 80px;"/>
                    @endif
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-3 col-sm-2">Content：</label>
                <div class="formControls col-xs-9 col-sm-10">
                    {!! $content->content !!}
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-3 col-sm-2">Images：</label>
                <div class="formControls col-8">
                    @foreach($images as $image)
                        <img src="{{url($image->image_path)}}" style="border: 1px solid #B8B9B9; width: 60px; height: 80px;" />
                    @endforeach
                </div>
            </div>
        </form>
    </article>
@endsection
@section('my-js')
    
@endsection