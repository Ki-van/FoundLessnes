import EditorJS from '@editorjs/editorjs';
import ImageTool from '@editorjs/image';
const Header = require('@editorjs/header');
import List from '@editorjs/list';



const editor = new EditorJS({

    holder: 'editorjs',

    tools: {
        header: Header,
        list: List,
        image: ImageTool
    },
});

