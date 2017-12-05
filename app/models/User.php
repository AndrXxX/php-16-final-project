<?php
require_once 'BaseModel.php';

class User extends BaseModel
{
    protected static $dbTableName = 'php_users';

    public static function all()
    {
        $tableName = self::$dbTableName;
        $sql = "SELECT * FROM $tableName ORDER BY name;";
        $statement = self::getDB()->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function destroy($id) {
        $id = (int)$id;
        if (is_int($id)) {
            $tableName = self::$dbTableName;
            $sql = "DELETE FROM $tableName WHERE id = :id;";
            $statement = self::getDB()->prepare($sql);
            $statement->bindParam('id', $id);
            $result = $statement->execute();
        } else {
            $result = false;
        }

        if ($result) {
            $message = new Messages(
                'Пользователь был удален',
                Messages::SUCCESS
            );
        } else {
            $message = new Messages(
                'Пользователь не был удален',
                Messages::WARNING
            );
        }
        $message->save();
        return $result;
    }

    /**
     * Добавляет/изменяет пользователя в БД (если пользователя с таким именем в базе нет)
     * @param $operation
     * @param $login
     * @param $password
     * @param $id
     * @param $role
     * @return bool
     */
    public function setUser($operation, $login, $password, $id = null, $role = 'admin')
    {
        $operationHint = $this->find($id) ? 'обновлен' : 'добавлен';
        switch ($operation) {
            case 'update';
                if (!$this->find($id)) {
                    $message = new Messages(
                        'Пользователь не был обновлен - нет такого пользователя',
                        Messages::WARNING
                    );
                    $message->save();
                    return false;
                }
                $sql = "UPDATE php_users 
                        SET name = :login, password = :password, role = :role, updated_at = NOW() 
                        WHERE id = :id LIMIT 1";
                break;
            default:
                if ($this->getUser($login)) {
                    $message = new Messages(
                        'Пользователь не был добавлен - уже есть такой логин',
                        Messages::WARNING
                    );
                    $message->save();
                    return false;
                }
                $sql = "INSERT INTO php_users (name, password, role, created_at, updated_at) 
                        VALUES (:login, :password, :role, NOW(), NOW())";
                break;
        }
        $statement = $this->getDB()->prepare($sql);
        $statement->bindParam('login', $login);
        $statement->bindParam('password', $this->getHash($password));
        $statement->bindParam('role', $role);
        if (!empty($id) && $operation === 'update') {
            $statement->bindParam('id', $id);
        }
        $result = $statement->execute();

        if ($result) {
            $message = new Messages(
                "Пользователь успешно $operationHint",
                Messages::SUCCESS
            );
        } else {
            $message = new Messages(
                "Пользователь не был $operationHint",
                Messages::WARNING
            );
        }

        $message->save();
        return $result;
    }

    /**
     * Реализует механизм проверок при авторизации
     * @param $login
     * @param $password
     * @return bool
     */
    public function checkForLogin($login, $password)
    {
        if (!$this->login($login, $password)) {
            $message = new Messages(
                'Авторизация не удалась: не найден пользователь, неправильный логин или неправильный пароль',
                Messages::WARNING
            );
            $message->save();
            return false;
        }
        return true;
    }

    /**
     * Реализует механизм авторизации
     * @param $login
     * @param $password
     * @return bool
     */
    protected function login($login, $password)
    {
        $user = !empty($login) && !empty($password) ? $this->getUser($login) : null;
        /* Ищем пользователя по логину */
        if ($user !== null && $user['password'] === $this->getHash($password)) {
            Session::Put('user', $user);
            $this->user = $user;
            Session::Put('user_id', $this->user['id']);
            return true;
        }
        return false;
    }

    /**
     * Ищет пользователя по логину
     * @param $login
     * @return mixed|null
     */
    protected function getUser($login)
    {
        $sql = "SELECT * FROM php_users WHERE name = :login LIMIT 1";
        $statement = $this->getDB()->prepare($sql);
        $statement->bindParam('login', $login);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Уничтожает сессию и переадресует на страницу входа
     */
    public function logout()
    {
        session_destroy();
        Router::redirect('login');
    }
}

