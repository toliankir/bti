<?php

namespace App\ViewHelpers;


use App\Core\ViewHelper;

class RightBlockNewsHelper extends ViewHelper
{
    private $articles;

    public function __construct()
    {
        $this->articles = (new NewsHelper([5]))->getData();
    }

    public function getData()
    {
        $result = '<div class="news-info"><i class="far fa-file-alt"></i><ul>';
        foreach ($this->articles as $news_item) {
            $result .= '<li>' . $news_item['title'] . '</li>';
        }
        $result .= '</ul></div>';
        return $result;
    }

}