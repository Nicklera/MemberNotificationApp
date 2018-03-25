var mix       = require('laravel-mix')
// Set resource root directory
.setResourceRoot('/idea/public/'),
// Config props
assetsDir   = 'resources/assets/',
nodeDir     = 'node_modules/',
publicDir   = 'public/',
distDir     = 'public/dist/',
composerDir = 'vendor/';

mix.copyDirectory(nodeDir + 'amcharts/dist/amcharts', publicDir + 'assets/plugins/amcharts');
mix.less(assetsDir + 'less/admin.less', distDir + 'css/admin.css')
    .options({
      processCssUrls: false
    })
    .less(assetsDir + 'less/common.less', distDir + 'css/common.css')
    .options({
      processCssUrls: false
    })
//   .less(assetsDir + 'less/application.less', distDir + 'css/application.css')
    .js( assetsDir + 'js/common.js',  distDir + 'js/common.js')
    .js( assetsDir + 'js/admin.js',  distDir + 'js/admin.js');
    // .scripts(adminJs, distDir + 'js/admin.js');

// Copy images
mix.copy(
    [
        // JSTree related images
        nodeDir + 'jstree/dist/themes/default/32px.png',
        nodeDir + 'jstree/dist/themes/default/40px.png',
        nodeDir + 'jstree/dist/themes/default/throbber.gif',

        // iCheck
        nodeDir + 'admin-lte/plugins/iCheck/square/blue.png',
    ], 
    distDir + 'css/'
);


if (mix.inProduction()) {
  mix.version();
}