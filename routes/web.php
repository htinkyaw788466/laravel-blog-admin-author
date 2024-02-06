<?php

use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\ClientPostController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Author\PostControllers;
use App\Http\Controllers\NormalAuthorController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Author\AuthorDashboardController;
use App\Http\Controllers\Admin\FavoriteControllers;
use App\Http\Controllers\Author\SettingControllers;
use App\Http\Controllers\Admin\SubscriberControllers;
use App\Http\Controllers\Author\FavoriteControllerss;
use App\Http\Controllers\Admin\AdminCommentController;
use App\Http\Controllers\Author\AuthorCommentController;
use App\Http\Controllers\SearchController;

Route::get('/',([HomeController::class,'index']))
       ->name('mainhome');

Route::post('subscriber',([SubscriberController::class,'store']))
       ->name('subscriber.store');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('posts',([ClientPostController::class,'index']))
       ->name('post.index');

Route::get('post/{slug}',([ClientPostController::class,'show']))
       ->name('post.show');

Route::get('/category/{slug}',([ClientPostController::class,'postCategory']))
       ->name('category.posts');

Route::get('/tag/{slug}',([ClientPostController::class,'postTag']))
       ->name('tag.posts');

Route::get('/search',([SearchController::class,'search']))
    ->name('search');

Route::get('profile/{username}',([NormalAuthorController::class,'profile']))
       ->name('author.profile');

//route group for user
Route::group(['middleware'=>['auth']],function(){
    Route::post('favorite/{post}/add',([FavoriteController::class,'add']))
           ->name('post.favorite');

    Route::post('comment/{post}',([CommentController::class,'store']))
    ->name('comment.store');


});

//route group for admin
Route::group([
    'as' => 'admin.', 'prefix' => 'admin', 'namespace' => 'Admin',
    'middleware' => ['auth', 'admin']
], function () {

    Route::get('dashboard', ([DashboardController::class, 'index']))
        ->name('dashboard');

    //setting route
    Route::get('settings',([SettingController::class,'index']))
           ->name('settings');

    Route::put('profile-update',([SettingController::class,'updateProfile']))
           ->name('profile.update');

    Route::put('password-update',([SettingController::class,'updatePassword']))
           ->name('password.update');

    //Tag Section Route
    //tag list
    Route::get('/tag', ([TagController::class, 'index']))
        ->name('tag.index');

    //tag form
    Route::get('/tag/create', ([TagController::class, 'create']))
        ->name('tag.create');

    //validate tag
    Route::post('tag/create', ([TagController::class, 'store']))
        ->name('tag.store');

    //edit tag form
    Route::get('/tag/{id}/edit', ([TagController::class, 'edit']))
        ->name('tag.edit');

    //validate tag update
    Route::put('/tag/{id}/update', ([TagController::class, 'update']))
        ->name('tag.update');

    //delete tag
    Route::delete('/tag/{id}/destroy', ([TagController::class, 'destroy']))
        ->name('tag.destroy');

    //Categories Section Route
    //category list
    Route::get('/category', ([CategoryController::class, 'index']))
        ->name('category.index');

    //category form
    Route::get('/category/create', ([CategoryController::class, 'create']))
        ->name('category.create');

    //validate category
    Route::post('category/create', ([CategoryController::class, 'store']))
        ->name('category.store');

    //edit category form
    Route::get('/category/{id}/edit', ([CategoryController::class, 'edit']))
        ->name('category.edit');

    //validate category update
    Route::put('/category/{id}/update', ([CategoryController::class, 'update']))
        ->name('category.update');

    //delete category
    Route::delete('/category/{id}/destroy', ([CategoryController::class, 'destroy']))
        ->name('category.destroy');


    //Post Section Route
    //post list
    Route::get('/post', ([PostController::class, 'index']))
        ->name('post.index');

    //post form
    Route::get('/post/create', ([PostController::class, 'create']))
        ->name('post.create');

    //validate post
    Route::post('post/create', ([PostController::class, 'store']))
        ->name('post.store');

    //edit post form
    Route::get('/post/{post}/edit', ([PostController::class, 'edit']))
        ->name('post.edit');

    //validate post update
    Route::put('/post/{post}/update', ([PostController::class, 'update']))
        ->name('post.update');

    //show single post
    Route::get('/post/{post}/show', ([PostController::class, 'show']))
    ->name('post.show');

    //delete post
    Route::delete('/post/{post}/destroy', ([PostController::class, 'destroy']))
        ->name('post.destroy');

    //pending and approve post
    Route::get('pending/post',([PostController::class,'pending']))
           ->name('post.pending');
    Route::put('post/{id}/approve',([PostController::class,'approval']))
           ->name('post.approve');

    //favorite post
    Route::get('/favorite',([FavoriteControllers::class,'index']))
           ->name('favorite.index');

    //subscriber email list and destroy
    Route::get('/subscriber',([SubscriberControllers::class,'index']))
           ->name('subscriber.index');
    Route::delete('/subscriber/{subscriber}',([SubscriberControllers::class,'destroy']))
           ->name('subscriber.destroy');

    //post comment route
    Route::get('/comments',([AdminCommentController::class,'index']))
           ->name('comment.index');
    Route::delete('/comments/{id}',([AdminCommentController::class,'destroy']))
           ->name('comment.destroy');

    //author route
    Route::get('/author',([AuthorController::class,'index']))
          ->name('author.index');
    Route::delete('/author/{id}',([AuthorController::class,'destroy']))
           ->name('author.destroy');
});


//route group for author
Route::group([
    'as' => 'author.', 'prefix' => 'author', 'namespace' => 'Author',
    'middleware' => ['auth', 'author']
], function () {

    Route::get('dashboard', ([AuthorDashboardController::class, 'index']))
        ->name('dashboard');

    //setting route
    Route::get('settings',([SettingControllers::class,'index']))
    ->name('settings');

    Route::put('profile-update',([SettingControllers::class,'updateProfile']))
        ->name('profile.update');

    Route::put('password-update',([SettingControllers::class,'updatePassword']))
        ->name('password.update');


    //Post Section Route
    //post list
    Route::get('/post', ([PostControllers::class, 'index']))
        ->name('post.index');

    //post form
    Route::get('/post/create', ([PostControllers::class, 'create']))
        ->name('post.create');

    //validate post
    Route::post('post/create', ([PostControllers::class, 'store']))
        ->name('post.store');

    //edit post form
    Route::get('/post/{post}/edit', ([PostControllers::class, 'edit']))
        ->name('post.edit');

    //validate post update
    Route::put('/post/{post}/update', ([PostControllers::class, 'update']))
        ->name('post.update');

    //show single post
    Route::get('/post/{post}/show', ([PostControllers::class, 'show']))
    ->name('post.show');

    //delete post
    Route::get('/post/{post}/destroy', ([PostControllers::class, 'destroy']))
        ->name('post.destroy');

    //favorite post
    Route::get('/favorite',([FavoriteControllerss::class,'index']))
           ->name('favorite.index');

    //post comment route
    Route::get('/comments',([AuthorCommentController::class,'index']))
    ->name('comment.index');
    Route::delete('/comments/{id}',([AuthorCommentController::class,'destroy']))
        ->name('comment.destroy');
});


View::composer('layouts.frontend.partials.footer',function($view){
    $categories = App\Models\Category::all();
    $view->with('categories',$categories);

    });
