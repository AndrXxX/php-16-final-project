<?php

class BlackListController extends BaseController
{
    protected $modelName = 'BlackList';
    protected $template = 'adminBlackList.twig';

    /**
     * Обновление списка запрещенных ключевых слов
     * @param $params
     */
    public function update($params)
    {
        $this->checkLogin();
        $list = explode("\n", getParam('list'));
        foreach (array_keys($list) as $key) {
            $list[$key] = trim($list[$key]);
        }
        $userName = $this->getThisModel()->getUserName();
        $result = $this->getThisModel()->setItems($list);

        if ($result) {
            $message = new Message("Список запрещенных слов успешно обновлен", Message::SUCCESS, 200);
            $logMsg = "$userName обновил список запрещенных ключевых слов";
            Logger::getLogger('actions')->log($logMsg);
        } else {
            $message = new Message("Список запрещенных слов не был обновлен", Message::WARNING, 400);
        }
        $message->save();

        $this->index($params);
    }

    /**
     * @return BlackList
     */
    protected function getThisModel()
    {
        return $this->model;

    }

    /**
     * @param $params
     * @param $items array
     */
    public function index($params, $items = [])
    {
        $this->checkLogin();
        $thisModel = $this->getThisModel();
        $userName = $thisModel->getUserName();
        $params = array_merge($params, $this->getNeedParams()); // добавляем требуемые для меню параметры
        $params['errors'] = Message::all();
        $params['user'] = $userName;
        $params['items'] = implode(PHP_EOL, $thisModel->getBlackList());

        $this->render($this->template, $params);
    }

}

