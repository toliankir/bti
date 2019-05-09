<?php

use App\ViewHelpers\ArticleFromCategoryHelper;

?>
<div class="article">
        <h3>Дана сторінка не знайдена.</h3>
</div>

<div class="services">
    <h3>Послуги</h3>
    <div class="service-items">
        <?php
        $quantity = 6;
        $articles = (new ArticleFromCategoryHelper(2))->getData();

        for ($i = 0; $i < $quantity; $i++) {
            $extJson = json_decode($articles[$i]['ext'], true);
            $imageLink = '';
            if ($extJson['mainImage'] !== '') {
                $imageLink = $extJson['mainImage'];
            }
            echo '<div class="service-item">';
            echo '<div class="service-item__image">';
            echo '<a href="/article/' . $articles[$i]['id'] . '"><img src="/assets/upload/' . $extJson['mainImage'] . '"></a>';
            echo '</div><div class="service-item__content">';
            echo '<p><a href="/article/' . $articles[$i]['id'] . '">' . $articles[$i]['title'] . '</a></p>';
            echo '</div></div>';
        }
        ?>
    </div>
</div>