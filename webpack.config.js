const path = require('path');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');

module.exports = {
    entry: ['./app/Resource/js/index.js', './app/Resource/scss/index.scss'],
    output: {
        path: path.resolve(__dirname, 'public'),
        filename: "js/index.min.js"
    },
    devtool: "source-map",

    module: {
        rules: [
            {
                test: /(\.js$|\.min\.js$)/,
                exclude: /(node_modules|bower_components)/,
                use: {
                    loader: 'babel-loader'
                }
            },
            {
                test: /\.scss$/,
                exclude: /(node_modules|bower_components)/,
                use: [
                    "style-loader",
                    "css-loader",
                    {
                        loader: 'sass-loader',
                        options: {
                            sourceMap: false,
                            sassOptions: {
                                outputStyle: 'compressed',
                            },
                        },
                    },
                ],
            }
        ]
    },
    resolve: {
        extensions: ['.js', '.scss']
    },
    optimization: {
        minimize: true,
        minimizer: [
            new UglifyJsPlugin({
                include: /\.min\.js$/,
                sourceMap: true
            })
        ]
    }
}