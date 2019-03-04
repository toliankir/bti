<?php

namespace App\Services;

class Helper
{
    private $mysqlService, $handledArticles=[];

    public function __construct()
    {
        $this->mysqlService = new MysqlService();
    }

    public function articleHandler($article, $articleArray)
    {
        if (in_array($article['id'], $this->handledArticles)) {
            return $articleArray;
        }
        $this->handledArticles[] = $article['id'];
        $ext = [];
        if ($article['ext'] !== '') {
            $ext = json_decode($article['ext'], true);
        }

        if (key_exists('LinkToArticle', $ext)) {
            $linkArticle = $this->mysqlService->getArticleById($ext['LinkToArticle']);
            $newArticle = [
                'category' => $linkArticle['category'],
                'description' => $linkArticle['description'],
                'ext' => $linkArticle['ext'],
                'id' => $linkArticle['id'],
                'timestamp' => $linkArticle['timestamp'],
                'title' => $linkArticle['title']
            ];
            $articleArray[] = $newArticle;
            return $articleArray;
        }

        $articleArray[] = $article;
        return $articleArray;

//        if (key_exists('submenuLink', $ext)) {
//            $subject = preg_replace('/^.*\//', '', $ext['submenuLink']);
//            $articles = $this->mysqlService->getArticlesWOTByCategory($subject);
//
//            $newArticles = [];
//            foreach ($articles as $newArticle) {
//                $newArticles = $this->articleHandler($newArticle, $newArticles);
//            }
//            return array_merge($articleArray, $newArticles);
//        }
        return false;
    }

}