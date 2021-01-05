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

Route::get('/documents-page',[\App\Http\Controllers\DocumentsController::class,'getPageDocumentsList'])
    ->name('page.documents');



Route::get('/documents-dump',[\App\Http\Controllers\DocumentsController::class,'dumpDocuments'])
    ->name('documents.dump.casts');
