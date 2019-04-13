<?php

use App\ViewHelpers\ArticleContentHelper;
use App\ViewHelpers\ArticleFromCategoryHelper;
use App\ViewHelpers\NewsBlockHelper;
use App\ViewHelpers\NewsHelper;
use App\ViewHelpers\RightBlockInfoHelper;
use App\ViewHelpers\SliderHelper;


?>
<div class="horizontal-line-green-2x">
</div>
<div class="promo">
    <div class="slider">
        <div class="slider-item"><img src="/assets/images/slider.jpg"></div>
    </div>
</div>
<div class="horizontal-line-green-2x">
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

<div class="sale">
    <div class="sale-item">
        <i class="fas fa-hryvnia"></i>
        <h4>Вигідні ціни</h4>
    </div>
    <div class="sale-item">
        <i class="far fa-clock"></i>
        <h4>Стислі терміни виконання замовлення</h4>
    </div>
    <div class="sale-item">
        <i class="fas fa-map-marked-alt"></i>
        <h4>Представництва в Кіровоградський області</h4>
    </div>
</div>

<div class="news">
    <div class="news-content">
        <?php
        echo (new NewsBlockHelper())->getData();
        ?>
    </div>
    <div class="right-block">

        <?php
        echo (new RightBlockInfoHelper())->getData();
        ?>

    </div>
</div>
