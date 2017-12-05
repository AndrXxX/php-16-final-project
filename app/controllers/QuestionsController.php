<?php
require_once 'BaseController.php';

class QuestionsController extends BaseController
{
    protected $modelName = 'Question';
    protected $template = 'clientQuestions.twig';

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
        $params['categories'] = $thisModel->getCategoriesList();
        $params['categoriesWithQuestions'] = $thisModel->getQuestionsList($thisModel::QUESTION_STATE_PUBLISHED);
        $params['errors'] = Messages::all();
        $this->render($this->template, $params);
    }

    /**
     * @param $params
     */
    public function store($params)
    {
        if (!empty(getParam('user_name')) && !empty(getParam('email'))
            && !empty(getParam('question')) && is_int((int)getParam('categoryID'))) {
            $userName = trim(getParam('user_name'));
            $email = trim(getParam('email'));
            $question = trim(getParam('question'));
            $categoryID = (int)trim(getParam('categoryID'));

            $result = $this->getThisModel()->addQuestion($userName, $email, $question, $categoryID);
            if ($result) {
                //Session::Add('operationResult', array('typeResult' => 'hint', 'textResult' => 'Вопрос добавлен'));
                $params['operationResult'][] = array('typeResult' => 'success', 'textResult' => 'Вопрос добавлен');
            } else {
                $params['operationResult'][] = array('typeResult' => 'danger', 'textResult' => 'Вопрос не был добавлен');
                $params['user_name'] = $userName;
                $params['email'] = $email;
                $params['question'] = $question;
                $params['categoryID'] = $categoryID;
            }
        }

        $this->index($params);
    }

    /**
     * Изменение/добавление пользователя
     * @param $params
     */
    public function update($params)
    {

    }

    /**
     * @return Question
     */
    protected function getThisModel()
    {
        return $this->model;

    }

}

