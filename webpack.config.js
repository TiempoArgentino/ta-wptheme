const path = require('path');
const {
    readdirSync,
    existsSync
} = require('fs')

/**
 *   Multiple configurations for every single module
 */
const configs = [];

/**
 *   Common configuration between bundles
 */
const moduleCommons = {
    rules: [{
        test: /\.m?js$/,
        exclude: /(node_modules|bower_components)/,
        use: {
            loader: 'babel-loader',
            options: {
                presets: ['@babel/preset-env']
            }
        }
    }]
};

/**
 *   Bundle for every inc/modules/:moduleName/index.js
 */
if (existsSync('./inc/modules')){
     readdirSync('./inc/modules', {
             withFileTypes: true
         })
         .filter(dirent => dirent.isDirectory())
         .forEach((moduleFolder, i) => {
             const scriptFile = `./inc/modules/${moduleFolder.name}/index.js`;
             if (!existsSync(scriptFile))
                 return;

             configs.push({
                 entry: scriptFile,
                 output: {
                     filename: 'index.min.js',
                     path: path.resolve(__dirname, `inc/modules/${moduleFolder.name}`),
                 },
                 module: moduleCommons,
             })
         });

}

/**
 *   Bundle for every components/:componentName/index.js
 */
if (existsSync('./components')){
    readdirSync('./components', {
            withFileTypes: true
        })
        .filter(dirent => dirent.isDirectory())
        .forEach((componentFolder, i) => {
            const scriptFile = `./components/${componentFolder.name}/index.js`;
            if (!existsSync(scriptFile))
                return;

            configs.push({
                entry: scriptFile,
                output: {
                    filename: 'index.min.js',
                    path: path.resolve(__dirname, `components/${componentFolder.name}/dist`),
                },
                module: moduleCommons,
            })
        });
}

module.exports = configs;
