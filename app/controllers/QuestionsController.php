<?php

class QuestionsController extends BaseController
{
    protected $modelName = 'Question';
    protected $clientTemplate = 'clientQuestions.twig';
    protected $template = 'adminQuestions.twig';

    /**
     * Изменение/добавление вопроса
     * @param $params
     */
    public function update($params)
    {
        $this->checkLogin(); // если не залогинен - переадресуем на страницу входа
        $userName = $this->getThisModel()->getUserName();
        $resultHint = Request::has('add') ? 'добавлен' : 'обновлен';
        $operation = Request::has('add') ? 'create' : 'update';

        $itemParams['author'] = trim(getParam('author'));
        $itemParams['author_email'] = trim(getParam('author_email'));
        $itemParams['question'] = trim(getParam('question'));
        $itemParams['category_id'] = (int)trim(getParam('category_id'));

        if (!empty($userName)) {
            $itemParams['answer'] = trim(getParam('answer'));
            $itemParams['state'] = trim(getParam('state'));
            $itemParams['id'] = (int)trim(getParam('id'));
        }

        $result = $this->getThisModel()->setItem($operation, $itemParams);

        if ($result) {
            $message = new Message("Вопрос успешно $resultHint",Message::SUCCESS,200);
            $userName = !empty($userName) ? $userName : 'Незалогиненный пользователь' . $itemParams['author'];
            $categoryId = $itemParams['category_id'];
            $category = Category::find($categoryId)['name'];

            if (!empty($itemParams['id'])) {
                $questionId = $itemParams['id'];
                $logMsg = "$userName обновил вопрос ($questionId) из темы \"$category\" ($categoryId)";
            } else {
                $logMsg = "$userName создал вопрос в теме \"$category\" ($categoryId)";
            }
            Logger::getLogger('actions')->log($logMsg);
        } else {
            $message = new Message("Вопрос не был $resultHint",Message::WARNING,400);
            foreach ($itemParams as $key => $itemParam) {
                $params[$key] = $itemParam;
            }
        }
        $message->save();

        $this->index($params);
    }

    /**
     * @return Question
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
        $this->checkLogin(); // если не залогинен - переадресуем на страницу входа

        $thisModel = $this->getThisModel();
        $userName = $this->getThisModel()->getUserName();
        $params['user'] = $thisModel->getUserName();
        $params['errors'] = Message::all();

        if (Router::currentRouteName() === 'error') {
            $this->render($this->errorTemplate, $params);
            die();
        }

        $params = array_merge($params, $this->getNeedParams()); // добавляем требуемые для меню параметры

        if (!empty($userName)) {
            $params['items'] = count($items) > 0 ? $items : $thisModel::all();
            if (!empty($params['id'])) {
                $params['editItem'] = $thisModel::find($params['id']);
            }
            $state = $thisModel::QUESTION_STATE_ALL;
            $categoryId = null;

            if (isset($params['state'])) {
                $stateId = $params['state'];
                $state = !empty($params['states'][$stateId]) ? $params['states'][$stateId] : $thisModel::QUESTION_STATE_ALL;
            } elseif (isset($params['category'])) {
                $categoryId = $params['category'];
            }

            $params['categoriesWithQuestions'] = $thisModel->getQuestionsList($state, $categoryId);
            $this->render($this->template, $params);

        } else {
            $params['categoriesWithQuestions'] = $thisModel->getQuestionsList($thisModel::QUESTION_STATE_PUBLISHED);
            $this->render($this->clientTemplate, $params);
        }
    }

}

