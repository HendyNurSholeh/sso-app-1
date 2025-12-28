<?php

use App\Http\Controllers\SSOController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [SSOController::class, 'redirect'])->name('login');
Route::get('/callback', [SSOController::class, 'callback']);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    });
});

Route::get('/logout', function () {
    Auth::logout();

    $logoutUrl =
        config('services.keycloak.base_url')
        . '/realms/' . config('services.keycloak.realm')
        . '/protocol/openid-connect/logout'
        . '?post_logout_redirect_uri=' . url('/');

    return redirect($logoutUrl);
});

