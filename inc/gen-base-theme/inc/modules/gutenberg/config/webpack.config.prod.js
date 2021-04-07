const { merge } = require('webpack-merge')
const commonConfig = require('./webpack.config.common.js');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
// Source maps are resource heavy and can cause out of memory issue for large source files.
const shouldUseSourceMap = process.env.GENERATE_SOURCEMAP === 'true';

module.exports = merge(commonConfig, {
    devtool: 'eval', // THIS SHOULD BE REMOVED !!!!!
    optimization: {
        minimizer: [
            // Minify the code.
            new UglifyJsPlugin({
                uglifyOptions: {
                    compress: {
                        // warnings: false,
                        // Disabled because of an issue with Uglify breaking seemingly valid code:
                        // https://github.com/facebookincubator/create-react-app/issues/2376
                        // Pending further investigation:
                        // https://github.com/mishoo/UglifyJS2/issues/2011
                        comparisons: false,
                    },
                    // mangle: {
                    //     safari10: true,
                    //     except: ['__', '_n', '_x', '_nx' ],
                    // },
                    output: {
                        comments: false,
                        // Turned on because emoji and regex is not minified properly using default
                        // https://github.com/facebookincubator/create-react-app/issues/2488
                        ascii_only: true,
                    },
                    sourceMap: shouldUseSourceMap,
                },
            })
        ],
    },
    // module: {
    //     rules: [
	// 		// {
    //         //     test: /style\.s?css$/i,
    //         //     exclude: /(node_modules|bower_components)/,
    //         //     use: [MiniCssExtractPlugin.loader, "css-loader", "sass-loader"],
    //         // },
    //     ]
    // },
})
