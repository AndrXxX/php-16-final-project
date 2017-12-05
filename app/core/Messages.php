<?php

class Messages
{
    const WARNING = 'alert-warning';    // Предупреждающее сообщение
    const DANGER = 'alert-danger';      // Сообщение об ошибке
    const SUCCESS = 'alert-success';    // Сообщение об успешном выполнении действия или подтверждающее сообщение
    const INFO = 'alert-info';          // Информационные сообщения
    protected $message;
    protected $type;


    public function __construct($message, $type, $save = true)
    {
        $type = $this->checkType($type) ? $type : self::INFO;
        $this->message = $message;
        $this->type = $type;
    }

    /**
     * Проверяет правильный ли тип
     * @param $type
     * @return bool
     */
    protected function checkType($type)
    {
        return in_array($type, [self::WARNING, self::DANGER, self::SUCCESS, self::INFO]);
    }

    /**
     * Возвращает список ошибок в виде объектов
     * @return Messages[]
     */
    public static function all()
    {
        $errorsList = Session::Flash('errors');
        if (is_array($errorsList)) {
            foreach ($errorsList as $error) {
                $errors[] = new Messages($error['message'], $error['type'], false);
            }
        }

        return isset($errors) ? $errors : [];
    }

    /**
     * Сохраняет ошибку в сессию
     */
    public function save()
    {
        Session::Add(
            'errors',
            [
                'message' => $this->getMessage(),
                'type' => $this->getType()
            ]);
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}