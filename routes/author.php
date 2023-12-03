<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use Illuminate\Support\Facades\Redirect;

Route::prefix('author')->name("author")->group(function(){
    Route::middleware(['guest:web'])->group(function(){
        Route::view('/login', 'back.pages.auth.login')->name('Login');
        Route::view('/forgot-password','back.pages.auth.forgot')->name('forgot-password');
        Route::get('/password/reset/{token}',[AuthorController::class,'RestForm'])->name('reset-form');

    });
    Route::middleware(['auth:web'])->group(function(){
        Route::get('/home',[AuthorController::class,'index'])->name('home');
        Route::post('/logout',[AuthorController::class,'logout'])->name('logout');
        Route::view('/profile', 'back.pages.profile')->name('profile');
        Route::post('/change-profile-picture',[AuthorController::class,'ChangeProfilPicture'])->name('change-profile-picture');
        Route::view('/settings', 'back.pages.settings')->name('setting');
        Route::post('/change-blog-logo',[AuthorController::class,'changeBlogLogo'])->name('change-blog-logo');
        Route::post('/change-blog-favicon',[AuthorController::class,'changeFaviconLogo'])->name('change-blog-favicon');
        Route::view('/Authors', 'back.pages.authors')->name('Authors');
        Route::view('/categories', 'back.pages.categories')->name('categories');

        Route::middleware(['isAdmin'])->group(function(){
            Route::view('/settings', 'back.pages.settings')->name('setting');
            Route::post('/change-blog-logo',[AuthorController::class,'changeBlogLogo'])->name('change-blog-logo');
            Route::post('/change-blog-favicon',[AuthorController::class,'changeFaviconLogo'])->name('change-blog-favicon');
            Route::view('/Authors', 'back.pages.authors')->name('Authors');
            Route::view('/categories', 'back.pages.categories')->name('categories');
        });


        Route::prefix('posts')->name("posts")->group(function(){
            Route::view('/add-post','back.pages.add-post')->name('add-post');
            Route::Post('/create',[AuthorController::class,'createPost'])->name('createPost');
            Route::view('/all','back.pages.all_posts')->name('all-post');
            Route::get('/edit-post',[AuthorController::class,'EditPost'])->name('editPost');
            Route::Post('/update-post',[AuthorController::class,'UpdatePost'])->name('updatePost');

        });

        



    });
});


