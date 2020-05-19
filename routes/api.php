<?php

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Resources\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['as' => 'api.users.', 'namespace' => 'Api'], function() {
    Route::get('users', 'UserController@index')->name('index');
    Route::post('users', 'UserController@store')->name('store');
    Route::get('users/{user}', 'UserController@edit')->name('edit');
    Route::put('users/{user}', 'UserController@update')->name('update');
    Route::delete('users/{user}', 'UserController@delete')->name('delete');
});
//Route::resource('users', 'Api\UserController', ['as' => 'api', 'prefix' => 'api'])->except('show');;
