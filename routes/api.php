<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('client_registration', 'FrontController@ClientRegistration');
Route::post('login', 'UserController@login');
Route::group(['middleware' => 'auth:api'],function(){
    Route::get('/check-login', 'UserController@checkLogin');
});
Route::get('all_cat_sub_chid', 'CategoryController@getCatSubChildCategory');
Route::resource('category','CategoryController');
Route::post('category_update','CategoryController@categoryUpdate');
//product cart 
Route::post('product/get_products_cart', 'CartController@GetProductsCart');
Route::post('product/update_products_cart', 'CartController@UpdateProductsCart');
Route::post('product/add_products_cart', 'CartController@AddProductsCart');
Route::post('product/delete_products_cart', 'CartController@DeleteProductsCart');
Route::resource('product','ProductController');
Route::post('update_product','ProductController@updateProduct');

Route::get('get_delivery_addresses', 'UserController@GetDeliveryAddresses');
Route::post('update_delivery_address', 'UserController@UpdateDeliveryAddress');
Route::post('add_delivery_address', 'UserController@AddDeliveryAddress');
Route::post('delete_delivery_address', 'UserController@DeleteDeliveryAddress');

Route::post('add_order', 'OrderController@AddOrder')->name('add_order');
Route::get('get_orders', 'OrderController@getOrders')->name('get_orders');
Route::get('get_user_orders', 'OrderController@getUserOrders')->name('get_user_orders');
Route::post('order/accept', 'OrderController@acceptOrder');