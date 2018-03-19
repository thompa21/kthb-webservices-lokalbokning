<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api/v1/'], function ($router) {
    //Sätt alltid statiska routes(entries/search) före dynamiska(entries/{id})
    $router->get('login/','UserController@authenticate');

    $router->get('users','UserController@index');
    $router->get('users/{id}','UserController@getUser');      
    $router->post('users','UserController@createUser');
    $router->post('users/{id}','UserController@updateUser');    
    $router->delete('users/{id}','UserController@deleteUser');

    $router->get('checkJWT','JWTController@index');

    $router->get('events','EventController@index');
    $router->get('noauth/events','EventController@noauthindex');
    //$router->get('events/?Start_Date=2017-01-01 00:00:00&End_date=2017-02-01 00:00:00','EventController@index');
    $router->get('events/{id}','EventController@getEvent');      
    $router->get('noauth/events/{id}','EventController@noauthgetEvent');
    $router->post('events','EventController@createEvent');
    $router->post('events/{id}','EventController@updateEvent');    
    $router->delete('events/{id}','EventController@deleteEvent');
});
// /orders?sort=-created_at