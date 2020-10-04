<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/redis-test',function(){
    \Illuminate\Support\Facades\Cache::remember('test',60,function(){
       return 'data test';
    });
    return \Illuminate\Support\Facades\Cache::get('test');
});
