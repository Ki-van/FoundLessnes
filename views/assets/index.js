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


window.onbeforeunload = save_progress;
document.getElementById("to_meta_stage").onclick = function () {
    document.querySelector(".editing_stage").setAttribute("hidden", true);
    document.querySelector(".meta_stage").removeAttribute("hidden");
};

document.getElementById("to_editing_stage").onclick = function () {
    document.querySelector(".meta_stage").setAttribute("hidden", true);
    document.querySelector(".editing_stage").removeAttribute("hidden");
};


function save_progress(ev) {
    //TODO: Validate article
    editor.save().then((outputData) => {
        let xmlHttp = new XMLHttpRequest();
        xmlHttp.open('post', '/api/article', true);
        xmlHttp.setRequestHeader("Content-Type", "application/json");
        xmlHttp.send(JSON.stringify(
            {
                article_status: 'creating',
                article: outputData
            }));
    })
}

