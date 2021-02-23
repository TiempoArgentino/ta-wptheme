const paths = require( './paths' );
const autoprefixer = require( 'autoprefixer' );
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const glob = require('glob');

function escapeRegExp(string) {
  return string.replace(/[.*+?^${}()|[\]\\\/]/g, '\\$&'); // $& means the whole matched string
}

//Generate object for webpack entry
var entryObject = glob.sync(paths.relativeBlocksJS).reduce(
    function (entries, entry) {
        const pathEscaped = escapeRegExp(paths.relativeBlocks);
        const regexpString = `${pathEscaped}\/([\\-\\w\\d_]+)\/block\\.js$`;
        const regexp = new RegExp(regexpString,"g");
        var matchForRename = regexp.exec(entry);

        if (matchForRename !== null && typeof matchForRename[1] !== 'undefined')
            entries[matchForRename[1]] = entry;

        return entries;
    },
    {}
);

module.exports = {
    entry: entryObject,
	output: {
		filename: 'blocks/[name]/block.min.js',//'moduleName/script.js', [name] - key from entryObject
        path: paths.prod,
		// chunkLoadingGlobal: 'testConfigChunks',
    },
    module: {
        rules: [
            {
                test: /\.m?js$/,
                exclude: /(node_modules|bower_components)/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env']
                    }
                }
            },
        ]
    },
	externals: require( paths.externals ),
};
