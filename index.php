<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);
mb_internal_encoding('UTF-8'); // Кодировка по умолчанию
ini_set('display_errors', 1);

require_once 'config.php';
require_once 'vendor/autoload.php';
require_once 'app/load.php';