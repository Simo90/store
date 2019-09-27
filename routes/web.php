<?php

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

Auth::routes();

Route::get('/', 'ProductController@homePage');

Route::get('product/{id}', 'ProductController@show');
Route::get('product/{id}/getReviews', 'ProductController@getReviews');

Route::resource('review', 'ReviewController')->only([
    'store', 'update', 'destroy'
]);

Route::get('/changePassword','Auth\ChangePasswordController@showForm')->middleware('auth');
Route::post('/changePassword','Auth\ChangePasswordController@changePassword')->middleware('auth')->name('changePassword');

Route::group( [ 'prefix' => config('app.admincp'), 'middleware' => ['auth']], function () {

    Route::resource('products', 'ProductController')->except([
        'show'
    ]);
});