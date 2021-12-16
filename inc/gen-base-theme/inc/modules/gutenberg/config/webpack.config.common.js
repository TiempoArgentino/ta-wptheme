const paths = require('./paths');
const autoprefixer = require('autoprefixer');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const glob = require('glob');

//Generate object for webpack entry
var entryObject = glob.sync(paths.relativeBlocksJS).reduce(
    function(entries, entry) {
        const pathEscaped = escapeRegExp(paths.relativeBlocks);
        const regexpString = `${pathEscaped}\/([\\-\\w\\d_]+)\/block\\.js$`;
        const regexp = new RegExp(regexpString, "g");
        var matchForRename = regexp.exec(entry);

        if (matchForRename !== null && typeof matchForRename[1] !== 'undefined')
            entries[matchForRename[1]] = entry;

        return entries;
    }, {}
);

console.log('ENTRIES:', entryObject);

module.exports = {
    entry: entryObject,
    output: {
        filename: (data) => {
            console.log('Output file name:', data.chunk.name);
            return `blocks/${data.chunk.name}/block.min.js`;
        }, //'moduleName/script.js', [name] - key from entryObject
        path: paths.prod,
        // chunkLoadingGlobal: 'testConfigChunks',
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: ({
                chunk
            }) => function() {
                console.log('CHUNK NAME: ', chunk.name, '\n\n');
                if (chunk.name) {
                    if (chunk.name.startsWith('editorStyles__')) {
                        return `blocks/${chunk.name.replace('editorStyles__', '')}/css/editor.min.css`;
                    } else if (chunk.name.startsWith('frontStyles__')) {
                        return `blocks/${chunk.name.replace('frontStyles__', '')}/css/style.min.css`;
                    }
                }
                return `css/${chunk.name}-styles.min.css`;
            },
            // chunkFilename: "[name].css",
        })
    ],
    optimization: {
        splitChunks: {
            cacheGroups: {
                // blocksJs: {
                // 	name: module => {
                // 		return blockNameByMainScriptModule(module);
                // 	},
                // 	test: module => {
                // 		return blockNameByMainScriptModule(module);
                // 	},
                // 	chunks: 'all',
                // 	enforce: true,
                // },
                editorStyles: {
                    name: module => {
                        return blockNameByStyleModule(module, 'editor', 'editorStyles__');
                    },
                    test: (module, chunks) => {
                        return module.type == 'css/mini-extract' && blockNameByStyleModule(module, 'editor', 'editorStyles__');
                    },
                    chunks: 'all',
                    reuseExistingChunk: true,
                    enforce: true,
                },
                frontStyles: {
                    name: module => {
                        return blockNameByStyleModule(module, 'style', 'frontStyles__');
                    },
                    test: module => {
                        return module.type == 'css/mini-extract' && blockNameByStyleModule(module, 'style', 'frontStyles__');
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
        rules: [{
                test: /\.m?js$/,
                exclude: /(node_modules|bower_components)/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env']
                    }
                }
            },
            {
                test: /\.(scss|css)$/,
                oneOf: [{
                        test: function(name) {
                            return isEditorStylePath(name) || isFrontStylePath(name);
                        },
                        use: [MiniCssExtractPlugin.loader, "css-loader", "sass-loader"],
                    },
                    {
                        test: name => true,
                        use: ["style-loader", "css-loader", "sass-loader"],
                    }
                ]
            },
            {
                test: /\.(gif|png|jpe?g|svg)$/i,
                use: [
                    'file-loader',
                    {
                        loader: 'image-webpack-loader',
                        options: {
                            bypassOnDebug: true, // webpack@1.x
                            disable: true, // webpack@2.x and newer
                        },
                    },
                ],
            }
        ]
    },
    externals: require(paths.externals),
};


function escapeRegExp(string) {
    return string.replace(/[.*+?^${}()|[\]\\\/]/g, '\\$&'); // $& means the whole matched string
}

function isBlockCssPath(stylePath, cssFilename) {
    const path = require('path');
    const pathSep = escapeRegExp(path.sep);
    //gutenberg\\src\\blocks\\(.+?(?=\\))\\css\\${cssFilename}\.s?css$
    const expresion = new RegExp(`gutenberg${pathSep}src${pathSep}blocks${pathSep}(.+?(?=${pathSep}))${pathSep}css${pathSep}${cssFilename}\\.s?css`);
    const match = stylePath.match(expresion);
    return match ? `${match[1]}` : null;
}

function blockNameByStyleModule(module, cssFilename = 'editor', prefix = '') {
    const blockName = isBlockCssPath(module.identifier(), cssFilename);
    return blockName ? `${prefix}${blockName}` : null;
}

function blockNameByMainScriptModule(module) {
    const path = require('path');
    const pathSep = escapeRegExp(path.sep);
    //gutenberg\\src\\blocks\\(.+?(?=\\))\\css\\block.js$
    const expresion = new RegExp(`gutenberg${pathSep}src${pathSep}blocks${pathSep}(.+?(?=${pathSep}))${pathSep}block\\.js`);
    const match = module.identifier().match(expresion);
    return match ? `${match[1]}` : null;
}

function isEditorStylePath(stylePath) {
    return isBlockCssPath(stylePath, 'editor');
}

function isFrontStylePath(stylePath) {
    return isBlockCssPath(stylePath, 'style');
}
