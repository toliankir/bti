<?php

namespace App\Core;

class Controller
{

    public $view, $model, $route;

    public function __construct($route = null)
    {
        $this->view = new View('test value');
        $this->route = $route;
        $model = '\\App\\Models\\' . ucfirst($route[1]) . 'Model';
        if (class_exists($model)) {
            $this->model = new $model();
        }
    }

    public function action_index()
    {

    }


}
