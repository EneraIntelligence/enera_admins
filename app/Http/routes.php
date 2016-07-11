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
//        Route::get('/search', ['as' => 'search::campaign', 'uses' => 'CampaignsController@search']);
        Route::match(['get', 'post'], '/search', ['as' => 'search::campaign', 'uses' => 'CampaignsController@search']);
    });

    Route::group(['prefix' => 'profile', 'as' => 'profile::'], function () {
        Route::get('/', ['as' => 'index', 'uses' => 'UserController@index']);
    });
    /* Admin */
    Route::group(['prefix' => 'admin', 'as' => 'admin::'], function () {
        /* clients */
        Route::group(['prefix' => 'clients', 'as' => 'clients::'], function () {
            Route::get('/', ['as' => 'index', 'uses' => 'ClientsController@index']);
            Route::get('/show/{id}', ['as' => 'show', 'uses' => 'ClientsController@show']);
            Route::post('/search', ['as' => 'search', 'uses' => 'ClientsController@search']);
        });
    });

    Route::group(['prefix' => 'issuetracker', 'as' => 'issuetracker::'], function () {
        Route::get('/', ['as' => 'index', 'uses' => 'IssueTrackerController@index']);
        Route::get('/show/{id}', ['as' => 'show', 'uses' => 'IssueTrackerController@show']);
        Route::match(['get', 'post'], '/close/{id}', ['as' => 'close', 'uses' => 'IssueTrackerController@close']);
        Route::match(['get', 'post'], '/close_list', ['as' => 'close_list', 'uses' => 'IssueTrackerController@close_list']);
    });

    Route::group(['prefix' => 'network', 'as' => 'network::'], function () {
        Route::get('/', ['as' => 'index', 'uses' => 'NetworksController@index']);
        Route::get('/show/{id}', ['as' => 'show', 'uses' => 'NetworksController@show']);
        Route::post('/search', ['as' => 'search', 'uses' => 'NetworksController@search']);
    });

    Route::group(['prefix' => 'mailing', 'as' => 'mailing::'], function () {
        Route::get('/', ['as' => 'index', 'uses' => 'MassiveMailingController@index']);
        Route::get('/newlist', ['as' => 'newList', 'uses' => 'MassiveMailingController@newList']);
        Route::post('/createlist', ['as' => 'createList', 'uses' => 'MassiveMailingController@createList']);
        Route::get('/sendMail', ['as' => 'sendMail', 'sendMail' => 'MassiveMailingController@sendMail']);

    });

});

Route::group(['middleware' => 'auth.ready'], function () {
    Route::get('/login', ['as' => 'auth.index', 'uses' => 'AuthController@index']);
    Route::post('/login', ['as' => 'auth.login', 'uses' => 'AuthController@login']);
    Route::get('/register', ['as' => 'auth.register', 'uses' => 'AuthController@register']);//vista de registro
    Route::post('/restore', ['as' => 'auth.restore', 'uses' => 'AuthController@restore']);  //2do paso de recuperar contraseña
    Route::get('/restore/password/{id}/{token}', ['as' => 'auth.reset', 'uses' => 'AuthController@verify']); //3er paso de recuperar contraseña valida el token de nueva contraseña//    Route::get('/register/verify/{id}/{token}', ['as' => 'auth.verify', 'uses' => 'AuthController@verify']); //ruta que valida el correo
    Route::get('/restore/password', ['as' => 'auth.newpassword', 'uses' => 'AuthController@newpassword']);   //4to paso de recuperar contraseña vista para poner la nueva contraseña
    Route::post('/restore/password', ['as' => 'auth.newpass', 'uses' => 'AuthController@newpass']);         //5to paso de recuperar contraseña
    Route::get('/remove', ['as' => 'auth.remove', 'uses' => 'AuthController@remove']); //cancela los codigos del usuario que se pasa
});

Route::get('/unsubscribe/{email}', ['as' => 'unSubscribe', 'uses' => 'MassiveMailingController@unSubscribe']);
Route::post('/unsubscribe', ['as' => 'unSubscribe', 'uses' => 'MassiveMailingController@unSubscribe']);

Route::get('/choose', ['as' => 'choose.platform', function () {
    return view('choose', [
        'color' => '#d32f2f',
        'msg' => Input::has('msg') ? Input::get('msg') : 'Selecciona alguna de las plataformas.'
    ]);
}]);


//route for tests of emails
Route::get('/test-email', function () {
    return view('mail.kitmailing_banamex');
});
/*Route::get('/test', function () {
    return view('massivemail.unsubscribeok');
});*/

Route::get('/massive_mail/{skip}/{take}', ['as' => 'mail.massive', 'uses' => 'MassiveMailingController@sendMail']);