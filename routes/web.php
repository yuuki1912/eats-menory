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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//メインページ一覧表示
Route::get('/eats', 'EatsController@index')->name('eats.index');
//マイページ投稿一覧表示
Route::get('/eats/myPage', 'EatsController@myPage')->name('eats.myPage');
//投稿内容作成
Route::get('/eats/create', 'EatsController@create')->name('eats.create');
//投稿
Route::post('/eats', 'EatsController@store')->name('eats.store');
//投稿の詳細
Route::get('/eats/{post}', 'EatsController@show')->name('eats.show');
//投稿の編集
Route::get('/eats/{post}/edit', 'EatsController@edit')->name('eats.edit');
//投稿の更新
Route::PATCH('/eats/{post}', 'EatsController@update')->name('eats.update');
//削除
Route::delete('/eats/{post}', 'EatsController@destroy')->name('eats.destroy');

//コメント機能
Route::resource('comments', 'CommentController');

//プロフィールの編集
Route::get('eats/myPage/userEdit', 'EatsController@userEdit')->name('eats.userEdit'); 
//プロフィールの更新
Route::patch('eats/myPage/userEdit', 'EatsController@userUpdate')->name('eats.userUpdate'); 

//パスワード編集
Route::get('eats/myPage/userEdit/change', 'ChangePasswordController@pasEdit');
//パスワード更新
Route::patch('eats/myPage/userEdit/change','ChangePasswordController@pasUpdate')->name('eats.change');

//ログアウト
Route::post('eats/myPage/userDelete', 'EatsController@userDelete')->name('eats.userDelete');

//いいね機能
Route::get('/eats/{post}/favorites', 'FavoriteController@store')->name('favorites');
Route::get('/eats/{post}/unfavorites', 'FavoriteController@destroy')->name('unfavorites');
Route::get('eats/{post}/countfavorites', 'FavoriteController@count');
Route::get('eats/{post}/hasfavorites', 'FavoriteController@hasfavorite');
