<?php


abstract class BaseController
{
    protected $model = null;
    protected $modelName = 'BaseModel';
    protected $template;

    /**
     * BaseController constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $modelFile = 'app/models/' . $this->modelName . '.php';
        if (is_file($modelFile)) {
            include $modelFile;
            $this->model = new $this->modelName();
        } else {
            throw new Exception("Модель $modelFile не обнаружена");
        }
    }

    /**
     * Обработка POST запросов
     * @param $params
     */
    public function store($params)
    {
        /* если была нажата кнопка Добавить */
        if (Request::has('add')) {
            $this->update($params);
        }
    }

    /**
     * Отображения форму создания сущности
     * @param $params
     */
    public function create($params)
    {
        $params['action'] = 'create';
        $this->index($params);
    }

    /**
     * Удаляет сущность
     * @param $params
     */
    public function destroy($params)
    {
        $thisModelClass = $this->modelName;
        $thisModelClass::destroy($params['id']);
        $this->index($params);
    }

    /**
     * Вывод формы с полями для изменения сущности
     * @param $params
     */
    public function edit($params)
    {
        $params['action'] = 'edit';
        $this->index($params);
    }

    /**
     * Выводит сущность по id
     * @param $params
     */
    public function show($params)
    {
        $thisModelClass = $this->modelName;
        $items = $thisModelClass::find($params['id']);
        $this->index($params, $items);
    }

    abstract public function update($params);

    abstract public function index($params, $items = []);

    abstract protected function getThisModel();

    /**
     * Отображаем шаблон
     * @param $template
     * @param array $params
     */
    protected function render($template, $params = [])
    {
        // Где лежат шаблоны
        $loader = new Twig_Loader_Filesystem('app/views/');

        // Где будут хранится файлы кэша (php файлы)
        $twig = new Twig_Environment($loader, array(
            'cache' => 'app/storage/tmp/twig_cache',
            'auto_reload' => true,
        ));

        $twig->addFunction('staticCall', new Twig_Function_Function('staticCall'));

        try {
            echo $twig->render($template, $params);
        } catch (Twig_Error_Loader $e) {
            die('Twig_Error_Loader: ' . $e->getMessage() . '<br/>');
        } catch (Twig_Error_Runtime $e) {
            die('Twig_Error_Runtime: ' . $e->getMessage() . '<br/>');
        } catch (Twig_Error_Syntax $e) {
            die('Twig_Error_Syntax: ' . $e->getMessage() . '<br/>');
        }
    }

}