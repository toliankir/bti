<?php
session_start();
define('ROOT_DIR', dirname(__DIR__, 3));

spl_autoload_register(function ($className) {
    $filePath = ROOT_DIR . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
    if (file_exists($filePath)) {
        require_once $filePath;
    }
});

use \App\{
    Services\MysqlService, Admin\RequestHandler, Admin\ResponseCreator, Services\FsService
};

if (isset($_GET['login'],$_GET['password'])  &&
    ($_GET['login'] === 'admin' && $_GET['password'] === 'koo')) {

    $_SESSION['login'] = $_GET['login'];
    ResponseCreator::responseCreate(200, 'Login success');
}

if (isset($_GET['logout'])) {
    unset($_SESSION['login']);
}

if (!isset($_SESSION['login'])) {
    ResponseCreator::responseCreate(403, 'Access denied');
}


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

