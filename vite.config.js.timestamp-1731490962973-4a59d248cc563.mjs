// vite.config.js
import { defineConfig } from "file:///opt/lampp/htdocs/laravel_meeting/node_modules/vite/dist/node/index.js";
import laravel from "file:///opt/lampp/htdocs/laravel_meeting/node_modules/laravel-vite-plugin/dist/index.js";
import vue from "file:///opt/lampp/htdocs/laravel_meeting/node_modules/@vitejs/plugin-vue/dist/index.mjs";
import commonjs from "file:///opt/lampp/htdocs/laravel_meeting/node_modules/vite-plugin-commonjs/dist/index.mjs";
var vite_config_default = defineConfig({
  define: {
    "__APP_VERSION__": JSON.stringify(process.env.npm_package_version)
  },
  plugins: [
    // version(),
    laravel({
      input: "resources/js/app.js",
      refresh: true
    }),
    vue()
  ]
  // server: {
  //   host: '0.0.0.0', // Allows access from the network, including ngrok
  //   port: 8001       // Ensure this matches the port you're using
  // },
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCIvb3B0L2xhbXBwL2h0ZG9jcy9sYXJhdmVsX21lZXRpbmdcIjtjb25zdCBfX3ZpdGVfaW5qZWN0ZWRfb3JpZ2luYWxfZmlsZW5hbWUgPSBcIi9vcHQvbGFtcHAvaHRkb2NzL2xhcmF2ZWxfbWVldGluZy92aXRlLmNvbmZpZy5qc1wiO2NvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9pbXBvcnRfbWV0YV91cmwgPSBcImZpbGU6Ly8vb3B0L2xhbXBwL2h0ZG9jcy9sYXJhdmVsX21lZXRpbmcvdml0ZS5jb25maWcuanNcIjtpbXBvcnQgeyBkZWZpbmVDb25maWcgfSBmcm9tICd2aXRlJztcbmltcG9ydCBsYXJhdmVsIGZyb20gJ2xhcmF2ZWwtdml0ZS1wbHVnaW4nO1xuaW1wb3J0IHZ1ZSBmcm9tICdAdml0ZWpzL3BsdWdpbi12dWUnO1xuaW1wb3J0IGNvbW1vbmpzIGZyb20gJ3ZpdGUtcGx1Z2luLWNvbW1vbmpzJztcbi8vIGltcG9ydCB2ZXJzaW9uIGZyb20gJ3ZpdGUtcGx1Z2luLXBhY2thZ2UtdmVyc2lvbic7XG5cbmV4cG9ydCBkZWZhdWx0IGRlZmluZUNvbmZpZyh7XG4gIGRlZmluZToge1xuICAgICdfX0FQUF9WRVJTSU9OX18nOiBKU09OLnN0cmluZ2lmeShwcm9jZXNzLmVudi5ucG1fcGFja2FnZV92ZXJzaW9uKSxcbiAgfSwgIFxuICBwbHVnaW5zOiBbXG4gICAgLy8gdmVyc2lvbigpLFxuICAgICAgbGFyYXZlbCh7XG4gICAgICAgICAgaW5wdXQ6ICdyZXNvdXJjZXMvanMvYXBwLmpzJyxcbiAgICAgICAgICByZWZyZXNoOiB0cnVlLFxuICAgICAgfSksXG4gICAgICB2dWUoKSwgICAgICBcbiAgXSxcbiAgLy8gc2VydmVyOiB7XG4gIC8vICAgaG9zdDogJzAuMC4wLjAnLCAvLyBBbGxvd3MgYWNjZXNzIGZyb20gdGhlIG5ldHdvcmssIGluY2x1ZGluZyBuZ3Jva1xuICAvLyAgIHBvcnQ6IDgwMDEgICAgICAgLy8gRW5zdXJlIHRoaXMgbWF0Y2hlcyB0aGUgcG9ydCB5b3UncmUgdXNpbmdcbiAgLy8gfSxcbiAgXG59KTtcbiJdLAogICJtYXBwaW5ncyI6ICI7QUFBcVIsU0FBUyxvQkFBb0I7QUFDbFQsT0FBTyxhQUFhO0FBQ3BCLE9BQU8sU0FBUztBQUNoQixPQUFPLGNBQWM7QUFHckIsSUFBTyxzQkFBUSxhQUFhO0FBQUEsRUFDMUIsUUFBUTtBQUFBLElBQ04sbUJBQW1CLEtBQUssVUFBVSxRQUFRLElBQUksbUJBQW1CO0FBQUEsRUFDbkU7QUFBQSxFQUNBLFNBQVM7QUFBQTtBQUFBLElBRUwsUUFBUTtBQUFBLE1BQ0osT0FBTztBQUFBLE1BQ1AsU0FBUztBQUFBLElBQ2IsQ0FBQztBQUFBLElBQ0QsSUFBSTtBQUFBLEVBQ1I7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQU1GLENBQUM7IiwKICAibmFtZXMiOiBbXQp9Cg==
