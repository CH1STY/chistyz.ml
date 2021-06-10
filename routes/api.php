<?php

Route::group([

'middleware' => 'api',
'prefix' => 'auth'

], function () {

    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');



});

Route::group([

'middleware' => 'api',
'prefix' => 'admin'

], function () {

    Route::post('addCat','AdminController@addCategory');
    Route::get('getCat','AdminController@getCategory');
    Route::get('deleteCat/{id}','AdminController@deleteCategory');
    Route::get('editCat/{id}','AdminController@editCategory');
    Route::post('editCat/{id}','AdminController@editCategoryVerify');

    Route::get('category/fetchCat', 'UserController@fetchCat');
    Route::resource('product', 'ProductController' );



});

Route::group([

'middleware' => 'api',
'prefix' => 'user'

], function () {


    Route::post('addTodo','UserController@addTodo');
    Route::get('getTodo','UserController@getTodo');
    Route::post('deleteTodo/{id}','UserController@deleteTodo');

    


});

Route::post('password-reset','PasswordController@index');
Route::post('password-reset/confirm','PasswordController@passwordResetVerify');
Route::get('token-validation/{token}','PasswordController@tokenValidate');

Route::get('home-carousel','HomeController@getCarousel');

Route::get('client-ip','HomeController@getIp');