'use strict'

const path = require('path')
const webpack = require('webpack')
const autoprefixer = require('autoprefixer-core')
const ExtractTextPlugin = require('extract-text-webpack-plugin')
const ManifestPlugin = require('webpack-manifest-plugin')

module.exports = function makeWebpackConfig(options, ACF_ADDRESS_ROOT) {

  let BUILD = !!options.BUILD
  let TEST = !!options.TEST

  let config = {}

  config.entry = {
    address_jquery: `./${ACF_ADDRESS_ROOT}/js/address.jquery`,
    input: `./${ACF_ADDRESS_ROOT}/js/input`,
    render_field: `./${ACF_ADDRESS_ROOT}/js/render_field`,
    render_field_options: `./${ACF_ADDRESS_ROOT}/js/render_field_options`
  }

  config.resolve = {
    extensions: [ '', '.jsx', '.js' ],
    root: path.join(__dirname, ACF_ADDRESS_ROOT)
  }

  config.output = {
    path: path.join(__dirname, ACF_ADDRESS_ROOT, 'dist'),
    filename: BUILD ? '[name].[hash].js' : '[name].bundle.js',
    chunkFilename: BUILD ? '[name].[hash].js' : '[name].bundle.js'
  }

  if (TEST) {
    config.devtool = 'inline-source-map'
  } else if (BUILD) {
    config.devtool = 'source-map'
  } else {
    config.devtool = 'eval-source-map'
  }

  config.eslint = {
    fix: true
  }
  if(!BUILD) {
    config.eslint.rules = {
      "no-console": 0
    }
  }

  const LOADER_INCLUDE_PATH = path.resolve(__dirname, ACF_ADDRESS_ROOT)

  config.module = {
    preLoaders: [
      { test: /\.jsx?$/, loader: 'eslint-loader', include: LOADER_INCLUDE_PATH, exclude: /node_modules/ }
    ],
    loaders: [
      { test: /\.json$/, loader: 'json' },
      { test: /\.jsx?$/, loader: 'babel?cacheDirectory', include: LOADER_INCLUDE_PATH }
    ]
  }

  let cssLoader = {
    test: /\.(css|scss)$/,
    loader: ExtractTextPlugin.extract('style', 'css?sourceMap!postcss!sass?sourceMap')
  }

  if (TEST) {
    cssLoader.loader = 'null'
  }

  config.module.loaders.push(cssLoader)

  config.postcss = [
    autoprefixer({
      browsers: [ 'last 2 version' ]
    })
  ]

  // definePlugin takes raw strings and inserts them, so you can put strings of JS if you want.
  let definePlugin = new webpack.DefinePlugin({
    __PROD__: JSON.stringify(JSON.parse(BUILD || false))
  })

  config.plugins = [
    definePlugin,
    new ExtractTextPlugin('[name].[hash].css', {
      disable: !BUILD || TEST
    }),
    new ManifestPlugin({
      fileName: 'manifest.json',
      basePath: ''
    })
  ]

  if (BUILD) {
    config.plugins.push(
      new webpack.NoErrorsPlugin(),
      new webpack.optimize.DedupePlugin(),
      new webpack.optimize.UglifyJsPlugin()
    )
  }

  return config
}
