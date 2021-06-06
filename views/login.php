<div class="art-post-body">
    <div class="art-post-body">
        <h2 class="art-post-header">
            <img src="images/cross.png" alt="CROSS" width="22" height="32">
            <a href="#">
                Регистрация
            </a>

        </h2>
    </div>

    <form  name="article_form" action="" enctype="multipart/form-data" method="post" >
        <div class="form-wrapper">
            <label>
                <span class="form-label-text">Тема статьи</span>
                <input name="article-theme" class="field" type="text" >
            </label>
            <label>
                <span class="form-label-text">Описание статьи</span>
                <textarea name="article-brief" class="field"></textarea>
            </label>
            <label>
                <span class="form-label-text">Почта</span>
                <input name="email" type="text" class="field" class="field" >
            </label>
            <label>
                <span class="form-label-text">Статья</span>
                <input name="article" type="file" multiple accept="text/plain,application/msword,application/pdf,">
            </label>
            <div class="form-submit-button">
                <input name="submit" type="submit" value="Отправить">
            </div>
        </div>
    </form>
</div>