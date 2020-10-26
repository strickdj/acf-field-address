const pkg = require('./package.json')

module.exports = {
  // Project Identity
  appName: 'acfFieldAddress', // Unique name of your project
  type: 'plugin', // Plugin or theme
  slug: 'acf-field-address', // Plugin or Theme slug, basically the directory name under `wp-content/<themes|plugins>`
  // Used to generate banners on top of compiled stuff
  bannerConfig: {
    name: 'acfFieldAddress',
    author: 'Daris Strickland',
    license: 'MIT',
    link: 'MIT',
    version: pkg.version,
    copyrightText:
      'This software is released under the MIT License\nhttps://opensource.org/licenses/MIT',
    credit: true,
  },
  // Files we need to compile, and where to put
  files: [
    {
    	name: 'address.jquery.js',
    	entry: {
    		 //https://wpack.io/apis/project-configuration/#files-array
    		main: ['./assets/js/address.jquery.js'],
    	},
    },    {
    	name: 'render_field',
    	entry: {
    		 //https://wpack.io/apis/project-configuration/#files-array
    		main: ['./assets/js/render_field.js'],
    	},
    },
    {
    	name: 'render_field_options',
    	entry: {
    		 // https://wpack.io/apis/project-configuration/#files-array
    		main: ['./assets/js/render_field_options.js'],
    	},
    },
  ],
  // Output path relative to the context directory
  // We need relative path here, else, we can not map to publicPath
  outputPath: 'dist',
  // Project specific config
  // Needs react(jsx)?
  hasReact: true,
  // Disable react refresh
  disableReactRefresh: false,
  // Needs sass?
  hasSass: true,
  // Needs less?
  hasLess: false,
  // Needs flowtype?
  hasFlow: false,
  // Externals
  // <https://webpack.js.org/configuration/externals/>
  externals: {
    jquery: 'jQuery',
  },
  // Webpack Aliases
  // <https://webpack.js.org/configuration/resolve/#resolve-alias>
  alias: undefined,
  // Show overlay on development
  errorOverlay: true,
  // Auto optimization by webpack
  // Split all common chunks with default config
  // <https://webpack.js.org/plugins/split-chunks-plugin/#optimization-splitchunks>
  // Won't hurt because we use PHP to automate loading
  optimizeSplitChunks: true,
  // Usually PHP and other files to watch and reload when changed
  watch: './src/**/*.php',
  // Files that you want to copy to your ultimate theme/plugin package
  // Supports glob matching from minimatch
  // @link <https://github.com/isaacs/minimatch#usage>
  packageFiles: [
    'inc/**',
    'vendor/**',
    'dist/**',
    '*.php',
    '*.md',
    'readme.txt',
    'languages/**',
    'layouts/**',
    'LICENSE',
    '*.css',
  ],
  // Path to package directory, relative to the root
  packageDirPath: 'package',
  // Hook into babeloverride so that we can add react-hot-loader plugin
  jsBabelOverride: defaults => ({
    ...defaults,
    plugins: ['react-hot-loader/babel'],
  }),
}
