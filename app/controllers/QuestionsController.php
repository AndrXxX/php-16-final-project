<?php
require_once 'BaseController.php';

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

        $resultHint = Request::has('add') ? 'добавлен' : 'обновлен';
        $operation = Request::has('add') ? 'create' : 'update';

        if (!empty(getParam('author')) && !empty(getParam('author_email'))
            && !empty(getParam('question')) && is_int((int)getParam('category_id'))) {
            $itemParams['author'] = trim(getParam('author'));
            $itemParams['author_email'] = trim(getParam('author_email'));
            $itemParams['question'] = trim(getParam('question'));
            $itemParams['category_id'] = (int)trim(getParam('category_id'));

            if (!empty($this->getThisModel()->getUserName())) {
                $itemParams['answer'] = trim(getParam('answer'));
                $itemParams['state'] = trim(getParam('state'));
                $itemParams['id'] = (int)trim(getParam('id'));
            }

            $result = $this->getThisModel()->setItem($operation, $itemParams);

            if ($result) {
                $message = new Messages(
                    "Вопрос успешно $resultHint",
                    Messages::SUCCESS,
                    200
                );
            } else {
                $message = new Messages(
                    "Вопрос не был $resultHint",
                    Messages::WARNING,
                    400
                );
                foreach ($itemParams as $key => $itemParam) {
                    $params[$key] = $itemParam;
                }
            }
            $message->save();
        }
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
        $thisModel = $this->getThisModel();
        $userName = $this->getThisModel()->getUserName();
        if (!empty($userName)) {
            $params['user'] = $userName;
        }
        $params['errors'] = Messages::all();

        if (Router::currentRouteName() === 'error') {
            $this->render($this->errorTemplate, $params);
        }

        $params['categories'] = $thisModel->getCategoriesList();
        if (!empty($userName) and !(Router::currentRouteName() === 'index')
            and !(Router::currentRouteName() === 'index_store')) {
                $params['items'] = count($items) > 0 ? $items : $thisModel::all();
                $params['states'] = $thisModel::getQuestionStateList();
                $params['categoriesWithQuestions'] = $thisModel->getQuestionsList($thisModel::QUESTION_STATE_ALL);
                $this->render($this->template, $params);

        } else {
            $params['categoriesWithQuestions'] = $thisModel->getQuestionsList($thisModel::QUESTION_STATE_PUBLISHED);
            $this->render($this->clientTemplate, $params);
        }
    }

}

