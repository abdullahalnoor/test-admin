<?php

use Illuminate\Support\Facades\Route;

use  App\Http\Controllers\Admin\CategoryController;
use  App\Http\Controllers\Admin\ProductController;

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
    return view('admin.dashboard.index');
    return view('backend.app');
    return view('welcome');
});


// Route::group(['prefix'=>'admin','as'=>'admin.','middleware'=>'auth'], function(){
    Route::group(['prefix'=>'admin','as'=>'admin.'], function(){
    Route::resource('category', CategoryController::class);
    Route::resource('product', ProductController::class);
    
    // Route::get('/dashboard', function () {
    //         return view('admin.home.index');
    //     })->name('dashboard');
    // Route::get('/', ['as' => 'index', 'uses' => 'AccountController@index']);
    // Route::get('connect', ['as' => 'connect', 'uses' = > 'AccountController@connect']);
});




