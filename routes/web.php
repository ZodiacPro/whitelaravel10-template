<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\AuthorityController;
            

Route::get('/', [DashboardController::class, 'index'])->middleware('auth');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::post('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('/sign-in', [SessionsController::class, 'create'])->middleware('guest')->name('login');
Route::post('/sign-in', [SessionsController::class, 'store'])->middleware('guest');
Route::post('/verify', [SessionsController::class, 'show'])->middleware('guest');

Route::post('/sign-out', [SessionsController::class, 'destroy'])->middleware('auth')->name('logout');
Route::get('/profile', [ProfileController::class, 'create'])->middleware('auth')->name('profile');
Route::post('/profile', [ProfileController::class, 'create'])->middleware('auth')->name('profile');
Route::post('/profile/user-profile', [ProfileController::class, 'update'])->middleware('auth')->name('user-profile');

// user management 
Route::group(['middleware' => 'auth'], function () {
	Route::get('/superadmin/user-management/download/template', [ProfileController::class, 'downloadtemplate'])->name('usermanagement.download.template');
	Route::post('/superadmin/user-management/upload/template', [ProfileController::class, 'user_upload'])->name('usermanagement.upload.template');
	Route::get('/superadmin/user-management', [ProfileController::class, 'index'])->name('usermanagement.index');
	Route::post('/superadmin/user-management/upload/command', [ProfileController::class, 'update_user'])->name('usermanagement.upload.reset');

	Route::get('/superadmin/authority', [AuthorityController::class, 'authority'])->name('superadmin.authority');
	Route::post('/superadmin/authority', [AuthorityController::class, 'authority'])->name('superadmin.authority');
});