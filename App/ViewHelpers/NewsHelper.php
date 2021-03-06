<?php

namespace App\ViewHelpers;


use App\Core\ViewHelper;
use App\Services\Helper;
use App\Services\MysqlService;

class NewsHelper extends ViewHelper
{
    private $service, $categories;

    public function __construct($categories)
    {
        $this->categories = $categories;
        $this->service = new MysqlService();
    }

    public function getData($quantity=5)
    {
        $response = $this->service->getArticlesByCategories($this->categories, $quantity);
        $handledArticles = [];

        foreach ($response as $article) {
            $handledArticles = (new Helper())->articleHandler($article, $handledArticles);
        }

        return $handledArticles;
    }
}