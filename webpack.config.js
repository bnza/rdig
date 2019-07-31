const Encore = require('@symfony/webpack-encore')
const path = require('path')

if (!Encore.isRuntimeEnvironmentConfigured()) {
  Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev')
}

Encore
// the project directory where compiled assets will be stored
  .setOutputPath('public/build/')
  // .setManifestKeyPrefix('public/build/')
  // the public path used by the web server to access the previous directory
  .setPublicPath('/build')
  .cleanupOutputBeforeBuild()
  .enableSourceMaps(!Encore.isProduction())
  // uncomment to create hashed filenames (e.g. app.abc123.css)
  // .enableVersioning(Encore.isProduction())
  // empty the outputPath dir before each build
  .cleanupOutputBeforeBuild()

  // show OS notifications when builds finish/fail
  // .enableBuildNotifications()

  // uncomment to define the assets of the project
  .addEntry('app', './assets/js/src/main.js')
  .enableSingleRuntimeChunk()
  // .addStyleEntry('css/app', './assets/css/app.scss')

  // uncomment if you use Sass/SCSS files
  .enableSassLoader()

  .enableVueLoader()

  .addLoader({
    test: /\.styl$/,
    loader: 'style-loader!css-loader!stylus-loader'
  })

let config = Encore.getWebpackConfig()

config.resolve.alias.vue = 'vue/dist/vue.esm.js'
config.resolve.alias['~'] = path.resolve(__dirname, './assets')

module.exports = config
