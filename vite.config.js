import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        host: 'localhost',
    },
    plugins: [
        // add css and js file
        laravel({
            input: [
                'resources/css/app.css',
                // 'resources/css/theme/dashlite.css',
                // 'resources/css/theme/theme.css',
                
                'resources/js/app.js',
                // 'resources/js/theme/bundle.js',
                // 'resources/js/theme/scripts.js',
            ],
            refresh: true,
        }),

        // auto refresh blade files
        {
            name: 'blade',
            handleHotUpdate({ file, server }) {
                if (file.endsWith('.blade.php')) {
                    server.ws.send({
                        type: 'full-reload',
                        path: '*',
                    });
                }
            },
        },
    ],
});
