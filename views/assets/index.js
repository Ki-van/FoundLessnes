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
});
document.getElementById('article_save').onclick = function (ev) {

    editor.save().then((outputData) => {

        if(outputData?.blocks?[0]?['type'] === 'header' && )

        let xmlHttp = new XMLHttpRequest();
        xmlHttp.open('post','/api/article', true);
        xmlHttp.setRequestHeader("Content-Type", "application/json");
        xmlHttp.send(JSON.stringify(outputData));
    })
};

/**
 *
 * @param data
 */

function firstBlock(data){
    return
}

