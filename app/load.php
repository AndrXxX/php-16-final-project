<?php

session_start();

require_once 'core/functions.php';
require_once 'core/Session.php';
require_once 'core/Router.php';
require_once 'core/DataBase.php';
require_once 'core/Request.php';
require_once 'core/Messages.php';

Router::get('/', 'QuestionsController@index', 'index');
Router::post('/', 'QuestionsController@store');

Router::get('/login/', 'UsersController@getLogin', 'login');
Router::post('/login/', 'UsersController@postLogin');
Router::get('/logout/', 'UsersController@getLogout', 'logout');

Router::resource('users', 'UsersController');
Router::resource('questions', 'QuestionsController');
Router::resource('categories', 'CategoriesController');

//Router::get('/question/update/id/(\d+)/', 'QuestionsController@update', ['id' => 1]);

/*preg_match('(^' . '/question/update/(\d+)/' . '$)', '/question/update/1/', $matchList);
var_dump($matchList);*/

/*$router->get('/book/add/', 'BookController@getAdd');
$router->post('/book/add/', 'BookController@postAdd');
$router->get('/book/update/id/(\d+)/', 'BookController@getUpdate', ['id' => 1]);
$router->post('/book/update/id/(\d+)/', 'BookController@postUpdate', ['id' => 1]);
$router->get('/book/delete/id/(\d+)/', 'BookController@getDelete', ['id' => 1]);*/

/*
1. GET /goods/{goodId} — Получение информации о товаре
2. POST /goods — Добавление нового товара
3. PUT /goods/{goodId} — Редактирование товара
4. PATCH /goods/{goodId} — Редактирование некоторых параметров товара
5. DELETE /goods/{goodId} — Удаление товара
По пользователям для разнообразия рассмотрим несколько вариантов с GET

1. GET /users/{userId} — Полная информация о пользователе
2. GET /users/{userId}/info — Только общая информация о пользователе
3. GET /users/{userId}/orders — Список заказов пользователя

 */

$uriQuery = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
$uri = is_null($uriQuery) ? '/' : $uriQuery;
/*var_dump(Router::currentRouteName());
var_dump(Session::Get('lastRouteName'));*/

try {
    Router::run($uri);
    Session::Put('lastRouteName', Router::currentRouteName());
} catch (Exception $e) {
    echo $e->getMessage();
    $message = new Messages(
        $e->getMessage(),
        Messages::DANGER
    );
    $message->save();
    //Session::Get('lastRouteName')
    Router::redirect('index');
    //die('Произошла ошибка: ' . $e->getMessage() . '<br/>');
}

/*
Удаляем "/?", потому что не сделали настройки на серверах
$currentUrl = str_replace('/?', '', $_SERVER['REQUEST_URI']);
$currentUrl = str_replace('/index.php?', '', $currentUrl);

 */

/*
Если добавить конфиг в
Apache
	Options +FollowSymLinks
	RewriteEngine On
	RewriteRule ^(.*)$ index.php [NC,L]

Nginx:
	location / {
		try_files $uri $uri/ /index.php?$query_string;
	}

то:
$currentUrl = $_SERVER['REQUEST_URI'];
$router->run($currentUrl);
*/
