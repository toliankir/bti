<?php

namespace App\Models;

use App\Core\Model;
use App\Services\MysqlService;

class TempModel extends Model
{
    private $mysqlService;

    public function __construct()
    {
        $this->mysqlService = new MysqlService();
    }

    public function getData()
    {
        return $this->mysqlService->getAllCategories();
    }
}