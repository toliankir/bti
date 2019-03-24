<?php

namespace App\ViewHelpers;

use App\Core\ViewHelper;

class NewsBlockHelper extends ViewHelper
{
    private $articles;

    public function __construct()
    {
        $this->articles = (new NewsHelper([5]))->getData();
    }

    public function getData()
    {
        $result = "<h3>Новини</h3>\n<ul>";
        foreach ($this->articles as $article) {
            $result .= "\n"
                . '<li><a href="../article/' . $article['id'] . '">' . $article['title'] . '</a>'
                . '<span>(' . date('d/m/Y', strtotime($article['timestamp'])) . ')</span>';
            if ($article['description'] !== '') {
                    $result .= '<p>' . $article['description'] . '</p>';
            }
            $result .=  '</li>';
        }
        return $result . '</ul>';
    }
}