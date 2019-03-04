<?php

namespace App\Models;

use App\Core\Model;
use App\Services\MysqlService;

class ArticleModel extends Model
{
    private $mysqlService, $article;

    public function __construct()
    {
        $this->mysqlService = new MysqlService();
    }

    public function setArticleId($id)
    {
        $this->article = $this->mysqlService->getArticleById($id);
    }

    public function setArticleTitle($title)
    {
        $this->article = $this->mysqlService->getArticleByTitle(urldecode($title));
    }

    public function getData()
    {
        return ['article' => $this->article];
    }
}