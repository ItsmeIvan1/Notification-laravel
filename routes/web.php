<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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


// Route::get('/', 'UserController@index')->name('list_user.index');
Route::get('/', [UserController::class, 'index']);

Route::post('/create', [UserController::class, 'create']);

Route::post('/notif', [UserController::class, 'Notification']);

Route::get('/History', [UserController::class, 'listOfNotifLogs'])->name('/history');



