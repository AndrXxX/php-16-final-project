<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);
mb_internal_encoding('UTF-8'); // Кодировка по умолчанию
ini_set('display_errors', 1);

require_once 'config.php';
require_once 'vendor/autoload.php';
require_once 'app/load.php';


/*$config = include 'config.php';*/

/**
 * Подключение к базе данных
 */
/*include 'lib/database/DataBase.php';*/

/*$db = DataBase::connect(
    $config['mysql']['host'],
    $config['mysql']['dbname'],
    $config['mysql']['user'],
    $config['mysql']['pass']
);*/

//include 'template/user/register.php';

/*$uri = parse_url($_SERVER['REQUEST_URI']);*/

/*$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'])
);*/

/*echo "<pre>";
var_dump($uri);*/

// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.
/*if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false;
}*/

//require_once __DIR__.'/public/index.php';
