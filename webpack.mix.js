let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
/*
mix.js('resources/assets/js/app.js', 'public/js')
    .combine([
        'vendor/almasaeed2010/adminlte/dist/js/app.min.js',
        'vendor/almasaeed2010/adminlte/dist/js/demo.js'
    ], 'public/js/admin.js')
    .combine([
        'vendor/almasaeed2010/adminlte/dist/css/AdminLTE.min.css',
        'vendor/almasaeed2010/adminlte/dist/css/skins/_all-skins.min.css'
    ], 'public/css/admin.css')
    .copy('vendor/almasaeed2010/adminlte/dist/img/', 'public/img-lte/')
    .copy('vendor/almasaeed2010/adminlte/plugins', 'public/plugins/')
    .sass('resources/assets/sass/app.scss', 'public/css');

mix.js('resources/assets/js/app.js', 'public/js')
    .js('resources/assets/js/admin.js', 'public/js')
    .combine([
        'resources/assets/js/binaryajax.js',
        'resources/assets/js/exif.js'
        ], 'public/js/plugins.js')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .combine([
        'public/css/app.css',
        'node_modules/admin-lte/dist/css/AdminLTE.min.css',
        'node_modules/admin-lte/dist/css/skins/_all-skins.min.css',
        'node_modules/font-awesome/css/font-awesome.min.css',
        'node_modules/ionicons/dist/css/ionicons.min.css',
        'node_modules/toastr/toastr.scss',
        'node_modules/sweetalert2/dist/sweetalert2.min.css'
    ], 'public/css/admin.css');
 */
mix.js('resources/vue-src/app.js', 'public/js')
    .js('resources/vue-src/admin.js', 'public/js')
    .sass('resources/vue-src/sass/app.scss', 'public/css');

var ExtractTextPlugin = require('extract-text-webpack-plugin');
mix.webpackConfig({
    module: {
        loaders: [
            {test: /\.css$/, loader: 'style-loader!css-loader'}
        ]
    },

    plugins: [
        // extract css into its own file
        new ExtractTextPlugin({
            filename: 'public/css/admin.css'
        }),
    ]
});