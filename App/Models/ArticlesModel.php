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
    private $mysqlService, $section, $startArticle = 0, $articlesPerPage = 0;

    public function __construct()
    {
        $this->mysqlService = new MysqlService();
    }

    public function setArticlesForPage($articlesPerPage, $pageNumber)
    {
        $this->articlesPerPage = $articlesPerPage;
        $this->startArticle = $pageNumber * $articlesPerPage;

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

        $pagesCount = intval((count($result) - 1) / $this->articlesPerPage);


        if ($this->articlesPerPage !== 0) {
            if ($this->startArticle > count($result)) {
                $this->startArticle = intval(count($result) / $this->articlesPerPage) * $this->articlesPerPage;
            }

            $lastArticle = $this->startArticle + $this->articlesPerPage;
            if ($lastArticle > count($result)) {
                $lastArticle = count($result);
            }
            $tmp_result = [];

            for ($i = $this->startArticle; $i < $lastArticle; $i++) {
                $tmp_result[] = $result[$i];
            }
            $result = $tmp_result;

        }

        return ['articles' => $result,
            'pagesCount' => $pagesCount,
            'category' => $this->section];
    }

}