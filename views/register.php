<?php

/**
 * @var $model \app\models\User
 * @var $this \app\core\View
 */

$this->title = 'Регистрация';
?>

<div class="block">

    <h2 class="art-post-header">
        <img src="images/cross.png" alt="CROSS" width="22" height="32">
        <a href="#">
            Регистрация
        </a>

    </h2>

    <?php

    use app\core\form\Form;

    $form = Form::begin('', 'post'); ?>
    <?php echo $form->field($model, 'username') ?>
    <?php echo $form->field($model, 'email') ?>
    <?php echo $form->field($model, 'password')->passwordField() ?>
    <?php echo $form->field($model, 'passwordConfirm')->passwordField() ?>
    <div class="form-group">
        <input name="submit" type="submit" value="Регистрация">
    </div>
    <?php Form::end() ?>

</div>