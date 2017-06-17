@extends('layouts.home')

@section('title','cart')

@section('content')
    <div class="page bk_content" style="top: 0;">
        <div class="weui_cells weui_cells_checkbox">
            @foreach($cartItems as $cartItem)
                <label class="weui_cell weui_check_label" for="{{$cartItem->product_id}}">
                    <div class="weui_cell_hd" style="width: 23px;">
                        <input type="checkbox" class="weui_check" name="cart_item" id="{{$cartItem->product_id}}" checked="checked">
                        <i class="weui_icon_checked"></i>
                    </div>
                    <div class="weui_cell_bd weui_cell_primary">
                        <div style="position: relative;">
                            <img class="bk_preview" src="{{$cartItem->product->preview}}" class="m3_preview" onclick="toProduct({{$cartItem->product_id}});"/>
                            <div style="position: absolute; left: 100px; right: 0; top: 0">
                                <p>{{$cartItem->product->product_name}}</p>
                                <p class="bk_time" style="margin-top: 15px;">num:<span class="bk_price"> ${{$cartItem->product->price}}</span> <span class="bk_summary"> x {{$cartItem->count}}</span></p>
                                <p class="bk_time">sum: <span class="bk_price">${{$cartItem->product->price * 1.00 * $cartItem->count}}</span></p>
                            </div>
                        </div>
                    </div>
                </label>
            @endforeach
        </div>
    </div>

     <form action="{{url('/orderCommit')}}" id="orderCommit" method="post">
      {{ csrf_field() }}
      <input type="hide" name="productIds" value="" />
    </form>

    <div class="bk_fix_bottom">
        <div class="bk_half_area">
            <button class="weui_btn weui_btn_primary" onclick="_toCharge();">submit order</button>
        </div>
        <div class="bk_half_area">
            <button class="weui_btn weui_btn_default" onclick="_onDelete();">delete</button>
        </div>
    </div>
@endsection

@section('my-js')
<script>
    $('input:checkbox[name=cart_item]').click(function(event) {
        var checked = $(this).attr('checked');
        if(checked == 'checked') {
            $(this).attr('checked', false);
            $(this).next().removeClass('weui_icon_checked');
            $(this).next().addClass('weui_icon_unchecked');
        } else {
            $(this).attr('checked', true);
            $(this).next().removeClass('weui_icon_unchecked');
            $(this).next().addClass('weui_icon_checked');
        }
    });
   function _onDelete(){
       var productIds = [];
       $('input:checkbox[name=cart_item]').each(function () {
           if ($(this).attr('checked') == 'checked'){
               productIds.push($(this).attr('id'));
           }
       });
       var carItemNum = $('label').length;
       if (carItemNum == 0){
           showTip('cart is empty');
           return;
       }
       if (productIds.length == 0){
           showTip('please select the items');
           return;
       }
       $.ajax({
           type : "GET",
           url : '{{url('service/cart/deleteCart')}}',
           data:{'productIds' : productIds + ''},
           dataType: 'json',
           cache : false,
           success : function (aData){
               if(aData == null) {
                   showTip('server error');
                   return;
               }
               if(aData.status != 0) {
                  showTip(aData.message);
                   return;
               }
               showTip(aData.message);
               location.reload();
           },
           error : function (xhr, status, error){
               console.log(xhr);
               console.log(status);
               console.log(error);
           }
       });
   }
function _toCharge(){
    var productIds = [];
    $('input:checkbox[name=cart_item]').each(function () {
        if ($(this).attr('checked') == 'checked'){
            productIds.push($(this).attr('id'));
        }
    });
    var carItemNum = $('label').length;
    if (carItemNum == 0){
        showTip('cart is empty');
        return;
    }
    if (productIds.length == 0){
        showTip('please select the items');
        return;
    }
    $('input[name=productIds]').val(productIds + '');
    console.log($('input[name=productIds]').val());
    $('#orderCommit').submit();
}
</script>
@endsection