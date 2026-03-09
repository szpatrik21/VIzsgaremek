import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/style3.css',
                'resources/css/main_page.css',
                'resources/css/navbar.css',
                'resources/css/register.css',
                'resources/css/style.css',
                'resources/css/auto.css',
                'resources/css/style2.css',
                'resources/css/style.css',
                'resources/css/style4.css',
                'resources/js/login.js',
                'resources/css/login.css',
                'resources/css/profile.css',
                'resources/css/autok.css',
                'resources/css/contact.css',
                'resources/css/createcars.css',
                'resources/js/main.js',
                'resources/css/admin/carcreate.css',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
