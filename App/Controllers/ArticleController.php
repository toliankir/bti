<?php

namespace App\Controllers;

use App\Core\Controller;

class ArticleController extends Controller
{


    public function action_index()
    {
        if (empty($this->route[2])) {
            $this->route[2] = 0;
        }
        $this->model->setArticleId($this->route[2]);
        $this->view->render('Article', 'MainTemplate', $this->model->getData());
    }
}