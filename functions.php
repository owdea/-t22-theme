<?php

function enqueue_custom_scripts_and_styles() {
    // Enqueue CSS
    wp_enqueue_style('custom-css', get_template_directory_uri() . '/assets/dist/main.min.css');

    // Enqueue JavaScript
    wp_enqueue_script('custom-js', get_template_directory_uri() . '/assets/dist/main.min.js');
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts_and_styles');

