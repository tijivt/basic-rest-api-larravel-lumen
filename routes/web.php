<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
p|
*/


$router->get('/', function () use ($router) {
    return $router->app->version();
});

//protected routes

$router->group(['prefix' => 'api','middleware' => 'auth'], function () use ($router) {

    $router->post('articles', ['uses' => 'ArticleController@create']);

    $router->delete('articles/{id}', ['uses' => 'ArticleController@delete']);

    $router->put('articles/{id}', ['uses' => 'ArticleController@update']);


});

//public routes

$router->group(['prefix' => 'api'], function () use ($router) {


    $router->post('register',  ['uses' => 'UserController@register']);
    $router->post('login',  ['uses' => 'UserController@login']);
    $router->get('articles',  ['uses' => 'ArticleController@showAllArticles']);

    $router->get('articles/{id}', ['uses' => 'ArticleController@showOneArticle']);


});
