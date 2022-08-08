<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DataController;
use App\Http\Middleware\CheckUser;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\JsonController;
use App\Http\Middleware\UserAuth;
use Illuminate\Support\Facades\Crypt;

Route::middleware(CheckUser::class)->group(function () {
    Route::get('/login', function () {
        return view('login');
    });

    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);

    Route::middleware(UserAuth::class)->group(function () {

        Route::get('/home', [UserController::class, 'index']);
        //Route::get('/', [JsonController::class, 'index']);

        Route::get('/profile', function () {
            return view('profile');
        });

        Route::get('/delete', function () {
            return view('/delete');
        });

        Route::get('/logout', function () {
            Session::forget('user_id');
            return view('/login');
        });

        Route::get('/chat/{id}/{fname}', function ($id, $fname) {
            return view('/chat', ['id' => Crypt::decrypt($id)], ['fname' => Crypt::decrypt($fname)]);
        });

        Route::post('/chat/get/{outgoing_id}', [JsonController::class, 'get']);
        Route::get('/delete/{id}', [JsonController::class, 'delete']);


        Route::post('/chat/store/{outgoing_id}', [JsonController::class, 'store']);
        // Route::get('/control', [DataController::class, 'control']);
    });
});
