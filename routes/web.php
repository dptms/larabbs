<?php

Route::get('/', 'PagesController@root')->name('root');

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

// Users Routes...
Route::resource('users', 'UsersController', ['only' => ['show', 'edit', 'update']]);

//Topics Routes...
Route::resource('topics', 'TopicsController', ['only' => ['index', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::post('/topics/upload_image', 'TopicsController@upload_image')->name('topics.upload_image');
Route::get('/topics/{topic}/{slug?}', 'TopicsController@show')->name('topics.show');

//Categories Routes...
Route::resource('categories', 'CategoriesController', ['only' => ['show']]);

//Replies Routes...
Route::resource('replies', 'RepliesController', ['only' => ['store','destroy']]);

Route::get('test',function(Faker\Generator $faker){
});