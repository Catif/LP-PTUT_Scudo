import { fileURLToPath, URL } from "node:url";

import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";

export default defineConfig({
  plugins: [
    vue(),
    laravel({
      input: ["resources/main.js"],
      refresh: true,
    }),
  ],
  resolve: {
    alias: {
      "@": fileURLToPath(new URL("./resources", import.meta.url)),
    },
  },
});
