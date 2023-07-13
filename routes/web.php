<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Category;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('phpinfo');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function(){
    Route::match(['get','post'],'login','AdminController@login');
    //Admin Dashboard
    Route::group(['middleware'=>['admin']],function(){
        Route::get('dashboard','AdminController@dashboard');
        Route::match(['get','post'],'updateadminpassword','AdminController@updatepassword');
        Route::match(['get','post'],'update-admin-details','AdminController@updateadmindetails');
        Route::post('check-current-password','AdminController@checkadminpassword');
        Route::match(['get','post'],'update-vendor-details/{slug}','AdminController@updatevendordetails');
        Route::get('admins/{type?}' ,'AdminController@admins');
        Route::get('view-vendor-details/{id}','AdminController@viewvendordetail');
        Route::post('update-admin-status','AdminController@updateAdminStatus');
        Route::get('logout','AdminController@logout');
        Route::get('section','SectionController@sections');
        Route::get('categories','CategoryController@categories');
        Route::get('brands','BrandController@brands');
        Route::post('update-brand-status','BrandController@updatebrandStatus');
        Route::get('delete-brand/{id}','BrandController@deletebrand');
        Route::match(['get','post'],'add-edit-brand/{id?}','BrandController@addEditbrand');
        Route::post('update-section-status','SectionController@updateSectionStatus');
        Route::get('delete-section/{id}','SectionController@deletesection');
        Route::match(['get','post'],'add-edit-section/{id?}','SectionController@addEditSection');
        Route::post('update-category-status','CategoryController@updateCategoryStatus');
        Route::match(['get','post'],'add-edit-category/{id?}','CategoryController@addEditCategory');
        Route::get('append_categorieslevel','CategoryController@appendCategoriesLevel');
        Route::get('delete-category/{id}','CategoryController@deleteCategory');
        Route::get('delete-category-image/{id}','CategoryController@deleteCategoryImage');

        Route::get('products','ProductController@products');
        Route::post('update-product-status','ProductController@updateproductStatus');
        Route::get('delete-product/{id}','ProductController@deleteProduct');
        Route::match(['get','post'],'add-edit-product/{id?}','ProductController@addEditProduct');
        Route::get('delete-product-image/{id}','ProductController@deleteproductimage');
        Route::get('delete-product-video/{id}','ProductController@deleteproductvideo');
        Route::post('update-attribute-status','ProductController@updateAttributeStatus');
        Route::get('delete-attribute/{id}','ProductController@deleteattribute');
        Route::match(['get','post'],'edit-attributes/{id}','ProductController@editattributes');
        Route::match(['get','post'],'add-attributes/{id}','ProductController@addattributes');
        Route::match(['get','post'],'add-images/{id}','ProductController@addimages');
        Route::post('update-image-status','ProductController@updateimageStatus');
        Route::get('delete-image/{id}','ProductController@deleteimage');

        Route::get('banners','BannersController@banners');
        Route::post('update-banner-status','BannersController@updatebannerStatus');
        Route::get('delete-banner/{id}','BannersController@deletebanner');
        Route::match(['get','post'],'add-banner/{id?}','BannersController@addbanner');
        Route::get('users','UserController@users');
        Route::post('update-user-status','UserController@updateuserStatus');

        Route::get('orders','OrderController@orders');

    });



});

Route::namespace('App\Http\Controllers\Front')->group(function(){
    Route::get('/','IndexController@index');


    $catUrls=Category::select('url')->where('status',1)->get()->pluck('url')->toArray();
    foreach ($catUrls as $key=> $url){
        Route::match(['get','post'],'/'.$url,'ProductsController@listing');


    }
    Route::get('/products/{vendorid}','ProductsController@vendorListing');
    Route::get('product/{id}','ProductsController@details');

    Route::post('get-product-price','ProductsController@getProductPrice');

    Route::get('vendor/login-register','VendorController@loginRegister');
    Route::post('vendor/register','VendorController@register');

    Route::get('vendor/confirm/{code}','VendorController@confirmvendor');

    Route::post('cart/add','ProductsController@cartadd');
    Route::get('/cart','ProductsController@cart');
    Route::post('/cart/update/','ProductsController@cartupdate');
    Route::post('/cart/delete/','ProductsController@cartdelete');
    Route::get('users/login-register','UserController@loginRegister');
    Route::post('/user/register','UserController@userregister');
    Route::group(['middleware'=>['auth']],function(){
        Route::match(['GET','POST'],'user/account','UserController@userAccount');
        Route::match(['GET','POST'],'/checkout/{id?}','ProductsController@checkout');
        Route::match(['GET','POST'],'/deliveryaddress','ProductsController@delivery');
Route::post('get-delivery-address','AddressController@getdeliveryAddress');
Route::post('save-delivery-address','AddressController@savedeliveryAddress');
Route::post('remove-delivery-address','AddressController@removedeliveryAddress');

    Route::get('thanks','ProductsController@thanks');
    Route::get('user/orders/{id?}','OrderController@orders');
    Route::get('paypal','PaypalController@paypal');
    Route::post('pay','PaypalController@pay')->name('payment');
    Route::get('success','PaypalController@success');
    Route::get('error','PaypalController@error');

    });
    Route::get('user/logout','UserController@userlogout');
    Route::post('user/login','UserController@userlogin');
    Route::get('user/confirm/{code}','UserController@confirmAccount');
    Route::match(['get','post'],'user/forgot-password','UserController@forgotpassword');





});