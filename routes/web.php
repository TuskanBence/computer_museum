<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LabelController;
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
/*
Route::get('/', function () {
    return view('welcome');
});

Route::get('/posts', function () {
    return view('posts.index');
});

Route::get('/posts/create', function () {
    return view('posts.create');
});

Route::get('/posts/x', function () {
    return view('posts.show');
});

Route::get('/posts/x/edit', function () {
    return view('posts.edit');
});

// -----------------------------------------

Route::get('/categories/create', function () {
    return view('categories.create');
});

Route::get('/categories/x', function () {
    return view('categories.show');
});
*/

Route::get('/', function () {
    return redirect()->route('items.index');
});
Route::get('/home', function () {
    return redirect()->route('items.index');
});
Route::resource('labels', LabelController::class);
Route::resource('items', ItemController::class);
// -----------------------------------------

Auth::routes();


