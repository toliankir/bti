<?php

namespace App\ViewHelpers;


use App\Core\ViewHelper;
use App\Services\MysqlService;

class HeaderMenuHelper extends ViewHelper
{
    private $section, $service;

    public function __construct($section)
    {
        $this->section = $section;
        $this->service = new MysqlService();
    }

    public function getData()
    {
        $articles = $this->service->getArticlesCategoryName($this->section);

        $result = '';
        foreach ($articles as $value) {
            $ext = json_decode($value['ext'], true);;
            $link = '/article/' . $value['id'];
            if (isset($ext['LinkToArticle'])) {
                $link = '/article/' . $ext['LinkToArticle'];
            }
            if (isset($ext['categoryLink'])) {
                $link = '/articles/' . $ext['categoryLink'];
            }
            if (isset($ext['externalLink'])) {
                $link = $ext['externalLink'];
            }
            $result = $result . "\n" .
                '<li><a href="' . $link . '">' . $value['title'] . '</a></li>';
        }
        return $result;
    }
}