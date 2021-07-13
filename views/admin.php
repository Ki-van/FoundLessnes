<?php
/**
 * @var $this \app\core\View
 */

    $this->title = 'Панель администратора';
?>

<div class="art-post-body">
    <h1>Админские штучки</h1>
</div>

<div id="editorjs" style="height: 300px; background: white;">

</div>

<script src="/assets/editor.js"></script>
<script>
    const editor = new EditorJS({
        /**
         * Id of Element that should contain Editor instance
         */
        holder: 'editorjs',
        onReady: () => {
            console.log('Editor.js is ready to work!')
        }
    });
</script>