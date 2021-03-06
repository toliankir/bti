<?php

namespace App\Admin;

use App\Services\{
    MysqlService, FsService
};

class RequestHandler
{
    private $service, $fsService;

    public function __construct(MysqlService $mysqlService, FsService $fsService)
    {
        $this->service = $mysqlService;
        $this->fsService = $fsService;
    }

    public function addCategory()
    {
        if (empty($_POST['categoryName'])) {
            ResponseCreator::responseCreate(422, 'Empty category name');
        }

        $this->service->addCategory($_POST['categoryName'], $_POST['categoryDescription']);
        ResponseCreator::responseCreate(200, 'Category added', [
            'categoryName' => $_POST['categoryName'],
            'categoryDescription' => $_POST['categoryDescription']]);
    }

    public function getAllCategories()
    {
        ResponseCreator::responseCreate(200, 'Ok', $this->service->getAllCategories());
    }

    public function deleteCategoryById()
    {
        if (empty($_GET['id'])) {
            ResponseCreator::responseCreate(422, 'Empty category id');
        }
        $this->service->deleteCategoryById($_GET['id']);
        ResponseCreator::responseCreate(200, 'Ok', ['id' => $_GET['id']]);
    }

    public function updateCategoryById()
    {
        if (empty($_POST['id'])) {
            ResponseCreator::responseCreate(422, 'Empty category id');
        }

        if (empty($_POST['category'])) {
            ResponseCreator::responseCreate(422, 'Empty category name');
        }
        $this->service->updateCategoryById($_POST['id'], $_POST['category'], $_POST['description']);
        ResponseCreator::responseCreate(200, 'Ok', ['id' => $_POST['id']]);
    }


    public function updateArticle()
    {
        if (empty($_POST['categoryId'])) {
            ResponseCreator::responseCreate(422, 'Empty categoryId');
        }
        if (empty($_POST['title'])) {
            ResponseCreator::responseCreate(422, 'Empty title');
        }
        if (empty($_POST['id'])) {
            ResponseCreator::responseCreate(422, 'Empty id');
        }

        // If new adding article
        if ($_POST['id'] === 'new') {
            $this->service->addArticle($_POST['categoryId'], $_POST['title'],
                $_POST['description'], $_POST['text'],
                $_POST['visible'] === 'true' ? true : false, $_POST['ext']);
            ResponseCreator::responseCreate(200, 'Article add', [
                'Article title' => $_POST['title']]);
        }

        // If article update
        $this->service->updateArticle($_POST['id'], $_POST['categoryId'], $_POST['title'],
            $_POST['description'], $_POST['text'],
            $_POST['visible'] === 'true' ? true : false, $_POST['ext']);
        ResponseCreator::responseCreate(200, 'Article update', [
            'Article title' => $_POST['title']]);
    }

    public function getArticleById()
    {
        if (empty($_GET['id'])) {
            ResponseCreator::responseCreate(422, 'Empty article id');
        }
        $articles = $this->service->getArticleById($_GET['id']);
        if (!$articles) {
            ResponseCreator::responseCreate(404, 'Article with id - ' . $_GET['id'] . ' don\'t  found');
        }
        ResponseCreator::responseCreate(200, 'OK', $articles);
    }

    public function deleteArticleById()
    {
        if (empty($_GET['id'])) {
            ResponseCreator::responseCreate(422, 'Empty article id');
        }
        $this->service->deleteArticleById($_GET['id']);
        ResponseCreator::responseCreate(200, 'Article # ' . $_GET['id'] . ' deleted');
    }

    public function getArticlesWOTByCategory()
    {
        if (empty($_GET['category'])) {
            ResponseCreator::responseCreate(422, 'Empty category');
        }
        ResponseCreator::responseCreate(200, 'OK', $this->service->getArticlesWOTByCategory($_GET['category']));
    }

    public function getArticlesByCategoryId()
    {
        if (empty($_GET['category'])) {
            ResponseCreator::responseCreate(422, 'Empty category id');
        }

        if ($_GET['category'] === 'noCategory') {
            ResponseCreator::responseCreate(200, 'OK', $articles = $this->service->getArticlesWoCategory());
        }

        ResponseCreator::responseCreate(200, 'OK', $this->service->getArticlesCategoryId($_GET['category']));
    }

    public function uploadFile()
    {
        if (empty($_FILES['fileData']['name'])) {
            ResponseCreator::responseCreate(422, 'Empty file data');
        }
        if (empty($_POST['articleId'])) {
            ResponseCreator::responseCreate(422, 'Empty article id');
        }
        $filename = $this->fsService->uploadFile($_FILES['fileData']['name'], $_FILES['fileData']['tmp_name']);
        $this->service->addFile($_POST['articleId'], $filename);
        ResponseCreator::responseCreate(200, 'OK', [
            'uploaded' => $filename,
            'article' => $_POST['articleId']
        ]);
    }

    public function getFilesForArticle()
    {
        if (empty($_GET['id'])) {
            ResponseCreator::responseCreate(422, 'Empty article id');
        }
        ResponseCreator::responseCreate(200, 'OK', $this->service->getFilesForArticle($_GET['id']));
    }

    public function deleteFile()
    {
        if (empty($_GET['file'])) {
            ResponseCreator::responseCreate(422, 'Empty article id');
        }
        if ($this->fsService->unlinkFile($_GET['file'])) {
            $this->service->deleteFile($_GET['file']);
            ResponseCreator::responseCreate(200, 'OK', [
                'deleteFile' => $_GET['file']
            ]);
        }
    }

    public function deleteFileFromDB()
    {
        if (empty($_GET['file'])) {
            ResponseCreator::responseCreate(422, 'Empty article id');
        }
        $this->service->deleteFile($_GET['file']);
        ResponseCreator::responseCreate(200, 'OK', [
            'deleteFile' => $_GET['file']
        ]);
    }

    public function unlinkFile()
    {
        if (empty($_GET['file'])) {
            ResponseCreator::responseCreate(422, 'Empty article id');
        }
        if ($this->fsService->unlinkFile($_GET['file'])) {
            ResponseCreator::responseCreate(200, 'OK', [
                'deleteFile' => $_GET['file']
            ]);
        }
    }

    public function getAllFiles()
    {
        $sqlBase = $this->service->getAllFiles();
        $fsList = $this->fsService->getAllFiles();
        $result = [];
        foreach ($sqlBase as $item) {
            if (($key = array_search($item['filename'], $fsList)) !== false) {
                $item['state'] = 'Base,Filesystem';
                unset($fsList[$key]);

            } else {
                $item['state'] = 'Base';
            }
            $result[] = $item;
        }
        foreach ($fsList as $file) {
            $result[] = [
                'id' => '',
                'article' => '',
                'filename' => $file,
                'description' => '',
                'title' => '',
                'state' => 'Filesystem'
            ];
        }
        ResponseCreator::responseCreate(200, 'Ok', $result);
    }

    public function updateFileById()
    {
        if ($_POST['id'] === '0') {
            $this->service->addFile($_POST['article'], $_POST['filename'], $_POST['description']);
            ResponseCreator::responseCreate(200, 'Ok', ['Add to base' => $_POST['filename']]);
        }

        if ($_POST['id'] !== '0') {
            $this->service->updateFile($_POST['id'], $_POST['article'], $_POST['description']);
            ResponseCreator::responseCreate(200, 'Ok', ['File update in base' => $_POST['filename']]);
        }
    }

    public function addLinkToArticle()
    {
        if (empty($_GET['categoryId'])) {
            ResponseCreator::responseCreate(200, 'Category id empty');
        }
        if (empty($_GET['link'])) {
            ResponseCreator::responseCreate(200, 'Link id empty');
        }
        $this->service->addLinkToArticle($_GET['categoryId'], $_GET['link']);
        ResponseCreator::responseCreate(200, 'Ok', ['Link to article add' => $_GET['link']]);
    }

    public function addCategoryLink()
    {
        if (empty($_GET['categoryId'])) {
            ResponseCreator::responseCreate(200, 'Category id empty');
        }
        if (empty($_GET['link'])) {
            ResponseCreator::responseCreate(200, 'Link id empty');
        }
        $this->service->addCategoryLink($_GET['categoryId'], $_GET['link']);
        ResponseCreator::responseCreate(200, 'Ok', ['Link to article add' => $_GET['link']]);
    }

    public function addExternalLink()
    {
        if (empty($_GET['categoryId'])) {
            ResponseCreator::responseCreate(200, 'Category id empty');
        }
        if (empty($_GET['link'])) {
            ResponseCreator::responseCreate(200, 'Link is empty');
        }
        $this->service->addExternalLink($_GET['categoryId'], $_GET['link']);
        ResponseCreator::responseCreate(200, 'Ok', ['External link add' => $_GET['link']]);
    }

    public function updateExtProperty()
    {
        if (empty($_GET['articleId'])) {
            ResponseCreator::responseCreate(200, 'Article id empty');
        }
        if (empty($_GET['key'])) {
            ResponseCreator::responseCreate(200, 'Key empty');
        }
        if (empty($_GET['value'])) {
            ResponseCreator::responseCreate(200, 'Value empty');
        }
        $article = $this->service->getArticleById($_GET['articleId']);
        $jsonExt = json_decode($article['ext'], true);
        if (!is_array($jsonExt)) {
            $jsonExt = [];
        }
        $jsonExt[$_GET['key']] = $_GET['value'];
        $this->service->updateArticleExt($_GET['articleId'], json_encode($jsonExt));
        ResponseCreator::responseCreate(200, 'Ok', ['Ext changed' => $_GET['articleId']]);
    }

    public function setArticlesOrderById()
    {
        $categories = $this->service->getAllCategories();
        foreach ($categories as $value) {
            $this->service->setArticlesOrderById($value['id']);
        }
    }


    public function articleUp()
    {
        if (empty($_GET['id'])) {
            ResponseCreator::responseCreate(200, 'Article id empty');
        }
        $article = $this->service->getArticleById($_GET['id']);
        $maximumOrder = $this->service->getMaximumOrderInCategory($article['category']);
        if ($article['art_order'] >= $maximumOrder) {
            ResponseCreator::responseCreate(200, 'Article already on top');
        }
        $newestArticle = $this->service->getIdByCategoryAndOrder($article['art_order'] + 1, $article['category']);
        $this->service->setOrderById($newestArticle, $article['art_order']);
        $this->service->setOrderById($_GET['id'], $article['art_order'] + 1);
        ResponseCreator::responseCreate(200, 'Article move to top on one step');
    }

    public function articleDown()
    {
        if (empty($_GET['id'])) {
            ResponseCreator::responseCreate(200, 'Article id empty');
        }
        $article = $this->service->getArticleById($_GET['id']);
        if ($article['art_order'] <= 0) {
            ResponseCreator::responseCreate(200, 'Article already on down');
        }
        $latestArticle = $this->service->getIdByCategoryAndOrder($article['art_order'] - 1, $article['category']);
        $this->service->setOrderById($latestArticle, $article['art_order']);
        $this->service->setOrderById($_GET['id'], $article['art_order'] - 1);
        ResponseCreator::responseCreate(200, 'Article move to down on one step');
    }

}
