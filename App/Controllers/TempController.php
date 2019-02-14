<?php

namespace App\Controllers;

use \App\Core\Controller;

class TempController extends Controller
{
    public function action_index()
    {
        $categories = $this->model->getData();
        $categoriesHtml = array_reduce($categories, function ($html, $category) {
            return $html = $html
                . '<tr><td>' . $category['id'] . '</td><td>' . $category['category'] . '</td><td>' . $category['description'] . '</td></tr>';
        });
        $outputData = [
            'categories' => '<table border="1">' . $categoriesHtml . '</table>'
        ];
        $this->view->render('Test', 'MainTemplate', $outputData);
    }
}