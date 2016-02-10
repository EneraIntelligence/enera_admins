<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => ['auth', 'guardian', 'preview']], function () {
    Route::get('/', ['as' => 'home', 'uses' => 'DashboardController@index']);
    Route::match(['post', 'get'], '/logout', ['as' => 'auth.logout', 'uses' => 'AuthController@logout']);

    Route::group(['prefix' => 'campaigns', 'as' => 'campaigns::'], function () {
        Route::get('/', ['as' => 'index', 'uses' => 'CampaignsController@index']);
        Route::get('/view/{id}', ['as' => 'show', 'uses' => 'CampaignsController@show']);
        Route::get('/admin/{id}', ['as' => 'admin::campaign', 'uses' => 'CampaignsController@admin']);
        Route::get('/active/{id}', ['as' => 'active::campaign', 'uses' => 'CampaignsController@active']);
        Route::match(['get', 'post'], '/reject', ['as' => 'reject::campaign', 'uses' => 'CampaignsController@reject']);
    });

    Route::group(['prefix' => 'profile', 'as' => 'profile::'], function () {
        Route::get('/', ['as' => 'index', 'uses' => 'UserController@index']);
    });

});

Route::group(['middleware' => 'auth.ready'], function () {
    Route::get('/login', ['as' => 'auth.index', 'uses' => 'AuthController@index']);
    Route::post('/login', ['as' => 'auth.login', 'uses' => 'AuthController@login']);
});

Route::get('/choose', ['as' => 'choose.platform', function () {
    return view('choose', [
        'color' => '#d32f2f',
        'msg' => Input::has('msg') ? Input::get('msg') : 'Selecciona alguna de las plataformas.'
    ]);
}]);