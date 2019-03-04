<?php

namespace App\ViewHelpers;


use App\Core\ViewHelper;
use App\Services\Helper;
use App\Services\MysqlService;

class NewsHelper extends ViewHelper
{
    private $service;

    public function __construct()
    {
        $this->service = new MysqlService();
    }

    public function getData()
    {
        $newsCategories = [25, 29, 30];
        $response = $this->service->getArticlesByCategories($newsCategories, 5);
        $handledArticles = [];

        foreach ($response as $article) {
            $handledArticles = (new Helper())->articleHandler($article, $handledArticles);
        }

        return $handledArticles;
    }
}