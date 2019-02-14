<?php

namespace App\Models;

use App\Core\Model;
use App\Services\MysqlService;

class DefaultModel extends Model
{
    private $mysqlService;

    public function __construct()
    {
        $this->mysqlService = new MysqlService();
    }

    public function getData()
    {
        $articles1 = $this->mysqlService->getArticlesWOTByCategory('абв');
        $articles2 = $this->mysqlService->getArticlesWOTByCategory('Операції з землею');
        return ['articles1' => $articles1, 'articles2' => $articles2];
    }
}