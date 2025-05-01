<?php

use App\Http\Controllers\studentController;
use App\Http\Controllers\TestController;
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



Route::get('/', [TestController::class, 'index'])->name('test.index');
Route::get('/profiles', [TestController::class, 'view'])->name('test.view');
Route::post('/test',[TestController::class, 'store'])->name('test.store');

Route::get('/student', [studentController::class, 'index'])->name('student.index');
Route::get('/student/view', [studentController::class, 'view'])->name('student.view');
Route::post('/student/store', [studentController::class, 'store'])->name('student.store');
