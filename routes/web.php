<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DataController;
use App\Http\Middleware\CheckUser;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\JsonController;
use App\Http\Middleware\UserAuth;



Route::middleware(CheckUser::class)->group(function () {
    Route::get('/login', function () {
        return view('login');
    });


    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);

    Route::middleware(UserAuth::class)->group(function () {

        Route::get('/home', [UserController::class, 'index']);
        Route::get('/', [JsonController::class, 'index']);

        Route::get('/profile', function () {
            return view('profile');
        });

        Route::get('/chat/{id}/{fname}', function ($id, $fname) {
            return view('chat', ['id' => $id], ['fname' => $fname]);
        });

        Route::get('/logout', function () {
            Session::forget('user_id');
            return view('/login');
        });


        Route::post('/chat/store/{outgoing_msg_id}', [JsonController::class, 'store']);
        Route::get('/chat/data', [JsonController::class, 'data']);
        Route::get('/control', [DataController::class, 'control']);
    });
});
