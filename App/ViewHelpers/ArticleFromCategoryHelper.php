<?php

namespace App\ViewHelpers;


use App\Core\ViewHelper;
use App\Services\Helper;
use App\Services\MysqlService;

class ArticleFromCategoryHelper extends ViewHelper
{
    private $service, $category;

    public function __construct($category)
    {
        $this->category = $category;
        $this->service = new MysqlService();
    }

    public function getData()
    {
        $response = $this->service->getArticlesCategoryId($this->category);
        $handledArticles = [];

        foreach ($response as $article) {
            $handledArticles = (new Helper())->articleHandler($article, $handledArticles);
        }

        return $handledArticles;
    }
}