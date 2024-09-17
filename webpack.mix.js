const mix = require("laravel-mix")
const BrowserSyncPlugin = require("browser-sync-webpack-plugin")

mix.disableSuccessNotifications()

// Compile TypeScript
mix.js("assets/js/main.js", "dist/main.min.js")

// Compile CSS
mix.css("assets/css/main.css", "dist/main.min.css")

// Set the public path
mix.setPublicPath("assets")

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
})
