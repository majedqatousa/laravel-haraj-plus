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
use Spatie\Sitemap\SitemapGenerator;
use App\Imports\Cities;
use App\Imports\Countries;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', 'Website\HomeController@index')->name('home');
Auth::routes();

Route::get('tech','Website\WebsiteController@techPage')->name('show-tech');
Route::post('tech','Website\WebsiteController@sendTech')->name('tech');
Route::post('tech-contact','Website\WebsiteController@sendTechContact')->name('tech.contact');
Route::post('send-tech/{id}', 'Website\WebsiteController@Replay')->name('send-tech');

Route::get('/payment_porcedures', function () {
    return view('website.payment_porcedures');
})->name('payment_porcedures');


Route::any('/loginwithsocial','Auth\LoginController@socialLogin')->name('loginwithsocial');
Route::any('/login/{social}/callback','Auth\LoginController@handleProviderCallback');
Route::any('/createOrGetUser','Auth\LoginController@createOrGetUser');
Route::get('signUp','Auth\RegisterController@getRegister')->name('signUp');
Route::get('/email','Auth\ForgotPasswordController@email_form')->name('email');
Route::post('/reset-mail','Auth\ForgotPasswordController@send_mail')->name("email.password");
Route::get('/reset-form','Auth\ForgotPasswordController@showResetForm')->name("reset.form");
Route::get('report-comment/{comment}/{product}','Website\WebsiteController@reportComment')->name('reportComment');
Route::post("password2/update",'Auth\ForgotPasswordController@updatePassword')->name('password.update1');
Route::get('search-result','Website\HomeController@getSearchResult')->name('search.result');
Route::post('verify','Website\WebsiteController@verify')->name('verify');
Route::get('resend','Auth\RegisterController@resend')->name('resend');
Route::get('user_sms','Auth\RegisterController@user_sms')->name('user_sms');
Route::get('haraj-specials','Website\WebsiteController@haraj_specials')->name('haraj-specials');

Route::get('logout', function () {
    $user = auth()->user();
    if(isset($user))
    { auth()->user()->update(['connected' => 0]);
    auth()->logout();
    session()->flush();

   }
    return redirect()->route('home');

})->name('Logout');
Route::get("/getAdd",'Website\WebsiteController@getAdd');
Route::get('unread',"Website\HomeController@unReadNotification");
Route::get('unreadMsg',"Website\HomeController@unreadMsg");
Route::get('/getMore','Admin\ProductController@getMore');
Route::get('/markAsUnread','Website\PaymentController@markAsUnread');

Route::get('/getSubcategories/{id}', 'Admin\ProductController@getSubCategories');
Route::get('/getCities/{id}', 'Admin\CityController@getCountryCities');
Route::get('/get-countries', 'Website\WebsiteController@getCountries');
Route::post('/product-rate/{id}', "Website\WebsiteController@rateProduct");
Route::post('/product-report/{id}', 'Website\WebsiteController@reportProduct')->name('products.report');
Route::get('/productsUser/{id}',"Website\WebsiteController@productsUser")->name('productsUser');
Route::group(['prefix' => 'admin'], function () {

    Route::group(['middleware' => 'admin'], function () {
    
        Route::get('chatUserPro/{product_id}', 'Admin\MessageController@chatUserPro')->name('chatUserPro');
        Route::get('/getMore','Admin\ProductController@getMore');
        Route::resource('users', 'Admin\UserController');
        Route::get('/businessmen', 'Admin\UserController@showBusiness')->name('businessmen');
        Route::get('/businessmen/details/{id}', 'Admin\UserController@businessDetails')->name('businessmen.details');
        Route::get('payments','Website\PaymentController@index')->name('payments.index');
        Route::get('payments/show/{id}','Website\PaymentController@show')->name('payments.show');
        Route::get('/businessmen/action/{id}/{status}', 'Website\PaymentController@paymentAccept')->name('businessmen.action');
        Route::get('/status/{id}/{status}', 'Admin\UserController@status')->name('status');
        Route::get('/deleteProduct/{id}', 'Admin\ProductController@deleteProduct')->name('deleteProduct');
        Route::resource('techs', 'Admin\TechController');
        Route::get('replay', 'Admin\TechController@replayPage')->name('replay-page');
        Route::post('tech-replay/{id}', 'Admin\TechController@AdminReplay')->name('tech-replay');

        Route::resource('products', 'Admin\ProductController');
      
        Route::get('product-activate/{id}', 'Admin\ProductController@product_activate')->name('products.activate');

        Route::post('/product-search','Admin\ProductController@search')->name('admin.search');


//Dashboard Index
        Route::get('index', 'Admin\IndexController@index')->name('main');

//Dashboard Countries
        Route::resource('countries', 'Admin\CountryController');

//Dashboard Cities
        Route::resource('cities', 'Admin\CityController');


//Dashboard Brands
        Route::resource('brands', 'Admin\BrandController');

//Dashboard Sliders
        Route::resource('sliders', 'Admin\SliderController');

//Dashboard Categories
        Route::resource('categories', 'Admin\CategoryController');

//Dashboard SubCategories
        Route::resource('sub-categories', 'Admin\SubCategoryController');


//Dashboard BankAccounts
        Route::resource('bank-accounts', 'Admin\BankAccountController');

//Dashboard Commissions
        Route::resource('commissions', 'Admin\CommissionController');
        Route::get('commissions/show/{id}','Website\CommissionController@show')->name('commissions.show');
        Route::get('commissions/{id}/{status}','Website\CommissionController@acceptIgnoreCommission')->name('commissions.status');

//Dashboard Ads
        Route::resource('ads', 'Admin\AdController');

        Route::delete('product/image/{id}', "Admin\ProductController@deleteImage");

//Dashboard Contacts
        Route::resource('contacts', 'Admin\ContactController');


//Dashboard Packages
        Route::resource('packages', 'Admin\PackageController');

//Dashboard Reports
        Route::resource('reports', 'Admin\ReportController');

        Route::post('block-reporter','Admin\ReportController@block_reporter');
        Route::get('comment-reports','Admin\ReportController@commentReports')->name('commentReports');
        Route::post('block-commenter','Admin\ReportController@block_commenter');
        Route::delete('delete-comment/{id}','Admin\ReportController@deleteComment');

//Dashboard Subscribers
        Route::resource('subscribers', 'Admin\SubscriberController');

//Dashboard StaticPages
        Route::resource('static-pages', 'Admin\StaticPageController');


//Dashboard Settings
        Route::resource('settings', 'Admin\SettingController');
        Route::put('settings', 'Admin\SettingController@update2')->name('update2');


        Route::get('product/status/{id}', "Admin\ProductController@getStatus")->name('product_status');

        Route::get('user-profile/{id}','Admin\UserController@UserProfile')->name('user-profile');


        Route::get('product/accept/{id}/{status}', "Admin\ProductController@accept")->name('productAccept');
        Route::get('chatUserPro/{id}','Admin\MessageController@chatUserPro')->name('chatUserPro');
        // Route::get('chatUser/{id}','Admin\MessageController@chatUser')->name('chatUser');
        
        Route::get('messages', 'Admin\MessageController@getMessages')->name('adminChat.index');
        Route::get('chat/{id}', 'Admin\MessageController@getChatPage')->name('adminChat.getChat');
    
        Route::post('send-bussiness','Admin\MessageController@sendBussiness')->name('send-bussiness');
    });
});

Route::get('products', function () {
    return view(


        'website.products'
    );
});

Route::get('add_phone/{token}/{id}', function ($token,$id) {


    return view('auth.add_phone',compact('token','id'));

})->name('add_phone');
Route::get('/products','Website\HomeController@products')->name('website.products');
Route::post('/products/{id}','Website\HomeController@togFav');
Route::get('/loadMore', 'Website\HomeController@loadMore');

Route::get('/loadMoreProducts', 'Website\HomeController@loadMoreProducts');
Route::any('search', 'Website\HomeController@productSearch')->name('products.search');
Route::any('search-category', 'Website\HomeController@productSearchCat')->name('category.search');
Route::get('/products/show/{id}', 'Website\WebsiteController@categoryProducts')->name('categoryProducts');


Route::post('login-user', 'Auth\LoginController@loginUser')->name('user.login');

//Website Subscribers
Route::post('subscriber', 'Website\SubscriberController@create')->name('subscriber.store');

//Website Commission
Route::get('commission', 'Website\CommissionController@index')->name('commission');

//Website CommissionPrivacy
Route::get('commission-privacy', 'Website\CommissionPrivacyController@index')->name('commission-privacy');

//Website Contacts
Route::get('contact', 'Website\ContactController@index')->name('contact');
Route::post('contact', 'Website\ContactController@store')->name('contact.store');
Route::post('contact-replay', 'Admin\TechController@AdminReplayContact')->name('contact-replay');


//Website WhoAreWe
Route::get('about', 'Website\WhoAreWeController@index')->name('who');

//Website PrivacyPolicy
Route::get('privacy', 'Website\PrivacyPolicyController@index')->name('privacy');

//Website TermsAndConditions
Route::get('terms', 'Website\TermAndConditionController@index')->name('terms');
Route::get('questions', 'Website\TermAndConditionController@questions')->name('questions');

//Website ProhibitedProducts
Route::get('prohibited', 'Website\ProhibitedController@index')->name('prohibited');

//Website Favourites
Route::get('favourite', 'Website\FavouriteController@index')->name('favourite');
Route::delete('favourite/{id}', 'Website\FavouriteController@deleteFavourites');

//Website SubCategories
Route::get('sub-category/{id}', 'Website\SubCategoryController@index')->name('sub-category');





Route::group(['middleware' => 'auth','LogoutUsers'], function () {
    Route::get('/products/deactivate/{id}', "Website\WebsiteController@deactivate")->name('products.deactivate');
    Route::delete('/products/delete/{id}', 'Website\WebsiteController@destroy');
    Route::post('product-store', 'Website\WebsiteController@store')->name('store');
    Route::get('/products/create', 'Website\WebsiteController@create')->name('products.add');
    Route::get('/payments/create/{package_type}', 'Website\PaymentController@create')->name('payments.create');
    Route::post('/pay', 'Website\PaymentController@pay')->name('pay');
    Route::get('/pay-result', 'Website\PaymentController@payresult')->name('pay-result');
    Route::get('/pay-result2', 'Website\PaymentController@payresult2')->name('pay-result2');
    Route::get('thanks','Website\PaymentController@thanks')->name('thanks');
    Route::get('/payment-methods/{package}','Website\WebsiteController@paymentMethods')->name('paymentMethods');
    Route::get('/payment-methods','Website\WebsiteController@paymentWays')->name('paymentWays');
    Route::post('/payments/store', 'Website\PaymentController@store')->name('payments.store');
    Route::get("/products/edit/{id}", "Website\WebsiteController@edit")->name('product.change');
    Route::put('/product/update/{id}', 'Website\WebsiteController@update')->name('update');
    Route::get('/users/{id}', 'Website\HomeController@profile')->name('business-profile');
    Route::post('/edit-profile', 'Website\HomeController@authProfile');
    Route::post('/add-link', 'Website\HomeController@addLink');
    Route::get('/profile-products', 'Website\HomeController@profileProducts')->name('showProfile');

    //Website Commission
    Route::post('commission', 'Website\CommissionController@create')->name('commission.store');

    //Website EditDataح
    Route::get('edit-data', 'Website\EditDataController@index')->name('edit-data');

    Route::post('update_password/{user_id}', 'Website\EditDataController@update_password')->name('update_password');
    Route::post('update_email/{user_id}', 'Website\EditDataController@update_email')->name('update_email');
    Route::post('update_phone/{user_id}', 'Website\EditDataController@update_phone')->name('update_phone');

    Route::patch('edit-data/{id}', 'Website\EditDataController@update')->name('edit-data.update');



    //For Adding And Deleting Favourites
    Route::post('home/{id}', 'Website\HomeController@toggleFavourites');
    //End of Favourites



    //Website Package
   

//     Route::get('chat/{product_id}', 'Website\MessageController@chat')->name('chat');

    Route::get('chat-store/{id}', 'Website\MessageController@chatStore')->name('chatStore');


//     Route::post('sendMsgSeller', 'Website\MessageController@sendMsgSeller')->name('sendMsgSeller');
//     Route::post('searchMsg', 'Website\MessageController@searchMsg')->name('searchMsg');
//     Route::get('chat_user/{msg_id}', 'Website\MessageController@chat_user')->name('chat_user');
//     Route::get('allMessages', 'Website\MessageController@allMessages')->name('allMessages');

    Route::get('messages', 'Website\MessageController@getMessages')->name('chat.index');
    Route::get('chat/{id}', 'Website\MessageController@getChatPage')->name('chat.getChat');
    Route::post('chat', 'Website\MessageController@store')->name('chat.store');
    Route::post('delete_chat', 'Website\MessageController@deleteChat')->name('chats.delete');
    Route::post('upload-image-chat', 'Website\MessageController@uploadChatImage')->name('upload-image-chat');


});

 Route::get('package', 'Website\PackageController@index')->name('package');



Route::get('product-details/{id}', "Website\WebsiteController@productDetails")->name('product-details');

Route::get('{profile}', "Website\HomeController@profileGeneral")->name('business-general-profile');


Route::get('clear', function () {

    \Illuminate\Support\Facades\Artisan::call('config:cache');

});







Route::post('add_user_phone/{user_id}', 'Website\WebsiteController@update_phone')->name('add_user_phone');
