<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/product_list', function () {
    return view('product_list');
});
Route::get('/products/all', [App\Http\Controllers\ProductController::class, 'allProducts']);
Route::get('/products/delete/{id}', [App\Http\Controllers\ProductController::class, 'delete']);
Route::post('/products/store', [App\Http\Controllers\ProductController::class, 'store']);
Route::resource('products', ProductController::class);
Route::resource('categories', CategoryController::class);
Route::resource('subcategories', SubCategoryController::class);
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/product_list', [App\Http\Controllers\ProductController::class, 'product_list']);
Route::post('/product_list', [App\Http\Controllers\ProductController::class, 'filterProduct']);
Route::get('/product/add', [App\Http\Controllers\ProductController::class, 'addProductPage']);
Route::post('/product/add', [App\Http\Controllers\ProductController::class, 'addProduct']);
Route::get('/product_list/ajax', [App\Http\Controllers\ProductController::class, 'product_list_ajax']);
