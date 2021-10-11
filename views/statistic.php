<?php
/**
 * @var  Visit[] $model
 */

use app\models\Visit;

$this->title = 'Панель администратора';
?>

<div class="block">
    <h2 class="art-post-header">
        <img src="/images/cross.png" alt="CROSS" width="22" height="32">
        <a href="#">
            Статистика
        </a>
    </h2>
    <?php
    foreach ($model as $item)
    {

        echo "<div class='block'><span>".$item['ip'].'</span></div>';
    }
    ?>
</div>