const mix = require("laravel-mix");
const BrowserSyncPlugin = require("browser-sync-webpack-plugin");
const cssnano = require('cssnano');

// Disable success notifications
mix.disableSuccessNotifications();

// Compile TypeScript
mix.js("assets/src/main.js", "dist/main.min.js");

// Compile Tailwind CSS using PostCSS
mix.postCss("assets/src/main.css", "dist/main.min.css", [
    require("tailwindcss"),
    require("postcss-import"),  // Přidání postcss-import pro zpracování importů
    ...mix.inProduction() ? [cssnano()] : []  // Přidání cssnano pouze v produkčním režimu
]);

// Set the public path
mix.setPublicPath("assets");

// BrowserSync configuration
mix.webpackConfig({
    plugins: [
        new BrowserSyncPlugin({
            proxy: process.env.BROWSER_SYNC_PROXY,
            files: ["**/*.js", "**/*.css", "**/*.php"],
            injectChanges: true,
        }),
    ],
    resolve: {
        extensions: [".js"],
    },
    watchOptions: {
        ignored: /node_modules/,      // Ignoruje složku node_modules
    },
});
