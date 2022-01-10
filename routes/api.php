<?php

use App\Http\Controllers\Api\Traits\ApiResponseTrait;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
   
    
// });

// Route::group(['middleware' => 'api'], function(){
//     Route::get('index','API\HomeController@index');
// });
Route::resource('favorite', 'API\favoriteController')->middleware('auth:user_api');
Route::get('allFavorites', 'API\favoriteController@showAllFavorits')->middleware('auth:user_api');

Route::DELETE('deleteFavorite/{id}', 'API\favoriteController@destroy')->middleware('auth:user_api');

Route::resource('product', 'API\productController')->middleware('auth:user_api');
Route::post('createAd', 'API\productController@store')->middleware('auth:user_api');
Route::post('createProductImages', 'API\productController@storeProductImages')->middleware('auth:user_api');
Route::post('demoCreateAd', 'API\productController@demoStore');

Route::get('myAds', 'API\productController@myAds')->middleware('auth:user_api');
Route::get('storeProducts', 'API\UserApiAuthController@getProducts')->middleware('auth:user_api');

Route::get('searchProducts/{key}', 'API\HomeController@searchProduct');

Route::post('uploadMainImage', 'API\productController@uploadMainImage')->middleware('auth:user_api');
Route::post('updateProduct/{id}', 'API\productController@update')->middleware('auth:user_api');
Route::resource('Category', 'API\CategoryController');
Route::get('adCategory', 'API\CategoryController@adCategory');

Route::resource('productRat', 'API\ratingController')->middleware('auth:user_api');
Route::get('subCategory/{id}', 'API\CategoryController@subCategory');
Route::resource('follower', 'API\followController')->middleware('auth:user_api');
Route::DELETE('unfollow/{id}', 'API\followController@unFollow')->middleware('auth:user_api');
Route::get('demoIsFollowed/{id}', 'API\followController@demoIsFollowed');
Route::get('isFollowed/{id}', 'API\followController@isFollowed')->middleware('auth:user_api');

Route::post('productReport', 'API\reportController@store')->middleware('auth:user_api');

Route::post('follow', 'API\followController@follow');
Route::post('productCategory', 'API\CategoryController@productCategory');
Route::get('cityIndex', 'API\productController@cityIndex');
Route::get('indexRat/{id}', 'API\ratingController@indexRat');
Route::get('ratingController/{id}', 'API\CategoryController@productCategory');
Route::get('indexRat/{id}', 'API\ratingController@indexRat');
Route::get('showProduct/{id}', 'API\productController@showProduct');
Route::post('reportProduct/{id}', 'API\productController@reportProduct')->middleware('auth:user_api');
Route::post('reportComment/{id}', 'API\productController@reportComment')->middleware('auth:user_api');
Route::get('CreateValidat', 'API\productController@CreateValidat')->middleware('auth:user_api');
Route::get('showImage/{id}', 'API\productController@showImage')->middleware('auth:user_api');
Route::DELETE('destroyImage/{id}', 'API\productController@destroyImage')->middleware('auth:user_api');
Route::DELETE('deleteProduct/{id}', 'API\productController@destroy')->middleware('auth:user_api');
Route::get('deleteProductImageByPath', 'API\productController@destroyImageByPath');
Route::get('store/{id}', 'API\productController@getStore');
Route::get('storeProducts/{id}', 'API\productController@getProducts');
Route::get('user/{id}', 'API\UserApiAuthController@userData');

Route::get('demoShowProduct/{id}', 'API\productController@demoShowProduct');

Route::put('productStatusActive/{id}', 'API\productController@productStatusActive')->middleware('auth:user_api');
Route::put('productStatusDeActive/{id}', 'API\productController@productStatusDeActive')->middleware('auth:user_api');

Route::get('Home', 'API\HomeController@businessProduct');
Route::get('userProduct', 'API\HomeController@userProduct');
Route::get('productCreated', 'API\HomeController@productCreated');
Route::get('productPrice/{type?}', 'API\HomeController@productPriceDesc');
Route::get('productPriceASC', 'API\HomeController@productPriceASC');
Route::get('fillterData', 'API\HomeController@fillterData');
Route::get('userPromit', 'API\HomeController@userPromit');
Route::get('productUserPromit', 'API\HomeController@productUserPromit');
Route::get('user-product', 'API\HomeController@productUser');
Route::get('city', 'API\HomeController@city');
Route::get('cityName/{id}', 'API\HomeController@cityName');

Route::get('userNotPromit', 'API\HomeController@userNotPromit');
Route::post('userPromitProfile', 'API\UserApiAuthController@userPromitProfile');
Route::post('add-name', 'API\UserApiAuthController@changeName');
Route::post('updateFcm_token', 'API\fcm_tokenController@updateFcm_token')->middleware('auth:user_api');
Route::get('mystore/{id}', 'API\HomeController@mystore')->middleware('auth:user_api');
Route::post('pay', 'API\paymentMethodController@pay')->middleware('auth:user_api');
Route::get('following/{id}', 'API\followController@following')->middleware('auth:user_api');
Route::get('followers/{id}', 'API\followController@follower')->middleware('auth:user_api');
Route::get('createStore', 'API\StoreController@create')->middleware('auth:user_api');
Route::post('checkOutId', 'API\paymentMethodController@checkOutId')->middleware('auth:user_api');
Route::post('contact-us', 'API\HomeController@contact')->middleware('auth:user_api');
Route::post('pay/bank', 'API\paymentMethodController@store')->middleware('auth:user_api');
Route::get('getPaymentStatus', 'API\paymentMethodController@getPaymentStatus')->middleware('auth:user_api');
Route::get('packge', 'API\paymentMethodController@packge');
Route::get('Notification', 'API\UserNotificationController@notification')->middleware('auth:user_api');
Route::delete('delete-notification/{id}', 'API\UserNotificationController@delete')->middleware('auth:user_api');
Route::get('test', 'API\UserApiAuthController@test')->middleware('auth:user_api');
Route::post('stop-Notification', 'API\fcm_tokenController@stopNotification')->middleware('auth:user_api');
Route::get('techs', 'API\techController@allTechs')->middleware('auth:user_api');
Route::get('tech/{id}', 'API\techController@showTech')->middleware('auth:user_api');
Route::prefix('auth')->group(function () {
    Route::post('/register', 'API\UserApiAuthController@register' );
    Route::post('/submitcode',  'API\UserApiAuthController@submitCode');
    Route::post('/login',  'API\UserApiAuthController@login');
    Route::post('/forget-password', 'API\UserApiAuthController@requestPasswordReset' );
});
Route::prefix('auth/')->middleware('auth:user_api')->group(function () {
    Route::post('/update', 'API\UserApiAuthController@update');
    Route::post('/change-phone', 'API\UserApiAuthController@changephone');
    Route::post('/reset-password', 'API\UserApiAuthController@resetPassword');
    Route::post('/email', 'API\UserApiAuthController@email');
    Route::get('/logout', 'API\AuthBaseController@logout');
    Route::get('/info', 'API\UserApiAuthController@info');
    Route::post('/updateImage', 'API\UserApiAuthController@uploadImage');
    Route::get('/rate', 'API\UserApiAuthController@CompletionRate');
    Route::post('/sendTech', 'API\UserApiAuthController@sendTech');
    Route::post('/chatImage', 'API\UserApiAuthController@chatImage');
    Route::get('/getStore', 'API\UserApiAuthController@getStore');
    Route::post('/saveFCMToken', 'API\UserApiAuthController@saveFCMToken');
    Route::post('/coverImage', 'API\UserApiAuthController@coverImage');
});
 Route::get('userFCMToken/{id}', 'API\UserApiAuthController@fcmToken');
Route::get('demoGetStore' ,'API\UserApiAuthController@demoGetStore' );
Route::get('demofollowing/{id}', 'API\followController@following');
Route::get('demofollowers/{id}', 'API\followController@follower');
Route::post('demoFollow' ,'API\followController@follow' );
Route::get('testFCM/{tokens}','API\UserFcmTokenController@sendTestNotification');
Route::get('FCM/{token}/{title}/{body}','API\UserFcmTokenController@sendFCMNotification');