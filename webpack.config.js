const path = require('path');

module.exports = {
    mode: 'development',
    entry: {
        Sandbox: './views/assets/Sandbox.js',
        ArticleAdmin: './views/assets/ArticleAdmin.js',
    },
    output: {
        path: path.resolve(__dirname, 'public', 'assets'),
        filename: '[name].bundle.js',
    }
}