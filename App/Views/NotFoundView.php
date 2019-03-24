<?php

use App\ViewHelpers\NewsHelper;

?>
<div class="article">
    <div class="container">
        <h3>Дана сторінка не знайдена.</h3>
    </div>
</div>

<div class="services">
    <div class="container">
        <h3>Послуги</h3>
        <div class="service-items">
            <?php

            $articles = (new NewsHelper([2]))->getData();
            for ($i = 0; $i < 5; $i++) {
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