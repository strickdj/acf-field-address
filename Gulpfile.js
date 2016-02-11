'use strict'
require('dotenv').config()

const gulp = require('gulp')
const gulpsync = require('gulp-sync')(gulp)
const gutil = require('gulp-util')
const dbTask = require('gulp-db')
const mysqldump = require('mysqldump')
const gmcfp = require('gulp-mysql-command-file-processor')
const livereload = require('gulp-livereload')
const webpack = require('webpack')
const del = require('del')
const fs = require('fs')

const ACF_ADDRESS_ROOT = process.env.ACF_ADDRESS_ROOT

/* ------------------------- Gulp Tasks -------------------------------- */

/**
 * Gulp
 * default task: `gulp`
 * alias for `gulp build`
 */
gulp.task('default', [ 'build' ])

/**
 * Gulp watch `gulp watch`
 * Watch Files For Changes and recompile on change.
 */
gulp.task('watch', [ 'webpack:build-dev', 'webpack:watch-dev' ])


gulp.task('webpack:watch-dev', () => {
  livereload.listen()
  gulp.watch(`./${ACF_ADDRESS_ROOT}/**/*.php`, [ 'livereload' ])
  gulp.watch(`./${ACF_ADDRESS_ROOT}/js/*.js`, [ 'webpack:build-dev' ])
  gulp.watch(`./${ACF_ADDRESS_ROOT}/scss/*.scss`, [ 'webpack:build-dev' ])
})

gulp.task('livereload', (cb) => {
  livereload.reload()
  cb()
})

gulp.task('build', gulpsync.sync([ 'clean:dist', [ 'webpack:build' ] ]))

gulp.task('clean:dist', () => {
  return del([
    `${ACF_ADDRESS_ROOT}/dist/*`
  ])
})

gulp.task('webpack:build', (cb) => {
  let webpackConfig = Object.create(require('./webpack.make')({
    BUILD: true,
    TEST: false
  }, ACF_ADDRESS_ROOT))
  let compiler = webpack(webpackConfig)

  compiler.run((err, stats) => {
    if(err) throw new gutil.PluginError('webpack:build', err)
    gutil.log('[webpack:build]', stats.toString({
      colors: true
    }))
    cb()
  })

})

let webpackDevConfig = Object.create(require('./webpack.make')({
  BUILD: false,
  TEST: false
}, ACF_ADDRESS_ROOT))
// create a single instance of the compiler to allow caching
let devCompiler = webpack(webpackDevConfig)

gulp.task('webpack:build-dev', (cb) => {
  // run webpack
  devCompiler.run((err, stats) => {
    if(err) throw new gutil.PluginError('webpack:build-dev', err)
    gutil.log('[webpack:build-dev]', stats.toString({
      colors: true
    }))
    livereload.reload()
    cb()
  })
})

/* ------------------------- Gulp Deploy Tasks -------------------------------- */

/**
 * Gulp Database Init `gulp db:init`
 * Initializes your local database with test database.
 */
gulp.task('db:init', gulpsync.sync([ 'db:drop', 'db:create', 'db:populate' ]))

let dbConfig = {
  host: process.env.DB_HOST,
  user: process.env.DB_USER,
  password: process.env.DB_PASSWORD,
  database: process.env.DB_NAME,
  port: process.env.DB_PORT || 3306
}

let dbManager = dbTask(Object.assign({}, dbConfig, { dialect: 'mysql', database: null }))

gulp.task('db:create', dbManager.create(process.env.DB_NAME))

gulp.task('db:drop', dbManager.drop(process.env.DB_NAME))

gulp.task('db:populate', cb => {
  gulp.src('./tests/_data/dump.sql')
    .pipe(gmcfp(dbConfig.user, dbConfig.password, dbConfig.host, dbConfig.port, dbConfig.database))
    .pipe(gulp.dest('./tests/fixtures'))

  cb()
})

/**
 * This is a helper task that updates tests/_data/dump.sql
 */
gulp.task('dump:local', (cb) => {
  let config = Object.assign({}, dbConfig, { dest:'./tests/_data/dump.sql' })
  mysqldump(config, err => {
    if(err) throw new Error(err)
    process.exit(0)
  })

  cb()
})
