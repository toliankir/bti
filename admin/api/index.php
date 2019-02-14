<?php
define('ROOT_DIR', dirname(__DIR__, 2));
//require_once ROOT_DIR . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'Services' . DIRECTORY_SEPARATOR . 'MysqlService.php';
//require_once ROOT_DIR . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'Services' . DIRECTORY_SEPARATOR . 'FsService.php';
//require_once ROOT_DIR . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'RequestHandler.php';
//require_once ROOT_DIR . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'ResponseCreator.php';

spl_autoload_register(function ($className) {
    $filePath = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
    if (file_exists($filePath)) {
        require_once $filePath;
    }
});

use \App\{
    Services\MysqlService, Admin\RequestHandler, Admin\ResponseCreator, Services\FsService
};


$mysqlService = new MysqlService();
$fsService = new FsService();
$requestHandler = new RequestHandler($mysqlService, $fsService);


if (!isset($_GET['action']) && !isset($_POST['action'])) {
    die();
}

if (isset($_GET['action'])) {
    $methodName = $_GET['action'];
} else {
    $methodName = $_POST['action'];
}

if (!method_exists($requestHandler, $methodName)) {
    ResponseCreator::responseCreate(200, 'Wrong response');
    die();
}

$requestHandler->$methodName();

