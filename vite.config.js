import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import commonjs from 'vite-plugin-commonjs';
// import version from 'vite-plugin-package-version';

export default defineConfig({
  define: {
    '__APP_VERSION__': JSON.stringify(process.env.npm_package_version),
  },  
  plugins: [
    // version(),
      laravel({
          input: 'resources/js/app.js',
          refresh: true,
      }),
      vue(),      
  ],
  // server: {
  //   host: '0.0.0.0', // Allows access from the network, including ngrok
  //   port: 8001       // Ensure this matches the port you're using
  // },
  
});
