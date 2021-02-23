const path = require('path');

const packageRelative = '../../../../gutenberg';
const devRelativePath = `${packageRelative}/src`;
const relativeBlocks = `${devRelativePath}/blocks`;

module.exports = {
    prod: path.resolve(__dirname, `../${packageRelative}/dist`),
    dev: path.resolve(__dirname, `../${devRelativePath}`),
    externals: path.resolve(__dirname, `externals.js`),
    relativeBlocks: relativeBlocks,
    relativeBlocksJS: `${relativeBlocks}/*/block.js`,
}
