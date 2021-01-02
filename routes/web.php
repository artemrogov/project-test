<?php

use Illuminate\Support\Facades\Route;
//use \App\Http\Controllers\PagesController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/redis-test',function(){
    \Illuminate\Support\Facades\Cache::remember('test',60,function(){
       return 'data test';
    });
    return \Illuminate\Support\Facades\Cache::get('test');
});

// this namespace web.php
//Route::get('/test-page',[PagesController::class,'index']);

// if define namespace in RouteServiceProvider.php:
Route::get('/test-page','PagesController@index')
    ->name('test.namespace.routing');

// services providers and facades

Route::get('/test-facade01',[\App\Http\Controllers\FilesUsersController::class,'testPage']);

Route::get('/test-facade02',[\App\Http\Controllers\FilesUsersController::class,'getTest02']);

Route::get('/import-documents',[\App\Http\Controllers\DocumentsController::class,'getParseDocument']);

Route::get('/documents',[\App\Http\Controllers\DocumentsController::class,'getDocuments']);

//getDocuments

// test mail send visualization

Route::get('/test-send-mail',function(){
   return  new \App\Mail\SendUsers('test browser!');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


Route::resource('/documents',AdminDocumentsController::class);


Route::get('/test-form',function()
{
    return view('livewire.document-view');
});
