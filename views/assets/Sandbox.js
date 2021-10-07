import {Article} from './Article';
import {editor} from "./editor";
import {setFlashMessage} from "./FlashMessages";

document.querySelector("form").addEventListener("submit", function (ev) {
  ev.preventDefault();
    editor.save().then((outputData)=> {
        Article.send({
            heading: document.querySelector("[name='heading']").value,
            description: document.querySelector('textarea[name="description"]').value,
            tag_ids: Array.from(document.querySelector('select[name="tag_ids"]').selectedOptions).map(el => el.value),
            domain_id: document.querySelector('select[name="domain_id"]').selectedOptions[0].value,
            article: outputData
        }, 'create', () => {
            setFlashMessage('Статья успешно отправлена на модерацию', true, 5000);
            document.querySelector(".meta_stage").setAttribute("hidden", true);
            setTimeout(()=>{
                location.replace("/profile");
            }, 5000)
        });
    });
});

/*window.addEventListener("beforeunload", function (e) {
    save_progress();
    e.returnValue = null;
    return null;
});*/


document.getElementById("to_meta_stage").onclick = function () {
    document.querySelector(".editing_stage").setAttribute("hidden", true);
    document.querySelector(".meta_stage").removeAttribute("hidden");
};

document.getElementById("to_editing_stage").onclick = function () {
    document.querySelector("input[name='heading']").value = editor.blocks.getBlockByIndex(0);
    document.querySelector(".meta_stage").setAttribute("hidden", true);
    document.querySelector(".editing_stage").removeAttribute("hidden");
};

