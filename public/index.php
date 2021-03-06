<?php
define('ROOT_DIR', dirname(__DIR__));

define('IMAGE_URL_PATH', '../');
spl_autoload_register(function ($className) {
    $filePath = ROOT_DIR . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
    if (file_exists($filePath)) {
        require_once $filePath;
    }
});

use \App\Controllers\{
    NotFoundController
};

$route = explode('/', preg_replace('/[?].*$/','',$_SERVER['REQUEST_URI']));

if (empty($route[1])) {
    $route[1] = 'default';
}
$controller = '\\App\\Controllers\\' . ucfirst($route[1]) . 'Controller';

if (class_exists($controller)) {
    $controller = new $controller($route);
    $controller->action_index();
    die();
}
(new NotFoundController())->action_index();


