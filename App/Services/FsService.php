<?php

namespace App\Services;

class FsService
{
    private $config, $uploadDir;

    public function __construct()
    {
        $this->config = require_once ROOT_DIR . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'fs.php';
        $this->uploadDir = ROOT_DIR . DIRECTORY_SEPARATOR . $this->config['upload_path'] . DIRECTORY_SEPARATOR;
    }

    public function uploadFile($filename, $tmp)
    {
        if (file_exists($this->uploadDir . $filename)) {
            $suffix = 0;
            $path_parts = pathinfo($filename);
            $newFilename = $path_parts['filename'] . '_' . $suffix . '.' . $path_parts['extension'];
            while (file_exists($this->uploadDir . $newFilename)) {
                $path_parts = pathinfo($filename);
                $newFilename = $path_parts['filename'] . '_' . ++$suffix . '.' . $path_parts['extension'];
            }
            $filename = $newFilename;
        }
        move_uploaded_file($tmp, $this->uploadDir . $filename);
        return $filename;
    }

    public function getAllFiles()
    {
        $result = [];
        foreach (scandir($this->uploadDir) as $item) {
            if (is_file($this->uploadDir . $item)) {
                $result[] = $item;
            }
        }
        return $result;
    }

    public function unlinkFile($file)
    {
        return unlink($this->uploadDir . $file);
    }
}
