import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
            'resources/css/app.css',
            'resources/js/app.js',
            'resources/js/deleteAllAlert.js',
            'resources/js/imageDelete.js',
            'resources/js/hintDelete.js',
            'resources/js/answerDelete.js',
            'resources/js/newHintBlock.js',
            'resources/js/newAnswerBlock.js',
            'resources/js/newGenreBlock.js',
            ],
            refresh: true,
        }),
    ],
});
