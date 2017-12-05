<?php
require_once 'BaseModel.php';

class Category extends BaseModel
{
    protected static $dbTableName = 'php_categories';

    public static function all()
    {
        $tableName = self::$dbTableName;
        $sql = "SELECT * FROM $tableName ORDER BY name;";
        $statement = self::getDB()->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Удаляет элемент из БД
     * @param $id
     * @return bool
     */
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
                'Категория была удалена',
                Messages::SUCCESS
            );
        } else {
            $message = new Messages(
                'Категория не была удалена',
                Messages::WARNING
            );
        }
        $message->save();
        return $result;
    }

    /**
     * Добавляет/изменяет категорию в БД
     * @param $operation
     * @param $name
     * @param $id
     * @return bool
     */
    public function setItem($operation, $name, $id = null)
    {
        $tableName = self::$dbTableName;
        $operationHint = $this->find($id) ? 'обновлена' : 'добавлена';
        switch ($operation) {
            case 'update';
                if (!$this->find($id)) {
                    $message = new Messages(
                        'Категория не была обновлен - нет такой категории',
                        Messages::WARNING
                    );
                    $message->save();
                    return false;
                }
                $sql = "UPDATE $tableName 
                        SET name = :name, user_id = :userId, updated_at = NOW() 
                        WHERE id = :id LIMIT 1";
                break;
            default:
                if ($this->getItem($name)) {
                    $message = new Messages(
                        'Категория не была добавлена - уже есть такая категория',
                        Messages::WARNING
                    );
                    $message->save();
                    return false;
                }
                $sql = "INSERT INTO $tableName (name, user_id, created_at, updated_at) 
                        VALUES (:name, :userId, NOW(), NOW())";
                break;
        }
        $statement = $this->getDB()->prepare($sql);
        $statement->bindParam('name', $name);
        $statement->bindParam('userId', $this->getCurrentUser('id'));
        if (!empty($id) && $operation === 'update') {
            $statement->bindParam('id', $id);
        }
        $result = $statement->execute();

        if ($result) {
            $message = new Messages(
                "Категория успешно $operationHint",
                Messages::SUCCESS
            );
        } else {
            $message = new Messages(
                "Категория не был $operationHint",
                Messages::WARNING
            );
        }

        $message->save();
        return $result;
    }

    /**
     * Ищет пользователя по логину
     * @param $name
     * @return mixed|null
     */
    protected function getItem($name)
    {
        $sql = "SELECT * FROM php_users WHERE name = :name LIMIT 1";
        $statement = $this->getDB()->prepare($sql);
        $statement->bindParam('name', $name);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}

