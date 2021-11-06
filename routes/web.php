<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

use App\Http\Controllers\Backend\AdminProfileController;
use App\Http\Controllers\Backend\BrandController; 
use App\Http\Controllers\Backend\CategoryController; 
use App\Http\Controllers\Backend\SubCategoryController; 
use App\Http\Controllers\Backend\ProductController; 
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\PageCartController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\ShippingController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\StripeController;
use App\Models\User;



// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('frontend.index');
});



Route::group(['prefix'=> 'admin', 'middleware'=>['admin:admin']], function(){
	Route::get('/login', [AdminController::class, 'loginForm']);
	Route::post('/login',[AdminController::class, 'store'])->name('admin.login');
});


Route::middleware(['auth:admin'])->group(function(){

// Admin 
Route::middleware(['auth:sanctum,admin', 'verified'])->get('/admin/dashboard', function () {
    return view('admin.index');
})->name('dashboard')->middleware('auth:admin');


// Admin All Route 
Route::get('/admin/logout', [AdminController::class, 'destroy'])->name('admin.logout');


// admin profile view
Route::get('/admin/profile', [AdminProfileController::class, 'AdminProfile'])->name('admin.profile');

// admin profile edit
Route::get('/admin/profile/edit', [AdminProfileController::class, 'AdminProfileEdit'])->name('admin.profile.edit');

// admin profile edit
Route::post('/admin/profile/update', [AdminProfileController::class, 'AdminProfileUpdate'])->name('admin.profile.store');

// Admin Password change  
Route::get('/admin/change/password', [AdminProfileController::class, 'AdminChnagePassword'])->name('admin.change.password');


// Admin Password Update  
Route::post('/admin/update/password', [AdminProfileController::class, 'AdminUpdatePassword'])->name('admin.update.password');


// Admin Brand All Route Group Start
Route::prefix('brand')->group(function () {
  Route::get('/view', [BrandController::class, 'BrandView'])->name('all.brand'); 
  Route::post('/add', [BrandController::class, 'BrandStore'])->name('brand.add'); 
  Route::get('/edit/{id}', [BrandController::class, 'BrandEdit'])->name('edit.brand'); 
  Route::post('/update', [BrandController::class, 'BrandUpdate'])->name('update.brand');
  Route::get('/delete/{id}', [BrandController::class, 'BrandDelete'])->name('delete.brand'); 
   
});// Admin Brand All Route Group End 


// Admin Category, Sub Category, Sub Sub Category All Route Group Start
Route::prefix('category')->group(function () {

 // Category All Route
  Route::get('/view', [CategoryController::class, 'CategoryView'])->name('all.category'); 
  Route::post('/store', [CategoryController::class, 'CategoryStore'])->name('store.category');
  Route::get('/edit/{id}', [CategoryController::class, 'CategoryEdit'])->name('edit.category'); 
  Route::post('/update', [CategoryController::class, 'CategoryUpdate'])->name('update.category'); 
  Route::get('/delete/{id}', [CategoryController::class, 'CategoryDelete'])->name('delete.category'); 

  // Sub Category All Route
  Route::get('/sub/view', [SubCategoryController::class, 'SubCategoryView'])->name('all.subcategory');
  Route::post('/sub/store', [SubCategoryController::class, 'SubCategoryStore'])->name('category.store');
  Route::get('/sub/edit/{id}', [SubCategoryController::class, 'SubCategoryEdit'])->name('subcategory.edit'); 
  Route::post('/sub/update', [SubCategoryController::class, 'SubCategoryUpdate'])->name('update.subcategory'); 
  Route::get('/sub/delete/{id}', [SubCategoryController::class, 'SubCategoryDelete'])->name('subcategory.delete'); 

// Sub Sub Category All Route
  Route::get('/sub/sub/view', [SubCategoryController::class, 'SubSubCategoryView'])->name('all.subsubcategory');



  Route::get('/subcategory/ajax/{category_id}', [SubCategoryController::class, 'GetSubCategory']);

  Route::get('/subsubcategory/ajax/{subcategory_id}', [SubCategoryController::class, 'GetSubSubCategory']);


  Route::post('/sub/sub/store', [SubCategoryController::class, 'SubSubCategoryStore'])->name('subsubcategory.store');
  Route::get('/sub/sub/edit/{id}', [SubCategoryController::class, 'SubSubCategoryEdit'])->name('subsubcategory.edit');
  Route::post('/sub/sub/update', [SubCategoryController::class, 'SubSubCategoryUpdate'])->name('subsubcategory.update');
  Route::get('/sub/sub/delete/{id}', [SubCategoryController::class, 'SubSubCategoryDelete'])->name('subsubcategory.delete'); 
});  // Admin Category, Sub Category, Sub Sub Category All Route Group End


// Admin Product All Route Group Start
Route::prefix('product')->group(function () {

  Route::get('/add', [ProductController::class, 'AddProduct'])->name('add.product'); 
  Route::post('/store', [ProductController::class, 'StoreProduct'])->name('product-store');
  Route::get('/view', [ProductController::class, 'ProductView'])->name('all.product'); 
  Route::get('/view/info/{id}', [ProductController::class, 'ProductInfoView'])->name('product.all_info_view');

  Route::get('/deactive/{id}', [ProductController::class, 'ProductDeactive'])->name('product.deactive'); 
  Route::get('/active/{id}', [ProductController::class, 'ProductActive'])->name('product.active');
   
});// Admin Product All Route Group End 


 // Admin Slider All Route Group Start
 Route::prefix('slider')->group(function () {

 Route::get('/view', [SliderController::class, 'SliderView'])->name('slider.manage'); 
 Route::post('/store', [SliderController::class, 'SliderStore'])->name('slider.store');
 Route::get('/delete/{id}', [SliderController::class, 'SliderDelete'])->name('slider.delete'); 
 Route::get('/edit/{id}', [SliderController::class, 'SliderEdit'])->name('edit.slider'); 
 Route::post('/update', [SliderController::class, 'SliderUpdate'])->name('update.slider');
 
 Route::get('/deactive/{id}', [SliderController::class, 'SliderDeactive'])->name('slider.deactive'); 
 Route::get('/active/{id}', [SliderController::class, 'SliderActive'])->name('slider.active');
  
   });// Admin Slider All Route Group End 

   // Admin Coupon route start here
  Route::prefix('coupon')->group(function () {

  Route::get('/coupon/view', [CouponController::class, 'CouponView'])->name('manage.coupon'); 
  Route::post('/coupon/coupon_apply', [CouponController::class, 'CouponStore'])->name('coupon.add'); 
  Route::get('/coupon/edit/{id}', [CouponController::class, 'CouponEdit'])->name('coupon.edit'); 
  Route::post('/coupon/update', [CouponController::class, 'CouponUpdate'])->name('coupon.update');
  Route::get('/coupon/coupon_remove/{id}', [CouponController::class, 'CouponDelete'])->name('coupon.delete');

  });// Admin oupon All Route Group End 

  // Admin shipping route start here
  Route::prefix('shipping')->group(function () {

    Route::get('/division/view', [ShippingController::class, 'DivisionView'])->name('manage.division'); 
    Route::post('/division/store', [ShippingController::class, 'DivisionStore'])->name('add.division');
    Route::get('/division/edit/{id}', [ShippingController::class, 'DivisionEdit'])->name('division.edit');
    Route::post('/division/update', [ShippingController::class, 'DivisionUpdate'])->name('division.update');
    Route::get('/division/delete/{id}', [ShippingController::class, 'DivisionDelete'])->name('division.delete');

     
    Route::get('/district/view', [ShippingController::class, 'DistrictView'])->name('manage.district');
    Route::post('/district/store', [ShippingController::class, 'DistrictStore'])->name('district.store');
    Route::get('/district/edit/{id}', [ShippingController::class, 'DistrictEdit'])->name('district.edit');
    Route::post('/district/update', [ShippingController::class, 'DistrictUpdate'])->name('district.update');
    Route::get('/district/delete/{id}', [ShippingController::class, 'DistrictDelete'])->name('district.delete');  

    Route::get('/district/ajax/{division_id}', [ShippingController::class, 'GetDistrict']);

    Route::get('/state/view', [ShippingController::class, 'StateView'])->name('manage.state'); 
    Route::post('/state/store', [ShippingController::class, 'StateStore'])->name('state.store');
    Route::get('/state/edit/{id}', [ShippingController::class, 'StateEdit'])->name('state.edit');
    Route::post('/state/update', [ShippingController::class, 'StateUpdate'])->name('state.update');
    Route::get('/state/delete/{id}', [ShippingController::class, 'StateDelete'])->name('state.delete');
  
    });// Admin shipping All Route Group End 

}); 


// ############################ User Route All Route ################################

// User
Route::middleware(['auth:sanctum,web', 'verified'])->get('/dashboard', function () {

  $id = Auth::user()->id;
  $user = User::find($id);

  return view('dashboard', compact('user'));
})->name('dashboard');

Route::get('/', [IndexController::class, 'index']);
// User Logout Route
Route::get('/user/logout', [IndexController::class, 'UserLogout'])->name('user.logout');

// User Profile Update
Route::get('/user/profile/update', [IndexController::class, 'UserProfileUpdate'])->name('user.profile.update');

// User Profile Update
Route::post('/user/profile/store', [IndexController::class, 'UserProfileStore'])->name('user.profile.store');


// User Change password
Route::get('/user/password', [IndexController::class, 'UserChangePassword'])->name('user.change.password');

// user password chnage
Route::post('/user/password/update', [IndexController::class, 'UserPasswordUpdate'])->name('user.password.update');

// ############################ End User Route All Route ################################




// Product detail route goes here
Route::get('/product/detail/{id}', [IndexController::class, 'ProductDetail']);

// Frontend tags route goes here
Route::get('/product/tag/{tag}', [IndexController::class, 'TagWiseProduct']);

// Frontend SubCategory route goes here
Route::get('/subcategory/product/{subcat_id}', [IndexController::class, 'SubCatWiseProduct']);

// Frontend Sub  SubSubCategory route goes here
Route::get('/subsubcategory/product/{subsubcat_id}', [IndexController::class, 'SubSubCatWiseProduct']);

// Product view model ajax card route goes here
Route::get('/product/view/modal/{id}', [IndexController::class, 'ProductViewAjax']);

// Product Add to cart route ajax route goes here
Route::post('/cart/data/store/{id}', [CartController::class, 'AddToCart']); 

// Product mini Cart ajax route goes here
Route::get('/product/mini/cart/', [CartController::class, 'AddMiniCart']);


// Remove mini cart product
Route::get('/minicart/product-remove/{rowId}', [CartController::class, 'RemoveMiniCart']);



######### Start Product wishlist only view Auth user in use middleware ###########
// Route::group(['prefix'=>'user','middleware' => ['user','auth'],'namespace'=>'User'],function(){

// Add to Wishlist product
Route::post('/add-to-wishlist/{product_id}', [CartController::class, 'AddToWishlist']); 

// Product Wishlist page
Route::get('/wishlist', [WishlistController::class, 'ViewWishlist'])->name('wishlist');
  
// Product Wishlist show data
Route::get('/get-wishlist-product', [WishlistController::class, 'GetWishlistProduct']);

// Remove  Wishlist Product
Route::get('/wishlist-remove/{id}', [WishlistController::class, 'RemoveWishlistProduct']); 
  
  // }); ####### End Product wishlist only view Auth user in use middleware  #############


// My cart Page view
Route::get('/mycart', [PageCartController::class, 'MyCart'])->name('mycart');
//product get into cart 
Route::get('/get-cart-product', [PageCartController::class, 'GetCartProduct']);
//reove from cart view product
Route::get('/cart-remove/{rowId}', [PageCartController::class, 'RemoveMyCart']);
//product increment button route
Route::get('/cart-increment/{rowId}', [PageCartController::class, 'CartIncrement']);
//product decrement button route
Route::get('/cart-decrement/{rowId}', [PageCartController::class, 'CartDecrement']);

// route for coupons of mycart

Route::post('/coupon_apply',[CartController::class,'CouponApply']);
Route::get('/coupon-calculation',[CartController::class,'CouponCalculation']);
Route::get('/coupon-remove',[CartController::class,'CouponRemove']);

// code for checkout
Route::get('/cart/checkout',[CheckoutController::class,'CheckoutView'])->name('checkout');
Route::get('/checkout/district/ajax/{division_id}',[CheckoutController::class,'GetDistrictData']);
Route::get('/checkout/state/ajax/{district_id}',[CheckoutController::class,'GetStateData']);
Route::post('/checkout/store',[CheckoutController::class,'CheckoutStore'])->name('store.checkout');

// code for payment
Route::post('/payment/store',[StripeController::class,'StripeOrder'])->name('stripe.order');
