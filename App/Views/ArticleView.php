<?php

use App\Services\MysqlService;
use App\ViewHelpers\NewsBlockHelper;

?>
<div class="line part">
</div>
<div class="content part">
    <div class="container">
        <div class="article w-75">

            <?php
            $categoryInfo = (new MysqlService())->getAllCategoryById($article['category']);
            echo '<h3>' . $article['title'] . '</h3>';
            echo '<h5 class="category-title">Розділ: <a href="../articles/'.$categoryInfo['category'] .'">' . $categoryInfo['category'] . '</a></h5>';
            ?>
            <?php echo $article['text']; ?>
        </div>
        <div class="right-column w-25">
            <?php
            echo (new NewsBlockHelper())->getData();
            ?>
        </div>
    </div>
</div>