const { merge } = require('webpack-merge')
const commonConfig = require('./webpack.config.common.js');

module.exports = merge(commonConfig, {
    devtool: 'eval-cheap-source-map', // THIS SHOULD BE REMOVED !!!!!
    optimization: {
        minimize: false,
    },
    module: {
        rules: [
            {
              test: /\.(scss|css)$/,
              use: [
                'style-loader',
                {loader: 'css-loader', options: {sourceMap: true, importLoaders: 1}},
                {loader: 'postcss-loader', options: {sourceMap: true}},
                {loader: 'sass-loader', options: {sourceMap: true}},
              ],
            },
        ]
    },
})
