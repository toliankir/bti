<?php
/**
 * Created by PhpStorm.
 * User: Tolian
 * Date: 24.02.2019
 * Time: 12:08
 */

namespace App\Models;


use App\Core\Model;
use App\Services\Helper;
use App\Services\MysqlService;

class ArticlesModel extends Model
{
    private $mysqlService, $section;

    public function __construct()
    {
        $this->mysqlService = new MysqlService();
    }

    public function setArticleSection($section)
    {
        $this->section = urldecode($section);
    }

    public function getData()
    {
        $articles = $this->mysqlService->getArticlesWOTByCategory($this->section);
        $result = [];

        foreach ($articles as $article) {
            $result = (new Helper())->articleHandler($article, $result);
        }

        return ['articles' => $result];

    }

}