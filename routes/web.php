<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LatestNewsController;
// use App\Http\Controllers\NewsApiController;

use App\Http\Controllers\Auth\{
    AdminController,
    AdminDashboardController
};

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

Route::get('/', function () {     return view('welcome'); });

// Route::get('/news/{source}', [NewsApiController::class,'getFreshNews'])->name('news');


Route::prefix('admin/')->group(function () {
    Route::get('/', [AdminController::class,'index'])->name('admin.login');
    Route::get('login', [AdminController::class,'index'])->name('admin.login');
    Route::post('adminLogin',[AdminController::class,'adminLogin'])->name('adminLogin');
    Route::get('logout', [AdminController::class, 'logout'])->name('adlogout');

    Route::prefix('dashboard/')->middleware(['auth:admin'])->group(function () {
        Route::get('/', [AdminDashboardController::class,'index'])->name('adhome');

        Route::get('/newsfeed', [LatestNewsController::class,'index'])->name('newsfeed');
        Route::get('/update/newsfeed/{action}/{id}', [LatestNewsController::class,'newsOperation'])->name('newsStatus');
    });

});