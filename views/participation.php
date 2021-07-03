<?php
/**
 * @var $this \app\core\View
 * @var $model \app\models\ParticipationForm
 */
use app\core\form\TextareaField;
use app\core\form\InputFileField;

$this->title = 'Участие';
?>

<div class="art-post-body">
    <div class="art-post-body">
        <h2 class="art-post-header">
            <img src="images/cross.png" alt="CROSS" width="22" height="32">
            <a href="#">
                Участие
            </a>

        </h2>
    </div>
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


    <?php use app\core\form\Form;


    $form = Form::begin('', 'post','multipart/form-data'); ?>
    <?php echo $form->field($model, 'heading') ?>
    <?php echo new TextareaField($model, 'description'); ?>
    <?php echo $form->field($model, 'email') ?>
    <?php echo (new InputFileField($model, 'files'))
        ->accept($model->rules()['files'][1]['file_accept']) //TODO: add search for rule param in rules by name
        ->multiple(true); ?>

    <div class="form-group">
        <input name="submit" type="submit" value="Отправить">
    </div>
    <?php Form::end() ?>
</div>