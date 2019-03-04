<?php

use App\ViewHelpers\ArticleContentHelper;
use App\ViewHelpers\NewsBlockHelper;
use App\ViewHelpers\NewsHelper;
use App\ViewHelpers\SliderHelper;


?>

<div class="promo part ">
    <div class="slider">
        <?php

        foreach ((new SliderHelper())->getData() as $value) {
            echo('<div class="slider-item"><img src="../assets/promo/' . $value['filename'] . '"><div class="promo-text"><p>' .
                $value['description'] . '</p></div></div>');
        }
        ?>
    </div>
    <div class="slider-control">

    </div>
</div>

<div class="areas part">
    <div class="container">
        <h3>Останні новини</h3>
        <div class="news-items">
            <?php
            $articles = (new NewsHelper())->getData();
            for ($i = 0; $i < 3; $i++) {
                $extJson = json_decode($articles[$i]['ext'], true);
                $imageLink = '';
                if ($extJson['mainImage'] !== '') {
                    $imageLink = $extJson['mainImage'];
                }
                echo '<div class="area-item"><div class="area-item__content">';
//                echo '<p class="area-item__title">'.$articles[$i]['title'].'</p>';
                echo '<p class="area-item__description"><a href="../article/' . $articles[$i]['id'] . '">' . $articles[$i]['title'] . '</a></p>';
                echo '<i class="fas fa-arrow-circle-right"></i></div>';
                echo '<div class="area-item__image">';
                echo '<img src="../assets/upload/' . $extJson['mainImage'] . '">';
                echo '</div></div>';
            }
            ?>

        </div>
        <div class="show-all-articles">Усі новини</div>
    </div>
</div>

<div class="content part">
    <div class="container">
        <div class="article w-75">
            <?php
            echo ((new ArticleContentHelper('Головне'))->getData())['text'];
            ?>
        </div>
        <div class="right-column w-25">
            <?php
            echo (new NewsBlockHelper())->getData();
            ?>
        </div>


    </div>
</div>

