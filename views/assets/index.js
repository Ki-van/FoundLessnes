import EditorJS from '@editorjs/editorjs';
import ImageTool from '@editorjs/image';

const Header = require('@editorjs/header');
import List from '@editorjs/list';


const editor = new EditorJS({

    holder: 'editorjs',

    tools: {
        header: Header,
        list: List,
        image: {
            class: ImageTool,
            config: {
                endpoints: {
                    byFile: 'http://localhost:8000/api/uploadFile',
                    byUrl: 'http://localhost:8000/api/uploadbyUrl',
                }
            }
        }
    },
    autofocus: true,

    data: {
        "blocks": [
            {
                "type": "header",
                "data": {
                    "text": "Заголовок",
                    "level": 2
                }
            },
            {
                "type": "paragraph",
                "data": {
                    "text": "Содержание публикации"
                }
            }
        ],
    },
});
document.querySelector("form").addEventListener("submit", function (ev) {
  ev.preventDefault();
    saveArticle('moderated', function () {
        window.location.replace('../../');
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


function saveArticle(status, callback) {
    //TODO: Validate article
    editor.save().then( async (outputData) => {
        let xmlHttp = new XMLHttpRequest();
        xmlHttp.open('post', '/api/article', true);
        xmlHttp.setRequestHeader("Content-Type", "application/json charset=utf-8");
        xmlHttp.onreadystatechange = function() {
          if(xmlHttp.readyState === XMLHttpRequest.DONE && xmlHttp.status === 200)
          {
                  callback();
          }
        };

        await xmlHttp.send(JSON.stringify(
            {
                heading: document.querySelector("input[name='heading']").value,
                description: document.querySelector('textarea[name="description"]').value,
                article_status: status,
                article: outputData
            }));
    })
    return false;
}

