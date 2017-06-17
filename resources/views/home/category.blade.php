@extends('layouts.home')
@section('title','category')

@section('content')
    <div class="weui_cells_title" > select book category</div>
    <div class="weui_cells weui_cells_split">
        <div class="weui_cell weui_cell_select">
            <div class="weui_cell_bd weui_cell_primary">
                <select class="weui_select" name="category">
                    @foreach($categorys as $category)
                        <option value="{{$category->id}}">{{$category->category_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="weui_cells weui_cells_access">
        <a class="weui_cell" href="javascript:;">
            <div class="weui_cell_bd weui_cell_primary">
                <p>cell standard</p>
            </div>
            <div class="weui_cell_ft"></div>
        </a>
    </div>
@endsection

@section('my-js')
    <script>
        getCategory();
        // when category changes, get the corespondent sub categories
        $('.weui_select').change(function () {
            getCategory();
        });
        function getCategory(){
            // get which option is selected
            var parentId = $('.weui_select option:selected').val();
            //ajax : get the sub categories through get
            $.get("{{url('service/category/parentId')}}" + '/' + parentId,
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
            //console.log(aData.result);
            showSubCategory(aData); // show the sub categories
            },
            'json'
            );
        }
        function showSubCategory(aData) {
            $('.weui_cells_access').html('');// empty old sub categories
            for ( var index in aData.result){
                // the url of detail of the sub category
                var next = "{{url('product/categoryId')}}" + '/' +  aData.result[index].id;
                var html = ' <a class="weui_cell" href="'+ next +'">' +
                '<div class="weui_cell_bd weui_cell_primary">' +
                '<p>' + aData.result[index].category_name +'</p>' +
                '</div>' +
                '<div class="weui_cell_ft"></div>' +
                '</a>';
                $('.weui_cells_access').append(html);// append 在最后追加，不然会覆盖前面的
            }

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