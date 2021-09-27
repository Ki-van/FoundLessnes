const path = require('path');

module.exports = {
    mode: 'development',
    entry: {
        scripts: './views/assets/index.js',
        editor: './views/assets/editor.js',
        articleAJAX: './views/assets/articleAJAX.js'
    },
    output: {
        path: path.resolve(__dirname, 'public', 'assets'),
        filename: '[name].bundle.js',
    }
}