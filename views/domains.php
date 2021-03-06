<?php

/**
 * @var $this \app\core\View
 * @var $domains array
 * @var $domain string
 * @var $articles array
 */

use app\models\Article;

if (isset($domains)) {
    $this->title = 'Области знаний';
} else
{
    $this->title = $domain;
}
?>

<?php if (isset($domains)) : ?>
<div class="block">
    <h2 class="art-post-header">
        <img src="/images/cross.png" alt="CROSS" width="22" height="32">
        <a href="#">
            Сферы познания
        </a>
    </h2>
    <div class="art-post-content">
        <p>
            Список областей знаний, по которым сгруппированы все статьи
        </p>
    </div>
    <?php foreach ($domains as $domain): ?>
        <div class="block">
            <h2 class="art-post-header">
                <img src="../images/cross.png" alt="CROSS" width="22" height="32">
                <a href="/domains/<?php echo $domain['name']?>">
                    <?php echo $domain['label'] ?>
                </a>
            </h2>
            <div class="art-post-header-meta">
                <span>Описание</span>
            </div>
            <div class="art-post-content">
                <p>
                    <?php echo $domain['description'] ?>
                </p>
            </div>
        </div>

    <?php endforeach;?>
    <?php elseif (!empty($articles)): ?>

    <?php
    /**
     * @var $article Article
     */
    foreach ($articles as $article):
        if($article['status_id'] != 1)
            continue;
        ?>


        <div class="block">
            <h2 class="art-post-header">
                <img src="../images/cross.png" alt="CROSS" width="22" height="32">
                <a href="/articles/<?php echo $article['alias'] == ''? $article['article_eval_id']: $article['alias']?>">
                    <?php echo $article['heading'] ?>
                </a>
            </h2>
            <div class="art-post-header-meta">
                <span>Опубликовано</span>
                <span class="date">
                <?php
                try {
                    echo (new DateTime($article['created_at']))->format("Y-m-d");
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
                    $author = \app\models\User::get_user_by_id($article['author_id']);
                    echo $author->username
                    ?>
                </a>
            </div>
            <div class="art-post-content">
                <p>
                    <?php echo $article['description'] ?>
                </p>
            </div>
        </div>
    <?php
    endforeach;
    endif;
    ?>

</div>
