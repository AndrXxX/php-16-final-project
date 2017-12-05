<?php
require_once 'BaseController.php';

class CategoriesController extends BaseController
{
    protected $modelName = 'Category';
    protected $template = 'adminCategories.twig';

    /**
     * @param $params
     * @param $items array
     */
    public function index($params, $items = [])
    {
        $thisModel = $this->getThisModel();
        if (empty($thisModel->getUserName())) {
            // если не залогинен
            Router::redirect('login');
        }

        $params['user'] = $thisModel->getUserName();
        $params['items'] = count($items) > 0 ? $items : $thisModel::all();
        $params['errors'] = Messages::all();
        $this->render($this->template, $params);
    }

    /**
     * Изменение/добавление пользователя
     * @param $params
     */
    public function update($params)
    {
        if (!empty(getParam('name'))) {
            $name = trim(getParam('name'));
            $thisModel = $this->getThisModel();
            $operation = !empty($params['id']) ? 'update' : 'create';
            $thisModel->setItem($operation, $name, $params['id']);
        }

        $this->index($params);
    }

    /**
     * @return Category
     */
    protected function getThisModel()
    {
        return $this->model;

    }

}

