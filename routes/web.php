<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth']], function(){

    Route::get('/', [App\Http\Controllers\VideoController::class,'index']);

    Route::get('/uploader', [App\Http\Controllers\VideoController::class,'uploader'])->name('uploader');

    Route::post('/upload', [App\Http\Controllers\VideoController::class,'store'])->name('upload');
});

Auth::routes();




// Route::get('/',
//     function(){
//         return view('welcome');
//     }
// )->name('/');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
