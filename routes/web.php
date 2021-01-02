<?php


use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});


Auth::routes([
    'login'=>true,
    'register'=>false,
    'reset'=>false
]);

Route::get('/home',
    [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home');

Route::resource('/documents',Admin\DocumentsController::class);

