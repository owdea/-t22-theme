const mix = require("laravel-mix");
const BrowserSyncPlugin = require("browser-sync-webpack-plugin");

// Disable success notifications
mix.disableSuccessNotifications();

// Compile TypeScript
mix.js("assets/src/main.js", "dist/main.min.js");

// Compile Tailwind CSS
mix.postCss("assets/src/main.css", "dist/main.min.css", [
    require("tailwindcss"),
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
    }
});
