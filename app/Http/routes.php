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
| Please avoid in using closure in route, or else route caching while failed.
| To make the route become most effective and easy to maintain,
| all route should be using route group and config namespace and prefix in the route group.
| All route should be named
*/

// All the API endpoint should be here.
Route::group(['namespace' => 'API', 'prefix' => 'api'], function () {

});
