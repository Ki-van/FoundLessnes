const path = require('path');

module.exports = {
    mode: 'development',
    entry: {
        scripts: './views/assets/index.js',
        articleAdmin: './views/assets/articleAdmin.js',
    },
    output: {
        path: path.resolve(__dirname, 'public', 'assets'),
        filename: '[name].bundle.js',
    }
}