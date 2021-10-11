<?php
/**
 * @var  $articles array
 */

use app\models\Visit;

$this->title = 'Статьи';
?>

<div class="block">
    <h2 class="art-post-header">
        <img src="/images/cross.png" alt="CROSS" width="22" height="32">
        <a href="#">
            Статьи
        </a>
    </h2>
    <?php foreach ($articles as $article): ?>
        <div class="block">
            <h2 class="art-post-header">
                <img src="../images/cross.png" alt="CROSS" width="22" height="32">
                <a href="/articles/<?php echo $article['alias'] == ''? $article['article_eval_id']: $article['alias']?>">
                    <?php echo $article['heading'] ?>
                </a>
            </h2>
            <div class="art-post-header-meta">
                <span>Создано</span>
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
                |
                <a>
                    <?php
                    /**
                     * @var $article_status \app\models\ArticleStatuses;
                     */
                        $article_status = \app\models\ArticleStatuses::findOne(['id' => $article['status_id']]);
                        echo $article_status->article_status;
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
    ?>
</div>