<?php

class LoggerController extends BaseController
{
    protected $modelName = 'Logger';
    protected $template = 'adminLog.twig';

    public function update($params)
    {
        $this->index($params);
    }

    /**
     * Отвечает за отображение
     * @param $params array
     * @param $items array
     */
    public function index($params, $items = [])
    {
        $this->checkLogin(); // если не залогинен - переадресуем на страницу входа
        $thisModel = $this->getThisModel();

        $params = array_merge($params, $this->getNeedParams()); // добавляем требуемые для меню параметры
        $params['user'] = $thisModel->getUserName();
        $params['logs'] = $thisModel->getLogContents('actions');
        $params['errors'] = Message::all();
        $this->render($this->template, $params);
    }

    /**
     * Возвращает текущую модель
     * @return Logger
     */
    protected function getThisModel()
    {
        return $this->model;
    }
}

