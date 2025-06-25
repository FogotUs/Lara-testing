<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Middleware\AuthenticateOnceWithBasicAuth;

Route::prefix('account')
    ->controller(AccountController::class)
    ->group(static function (): void {
        Route::post('/register','create');
        Route::post('/login','show')->middleware([AuthenticateOnceWithBasicAuth::class]);
        Route::get('/user/{user}','index')->middleware([AuthenticateOnceWithBasicAuth::class,'can:view,user']);
        Route::patch('/user/{user}/changepassword','update')->middleware(AuthenticateOnceWithBasicAuth::class);
    });

