    <div class="art-post-body">

    <h2 class="art-post-header">
        <img src="images/cross.png" alt="CROSS" width="22" height="32">
        <a href="#">
            Регистрация
        </a>

    </h2>

    <?php $form =  \app\core\form\Form::begin('', 'post'); ?>
        <?php echo $form->field($model, 'name')?>
        <?php echo $form->field($model, 'email')?>
        <?php echo $form->field($model, 'password')->passwordField()?>
        <?php echo $form->field($model, 'passwordConfirm')->passwordField()?>
        <div class="form-group">
            <input name="submit" type="submit" value="Регистрация">
        </div>
    <?php \app\core\form\Form::end() ?>

</div>