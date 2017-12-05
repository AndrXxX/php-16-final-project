<?php
require_once 'BaseModel.php';

class Question extends BaseModel
{
    const QUESTION_STATE_PUBLISHED = 'опубликован';
    const QUESTION_STATE_HIDDEN = 'скрыт';
    const QUESTION_STATE_WAIT_ANSWER = 'ожидает ответа';

    protected static $dbTableName = 'php_users';


    /**
     * Возвращает массив задач созданных пользователем (когда $owner === true)
     * или назначенных пользователю (когда $owner === false)
     * @param $owner bool
     * @return array
     */
    /*public function getTasks($owner = true)
    {
        if ($owner === true) {
            $where = ' WHERE owner_user.login = :login ';
        } else {
            $where = ' WHERE owner_user.login <> :login AND assigned_user.login = :login ';
        }
        $sort = $this->getSortType();
        $sth = $this->getDB()->prepare('
            SELECT task.id, task.user_id, task.assigned_user_id, task.description, task.is_done, task.date_added, 
              owner_user.login AS owner_user_login, assigned_user.login AS assigned_user_login
            FROM task
            JOIN user AS owner_user ON owner_user.id=task.user_id
            JOIN user AS assigned_user ON assigned_user.id=task.assigned_user_id'
            . $where .
            "ORDER BY $sort ASC;");
        $sth->bindValue(':login', $this->getUserName(), PDO::PARAM_STR);

        if ($owner === false) {
            // во втором случае два параметра :login
            $sth->bindValue(':login', $this->getUserName(), PDO::PARAM_STR);
        }

        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Извлекает тип сортировки
     * @return string
     */
    /*public function getSortType()
    {
        return !empty($_SESSION['sort']) ? $_SESSION['sort'] : 'date_added';
    }

    /**
     * Возвращает список категорий из БД
     */
    public function getCategoriesList()
    {
        $sql = "SELECT id, name FROM php_categories ORDER BY name;";
        $statement = $this->getDB()->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Возвращает список категорий из БД
     * @param $state
     * @param null $categoryId
     * @return array
     */
    public function getQuestionsList($state, $categoryId = null)
    {
        //
        if (in_array($state, $this->getQuestionStateList())) {
            if (is_null($categoryId)) {
                $categoryId = '%';
                $sqlCategoryFilter = "AND category_id LIKE :categoryId";
            } else {
                $categoryId = (int)$categoryId;
                $sqlCategoryFilter = "AND category_id=:categoryId";
            }

            $sql = "SELECT questions.id, questions.name, questions.answer, questions.state, questions.created_at, 
                questions.updated_at, questions.category_id, categories.name AS category_name, questions.user_id, 
                users.name AS user_login
                FROM php_questions AS questions
                  JOIN php_users AS users ON users.id=questions.user_id
                  JOIN php_categories AS categories ON categories.id=questions.category_id
                WHERE state=:state $sqlCategoryFilter 
                ORDER BY category_name, questions.name;";

            $statement = $this->getDB()->prepare($sql);
            $statement->bindParam('state', $state);
            $statement->bindParam('categoryId', $categoryId);
            $statement->execute();
            $unsortedArray = $statement->fetchAll(PDO::FETCH_ASSOC);
            $questions = [];

            foreach ($this->getCategoriesList() as $category)
            {
                $questions[$category['name']] = [];
            }

            foreach ($unsortedArray as $question)
            {
                $questions[$question['category_name']][] = $question;
            }

            return $questions;
        }

    }

    public function addQuestion($userName, $email, $question, $categoryID)
    {
        $state = self::QUESTION_STATE_WAIT_ANSWER;
        $sql = "INSERT INTO php_questions (name, author, author_email, created_at, updated_at, category_id, state)
                VALUES (:name, :author, :author_email, NOW(), NOW(), :category_id, :state);";
        $statement = $this->getDB()->prepare($sql);
        $statement->bindParam('name', $question);
        $statement->bindParam('author', $userName);
        $statement->bindParam('author_email', $email);
        $statement->bindParam('category_id', $categoryID);
        $statement->bindParam('state', $state);
        return $statement->execute();
    }

    /**
     * Возвращает список состояний вопросов
     */
    protected function getQuestionStateList()
    {
        return array(
            self::QUESTION_STATE_PUBLISHED,
            self::QUESTION_STATE_HIDDEN,
            self::QUESTION_STATE_WAIT_ANSWER
        );
    }



}

