const zlib = require("zlib");
const CompressionPlugin = require("compression-webpack-plugin");

module.exports = {
  transpileDependencies: [
    'vuetify'
  ],

  devServer: {
    proxy: 'http://localhost:8000'
  },

  outputDir: '../backend/public',

  indexPath: process.env.NODE_ENV === 'production'
    ? '../resources/views/index.blade.php'
    : 'index.html',

  productionSourceMap: false,

  configureWebpack:
    process.env.NODE_ENV === "production"
      ? {
        plugins: [
          new CompressionPlugin({
            filename: "[path][base].br",
            algorithm: "brotliCompress",
            test: /\.(js|css|svg)$/,
            compressionOptions: {
              params: {
                [zlib.constants.BROTLI_PARAM_QUALITY]: 11,
              },
            },
          }),
          new CompressionPlugin({
            test: /\.(js|css|svg)$/,
          }),
        ],
      }
      : {},
}
