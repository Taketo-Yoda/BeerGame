const path = require('path');
webpack = require('webpack');

module.exports = {
    // コンパイルモード
    mode: 'production',
    // エントリーポイントの設定
    entry: path.resolve(__dirname, "./src/index.js"),
    // 出力先の設定
    output: {
        path: path.resolve(__dirname, 'webroot/js'),
        filename: 'index.js'
    },
    // スタイルシートの読み込み
    module: {
        rules: [
            {
                test: /\.css$/,
                use: ['style-loader', 'css-loader']
            }
        ]
    },
    // JQuery読み込み
    plugins: [
        new webpack.ProvidePlugin({
            $: 'jquery',
            jQuery: 'jquery',
            "window.$": "jquery"
        })
    ]
};