<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

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

Route::view('/register', 'users.register')->name('register')->middleware('guest');

Route::get('/', function () {
    return view('users.login');
})->name('login')->middleware('guest');

Route::get('/dashboard', function () {
    return view('users.index');
})->name('dashboard')->middleware('auth');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::get('/logout-and-redirect', [AuthenticatedSessionController::class, 'logoutAndRedirectToLogin'])->name('logoutAndRedirectToLogin');
