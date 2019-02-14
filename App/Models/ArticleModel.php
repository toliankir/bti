<?php

namespace App\Models;

use App\Core\Model;
use App\Services\MysqlService;

class ArticleModel extends Model
{
    private $mysqlService, $articleId;
    public function __construct()
    {
        $this->mysqlService = new MysqlService();
    }

    public function setArticleId($id) {
        $this->articleId = $id;
    }

    public function getData()
    {
        return ['article' => $this->mysqlService->getArticleById($this->articleId)];
    }
}