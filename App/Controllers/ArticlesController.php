<?php

namespace App\Controllers;

use App\Core\Controller;

class ArticlesController extends Controller
{
    const ARTICLES_PER_PAGE = 10;

    public function action_index()
    {

        if (!isset($this->route[3]) || !is_numeric($this->route[3])) {
            $this->route[3] = 0;
        }
        $this->model->setArticlesForPage(self::ARTICLES_PER_PAGE, $this->route[3]);
        $this->model->setArticleSection($this->route[2]);
        $this->view->render('Articles', 'MainTemplate', $this->model->getData());
    }
}