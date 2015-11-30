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


// put all routes in a group to define the API version
// url therefore is for instance '/api/v0.1/makers'
Route::group(array('prefix' => 'api/v0.1'), function() {

    Route::resource('files', 'FileController', ['except' => ['create','edit']]);

	Route::resource('makers', 'MakerController', ['except' => ['create','edit']]);

	Route::resource('vehicles', 'VehicleController', ['only' => ['index']]);

	Route::resource('makers.vehicles', 'MakerVehiclesController', ['except' => ['edit', 'create']]);

	Route::get('vehicles/full', 'VehicleController@vehiclesFull');
	Route::get('vehicles/full/{id}', 'VehicleController@vehiclesFull');


    Route::post('oauth/access_token', function() {
        return response()->json(Authorizer::issueAccessToken());
    });

});

