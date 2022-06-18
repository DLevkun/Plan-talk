<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/home/data', [App\Http\Controllers\HomeController::class, 'data'])->name('home.data');

Route::resource('/goals', App\Http\Controllers\GoalController::class)->names('goals');

Route::resource('/groups', App\Http\Controllers\GroupController::class)->names('groups');

Route::post('/user/description', [App\Http\Controllers\UserController::class, 'editDescription'])->name('editDescription');
Route::post('/user/info', [App\Http\Controllers\UserController::class, 'editUserInfo'])->name('editUserInfo');
Route::post('user/img', [App\Http\Controllers\UserController::class, 'uploadProfileImage'])->name('uploadFile');

Route::get('posts/category/{id}', [App\Http\Controllers\PostController::class, 'showCategoryPosts'])->name('categoryPosts');
Route::get('posts/new', [App\Http\Controllers\PostController::class, 'showNewPosts'])->name('showNewPosts');
Route::resource('/posts', App\Http\Controllers\PostController::class)->names('posts')->except(['index']);

Route::post('/subscribe/{id}', [App\Http\Controllers\GroupUserController::class, 'edit'])->name('subscribe.edit');
Route::resource('/subscribe', App\Http\Controllers\GroupUserController::class)->names('subscribe')->except(['edit']);

Route::delete('friends/unfollow/{id}', [App\Http\Controllers\FriendController::class, 'destroySearch'])->name('destroySearch');
Route::patch('friends/follow/{id}', [App\Http\Controllers\FriendController::class, 'followSearch'])->name('followSearch');
Route::patch('friends/{id}/follow', [App\Http\Controllers\FriendController::class, 'follow'])->name('friends.follow');
Route::post('friends/search', [App\Http\Controllers\FriendController::class, 'search'])->name('friends.search');
Route::resource('/friends', App\Http\Controllers\FriendController::class)->names('friends');//->except(['store', 'create', 'update', 'edit']);

Route::post('comment/{id}', [App\Http\Controllers\CommentController::class, 'comment'])->name('comment');
Route::delete('comment/{id}/delete', [App\Http\Controllers\CommentController::class, 'deleteComment'])->name('deleteComment');

Route::get('locale/{lang}', [App\Http\Controllers\HomeController::class, 'changeLocale'])->name('changeLocale');
