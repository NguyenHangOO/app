<?php

use App\Http\Controllers\admim\AdminController;
use App\Http\Controllers\admim\TaskController;
use App\Http\Controllers\login\LoginController;
use Illuminate\Support\Facades\Route;

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

/*Route::get('/', function () {
    return view('welcome');
});*/
Route::get('/',[LoginController::class,'index'])->name('login');
Route::post('/',[LoginController::class, 'store'])->name('store');
Route::middleware(['auth'])->group(function (){
    Route::get('admin',[AdminController::class,'index'])->name('admin');
    Route::get('logout',[AdminController::class,'logout'])->name('logout');
    #NguoiDung
    Route::prefix('user')->group(function (){
        Route::get('/',[AdminController::class,'users'])->name('users');
        Route::get('adduser',[AdminController::class,'create'])->name('add_users');
        Route::post('adduser',[AdminController::class,'store']);
        Route::get('edit/{u}',[AdminController::class,'show']);
        Route::post('edit/{u}',[AdminController::class,'update']);
        Route::DELETE('destroy',[AdminController::class,'destroy']);
        Route::get('grant/{u}',[AdminController::class,'grant']);
        Route::get('lock/{u}',[AdminController::class,'lock']);
        Route::get('unlock/{u}',[AdminController::class,'unlock']);
        Route::post('up_profile',[AdminController::class,'up_profile'])->name('up_profile');
        Route::post('up_pass',[AdminController::class,'up_pass'])->name('up_pass');
    });
    #Nhiem vu
    Route::prefix('task')->group(function (){
        Route::get('/',[TaskController::class,'index'])->name('tasks');
        Route::get('addtask',[TaskController::class,'create'])->name('add_tasks');
        Route::post('addtask',[TaskController::class,'store']);
        Route::get('edit/{t}',[TaskController::class,'show']);
        Route::post('edit/{t}',[TaskController::class,'update']);
        Route::post('check',[TaskController::class,'check'])->name('check');
    });
});
