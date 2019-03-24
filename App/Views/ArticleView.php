<?php

use App\Services\MysqlService;
use App\ViewHelpers\NewsBlockHelper;

?>
    <div class="article">
        <div class="container">
        <?php
        $categoryInfo = (new MysqlService())->getAllCategoryById($article['category']);

        echo '<h3>' . $article['title'] . '</h3>';

        if ($categoryInfo['category'] !== 'Оформлення') {
            echo '<h5 class="category-title">Розділ: <a href=" /articles/' . $categoryInfo['category'] . '">' . $categoryInfo['category'] . '</a></h5>';
        }
        ?>
        <?php echo $article['text']; ?>
        </div>
    </div>

