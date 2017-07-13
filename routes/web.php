<?php

/*
|--------------------------------------------------------------------------
| ADMIN Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
Route::group(array('prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['adminauth']), function () {

    Route::get('/',                         '\App\maguttiCms\Admin\Controllers\AdminPagesController@home');
    Route::get('/list/{section?}/{sub?}',   '\App\maguttiCms\Admin\Controllers\AdminPagesController@lista');
    Route::get('/create/{section}',         '\App\maguttiCms\Admin\Controllers\AdminPagesController@create');
    Route::post('/create/{section}',        '\App\maguttiCms\Admin\Controllers\AdminPagesController@store');


    Route::get('/edit/{section}/{id?}/{type?}', '\App\maguttiCms\Admin\Controllers\AdminPagesController@edit');
    Route::post('/edit/{section}/{id?}',        '\App\maguttiCms\Admin\Controllers\AdminPagesController@update');

	Route::get('/file_view/{section}/{id}/{key}', '\App\maguttiCms\Admin\Controllers\AdminPagesController@file_view');

    Route::get('/editmodal/{section}/{id?}/{type?}','\App\maguttiCms\Admin\Controllers\AdminPagesController@editmodal');
    Route::post('/editmodal/{section}/{id?}',       '\App\maguttiCms\Admin\Controllers\AdminPagesController@updatemodal');
    Route::get('/delete/{section}/{id?}',           '\App\maguttiCms\Admin\Controllers\AdminPagesController@destroy');

    Route::get('/duplicate/{section}/{id?}/{type?}', '\App\maguttiCms\Admin\Controllers\AdminPagesController@duplicate');

    /*
    |--------------------------------------------------------------------------
    | API
    |--------------------------------------------------------------------------
    */
    Route::group(array('prefix' => 'api'), function () {

        Route::get('update/{method}/{model?}/{id?}',        '\App\maguttiCms\Admin\Controllers\AjaxController@update');
        Route::get('delete/{model?}/{id?}',                 '\App\maguttiCms\Admin\Controllers\AjaxController@delete');

        /*
        |--------------------------------------------------------------------------
        | MEDIA LIBRARY
        |--------------------------------------------------------------------------
        */
        Route::post('uploadifiveSingle/',                    '\App\maguttiCms\Admin\Controllers\AjaxController@uploadifiveSingle');
        Route::post('uploadifiveMedia/',                    '\App\maguttiCms\Admin\Controllers\AjaxController@uploadifiveMedia');
        Route::get('updateHtml/media/{model?}','\App\maguttiCms\Admin\Controllers\AjaxController@updateModelMediaList');
        Route::get('updateHtml/{mediaType?}/{model?}/{id?}','\App\maguttiCms\Admin\Controllers\AjaxController@updateMediaList');
        Route::get('updateMediaSortList/',                  '\App\maguttiCms\Admin\Controllers\AjaxController@updateMediaSortList');

        Route::get('api/suggest', ['as' => 'api.suggest', 'uses' => '\App\maguttiCms\Admin\Controllers\AjaxController@suggest']);
    });
    Route::get('export/{model?}',               '\App\maguttiCms\Admin\Controllers\ExportController@model');
    Route::get('/exportlist/{section?}/{sub?}', '\App\maguttiCms\Admin\Controllers\AdminExportController@lista');

});

/*
|--------------------------------------------------------------------------
| ADMIN AUTH
|--------------------------------------------------------------------------
*/
Route::group(array('prefix' => 'admin'), function () {

    // Admin Auth and Password routes...
    Route::get('login',  '\App\maguttiCms\Admin\Controllers\Auth\LoginController@showLoginForm');
    Route::post('login', '\App\maguttiCms\Admin\Controllers\Auth\LoginController@login');
    Route::get('logout', '\App\maguttiCms\Admin\Controllers\Auth\LoginController@logout');


    // Password Reset Routes...
    Route::get('password/reset',         '\App\maguttiCms\Admin\Controllers\Auth\ForgotPasswordController@showLinkRequestForm');
    Route::post('password/email',        '\App\maguttiCms\Admin\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::get('password/reset/{token}', '\App\maguttiCms\Admin\Controllers\Auth\ResetPasswordController@showResetForm');
    Route::post('password/reset',        '\App\maguttiCms\Admin\Controllers\Auth\ResetPasswordController@reset');
});

/*
|--------------------------------------------------------------------------
| FRONT END
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => LaravelLocalization::setLocale()], function () {

    // Authentication routes...
    Route::get('users/login', '\App\maguttiCms\Website\Controllers\Auth\LoginController@showLoginForm')->name('users/login');
    Route::post('users/login','\App\maguttiCms\Website\Controllers\Auth\LoginController@login');
    Route::get('users/logout','\App\maguttiCms\Website\Controllers\Auth\LoginController@logout');

    // Registration routes...
    Route::get('/register', '\App\maguttiCms\Website\Controllers\Auth\RegisterController@showRegistrationForm');
    Route::post('/register','\App\maguttiCms\Website\Controllers\Auth\RegisterController@register');

    // Password Reset Routes...
    Route::get('password/reset',        '\App\maguttiCms\Website\Controllers\Auth\ForgotPasswordController@showLinkRequestForm');
    Route::post('password/email',       '\App\maguttiCms\Website\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::get('password/reset/{token}','\App\maguttiCms\Website\Controllers\Auth\ResetPasswordController@showResetForm');
    Route::post('password/reset',       '\App\maguttiCms\Website\Controllers\Auth\ResetPasswordController@reset');


    // Pages routes...
    Route::get('/',                     '\App\maguttiCms\Website\Controllers\PagesController@home');
    Route::get('/news/',                '\App\maguttiCms\Website\Controllers\PagesController@news');
    Route::get('/news/{slug}',          '\App\maguttiCms\Website\Controllers\PagesController@news');
    Route::get('/products/{product?}',	'\App\maguttiCms\Website\Controllers\ProductsController@products');
    Route::get('/contacts/',		    '\App\maguttiCms\Website\Controllers\PagesController@contacts');
    Route::post('/contacts/',		    '\App\maguttiCms\Website\Controllers\WebsiteFormController@getContactUsForm');

    Route::get('/test/{child}',                     '\App\maguttiCms\Website\Controllers\PagesController@test');

    Route::get('/{parent}/{child}', '\App\maguttiCms\Website\Controllers\PagesController@pages');
    Route::get('/{parent?}/', '\App\maguttiCms\Website\Controllers\PagesController@pages');


    // Api
    /* TODO   fix */
    Route::post('/api/newsletter',      '\App\maguttiCms\Website\Controllers\APIController@subscribeNewsletter');

});

/*
|--------------------------------------------------------------------------
|   RESERVED AREA USER ROUTES
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => LaravelLocalization::setLocale(),'middleware' => ['auth']], function () {
    Route::get('users/dashboard',    '\App\maguttiCms\Website\Controllers\ReservedAreaController@dashboard');
    Route::get('users/profile','\App\maguttiCms\Website\Controllers\ReservedAreaController@profile');
});
