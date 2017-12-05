<?php

/**
 * Проверяет, является ли метод ответа POST
 * @return bool
 */
function isPost()
{
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}

/**
 * Проверяет установлен ли параметр $name в запросе
 * @param $name
 * @return null
 */
function getParam($name)
{
    return !empty($_REQUEST[$name]) ? $_REQUEST[$name] : '';
}

/**
 * Функция для вызова статического метода класса
 * @param $class
 * @param $function
 * @param array $args
 * @return mixed|null
 */
function staticCall($class, $function, $args = array())
{
    if (class_exists($class) && method_exists($class, $function))
        return call_user_func_array(array($class, $function), $args);
    return null;
}