import {saveArticle} from './articleAJAX';
import {editor} from "./editor";
import {setFlashMessage} from "./FlashMessages";

document.querySelector('form').onsubmit = function (ev) {
  ev.preventDefault();
  //TODO: validation
  editor.save().then(async (outputData) => {
      saveArticle({
          heading: document.querySelector("input[name='heading']").value,
          description: document.querySelector('textarea[name="description"]').value,
          article_status_id: document.querySelector('select[name="article_status"]').selectedOptions[0].value,
          article: outputData
      }, setFlashMessage('Статья успешно сохранена', true, 10000));
  })
};