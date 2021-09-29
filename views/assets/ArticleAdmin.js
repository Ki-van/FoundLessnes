import {Article} from './Article';
import {editor} from "./editor";
import {setFlashMessage} from "./FlashMessages";

document.querySelector('form').onsubmit = function (ev) {
  ev.preventDefault();

  editor.save().then(async (outputData) => {
      await Article.send({
          article_eval_id: article_eval_id,
          heading: document.querySelector("input[name='heading']").value,
          description: document.querySelector('textarea[name="description"]').value,
          status_id: document.querySelector('select[name="article_status"]').selectedOptions[0].value,
          alias: document.querySelector('input[name="alias"]').value,
          body: outputData
      }, "update", () => setFlashMessage('Статья успешно сохранена', true, 5000));
  })
};