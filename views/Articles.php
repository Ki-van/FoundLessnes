<?php

/**
 * @var $this \app\core\View
 * @var $model \app\models\Article
 * @var $domains array
 */

use app\core\Application;
use app\core\form\Form;
use app\core\form\SelectField;
use app\core\form\TextareaField;
use app\models\ArticleStatuses;

if (!isset($model))
    $this->title = 'Статьи';
else
    $this->title = $model->heading;
?>

<div class="block">
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
            <a>
                <?php echo $model->heading ?>
            </a>
        </h2>
        <div class="art-post-header-meta">
            <span>Опубликовано</span>
            <span class="date">
                <?php
                try {
                    echo (new DateTime($model->created_at))->format("Y-m-d");
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
        let article_eval_id = <?php echo '"' . ($model->article_eval_id) . '"' ?>;
    </script>
    <script src="/assets/ArticleAdmin.bundle.js"></script>
</div>