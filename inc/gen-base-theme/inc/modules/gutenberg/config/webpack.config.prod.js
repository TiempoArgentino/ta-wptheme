const paths = require( './paths' );
const { merge } = require('webpack-merge')
const commonConfig = require( './webpack.config.common.js' );
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

// Source maps are resource heavy and can cause out of memory issue for large source files.
const shouldUseSourceMap = process.env.GENERATE_SOURCEMAP === 'true';

function escapeRegExp(string) {
	return string.replace(/[.*+?^${}()|[​\]\\]/g, '\\$&'); // $& means the whole matched string
}

function blockNameByStyleModule(module, cssFilename = 'editor', prefix = ''){
	const path = require('path');
	const pathSep = escapeRegExp(path.sep);
	//gutenberg\\src\\blocks\\(.+?(?=\\))\\css\\${cssFilename}\.s?css$
	const expresion = new RegExp(`gutenberg${pathSep}src${pathSep}blocks${pathSep}(.+?(?=${pathSep}))${pathSep}css${pathSep}${cssFilename}\\.s?css`);
	const match = module.identifier().match(expresion);
	return match ? `${prefix}${match[1]}` : null;
}

function blockNameByMainScriptModule(module){
	const path = require('path');
	const pathSep = escapeRegExp(path.sep);
	//gutenberg\\src\\blocks\\(.+?(?=\\))\\css\\block.js$
	const expresion = new RegExp(`gutenberg${pathSep}src${pathSep}blocks${pathSep}(.+?(?=${pathSep}))${pathSep}block\\.js`);
	const match = module.identifier().match(expresion);
	return match ? `${match[1]}` : null;
}

module.exports = merge(commonConfig, {
    devtool: 'eval', // THIS SHOULD BE REMOVED !!!!!
    output: {
		filename: 'blocks/[name]/block.min.js',//'moduleName/script.js', [name] - key from entryObject
        path: paths.prod,
		chunkLoadingGlobal: 'testConfigChunks',
    },
    plugins: [
        new MiniCssExtractPlugin({
          filename: ({ chunk }) => function(){
			  console.log('CHUNK NAME: ', chunk.name, '\n\n');
			  if( chunk.name ){
				  if( chunk.name.startsWith('editorStyles__') ){
					  return `blocks/${chunk.name.replace('editorStyles__', '')}/css/editor.min.css`;
				  }
				  else if( chunk.name.startsWith('frontStyles__') ){
					  return `blocks/${chunk.name.replace('frontStyles__', '')}/css/style.min.css`;
				  }
			  }
			  return 'css/styles.min.css';
		  },
          // chunkFilename: "[name].css"
        })
    ],
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
        splitChunks: {
            cacheGroups: {
				blocksJs: {
					name: module => {
						return blockNameByMainScriptModule(module);
					},
					test: module => {
						return blockNameByMainScriptModule(module);
					},
					chunks: 'all',
					enforce: true,
				},
				editorStyles: {
					name: module => {
						return blockNameByStyleModule(module, 'editor', 'editorStyles__');
                    },
					test: module => {
						return blockNameByStyleModule(module, 'editor', 'editorStyles__');
					},
					chunks: 'all',
					enforce: true,
				},
                frontStyles: {
					name: module => {
						return blockNameByStyleModule(module, 'style', 'frontStyles__');
                    },
					test: module => {
						return blockNameByStyleModule(module, 'style', 'frontStyles__');
					},
					chunks: 'all',
					enforce: true,
                },
				// styles: {
				// 	name: 'styles',
				// 	test: /\.s?css$/,
				// 	chunks: 'all',
				// 	enforce: true,
				// 	priority: 20,
				// },
            }
        },
    },
    module: {
        rules: [
            {
                test: /\.s?css$/i,
                exclude: /(node_modules|bower_components)/,
                use: [MiniCssExtractPlugin.loader, "css-loader", "sass-loader"],
            },
        ]
    },
})
