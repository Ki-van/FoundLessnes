const path = require('path')
const { SRC, DIST, ASSETS } = require('./paths')

module.exports = {
    entry: {
        scripts: path.resolve(SRC, 'js', 'index.js')
    },
    output: {
        path: DIST,
        filename: 'scripts.js',
        publicPath: ASSETS
    }
}