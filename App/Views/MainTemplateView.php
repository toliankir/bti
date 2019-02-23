<?php

use App\ViewHelpers\FooterHelper;

?>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta charset="UTF-8">
    <title>TEST</title>
    <link type="text/css" rel="stylesheet" href="/style/style.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700|Roboto:400,500,700&amp;subset=cyrillic"
          rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
          integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
</head>
<body>
<div class="header">
    <div class="container">
        <img src="assets/images/Kropyvnytskyi.png">
    </div>
</div>
<div class="menu">
    <div class="container">
        <a href="/" class="menu__item">Головна</a>
        <a class="menu__item">Звітність</a>
        <a class="menu__item">О Нас</a>
        <a class="menu__item">Контакти</a>
    </div>
</div>
<div class="content">
    <div class="container">
        <?php
        echo $layoutContent;
        ?>
    </div>
</div>

<div class="footer">
    <div class="container">
<!--                <span class="footer__text">25006, м. Кропивницький, вул. Калініна, 12<br>(0522) 226901</span>-->
        <?php
        $footer = (new FooterHelper())->getData();
        echo $footer['text'];
        ?>
    </div>
</div>
</body>
</html>