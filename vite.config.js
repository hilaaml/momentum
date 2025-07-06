import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/heatmap-init.js',
                'resources/js/timers.js',
                'resources/js/journal-calendar.js',
                'resources/js/reportCharts.js',
                'resources/js/form-validation.js'
            ],
            refresh: true,
        }),
    ],
});
