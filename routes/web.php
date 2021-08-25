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

Route::resource('posts', PostsController::class);

Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index']);
