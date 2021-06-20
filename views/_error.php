<?php
/**
 * @var $exception Exception
 * @var $this View
 */

use app\core\View;

$this->title = 'Ошибка';
?>

<div class="art-post-body">
<h3><?php echo $exception->getCode()?></h3>
    <div class="art-post-content">
        <p>
            <?php echo $exception->getMessage()?>
        </p>
    </div>
</div>