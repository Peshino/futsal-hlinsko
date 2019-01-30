<?php
Route::get('/tasks', 'TasksController@index');
Route::get('/tasks/{task}', 'TasksController@show');

Route::get('posts', 'PostsController@index');
Route::get('posts/{post}', 'PostsController@show');
Route::get('/post/create', 'PostsController@create');
Route::post('/store-posts', 'PostsController@store');

Route::post('/post/{post}/comments', 'CommentsController@store');

// Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/register', 'Auth\RegisterController@create')->name('register');
Route::post('/register', 'Auth\RegisterController@store');

Route::get('/login', 'Auth\LoginController@create');
Route::post('/login', 'Auth\LoginController@store')->name('login');
Route::post('/logout', 'Auth\LoginController@destroy')->name('logout');
