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
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $publish_time = get_the_time('U', $post_id);
    $modified_time = get_the_modified_time('U', $post_id);
    $current_time = current_time('timestamp');

    $time_diff_publish = $current_time - $publish_time;
    $time_diff_modify = $current_time - $modified_time;

    $output = '';

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

    return $output;
}

// Get Youtube embed Url from normal url
function getYoutubeEmbedUrl($input)
{
    $shortUrlRegex = '/youtu.be\/([a-zA-Z0-9_-]+)\??/i';
    $longUrlRegex = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))([a-zA-Z0-9_-]+)/i';

    if (preg_match($longUrlRegex, $input, $matches) || preg_match($shortUrlRegex, $input, $matches)) {
        $youtube_id = $matches[count($matches) - 1];
    } else {
        $youtube_id = $input;
    }

    return 'https://www.youtube.com/embed/' . $youtube_id;
}

function custom_search_orderby($query) {
    if ($query->is_search() && $query->is_main_query()) {
        $orderby = get_query_var('orderby');

        if ($orderby === 'date') {
            $query->set('orderby', 'date');
            $query->set('order', 'DESC'); // Řazení od nejnovějšího
        } elseif ($orderby === 'relevance') {
            // Řazení dle relevance (použije základní řazení WordPressu podle shody)
            $query->set('orderby', 'relevance'); // Pro relevance, pokud používáš plugin jako Relevanssi
        }
    }
}
add_action('pre_get_posts', 'custom_search_orderby');

function highlight_search_text($text) {
    if (is_search()) {
        $search_query = get_search_query();
        if ($search_query) {
            $text = preg_replace('/(' . preg_quote($search_query, '/') . ')/i', '<strong>$1</strong>', $text);
        }
    }
    return $text;
}


//Search time
function measure_query_time($request) {
    global $search_start_time;
    $search_start_time = microtime(true);
    return $request;
}
add_filter('posts_request', 'measure_query_time');

function log_query_time() {
    global $search_start_time, $query_time;
    $query_time = microtime(true) - $search_start_time;
}
add_action('wp', 'log_query_time');


//Getting data from NYTimes endpoint
function get_nyt_articles_data($query) {
    $api_key = get_field("nyt_api_key", "option");
    $url = "https://api.nytimes.com/svc/search/v2/articlesearch.json?q=" . urlencode($query) . "&api-key=" . $api_key;

    $response = wp_remote_get($url);

    if (is_wp_error($response)) {
        return [];
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (!isset($data['response']['docs'])) {
        return [];
    }

    $formatted_articles = [];
    $id = 0;

    foreach ($data['response']['docs'] as $doc) {
        $publish_time_formatted = !empty($doc['pub_date']) ? date('j. n. Y', strtotime($doc['pub_date'])) : 'Unknown Date';
        $thumbnail_url = isset($doc['multimedia'][0]['url']) ? 'https://www.nytimes.com/' . $doc['multimedia'][0]['url'] : get_template_directory_uri() . "/assets/img/placeholder.webp";

        $formatted_articles[] = [
            'id' => $id++,
            'url' => $doc['web_url'] ?? '',
            'thumbnail' => $thumbnail_url,
            'excerpt' => $doc['abstract'] ?? 'N/A',
            'title' => $doc['headline']['main'] ?? 'No Title',
            'source' => $doc['source'] ?? 'Unknown Source',
            'publish_time' => $publish_time_formatted,
        ];
    }

    return $formatted_articles;
}


//Fetching data
function fetch_weather_data($cities) {
    $max_temperatures = [];
    $min_temperatures = [];
    $sunrise_times = [];
    $sunset_times = [];
    $weather_codes = [];
    $cities_data = [];

    $example_data = get_option('Praha_weather_data');
    if ($example_data) {
        $api_date = $example_data->daily->time[0];
    } else {
        $api_date = "";
    }
    $today_date = date('Y-m-d');

    if ($api_date === $today_date) {
        foreach ($cities as $city) {
            $city_name = $city['city'];
            $data = get_option($city_name . '_weather_data');
            $cities_data[$city_name] = $data;

            $max_temperatures[] = $data->daily->temperature_2m_max;
            $min_temperatures[] = $data->daily->temperature_2m_min;
            $sunrise_times[] = $data->daily->sunrise;
            $sunset_times[] = $data->daily->sunset;
            $weather_codes[] = $data->daily->weather_code;
        }
    } else {
        foreach ($cities as $city) {
            $latitude = $city['latitude'];
            $longitude = $city['longitude'];
            $city_name = $city['city'];

            $data = json_decode(wp_remote_retrieve_body(
                wp_remote_get('https://api.open-meteo.com/v1/forecast?latitude=' . $latitude .
                    '&longitude=' . $longitude .
                    '&daily=weather_code,temperature_2m_max,temperature_2m_min,sunrise,sunset,uv_index_max&timezone=Europe%2FBerlin')
            ));

            $cities_data[$city_name] = $data;
            $max_temperatures[] = $data->daily->temperature_2m_max;
            $min_temperatures[] = $data->daily->temperature_2m_min;
            $sunrise_times[] = $data->daily->sunrise;
            $sunset_times[] = $data->daily->sunset;
            $weather_codes[] = $data->daily->weather_code;

            update_option($city_name . '_weather_data', $data);
        }
    }

    $avg_max_temperatures = calculate_average_daily_temperatures($max_temperatures);
    $avg_min_temperatures = calculate_average_daily_temperatures($min_temperatures);
    $avg_sunrise_times = calculate_average_sun_times($sunrise_times);
    $avg_sunset_times = calculate_average_sun_times($sunset_times);
    $avg_weather_codes = calculate_average_weather_code($weather_codes);

    return [
        'avg_max_temperatures' => $avg_max_temperatures,
        'avg_min_temperatures' => $avg_min_temperatures,
        'avg_sunrise_times' => $avg_sunrise_times,
        'avg_sunset_times' => $avg_sunset_times,
        'avg_weather_codes' => $avg_weather_codes,
        'cities_data' => $cities_data,
    ];
}


function calculate_average_daily_temperatures($temperature_data) {
    $day_count = count($temperature_data[0]);
    $average_temperatures = [];

    for ($day = 0; $day < $day_count; $day++) {
        $sum = 0;
        $city_count = count($temperature_data);

        foreach ($temperature_data as $city_temps) {
            $sum += $city_temps[$day];
        }

        $average_temperatures[$day] = round($sum / $city_count);
    }

    return $average_temperatures;
}

function calculate_average_sun_times($sun_times_data) {
    $day_count = count($sun_times_data[0]);
    $average_sun_times = [];

    for ($day = 0; $day < $day_count; $day++) {
        $sum_minutes = 0;
        $city_count = count($sun_times_data);

        foreach ($sun_times_data as $city_sun_times) {
            $time_part = explode('T', $city_sun_times[$day])[1];
            list($hours, $minutes) = explode(':', $time_part);
            $sum_minutes += intval($hours) * 60 + intval($minutes);
        }

        $avg_minutes = round($sum_minutes / $city_count);
        $hours = floor($avg_minutes / 60);
        $minutes = $avg_minutes % 60;

        $average_sun_times[$day] = sprintf('%02d:%02d', $hours, $minutes);
    }

    return $average_sun_times;
}

function calculate_average_weather_code($weather_codes) {
    $day_count = count($weather_codes[0]);
    $average_weather_codes = [];

    for ($day = 0; $day < $day_count; $day++) {
        $sum = 0;
        $city_count = count($weather_codes);

        foreach ($weather_codes as $city_codes) {
            $sum += $city_codes[$day];
        }

        $average_weather_codes[$day] = round($sum / $city_count);
    }

    return $average_weather_codes;
}
