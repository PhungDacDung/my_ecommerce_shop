<?php

use App\Models\Product;
use App\Http\Services\UploadService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\Group;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\Users\LoginController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;

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

/* Route::get('/', function () {
    return view('welcome');
});
 */

Auth::routes();

// Route::get('/admin/users/login',[LoginController::class,'index'])->name('login');
// Route::post('/admin/users/login/store',[LoginController::class,'store']);
 
Route::middleware(['auth'])->group(function(){

    Route::prefix('/admin')->group(function(){
        
        Route::get('/',[MainController::class,'index'])->name('admin');
        Route::get('/main',[MainController::class,'index']);

        Route::prefix('/menu')->group(function(){

            Route::get('add',[MenuController::class,'create']);
            Route::post('add',[MenuController::class,'store']);
            Route::get('list',[MenuController::class,'list']);
            Route::DELETE('delete',[MenuController::class,'delete']);
            Route::get('edit/{id}',[MenuController::class,'edit']);
            Route::post('edit/{data}',[MenuController::class,'update']);

        });

        //Product
        Route::prefix('/product')->group(function(){
            Route::get('add',[ProductController::class,'create']);
            Route::post('add',[ProductController::class,'store']);
            Route::get('list',[ProductController::class,'index']);
            Route::get('edit/{product}',[ProductController::class,'show']);
            Route::post('edit/{product}',[ProductController::class,'update']);
            Route::DELETE('delete',[ProductController::class,'destroy']);
        });

        Route::prefix('/slider')->group(function(){
            Route::get('add',[SliderController::class,'create']);
            Route::post('add',[SliderController::class,'store']);
            Route::get('list',[SliderController::class,'index']);
            Route::get('edit/{product}',[SliderController::class,'show']);
            Route::post('edit/{product}',[SliderController::class,'update']);
            Route::DELETE('delete',[SliderController::class,'destroy']);
        });

        /* Blog admin  */

        Route::prefix('/blog')->group(function(){
            Route::get('add',[AdminBlogController::class,'create']);
            Route::post('add',[AdminBlogController::class,'store']);
        });

        //Upload
        /* Route::post('upload',[UploadController::class,'store']); */

    });
    
    
});
/* View home page */
Route::get('/',[HomeController::class,'index']);
Route::post('/services/loadProduct',[HomeController::class,'loadMore']);

/* Get product for quick view */
Route::get('/product/{id}',[HomeController::class,'getProductId'])->name('get-product-id');

Route::get('/about', function () {
    return view('pages/about');
})->name("about-us");

Route::get('/contact', function () {
    return view('pages/contact');
})->name("contact");

// Route::get('/product', function () {
//     return view('pages/product');
// })->name("product");
Route::get('product',[ProductController::class,'productPage']);


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/* Product detail page */
Route::get('/product-detail/{id}',[ProductController::class,'showDetail'])->name('product-detail');


Route::middleware(['auth'])->group(function(){

/* Add to cart */

Route::post('/add-cart',[CartController::class,'create']);

/* Show cart */
Route::get('/cart',[CartController::class,'show']);

/* Blog */
Route::get('/blog',[BlogController::class,'show']);
Route::get('/blog-detail/{id}',[AdminBlogController::class,'showDetail'])->name('blog-detail');

// Route::get('/contact', [EmailController::class, 'sendEmail']);
Route::post('/send-email', [EmailController::class, 'sendEmail']);
});


