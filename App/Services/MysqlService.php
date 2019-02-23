<?php

namespace App\Services;

use PDO;
use PDOException;

class MysqlService
{
    private $config, $pdo;

    const ARTICLE_TABLE = 'articles';
    const CATEGORY_TABLE = 'categories';
    const FILE_TABLE = 'files';


    public function __construct()
    {
        $db = MysqlConnection::instance();
        $this->pdo = $db->getConnection();
    }

    public function addCategory($categoryName, $categoryDescription)
    {
        $stmt = $this->pdo->prepare('INSERT INTO ' . self::CATEGORY_TABLE . '(category, description) VALUES (:category, :description)');
        $stmt->bindParam(':category', $categoryName);
        $stmt->bindParam(':description', $categoryDescription);
        $stmt->execute();
    }

    public function deleteCategoryById($categoryId)
    {
        $stmt = $this->pdo->prepare('DELETE FROM ' . self::CATEGORY_TABLE . ' WHERE id = :id');
        $stmt->bindParam(':id', $categoryId);
        $stmt->execute();
    }

    public function getAllCategories()
    {
        $stmt = $this->pdo->prepare('SELECT * FROM ' . self::CATEGORY_TABLE);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function updateCategoryById($categoryId, $categoryName, $categoryDescription)
    {
        $stmt = $this->pdo->prepare('UPDATE ' . self::CATEGORY_TABLE . ' SET category=:category, description=:description WHERE id = :id');
        $stmt->bindParam(':id', $categoryId);
        $stmt->bindParam(':category', $categoryName);
        $stmt->bindParam(':description', $categoryDescription);
        $stmt->execute();
    }

    public function addArticle($categoryId, $articleTitle, $articleDescription, $articleText, $articleVisible)
    {
        $stmt = $this->pdo->prepare('INSERT INTO ' . self::ARTICLE_TABLE . '(text, category, description, title, visible) VALUES (:text, :category, :description, :title, :visible)');
        $stmt->bindParam(':category', $categoryId);
        $stmt->bindParam(':description', $articleDescription);
        $stmt->bindParam(':text', $articleText);
        $stmt->bindParam(':title', $articleTitle);
        $stmt->bindParam(':visible', $articleVisible);
        $stmt->execute();
    }

    public function updateArticle($id, $categoryId, $articleTitle, $articleDescription, $articleText, $articleVisible)
    {
        $stmt = $this->pdo->prepare('UPDATE ' . self::ARTICLE_TABLE . ' SET text=:text, category=:category, title=:title, description=:description, visible=:visible WHERE id=:id');
        $stmt->bindParam(':text', $articleText);
        $stmt->bindParam(':category', $categoryId);
        $stmt->bindParam(':title', $articleTitle);
        $stmt->bindParam(':description', $articleDescription);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':visible', $articleVisible);
        $stmt->execute();
    }

    public function getArticleById($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM ' . self::ARTICLE_TABLE . ' WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getArticlesWOTByCategory($category)
    {
        $stmt = $this->pdo->prepare('SELECT c.category, a.category as categoryId, a.description, a.ext, a.id, a.timestamp, a.title, a.description FROM '
            . self::ARTICLE_TABLE . ' a LEFT JOIN ' . self::CATEGORY_TABLE . ' c ON a.category = c.id WHERE c.category LIKE :category');
        $prepareCategory = $category . '%';
        $stmt->bindParam(':category', $prepareCategory);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getArticlesCategoryId($id)
    {
        $stmt = $this->pdo->prepare('SELECT category, description, ext, id, visible, timestamp, title, description FROM '
            . self::ARTICLE_TABLE . ' WHERE category = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function deleteArticleById($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM ' . self::ARTICLE_TABLE . ' WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function addFile($articleId, $fileName, $description = '')
    {
        $stmt = $this->pdo->prepare('INSERT INTO ' . self::FILE_TABLE . '(article, filename, description) VALUES (:article, :filename, :description)');
        $stmt->bindParam(':article', $articleId);
        $stmt->bindParam(':filename', $fileName);
        $stmt->bindParam(':description', $description);
        $stmt->execute();
    }

    public function updateFile($id, $articleId, $description)
    {
        $stmt = $this->pdo->prepare('UPDATE ' . self::FILE_TABLE . ' SET article=:article, description=:description WHERE id=:id');
        $stmt->bindParam(':article', $articleId);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }


    public function getFilesForArticle($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM ' . self::FILE_TABLE . ' WHERE article = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllFiles()
    {
        $stmt = $this->pdo->prepare('SELECT f.id, f.article, f.filename, f.description, a.title FROM ' . self::FILE_TABLE . ' f LEFT JOIN ' . self::ARTICLE_TABLE . ' a  ON f.article = a.id');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function deleteFile($filename)
    {
        $stmt = $this->pdo->prepare('DELETE FROM ' . self::FILE_TABLE . ' WHERE filename = :filename');
        $stmt->bindParam(':filename', $filename);
        $stmt->execute();
    }
}
