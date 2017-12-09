<?php
require_once 'BaseController.php';

class UsersController extends BaseController
{
    protected $modelName = 'User';
    protected $loginTemplate = 'adminLogin.twig';
    protected $template = 'adminUsers.twig';


    /**
     * Изменение/добавление пользователя
     * @param $params
     */
    public function update($params)
    {
        $thisModel = $this->getThisModel();
        $operation = !empty($params['id']) ? 'update' : 'create';
        $login = Request::get('name');
        $password = Request::get('password');
        $thisModel->setUser($operation, $login, $password, $params['id']);
        $this->index($params);
    }

    /**
     * Возвращает текущую модель
     * @return User
     */
    protected function getThisModel()
    {
        return $this->model;
    }

    /**
     * Отвечает за отображение
     * @param $params array
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
     * Выполняет авторизацию
     * @param $params
     */
    public function postLogin($params)
    {
        if (isPost()) {
            $this->getThisModel()->checkForLogin(getParam('login'), getParam('password'));
            if (!empty(getParam('remember_me'))) {
                Session::Put('authLogin', getParam('login'));
                Session::Put('remember_me', 'checked');
            }
        }

        $this->getLogin($params);
    }

    /**
     * Форма авторизации
     * @param $params
     */
    public function getLogin($params)
    {
        $userName = $this->getThisModel()->getUserName();
        if (!empty($userName)) {
            $params['user'] = $userName;
            Router::redirect('index');
        }
        $params['authLogin'] = Session::Get('authLogin');
        $params['remember_me'] = Session::Get('remember_me');
        $params['errors'] = Messages::all();
        $this->render($this->loginTemplate, $params);
    }

    /**
     * Выход из пользователя
     */
    public function getLogout()
    {
        $this->getThisModel()->logout();
    }


}

