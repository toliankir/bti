<?php

use App\ViewHelpers\NewsBlockHelper;

?>
<div class="line part">
</div>
<div class="content part">
    <div class="container">
        <div class="article w-75">
            <?php
            foreach ($articles as $article) {
                echo '<h3>' . $article['title'] . '</h3>';
                echo '<span>' . date('d/m/Y', strtotime($article['timestamp'])) . '</span>';
                echo '<p>'.$article['description'].'</p>';
                echo '<a href="../article/' . $article['id'] . '">Подробнее</a>';
            }
            ?>
        </div>
        <div class="right-column w-25">
            <?php
            echo (new NewsBlockHelper())->getData();
            ?>
        </div>
    </div>
</div>