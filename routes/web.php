<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

// トップ
Route::get('/', 'App\Http\Controllers\IndexController@index')->name('index');


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 利用規約
Route::get('/terms', function () {
    return Inertia::render('Terms');
})->name('terms');

// プライバシーポリシー
Route::get('/privacy', function () {
    return Inertia::render('Privacy');
})->name('privacy');

// require __DIR__.'/auth.php';
