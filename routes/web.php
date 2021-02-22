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


Route::get('/test-q',function (){

    $user = \App\Models\User::first();

    /*dispatch(function(){
      logger('Hello first queue');
    })->delay(now()->addMinutes(1));*/

    //throw new Exception("test!");

    //dispatch(new \App\Jobs\LearnJobQueue($user))->onQueue('users_test');

    //$p = 17;

    //\App\Jobs\LearnJobQueue::dispatchIf($p > 11,$user)->onQueue('users');

    //\App\Jobs\LearnJobQueue::dispatch($user)->onQueue('user');

    //throw new \Exception("error test!");

    \App\Jobs\TestJob1::dispatch()->onQueue('test_job1');

    return "ok";
});

Route::get('/pipeline',function (){

   $pipeline = app(\Illuminate\Pipeline\Pipeline::class);

   $pipeline->send('hello world!')->through(
    []
   )->then(function ($string){
       dump($string);
   });

   return "ok pipeline!";

});
