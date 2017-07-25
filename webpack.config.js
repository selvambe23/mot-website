const webpack = require('webpack'),
    path = require('path'),
    ExtractTextPlugin = require('extract-text-webpack-plugin'),
    extractCSS = new ExtractTextPlugin('style/[name].[contenthash:20].css'),
    CleanWebpackPlugin = require('clean-webpack-plugin'),
    WebpackAssetsManifest = require('webpack-assets-manifest'),
    PATH = {
        public: path.resolve(__dirname, 'web/app/themes/krds/assets'),
        build: path.resolve(__dirname, 'web/app/themes/krds/build')
    },
    isLocal = (process.env.NODE_ENV === 'local');

console.log('NODE_ENV:', process.env.NODE_ENV);

const rules = [{
        test: /\.js$/,
        exclude: [/node_modules/],
        use: 'babel-loader'
    },
    {
        test: /\.(less|css)$/,
        use: extractCSS.extract({
            fallback: 'style-loader',
            use: `css-loader?${ isLocal ? 'sourceMap' : 'minimize' }!postcss-loader!less-loader?sourceMap`
            //minimize css in build to avoid bundling newline chars in js chunk
        })
    },
    {
        test: /\.(jpe?g|png|gif|webp|mp3|ogg|woff|woff2|ttf|svg|eot)$/,
        exclude: [/node_modules/],
        use: 'file-loader?name=[path][name].[hash:8].[ext]'
    },
    { //can't use [path] for images inside node_modules, so copy them to build
        test: /\.(jpe?g|png|gif|webp)$/,
        include: [/node_modules/],
        use: 'file-loader?name=build/img/[name].[hash:8].[ext]'
    },
    { //can't use [path] for fonts inside node_modules, so copy them to build
        test: /\.(woff|woff2|ttf|svg|eot)$/,
        include: [/node_modules/],
        use: 'file-loader?name=build/font/[name].[hash:8].[ext]'
    }
]

const plugins = [
    extractCSS,
    // To prevent longterm cache of vendor chunks
    // extract a 'manifest' chunk, then include it to the app
    new webpack.optimize.CommonsChunkPlugin({
        names: ['lib', 'manifest']
    }),
    //automatically load the modules
    //when the key is identified in a file
    new webpack.ProvidePlugin({
        $: 'jquery',
        jQuery: 'jquery'
    }),
    // create manifest json to refer assets in php file
    new WebpackAssetsManifest({
        output: 'webpack-manifest.json',
        publicPath: '/build/',
        writeToDisk: true //php needs this to read file from disk
    })
]

const buildPlugins = [
    new CleanWebpackPlugin(PATH.build),
    new webpack.optimize.UglifyJsPlugin({
        compress: {
            drop_console: true
        }
    })
]

//add buildPlugins in non local env
!isLocal && plugins.push.apply(plugins, buildPlugins);

module.exports = {

    devtool: isLocal ? 'source-map' : false,

    entry: {
        main: 'js/main',
        lib: ['jquery']
    },

    context: PATH.public,

    output: {
        path: PATH.build,
        publicPath: '/app/themes/krds/build/',
        filename: 'js/[name].[chunkhash].js',
        chunkFilename: 'js/[chunkhash].js'
    },

    devServer: {
        host: '0.0.0.0',
        port: 8000,
        disableHostCheck: true,
        inline: true,
        compress: true,
        proxy: {
            '*': {
                target: 'http://localhost:8001'
            }
        }
    },

    plugins: plugins,

    module: {
        rules: rules
    },

    resolve: {
        modules: ['node_modules', PATH.public, 'web/app/plugins/'],
        extensions: ['.js', '.less'],
        descriptionFiles: ['package.json', 'bower.json', '.bower.json']
    },

    watchOptions: {
        ignored: /(node_modules)/
    }

}