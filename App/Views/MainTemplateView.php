<?php

use App\ViewHelpers\FooterHelper;
use App\ViewHelpers\HeaderMenuHelper;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link type="text/css" rel="stylesheet" href="../style/style.css">
    <link href="https://fonts.googleapis.com/css?family=Oswald:300;600" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
          integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="shortcut icon" href="../assets/icon.png" type="image/png">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
</head>
<body>
<div class="top-menu part">
    <div class="container">
        <p class="address">
            <img src="../assets/icons/place.png">
            25002, Україна, м.Кропивницький, вул.Енергетиків, 20
        </p>
        <p class="email">
            <img src="../assets/icons/email.png">
            vp_tec@krmr.gov.ua
        </p>
        <p class="telephone">
            <img src="../assets/icons/telephone.png">
            (0522) 30-15-20
        </p>
    </div>
</div>

<div class="header part">
    <div class="container">
        <div class="logo">
            <img src="../assets/images/logo.png">
            <div>
                <p class="logo__title">КП "ТЕПЛОЕНЕРГЕТИК"</p>
                <p class="logo__text">Кіровоградська ТЕЦ</p>
            </div>
        </div>
        <div class="header-menu">
            <ul>
                <li class="menu-item"><a href="../">Головна</a></li>
                <li class="menu-item"><a href="../articles/Підприємство">Підприємство</a>
                    <div class="sub-menu-element">
                        <ul>
                            <?php
                            echo (new HeaderMenuHelper('Підприємство'))->getData();
                            ?>
                        </ul>
                    </div>
                </li>
                <li class="menu-item">
                    <a>Робота з громодянами</a>
                    <div class="sub-menu-element">
                        <a>Робота з громодянами</a>
                    </div>
                </li class="menu-item">
                <li class="menu-item">
                    <a>Тарифи</a>
                    <div class="sub-menu-element">
                        <ul>
                            <?php
                            echo (new HeaderMenuHelper('Тарифи'))->getData();
                            ?>
                        </ul>
                    </div>
                </li>
                <li class="menu-item"><a href="">Субсідія</a></li>
                <li class="menu-item"><a href="../article/18">Соц. політика</a></li>
                <li class="menu-item"><a href="../article/17">Вакансії</a></li>
                <li class="menu-item"><a href="../article/16">Контакти</a></li>
            </ul>

        </div>
        <!--<img src="Kropyvnytskyi.png">-->
    </div>
</div>

<?php
echo $layoutContent;
?>

<div class="footer part">
    <div class="container">
        <div class="logo">
            <p class="title">КП "ТЕПЛОЕНЕРГЕТИК"</p>
            <p>Кіровоградська ТЕЦ</p>
        </div>
        <div class="contact">
            <?php
            $footer = (new FooterHelper())->getData();
            echo $footer['text'];
            ?>
        </div>
    </div>
</div>
<script src="../scripts/script.js"></script>
</body>
</html>