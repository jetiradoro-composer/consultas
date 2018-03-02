<?php

Route::group(['middleware' => ['web','user'], 'prefix' => 'consultes', 'namespace' => 'Modules\Consultas\Http\Controllers'], function()
{
    Route::get('/', [
        'as' => 'module.consultes',
        'uses' => 'ConsultasController@index',
    ]);

    //API
    Route::get('/tables','ConsultasController@getTables');

    Route::post('/set-query/{excel?}', [
        'as' => 'consultas.set-query',
        'uses' => 'ConsultasController@setQuery',
    ]);
});
