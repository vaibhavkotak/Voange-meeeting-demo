const path = require('path');

module.exports = {
  // Entry point for your app
  entry: './src/main.js',  // Modify this path to your entry JS file

  // Output configuration
  output: {
    filename: 'bundle.js',  // Output file name
    path: path.resolve(__dirname, 'dist'),  // Output directory
    publicPath: '/',  // Public path for assets
  },

  // Mode (development or production)
  mode: 'development',  // or 'production' for production builds

  // Module loaders for transpiling and handling different types of files
  module: {
    rules: [
      {
        test: /\.js$/,  // Transpile JavaScript files with Babel
        exclude: /node_modules/,
        use: 'babel-loader',
      },
      {
        test: /\.vue$/,  // Handle Vue files (if using Vue)
        use: 'vue-loader',
      },
      {
        test: /\.css$/,  // Handle CSS files
        use: ['style-loader', 'css-loader'],
      },
      {
        test: /\.scss$/,  // Handle SCSS files (if using SCSS)
        use: ['style-loader', 'css-loader', 'sass-loader'],
      },
      {
        test: /\.(png|jpg|gif)$/i,  // Handle image files
        use: [
          {
            loader: 'file-loader',
            options: {
              name: '[name].[hash].[ext]',
              outputPath: 'assets/images',
            },
          },
        ],
      },
    ],
  },

  // Plugins for extra functionality
  plugins: [
    new HtmlWebpackPlugin({
      template: './public/index.html',  // Modify this path as per your HTML template
    }),
    new VueLoaderPlugin(),  // If you're using Vue
  ],

  // Development server configuration
  devServer: {
    contentBase: path.join(__dirname, 'dist'),  // Directory to serve content from
    compress: true,
    port: 9000,  // Port number for development server
    open: true,  // Automatically open the browser
    hot: true,  // Enable hot module replacement
    historyApiFallback: true,  // For single-page apps (SPA)
  },

  // Resolve options for resolving modules
  resolve: {
    alias: {
      '@': path.resolve(__dirname, 'src'),  // Resolve '@' to the src folder
    },
    extensions: ['.js', '.vue', '.json'],  // File extensions to resolve
  },
};
