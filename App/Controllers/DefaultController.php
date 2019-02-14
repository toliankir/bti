<?php

namespace App\Controllers;

use \App\Core\Controller;

class DefaultController extends Controller
{
    public function action_index()
    {
        $this->view->render('Default', 'MainTemplate',  array_merge(
            ['test' => 'default'],
            $this->model->getData()));
    }

}