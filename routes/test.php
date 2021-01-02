<?php
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function(){
    Route::get('/home-admin','Administrator@dashboard');
    Route::get('/test-page','Administrator@settingsPage');
    Route::get('/user-page/{user}','Administrator@userPage');
});
