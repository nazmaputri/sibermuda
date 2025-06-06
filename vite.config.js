import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
            'resources/css/app.css', 
            'resources/js/app.js',  
            'resources/js/alert.js',
            'resources/js/delete-confirm.js',
            'resources/js/bootstrap.js',
            ],
            refresh: true,
        }),
    ],
});
