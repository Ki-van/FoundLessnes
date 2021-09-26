<?php
/**
 * @var  Visit[] $model
 */

use app\models\Visit;

$this->title = 'Панель администратора';
?>

<div class="art-post-body">
    <h1>Статистика</h1>
    <?php
    foreach ($model as $item)
    {
        echo "<p>".$item['ip'].'</p><br>';
    }
    ?>
</div>