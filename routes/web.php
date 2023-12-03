<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*Route::get('/', function () {
    return view('front.pages.example');
});*/
Route::view('/','front.pages.home')->name('home');
Route::get('/article/{any}',[BlogController::class,'readPost'])->name('read_post');
Route::get('/category/{any}',[BlogController::class,'CategoryPost'])->name('category_post');
Route::get('/posts/tag/{any}',[BlogController::class,'tagPost'])->name('tag_post');
Route::get('/search',[BlogController::class,'searchPost'])->name('search_post');
Route::get('/contact',[BlogController::class,'contact'])->name('contact');
Route::post('/contact', [BlogController::class, 'sendMail'])->name('contact.store');








