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
        usort($articles, function ($a, $b) {
            return strcasecmp($a['title'], $b['title']);
        });

        $result = '';
        foreach ($articles as $value) {
            $ext = [];
            if (!empty($value['ext'])) {
                $ext = json_decode($value['ext'], true);
            }

            $result = $result . "\n" .
                '<li><a href="'.
                ((array_key_exists('externalLink', $ext) && !empty($ext["externalLink"]))
                    ? $ext["externalLink"] : '../article/' . $value['id'])
                . '">' . $value['title'] . '</a></li>';
        }
        return $result;
    }
}