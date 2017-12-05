<?php

abstract class BaseModel
{
    protected static $db = null; // подключение к базе данных
    protected static $dbTableName = ''; // название таблицы, с которой работает модель
    protected $user;

    public function __construct()
    {
        if (!empty(Session::Get('user'))) {
            $this->user = Session::Get('user');
        }
    }

    /**
     * Возвращает подключение в БД
     * @return PDO
     */
    protected static function getDB()
    {
        if (!is_resource(self::$db)) {
            self::$db = DataBase::connect();
        }
        return self::$db;
    }

    /**
     * Возвращает имя пользователя (логин)
     * @return string|null
     */
    public function getUserName()
    {
        return $this->getCurrentUser('name');
    }

    /**
     * Возвращает текущего пользователя (если есть) или его параметр при наличии $param
     * @param null $param
     * @return null
     */
    protected function getCurrentUser($param = null)
    {
        if (isset($param)) {
            return isset($this->user[$param]) ? $this->user[$param] : null;
        }
        return isset($this->user) ? $this->user : null;
    }

    /**
     * Возвращает хеш md5 от полученного параметра
     * @param $password
     * @return string
     */
    public function getHash($password)
    {
        return md5($password);
    }

    /**
     * Ищет сущность по id
     * @param $id
     * @return mixed|null
     */
    protected function find($id)
    {
        $sql = "SELECT * FROM php_users WHERE id = :id";
        $statement = $this->getDB()->prepare($sql);
        $statement->bindParam('id', $id);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}