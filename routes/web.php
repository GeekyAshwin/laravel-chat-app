<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CallController;


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



Route::get('/', [ChatController::class, 'index']);
Route::post('login', [UserController::class, 'login'])->name('login');
Route::resource('/message', 'App\Http\Controllers\MessageController');
Route::get('/user-messages', [MessageController::class, 'loadMessages'])->name('loadMessages');

#Call Routes
Route::post('make-call', [CallController::class, 'makeCall'])->name('make-call');
Route::post('accept-call', [CallController::class, 'acceptCall'])->name('accept-call');
Route::post('reject-call', [CallController::class, 'rejectCall'])->name('reject-call');
Route::post('end-call', [CallController::class, 'endCall'])->name('end-call');
Route::post('logout', [UserController::class, 'logout'])->name('logout');
Route::get('invite-link/{chat_code}', [UserController::class, 'showChatPage']);
