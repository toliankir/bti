<?php
/**
 * Created by PhpStorm.
 * User: Tolian
 * Date: 03.03.2019
 * Time: 19:39
 */

namespace App\ViewHelpers;


use App\Core\ViewHelper;

class NewsBlockHelper extends ViewHelper
{
    private $articles;

    public function __construct()
    {
        $this->articles = (new NewsHelper())->getData();
    }

    public function getData()
    {
        $result = "<h3>Новини</h3>\n<ul>";
        foreach ($this->articles as $article) {
            $result = $result . "\n"
                . '<li><a href="../article/' . $article['id'] . '">' . $article['title'] . '</a><p>' .
                date('d/m/Y', strtotime($article['timestamp'])) . '</p></li>';
        }
        return $result . '</ul>';
    }
}