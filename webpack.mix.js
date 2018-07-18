let mix = require('laravel-mix');

mix.webpackConfig({
  resolve: {
    extensions: ['.js', '.vue', '.json'],
    alias: {
      'components': 'assets/js/components',
      'api': 'assets/js/api',
      'common': 'assets/js/common'
    },
    modules: [
      'node_modules',
      path.resolve(__dirname, "resources")
    ]
  },
  output: {
    publicPath: "/",
    chunkFilename: 'js/lazy/[name].js'
  }
})

mix.js('resources/assets/js/main.js', 'public/js')
   .stylus('resources/assets/stylus/index.styl', 'public/css')
   .stylus('resources/assets/stylus/element.styl', 'public/css')
   .extract(['vue'])
