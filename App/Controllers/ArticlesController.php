<?php

namespace App\Controllers;

use App\Core\Controller;

class ArticlesController extends Controller
{
    const ARTICLES_PER_PAGE = 5;

    public function action_index()
    {
        if (empty($this->route[3])) {
            $this->route[3] = 0;
        }
        $this->model->setArticleSection($this->route[2]);
        $this->view->render('Articles', 'MainTemplate', $this->model->getData());
    }
}