<?php

App::bind('\App\Billing\Stripe', function() {
  return new \App\Billing\Stripe(config('services.stripe.secret'));
});

$stripe = resolve('App\Billing\Stripe');

dd($stripe);

Route::get('/tasks', 'TasksController@index');
Route::get('/tasks/{task}', 'TasksController@show');

Route::get('posts', 'PostsController@index')->name('home');
Route::get('posts/{post}', 'PostsController@show');
Route::get('/post/create', 'PostsController@create');
Route::post('/store-posts', 'PostsController@store');

Route::post('/post/{post}/comments', 'CommentsController@store');

// Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/register', 'RegistrationController@create');
Route::post('/register', 'RegistrationController@store');

Route::get('/login', 'SessionsController@create');
Route::post('/login', 'SessionsController@store');
Route::get('/logout', 'SessionsController@destroy');
