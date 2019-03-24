<?php

use App\ViewHelpers\NewsBlockHelper;
use App\ViewHelpers\RightBlockInfoHelper;
use App\ViewHelpers\RightBlockNewsHelper;

const IMAGE_TYPE = ['jpg', 'jpeg', 'png', 'gif', 'svg'];

?>

<div class="article-list">
    <div class="container">
        <div class="content">
            <?php
            if (count($articles) !== 0) {
                echo '<h3>' . $category . '</h3>';
            }

            foreach ($articles as $article) {
                echo '<div class="article-list__item">';
                $extJson = json_decode($article['ext'], true);
                $imgType = '';

                if (!empty($extJson['mainImage'])) {
                    $imgArray = explode('.', $extJson['mainImage']);
                    $imgType = end($imgArray);
                }

                if (in_array($imgType, IMAGE_TYPE)) {
                    echo '<div class="article-list__image"><img src="/assets/upload/' . $extJson['mainImage'] . '"></div>';
                    $imageLink = $extJson['mainImage'];
                }

                echo '<div class="article-list__content"><h5>' . $article['title'];
                echo '<span>(' . date('d/m/Y', strtotime($article['timestamp'])) . ')</span></h5>';
                if (!empty($article['description'])) {
                    echo '<p>' . $article['description'] . '</p>';
                }

                if (empty($imgType) ||  in_array($imgType, IMAGE_TYPE)) {
                    echo '<p><a href="/article/' . $article['id'] . '">Детальніше</a></p>';
                } else {
                    echo '<p><a target="_blank" href="/assets/upload/' . $extJson['mainImage'] . '">Завантажити</a></p>';
                }

                echo '</div></div>';

            }

            if ($pagesCount !== 0) {
                echo '<div class="pages-nav">Сторінка: ';
                for ($i = 0; $i <= $pagesCount; $i++) {
                    echo '<a href="/articles/' . $category . '/' . $i . '">' . $i . '</a>';
                }
                echo '</div>';
            }
            ?>
        </div>
        <div class="right-block">
            <?php
            echo (new RightBlockNewsHelper())->getData();
            echo (new RightBlockInfoHelper())->getData();
            ?>
        </div>
    </div>
</div>
