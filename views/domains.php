<?php

/**
 * @var $this \app\core\View
 * @var $domains array
 */
$this->title = 'Области знаний';
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

    <?php
    endforeach;
    endif;
    ?>
</div>
