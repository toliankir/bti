<?php

namespace App\Controllers;

use App\Core\Controller;

class NotFoundController extends Controller
{
    public function action_index()
    {
        $this->view->render('NotFound', 'MainTemplate', ['test' => 'Page not found']);
    }

}