<?php

add_theme_support('post-thumbnails');
function enqueue_custom_scripts_and_styles() {
    // Enqueue CSS
    wp_enqueue_style('custom-css', get_template_directory_uri() . '/assets/dist/main.min.css');

    wp_enqueue_script( 'swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js', array(), null, true );

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
            'view_item'                  => 'Zobrazit téma',
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
            'no_terms'                   => 'Žádná témata',
            'filter_by_item'             => 'Filtrovat',
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
            'view_item'                  => 'Zobrazit rubriku',
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
        register_block_type( __DIR__ . '/utils/blocks/photo-gallery' );
        register_block_type( __DIR__ . '/utils/blocks/themes' );
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

function load_authors_choices( $field ) {
    $field['choices'] = [];

    if ( have_rows( 'authors_list', 'option' ) ) {
        while ( have_rows( 'authors_list', 'option' ) ) {
            the_row();
            $author_name = get_sub_field( 'author_name' );
            $author_id = get_sub_field( 'author_id' );
            $field['choices'][ $author_id ] = $author_name;
        }
    }

    return $field;
}
add_filter( 'acf/load_field/name=authors_select', 'load_authors_choices' );

//Filter for Post Objects on taxonomy page.
function filter_acf_post_object_by_taxonomy( $args ) {

    $url = wp_get_referer();

    // Get ID a type of the taxonomy (category or post_tag) from url
    if ( preg_match( '/tag_ID=([0-9]+)/', $url, $matches ) && preg_match( '/taxonomy=([a-z_]+)/', $url, $taxonomy_matches ) ) {
        $term_id = intval( $matches[1] ); // ID of taxonomy
        $taxonomy = $taxonomy_matches[1]; // Name of taxonomy
    }

    // Applying filter when having info
    if ( $term_id && in_array( $taxonomy, ['category', 'post_tag'], true ) ) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => $taxonomy,
                'field'    => 'term_id',
                'terms'    => $term_id,
            ),
        );
    }

    return $args;
}
add_filter('acf/fields/post_object/query/name=taxonomy-pinned-post', 'filter_acf_post_object_by_taxonomy', 10, 3);

// Vlož do functions.php
function display_post_time_info($post_id = null) {
    // Pokud není zadán $post_id, použije se aktuální příspěvek
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    // Načtení časů publikace a poslední aktualizace
    $publish_time = get_the_time('U', $post_id);
    $modified_time = get_the_modified_time('U', $post_id);
    $current_time = current_time('timestamp');

    // Výpočet rozdílu času od publikace a aktualizace
    $time_diff_publish = $current_time - $publish_time;
    $time_diff_modify = $current_time - $modified_time;

    // Výstup HTML
    $output = '';

    // Čas od publikace
    $output .= '<div class="time-container">';
    if ($time_diff_publish >= 60 * 60 * 24) {
        $output .= '<span class="published-date">' . get_the_date('j. m. Y', $post_id) . '</span>';
    } elseif ($time_diff_publish >= 60 * 60) {
        $hours = floor($time_diff_publish / (60 * 60)) == 1 ? "hodinou" : "hodinami";
        $output .= '<span class="published-date">před ' . floor($time_diff_publish / (60 * 60)) .' '. $hours .'</span>';
    } else {
        $minutes = floor($time_diff_publish / 60) == 1 ? "minutou" : "minutami";
        $output .= '<span class="published-date">před ' . floor($time_diff_publish / 60) .' '. $minutes .'</span>';
    }

    // Čas od poslední aktualizace (pokud došlo k úpravám)
    if ($modified_time != $publish_time) {
        $output .= '<img src="' . esc_url(get_template_directory_uri() .'/assets/icons/update.svg') . '" alt="aktualizováno" class="update-icon">';

        if ($time_diff_modify >= 60 * 60 * 24) {
            $output .= '<span>' . get_the_modified_date('j. m. Y', $post_id) . '</span>';
        } elseif ($time_diff_modify >= 60 * 60) {
            $hours = floor($time_diff_modify / (60 * 60)) == 1 ? "hodinou" : "hodinami";
            $output .= '<span>před ' . floor($time_diff_modify / (60 * 60)) .' '. $hours .'</span>';
        } else {
            $minutes = floor($time_diff_modify / 60) == 1 ? "minutou" : "minutami";
            $output .= '<span>před ' . floor($time_diff_modify / 60) .' '. $minutes .'</span>';
        }
    }
    $output .= '</div>';

    // Vrácení HTML výstupu
    return $output;
}






