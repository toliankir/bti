<?php

namespace App\ViewHelpers;

use App\Core\ViewHelper;
use App\Services\MysqlService;

class FooterHelper extends ViewHelper
{
    private $service;

    public function __construct()
    {
        $this->service = new MysqlService();
    }

    public function getData()
    {
    return $this->service->getArticleById(15);
    }
}