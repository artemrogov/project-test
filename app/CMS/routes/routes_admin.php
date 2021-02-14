<?php

use App\CMS\Http\PagesController;
use Illuminate\Support\Facades\Route;


Route::name('cms.')->prefix('cms')->group(function ()
{
    Route::get('/',[PagesController::class,'index'])
        ->name('page.index');

    Route::get('/categories',[PagesController::class,'categories'])
        ->name('page.categories');

    Route::get('/help',[PagesController::class,'help_page'])
        ->name('page.help');

    Route::get('/users/{id}',[PagesController::class,'users'])
    ->where('id','[0-9]+')
    ->name('users.list');

});
