const path = require('path');

module.exports = {
    mode: 'development',
    entry: {
        scripts: './views/assets/index.js',
        articleView: './views/assets/articleView.js'
    },
    output: {
        path: path.resolve(__dirname, 'public', 'assets'),
        filename: '[name].bundle.js',
    }
}