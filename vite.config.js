import { defineConfig } from "vite";
import fullReload from "vite-plugin-full-reload";

export default defineConfig({
    plugins: [fullReload("**/*.php")],
    server: {
        host: "0.0.0.0",
        hmr: {
            host: "localhost",
        },
    },
    publicDir: false,
    build: {
        outDir: "public/build",
        rolldownOptions: {
            input: "src/js/main.js",
        },
        manifest: true,
        emptyOutDir: true,
    },
    css: {
        preprocessorOptions: {
            scss: {
                api: "modern-compiler",
            },
        },
    },
});
