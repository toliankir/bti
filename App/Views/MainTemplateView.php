<?php

use App\ViewHelpers\ArticleContentHelper;
use App\ViewHelpers\FooterHelper;
use App\ViewHelpers\HeaderMenuHelper;

$title = (new ArticleContentHelper('Заголовок'))->getData();
$title['text'] = strip_tags($title['text']);

$keywords = (new ArticleContentHelper('Ключевые слова'))->getData();
$keywords['text'] = strip_tags($keywords['text']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php
        echo $title['description'] . ' ' . $title['text'];
        ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="keywords" content="<?php
    echo $keywords['text'];
    ?>" />
    <meta name="description" content="<?php echo $title['text'];?>">
    <link type="text/css" rel="stylesheet" media="all and (min-device-width: 769px)" href="/style/style.css">
    <link type="text/css" rel="stylesheet" media="all and (max-device-width: 768px)" href="/style/style_mobile.css">
    <link href="https://fonts.googleapis.com/css?family=Oswald:300;600" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
          integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="shortcut icon" href="/assets/icon.png" type="image/png">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
</head>
<body>

<header>
    <div class="container">
        <div class="logo">
            <img src="/assets/images/Kropyvnytskyi.png">
            <a href="/">
                <h1><?php
                    echo '<p>' . $title['description'] . '</p>' . $title['text'];
                    ?>
                </h1>
            </a>
        </div>
        <nav>
            <ul>
                <li><a href="/">Головна</a></li>
                <li><a href="/articles/Послуги">Послуги</a></li>
                <li><a href="/articles/Інформація">Інформація</a></li>
                <li><a href="/article/34">Фінансова звітність</a></li>
                <li><a href="/article/9">Контакти</a></li>
            </ul>
        </nav>
    </div>
</header>

<div class="horizontal-line">
</div>

<main>
    <?php
    echo $layoutContent;
    ?>
</main>

<footer>
    <div class="container">
        <div class="title">
            <h3><?php
                echo '<p>' . $title['description'] . '</p>' . $title['text'];
                ?>
            </h3>
        </div>
        <div class="content">
            <?php
            echo ((new ArticleContentHelper('footer'))->getData())['text'];
            ?>
        </div>

    </div>
</footer>
<script src="/scripts/script.js"></script>


</body>
</html>