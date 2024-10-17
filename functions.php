<?php

add_theme_support('post-thumbnails');
function enqueue_custom_scripts_and_styles() {
    // Enqueue CSS
    wp_enqueue_style('custom-css', get_template_directory_uri() . '/assets/dist/main.min.css');

    // Enqueue JavaScript
    wp_enqueue_script('custom-js', get_template_directory_uri() . '/assets/dist/main.min.js');
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts_and_styles');

function enqueue_block_editor_styles() {
    // Enqueue CSS for Gutenberg editor
    wp_enqueue_style('editor-styles', get_template_directory_uri() . '/assets/dist/main.min.css');
}

add_action('enqueue_block_editor_assets', 'enqueue_block_editor_styles');

register_nav_menus(
    array(
        'primary' => __( 'Primary Menu' ),
        'footer' => __( 'Footer Menu' ),
    )
);

function change_tag_labels_to_tema() {
    global $wp_taxonomies;
    if (isset($wp_taxonomies['post_tag'])) {
        $wp_taxonomies['post_tag']->labels = (object) array(
            'name'                       => 'Témata',
            'singular_name'              => 'Téma',
            'search_items'               => 'Hledat témata',
            'popular_items'              => 'Populární témata',
            'all_items'                  => 'Všechna témata',
            'edit_item'                  => 'Upravit téma',
            'update_item'                => 'Aktualizovat téma',
            'add_new_item'               => 'Přidat nové téma',
            'new_item_name'              => 'Nové téma',
            'separate_items_with_commas' => 'Oddělte témata čárkami',
            'add_or_remove_items'        => 'Přidat nebo odebrat témata',
            'choose_from_most_used'      => 'Vyberte z nejčastěji používaných témat',
            'not_found'                  => 'Žádná témata nenalezena',
            'menu_name'                  => 'Témata',
            'most_used'                  => 'Nejpoužívanější',
            'slug_field_description'     => 'Slouží jako URL identifikátor pro téma; povoleny jsou pouze malá písmena, čísla a pomlčky.',
            'name_field_description'     => 'Zadejte název tohoto tématu',
            'desc_field_description'     => 'Popis tohoto tématu',
            'items_list'                 => 'Seznam témat',
            'items_list_navigation'      => 'Navigace seznamem témat',
        );
    }
}
add_action('init', 'change_tag_labels_to_tema');

function change_category_labels_to_rubriky() {
    global $wp_taxonomies;
    if (isset($wp_taxonomies['category'])) {
        $wp_taxonomies['category']->labels = (object) array(
            'name'                       => 'Rubriky',
            'singular_name'              => 'Rubrika',
            'search_items'               => 'Hledat rubriky',
            'all_items'                  => 'Všechny rubriky',
            'parent_item'                => 'Nadřazená rubrika',
            'parent_item_colon'          => 'Nadřazená rubrika:',
            'edit_item'                  => 'Upravit rubriku',
            'update_item'                => 'Aktualizovat rubriku',
            'add_new_item'               => 'Přidat novou rubriku',
            'new_item_name'              => 'Název nové rubriky',
            'menu_name'                  => 'Rubriky',
            'most_used'                  => 'Nejpoužívanější',
            'slug_field_description'     => 'Slouží jako URL identifikátor pro rubriku; povoleny jsou pouze malá písmena, čísla a pomlčky.',
            'name_field_description'     => 'Zadejte název této rubriky',
            'desc_field_description'     => 'Popis této rubriky',
            'items_list'                 => 'Seznam rubrik',
            'items_list_navigation'      => 'Navigace seznamem rubrik',
        );
    }
}
add_action('init', 'change_category_labels_to_rubriky');

function theme_update_checker() {
    include 'plugin-update-checker/plugin-update-checker.php';
    $my_update_checker = YahnisElsts\PluginUpdateChecker\v5\PucFactory::buildUpdateChecker(
        'https://github.com/owdea/ct22-theme',
        __FILE__,
        'ct22-theme'
    );

    $my_update_checker->setBranch( 'main' );
}

add_action( 'after_setup_theme', 'theme_update_checker' );

function ct22_register_acf_blocks(): void {
    if ( function_exists( 'acf_register_block_type' ) ) {
        register_block_type( __DIR__ . '/utils/blocks/link' );
    }
}

add_action( 'init', 'ct22_register_acf_blocks' );

function register_ct22_block_category( $categories, $post ) {
    return array_merge(
        array(
            array(
                'slug'  => 'ct22-blocks',
                'title' => __( 'ČT22 bloky', 'text-domain' ),
                'icon'  => null,
            ),
        ),
        $categories
    );
}
add_filter( 'block_categories_all', 'register_ct22_block_category', 10, 2 );
