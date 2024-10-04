import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    server: {
        // Responde a todas as requisições de rede
        host: "0.0.0.0",
        port: 5173,
        strictPort: true,
        // Use a URL definida no .env
        origin: process.env.VITE_APP_URL,
    },
});
