<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/tasks', [App\Http\Controllers\TaskController::class, 'index']);
Route::get('/tasks/{task}', [App\Http\Controllers\TaskController::class, 'show']);
Route::get('/tasks/create', [App\Http\Controllers\TaskController::class, 'create']);
Route::post('/tasks', [App\Http\Controllers\TaskController::class, 'store']);
Route::put('/tasks/{task}', [App\Http\Controllers\TaskController::class, 'update']);
Route::delete('/tasks/{task}', [App\Http\Controllers\TaskController::class, 'destroy']);
