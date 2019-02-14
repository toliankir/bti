<?php
namespace App\Core;

class View
{
    private $defaultData;

    public function __construct($defaultData)
    {
        $this->defaultData = $defaultData;
    }

    private function getViewPath($view)
    {
        return ROOT_DIR . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'Views'
            . DIRECTORY_SEPARATOR . $view . 'View.php';
    }

    public function render($contentView, $templateView, $data)
    {
        if (is_array($data)) {
            extract($data);
        }

        $templateFile = $this->getViewPath($templateView);
        $contentFile = $this->getViewPath($contentView);


        $layoutContent = '';
        if (file_exists($contentFile)) {
            ob_start();
            require $contentFile;
            $layoutContent = ob_get_clean();
        }


        if (file_exists($templateFile)) {
            require $templateFile;
        }

    }

}