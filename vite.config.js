import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
            'resources/css/app.css',
            'resources/js/app.js',
            'resources/js/genre_handler.js',
            'resources/js/delete_all_alert.js',
            'resources/js/image_drop_form_handler.js',
            'resources/js/image_delete.js',
            'resources/js/hint_delete.js',
            'resources/js/answer_delete.js',
            'resources/js/newHintBlock.js',
            'resources/js/newAnswerBlock.js',
            ],
            refresh: true,
        }),
    ],
});
