<?php

/**
 * @var $this \app\core\View
 * @var $model \app\models\Article
 */

use app\core\Application;
use app\core\form\Form;
use app\core\form\SelectField;
use app\core\form\TextareaField;
use app\models\ArticleStatuses;

if(empty($model))
    $this->title = 'Статьи';
else
    $this->title = $model->heading;
?>

<div class="block">
    <?php if ($model == null) : ?>
        <div class="block">
            <h2 class="art-post-header">
                <img src="/images/cross.png" alt="CROSS" width="22" height="32">
                <a href="#">
                    Статьи
                </a>
            </h2>
            <div class="art-post-content">
                <p>
                    Это список статей, сгруппированных по сферам познания и направлению нашей совместной деятельности
                </p>
            </div>
        </div>
        <div class="art-columns">
            <div class="art-content-lcolumn">
                <h3>Философия</h3>
                <ul>
                    <li><a href="">Философия математики</a></li>
                    <li><a href="">Метод философии</a></li>
                    <li><a href="">Безосновность</a></li>
                    <li><a href="/articles/psix_foundation">Основания ПСИХ</a></li>
                    <li><a href="">Философское доказательство судьбы</a></li>
                    <li><a href="">Кто я, а кто не я?</a></li>
                    <li><a href="">Структура вечных вопросов по типу "Смысла жизни" и "Цели мироздания"</a></li>
                </ul>
                <h3>Нейрофизиология</h3>
                <ul>
                    <li><a href="">Механизм восприятия</a></li>
                    <li><a href="">Мышление и психика</a></li>
                    <li><a href="">Инстинкты и потребности</a></li>
                    <li><a href="">Базовые типы психики</a></li>
                    <li><a href="">Человек</a></li>
                </ul>

            </div>

            <div class="art-content-rcolumn">
                <h3>Математика</h3>
                <ul>
                    <li><a href="">Математическое доказательство судьбы </a></li>
                    <li><a href="">Основания матемтики</a></li>
                    <li><a href="">Теорема Гёделя о неполноте</a></li>
                    <li><a href="">Биномиальное распределение</a></li>
                </ul>
                <h3>Психология</h3>
                <ul>
                    <li><a href="">Теоретическая психология</a></li>
                    <li><a href="">Психоанализ</a></li>
                    <li><a href="/articles/socionics">Соционика</a></li>
                    <li><a href="">Психософия</a></li>
                    <li><a href="">Темпористика</a></li>
                </ul>
            </div>
        </div>
    <?php else: ?>
    <?php

    if (Application::isAdmin()) :
    $article_statuses = ArticleStatuses::selectAll();
    $ids = array_map(fn($val) => $val['id'], $article_statuses);
    $statuses = array_map(fn($val) => $val['article_status'], $article_statuses);
    ?>

    <?php $form = Form::begin('', 'post'); ?>
    <?php echo $form->field($model, 'heading') ?>
    <?php echo new TextareaField($model, 'description') ?>
    <?php echo $form->field($model, 'alias') ?>
    <?php
    echo
    (new SelectField($model, 'article_status'))
        ->options(array_combine($ids, $statuses))
        ->selected($model->status_id);
    ?>
        <div class="form-group">
            <button class="btn" id="saveBtn">Сохранить</button>
        </div>
    <?php Form::end() ?>
    <?php endif; ?>
        <div class="block">
            <h2 class="art-post-header">
                <img src="/images/cross.png" alt="CROSS" width="22" height="32">
                <a href="/psix_foundation.php">
                    <?php echo $model->heading ?>
                </a>
            </h2>
            <div class="art-post-header-meta">
                <span>Опубликовано</span>
                <span class="date"><?php
                    try {
                        $date = new DateTime($model->created_at);
                        echo $date->format("Y-m-d");
                    } catch (Exception $e) {
                        echo "Когда то";
                    }

                    ?>
                </span>
                |
                <a href="#" class="url">
                    <?php
                    /**
                     * @var $author \app\models\User
                     */
                    $author = \app\models\User::get_user_by_id($model->author_id);
                    echo $author->username
                    ?>
                </a>
            </div>
        </div>
        <div class="block">
            <div id="editorjs" class="art-post-content"></div>
        </div>
        <script>
            let body = <?php echo $model->body?>;
            let readOnly = <?php echo Application::isAdmin() ? 'false' : 'true' ?>;
            let article_eval_id = <?php echo '"'.($model->article_eval_id).'"' ?>;
        </script>
        <script src="/assets/ArticleAdmin.bundle.js"></script>

    <?php endif; ?>
</div>