<?php

use app\core\Application;
use app\core\View;

/** @var $this View */


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="description" content="Ход завязки всего на всем или культура детерменизма" />
    <meta name="keywords" content="детерменизм безосновность философия">

    <link href="/css/stylesheet.css" rel="stylesheet" type="text/css">
    <title><?php echo $this->title ?></title>
    <link rel="shortcut icon" href="/images/cross.ico" type="image/x-icon">

</head>

<body>

    <header>
        <div class="art-header-center">
            <div class="art-header-png"></div>
        </div>
        <div class="art-header-wrapper">
            <div class="art-header-inner">
                <div class="art-headerobject"></div>
                <div class="art-logo">
                    <h1 id="name-text" class="art-logo-name"><a href="/">Познания сфер интегральный хаос (ПСИХ)</a></h1>
                    <h2 id="slogan-text" class="art-logo-text">
                        << Опоры и начала - лишь упрощения>>
                    </h2>
                </div>
            </div>
        </div>
    </header>

    <div class="content">
        <nav>
            <ul class="nav">
                <li class="menu-item menu-item-active"><a href="/">Главная</a></li>
                <li><span class="menu-separator"></span></li>
                <li class="menu-item"><a href="articles">Статьи</a></li>
                <li><span class="menu-separator"></span></li>
                <li class="menu-item"><a href="#">Прогресс</a></li>
                <li><span class="menu-separator"></span></li>
                <li class="menu-item"><a href="participation">Участие</a></li>
                <li><span class="menu-separator"></span></li>
                <li class="menu-item">
                    <div class="menu-dropdown">
                        <a href="../About.html">О ПСИХ</a>
                        <div class="menu-dropdown-content">
                            <a>О мне</a>
                            <a>Public keys</a>
                            <a>О группе ПСИХ</a>
                            <a>FAQ</a>
                            <a>Карта сайта</a>
                        </div>
                    </div>
                </li>
                <?php if (Application::isGuest()) : ?>
                    <li class="menu-item push"><a href="/login">Вход</a></li>
                    <li><span class="menu-separator"></span></li>
                    <li class="menu-item"><a href="/register">Регистрация</a></li>
                <?php else : ?>

                    <li class="menu-item push">
                        <div class="menu-dropdown">
                            <a href="/profile"><?php echo Application::$app->user->getDisplayName() ?></a>
                            <div class="menu-dropdown-content">
                                <a href="/profile/sandbox">Написать публикацию</a>
                                <a href="logout">Выйти</a>
                            </div>
                        </div>
                    </li>

                <?php endif; ?>
            </ul>

        </nav>
        <?php if (Application::$app->session->getFlash('success')) : ?>
            <div class="alert alert-success">
                <p><?php echo Application::$app->session->getFlash('success') ?></p>
            </div>
        <?php endif; ?>
        <?php if (Application::$app->session->getFlash('fail')) : ?>
            <div class="alert alert-fail">
                <p><?php echo Application::$app->session->getFlash('fail') ?></p>
            </div>
        <?php endif; ?>
        {{content}}

        <div class="content-footer">
            <br>
            <br>
            Отче наш, сущий на небесах! да святится имя Твое да приидет Царствие Твое; да будет воля Твоя и на земле, как на
            небе;
        </div>
    </div>
    <footer>

    </footer>
</body>

</html>