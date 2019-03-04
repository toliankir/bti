<?php

namespace App\ViewHelpers;

use App\Core\ViewHelper;
use App\Services\MysqlService;

class ArticleContentHelper extends ViewHelper
{
    private $service, $article;

    public function __construct($article)
    {
        $this->service = new MysqlService();
        $this->article = $article;
    }

    public function getData()
    {
        return $this->service->getArticleByTitle($this->article);
    }
}