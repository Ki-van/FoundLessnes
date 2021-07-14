const { merge } = require('webpack-merge')

module.exports = merge(require('./config.base.js'), {
    mode: 'production',
    entry: '/views/assets',
    // We'll place webpack configuration for production environment here
})