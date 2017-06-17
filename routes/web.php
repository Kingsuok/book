<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('home.login');
//});
//


Route::group(['namespace'=>'View\home'],function (){
    Route::get('/','IndexController@index');
    Route::get('/login','MemberController@login');
    Route::get('/register','MemberController@register');
    Route::get('/category','IndexController@category');// top category
    Route::get('/product/categoryId/{categoryId}','IndexController@product');// product
    Route::get('/product/pdtId/{pdtId}','IndexController@pdtDetail');// product detail
    Route::get('/cart','CartController@cart');
});
    //all requests from ajax should be dealt in service
Route::group(['prefix'=>'service','namespace'=>'Service\Home'],function(){
    Route::post('register','MemberController@register');
    Route::get('validateEmail', 'MemberController@validateEmail');
    Route::post('login','MemberController@login');
    Route::get('category/parentId/{parentId}','IndexController@category');
    Route::get('cart/add/{pdtId}','CartController@addCart');
    Route::get('cart/deleteCart','CartController@deleteCart');
    Route::get('/logout','MemberController@logout');
});
// common controller for home and admin
Route::group(['prefix'=>'service','namespace'=>'Service\Common'],function(){
    Route::get('validateCode/code','ValidateController@createCode');
    Route::post('validateCode/send','ValidateController@sendSMS');
    Route::post('upload/{fileName}','UploadController@uploadFile');
});
//Route::any('/service/validateCode/code','Service\ValidateController@createCode');
//Route::post('/service/validateCode/send','Service\ValidateController@sendSMS');
//Route::post('/service/register','Service\MemberController@register');
//Route::get('/service/validateEmail', 'Service\MemberController@validateEmail');
//Route::post('/service/login','Service\MemberController@login');

Route::group(['middleware'=>['home.login']],function(){
    Route::group(['namespace'=>'View\Home'],function(){
        Route::post('/orderCommit', 'OrderController@orderCommit');
        Route::get('/orderList', 'OrderController@orderList');
        Route::post('/payOrder','OrderController@payOrder');
    });
    Route::post('service/charge','Service\Home\PayController@orderCharge');
});

// back end router
// 由于登录不需要，身份验证所以单独拿出来
Route::get('/admin', 'View\Admin\AdminController@toLogin');
Route::post('/admin/service/login', 'Service\Admin\AdminController@login');
Route::get('admin/service/admin/logout', 'Service\Admin\AdminController@logout');
// add the middleware : admin.login1
Route::group(['prefix'=>'admin','middleware'=>['admin.login']],function(){

    Route::group(['namespace'=>'View\Admin'],function(){

        Route::get('index', 'IndexController@toIndex');
        Route::resource('category','CategoryController');
        Route::resource('product','ProductController');
        Route::resource('member','MemberController');
        Route::resource('order','OrderController');
        Route::get('admin/edit', 'AdminController@edit');
    });

    Route::group(['prefix'=>'service','namespace'=>'Service\Admin'],function(){

        Route::post('admin/edit', 'AdminController@edit');

        Route::group(['prefix'=>'category'],function (){
            Route::post('/store', 'CategoryController@storeCategory');
            Route::post('/delete', 'CategoryController@deleteCategory');
            Route::post('/update', 'CategoryController@updateCategory');
        });

        Route::group(['prefix'=>'product'],function (){
            Route::post('/store', 'ProductController@storeProduct');
            Route::post('/delete', 'ProductController@deleteProduct');
            Route::post('/update', 'ProductController@updateProduct');
        });

        Route::group(['prefix'=>'member'],function (){
            //Route::post('/store', 'MemberController@storeMember');
            Route::post('/delete', 'MemberController@deleteMember');
            //Route::post('/update', 'MemberController@updateMember');
        });

        Route::group(['prefix'=>'order'],function (){
            Route::post('/delete', 'OrderController@deleteOrder');
            Route::post('/update', 'OrderController@updateOrder');
        });
    });
});
