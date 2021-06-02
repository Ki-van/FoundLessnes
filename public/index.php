<?php
    require_once __DIR__ . "/../vendor/autoload.php";
    use app\core\Application;

    $app = new Application();

    $app->router->get('/', function(){
        return "HELL yeah";
    });

    $app->run();
?>
<!--
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="description" content="Ход завязки всего на всем или культура детерменизма"/>
    <meta name="keywords" content="детерменизм безосновность философия">
    <link href="../stylesheet.css" rel="stylesheet" type="text/css">
    <title>FoundLessness</title>
    <link rel="shortcut icon" href="../images/cross.ico" type="image/x-icon">

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
                <h1 id="name-text" class="art-logo-name"><a href="index.php">Познания сфер интегральный хаос (ПСИХ)</a></h1>
                <h2 id="slogan-text" class="art-logo-text"><< Опоры и начала - лишь упрощения >></h2>
            </div>
        </div>
    </div>
</header>

<div class="content">
    <nav>
   <ul class="nav">
       <li class="menu-item menu-item-active"><a href="index.php">Главная</a></li>
       <li><span class="menu-separator"></span></li>
       <li class="menu-item"><a href="../articles.html">Статьи</a></li>
       <li><span class="menu-separator"></span></li>
       <li class="menu-item"><a href="#">Прогресс</a></li>
       <li><span class="menu-separator"></span></li>
       <li class="menu-item"><a href="../Participation.html">Участие</a></li>
       <li><span class="menu-separator"></span></li>
       <li class="menu-item">
           <div class="menu-dropdown">
               <a href="../About.html">О ПСИХ</a>
               <div class="menu-dropdown-content">
                    <a>О мне</a>
                   <a>Public keys</a>
                   <a>О группе ПСИХ</a>
                   <a>FQ</a>
                   <a>Карта сайта</a>
               </div>
           </div>
       </li>
   </ul>
    </nav>
    <div class="art-post-body">
        <h2 class="art-post-header">
            <img src="../images/cross.png" alt="CROSS" width="22" height="32">
            <a href="#">
                Математическое доказательство судьбы
            </a>
        </h2>
        <div class="art-post-header-meta">
            <span>Опубликовано</span>
            <span class="date">сегодня</span>
            |
            <a href="#" class="url">
                Админом
            </a>
        </div>
        <div class="art-post-content">
            <p>
                В основу доказательства положена информационная энтропия - мера неопределённости некоторой системы (в статистической физике или теории информации). Попутно проведен ликбец по детерменизму.
            </p>
        </div>
    </div>
    <div class="art-post-body">
        <h2 class="art-post-header">
            <img src="../images/cross.png" alt="CROSS" width="22" height="32">
            <a href="#">
            Основания математики
            </a>
        </h2>
        <div class="art-post-header-meta">
            <span>Опубликовано</span>
                <span class="date">сегодня</span>
            |
            <a href="#" class="url">
                Админом
            </a>
        </div>
        <div class="art-post-content">
            <p>
                Математика - наука об отношениях между объектами, о которых ничего не известно, кроме описывающих их некоторых свойств, — именно тех, которые в качестве аксиом положены в основание той или иной математической теории
            </p>
        </div>
    </div>
    <div class="art-post-body">
        <h2 class="art-post-header">
            <img src="../images/cross.png" alt="CROSS" width="22" height="32">
            <a href="#">
                Философия математки
            </a>
        </h2>
        <div class="art-post-header-meta">
            <span>Опубликовано</span>
            <span class="date">сегодня</span>
            |
            <a href="#" class="url">
                Админом
            </a>
        </div>
        <div class="art-post-content">
            <p>
                Существует ли реальный физический мир независимо от человека? Существуют ли горы, деревья, суша, море и небо независимо от того, есть ли люди, способные воспринимать все эти объекта? Такой вопрос кажется нелепым: разумеется, существуют. Разве мы не наблюдаем окружающий мир постоянно? Разве наши органы чувств не рождают у нас непрерывно ощущения, подтверждающие существование внешнего мира? Но люди мыслящие полагают не лишним подвергнуть сомнению очевидное, даже если это сомнение разрешается еще одним подтверждением.
            </p>
        </div>
    </div>
    <div class="art-post-body">
        <h2 class="art-post-header">
            <img src="../images/cross.png" alt="CROSS" width="22" height="32">
            <a href="../articles/psix_foundation.html">
                Основания ПСИХ
            </a>
        </h2>
        <div class="art-post-header-meta">
            <span>Опубликовано</span>
            <span class="date">сегодня</span>
            |
            <a href="#" class="url">
                Админом
            </a>
        </div>
        <div class="art-post-content">
            <p>
                Безосновность как надистина, высшая истина, руководство к действию и основание этого места.
            </p>
        </div>
    </div>
    <div class="art-post-body">
        <h2 class="art-post-header">
            <img src="../images/cross.png" alt="CROSS" width="22" height="32">
            <a href="#">
                Научный метод
            </a>
        </h2>
        <div class="art-post-header-meta">
            <span>Опубликовано</span>
            <span class="date">сегодня</span>
            |
            <a href="#" class="url">
                Админом
            </a>
        </div>
        <div class="art-post-content">
            <p>
                Метод включает в себя способы исследования феноменов, систематизацию, корректировку новых и полученных ранее знаний. Умозаключения и выводы делаются с помощью правил и принципов рассуждения на основе эмпирических (наблюдаемых и измеряемых) данных об объекте            </p>
        </div>
    </div>

    <div class="art-post-body">
        <h2 class="art-post-header">
            <img src="../images/cross.png" alt="CROSS" width="22" height="32">
            <a href="#">
                Метод философии
            </a>
        </h2>
        <div class="art-post-header-meta">
            <span>Опубликовано</span>
            <span class="date">сегодня</span>
            |
            <a href="#" class="url">
                Админом
            </a>
        </div>
        <div class="art-post-content">
            <p>
                Всеобщий философский метод – это исследование единства мировоззрения и методологии, к которым прибегает тот или иной субъект в различной деятельности.

                Выявление фактов связано с отражением социальной действительности в человеческом сознании посредством использования объективной диалектики.

                При рассмотрении того или иного события исключается всякая субъективность и предвзятость за счет того, что вышеуказанное событие изучается в тот момент, когда оно становится и развивается.
            </p>
        </div>
    </div>

    <div class="art-post-body">
        <h2 class="art-post-header">
            <img src="../images/cross.png" alt="CROSS" width="22" height="32">
            <a href="#">
                Безосновность
            </a>
        </h2>
        <div class="art-post-header-meta">
            <span>Опубликовано</span>
            <span class="date">сегодня</span>
            |
            <a href="#" class="url">
                Админом
            </a>
        </div>
        <div class="art-post-content">
            <p>Посмотрим прямо перед собой и обнаружим язык, нет, не тот что во рту. Сами по себе слова это просто звуки, которые в нашей голове сопоставляются с какими то объектами, обретая "тот самы смысл". Но попробуем определить истоки слов, слов без определения и не сможем этого сделать, ведь те слова что не имеют определения просто не используются(хотя бы понятие)</p>
        </div>
    </div>
    <div class="content-footer">
        <br>
        <br>
        Отче наш, сущий на небесах! да святится имя Твое да приидет Царствие Твое; да будет воля Твоя и на земле, как на небе;
    </div>
</div>
<footer>

</footer>
<script src="../assets/eventHandlers.js"></script>
</body>
</html>-->