<?php

namespace App\ViewHelpers;

use App\Core\ViewHelper;
use App\Services\MysqlService;

class SliderHelper extends ViewHelper
{
    private $service;

    const SLIDER_ARTICLE = 44;

    public function __construct()
    {
        $this->service = new MysqlService();
    }

    public function getData()
    {
        return $this->service->getFilesForArticle(self::SLIDER_ARTICLE);
    }

}