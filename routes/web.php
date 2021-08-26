<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;

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

Route::get('/about', function () {
    return view('pages.about');
});

// Posts
Route::post('posts/upvote/{id}', ['uses' => 'App\Http\Controllers\PostsController@upvote']);
Route::post('posts/downvote/{id}', ['uses' => 'App\Http\Controllers\PostsController@downvote']);
Route::get('posts/comment/{id}', ['uses' => 'App\Http\Controllers\PostsController@comment']);
Route::post('posts/comment/{id}', ['uses' => 'App\Http\Controllers\PostsController@createComment']);

Route::resource('posts', PostsController::class);

// Auth
Auth::routes();

// Dashboard
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index']);
