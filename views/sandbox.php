<?php

/**
 * @var $model \app\models\Article
 * @var $this \app\core\View
 */

$this->title = 'Создание публикации';
?>

<div class="block">
    <h2 class="art-post-header">
        <img src="/images/cross.png" alt="CROSS" width="22" height="32">
        <a href="#">
            Создание публикации
        </a>
    </h2>
    <div class="art-post-content">
        <h4>Если вы хотите стать частью ПСИХ, прочитайте текст ниже:</h4>
        <p>ПСИХ - уважаемае мной и организованное мной движение, участники которого ищущие люди, требующие от себя
            смотреть дальше своего носа. Целью движения не является коммерческая выгода, а чистый, идеальный интерес.
            Если вы прочитали Созерцание чистого разума и решили что познали истину, вам будут рады, но не у нас) </p>
        <p>Участие в движении не предполагает авторизации, но так вы сможите называться своим именем и вас будет легко
            отличить от других учавствующих.</p>
        <p>Если вы чувствуете, что можете дополнить картину надистины, прикрепите вашу статью в форме ниже и в ходе
            обсуждения мы найдем ей место на карта прогресса</p>
        <p>Пожалуйста, структурируйте ваши статьи, в потоке сознания искать иглу, что наркоману продеть нитку в ту же
            иглу, занятие интересное, но не для нас. (ДОЗУ)</p>
    </div>
</div>
<div class="block editing_stage">
    <div id="editorjs" class="art-post-content"></div>
    <button class="btn" id="to_meta_stage">Готов к публикации</button>
</div>
<div class="block meta_stage" hidden>
    <div class="block">
        <h2 class="art-post-header">
            <img src="/images/cross.png" alt="CROSS" width="22" height="32">
            <a href="#">
                Настройки публикации
            </a>
        </h2>
    </div>
    <div class="block">
        <?php

        use app\core\form\Form;
        use app\core\form\TextareaField;

        $form = Form::begin('', 'post'); ?>
        <?php echo $form->field($model, 'heading') ?>
        <?php echo new TextareaField($model, 'description'); ?>
        <?php ?>

        <div class="form-group">
            <button class="btn" id="send">Отправить на модерацию</button>
        </div>
        <?php Form::end() ?>
    </div>
    <button class="btn" id="to_editing_stage">Назад к публикации</button>
</div>

<script src="/assets/scripts.js"></script>