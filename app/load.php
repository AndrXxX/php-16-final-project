<?php

session_start();

require_once 'core/functions.php';
require_once 'core/Session.php';
require_once 'core/Router.php';
require_once 'core/DataBase.php';
require_once 'core/Request.php';
require_once 'core/Messages.php';

Router::$base_route = 'error';

Router::get('/', 'QuestionsController@index', 'index');
Router::post('/', 'QuestionsController@store', 'index_store');

Router::get('/login/', 'UsersController@getLogin', 'login');
Router::post('/login/', 'UsersController@postLogin');
Router::get('/logout/', 'UsersController@getLogout', 'logout');

Router::resource('users', 'UsersController');
Router::resource('questions', 'QuestionsController');
Router::resource('categories', 'CategoriesController');

Router::get('/error/', 'QuestionsController@index', 'error');

$uriQuery = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
$uri = is_null($uriQuery) ? '/' : $uriQuery;

try {
    Router::run($uri);
    Session::Put('lastRouteName', Router::currentRouteName());
} catch (Exception $e) {
    Messages::setCriticalErrorAndRedirect($e->getMessage(), $e->getCode());
}


