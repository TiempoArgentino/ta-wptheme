const {
    merge
} = require('webpack-merge')
const commonConfig = require('./webpack.config.common.js');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

const useCommonStyles = [
    // 'style-loader',
    {
        loader: 'css-loader',
        options: {
            sourceMap: true,
            importLoaders: 1
        }
    },
    {
        loader: 'postcss-loader',
        options: {
            sourceMap: true
        }
    },
    {
        loader: 'sass-loader',
        options: {
            sourceMap: true
        }
    },
];

let cssLoaderIndex = commonConfig.module.rules.findIndex(rule => String(rule.test) == String(/\.(scss|css)$/) );
commonConfig.module.rules[cssLoaderIndex].oneOf[0].use = [MiniCssExtractPlugin.loader, ...useCommonStyles],
commonConfig.module.rules[cssLoaderIndex].oneOf[1].use = ['style-loader', ...useCommonStyles],

module.exports = merge(commonConfig, {
    devtool: 'eval-cheap-source-map', // THIS SHOULD BE REMOVED !!!!!
    optimization: {
        minimize: false,
    },
})
