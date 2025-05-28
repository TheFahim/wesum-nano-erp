import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js', 'resources/css/app.css'],
            refresh: true,
        }),
    ],
    // server: {
    //     https: true,
    //     host: '0.0.0.0',
    //     port: 5173,
    //     origin: 'https://ucugyluitn.sharedwithexpose.com',
    // },

});
