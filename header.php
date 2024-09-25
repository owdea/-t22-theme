<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open();

echo '<header>';
echo '<div class="header-top">';
echo '<a href="' . get_site_url() . '">
     <img class="header-logo" src="' . get_site_url() . '/wp-content/themes/ct22-theme/assets/icons/ct22-logo-white.svg" alt="čt22 logo">
     </a>';
echo '<div class="header-top-right">';
get_search_form();
echo '<button class="secondary-menu-btn">';
echo '<img src="' . get_site_url() . '/wp-content/themes/ct22-theme/assets/icons/secondary-menu.svg" alt="Ikona sekundárního menu">';
echo '<span>ČT</span>';
echo '</button>';
echo '<div class="secondary-menu">';
echo '<div class="secondary-menu-icons">';
if (have_rows('secondary_menu_icons', 'option')) :

    while (have_rows('secondary_menu_icons', 'option')) : the_row();
        $image = get_sub_field('secondary_menu_navigator_image');
        $link = get_sub_field('secondary_menu_navigator_link');

        if ($image) {
            echo '<a href="' . esc_url($link) . '">';
            echo '<img src="' . esc_url($image['url']) . '" alt="' . esc_attr($image['alt']) . '" />';
            echo '</a>';
        }

    endwhile;
endif;
echo '</div>';
if (have_rows('secondary_menu_headings', 'option')) :
    echo '<ul class="secondary-menu-headings">';

    while (have_rows('secondary_menu_headings', 'option')) : the_row();

        $post_object = get_sub_field('secondary_menu_heading');

        if ($post_object) :
            $post_id = $post_object->ID;
            $post_title = get_the_title($post_id);
            $post_url = get_permalink($post_id);

            echo '<li>';
            echo '<a href="' . esc_url($post_url) . '">' . esc_html($post_title) . '</a>';
            echo '</li>';
        endif;

    endwhile;

    echo '</ul>';
else :
    echo '<p>no values</p>';
endif;

$menu_items = get_field('secondary_menu_navigators', 'options');

if ($menu_items) {
    echo '<ul class="secondary-menu-navigators">';

    foreach ($menu_items as $item) {
        // Post Object
        if (!empty($item['secondary_menu_navigator_post']) && is_object($item['secondary_menu_navigator_post'])) {
            $post_object = $item['secondary_menu_navigator_post'];
            echo '<li><a href="' . get_permalink($post_object->ID) . '">' . esc_html($post_object->post_title) . '</a></li>';
        }

        // Rubrika
        if (!empty($item['secondary_menu_navigator_rubrika'])) {
            foreach ($item['secondary_menu_navigator_rubrika'] as $term_id) {
                $term = get_term($term_id, 'category');
                if ($term && !is_wp_error($term)) {
                    echo '<li><a href="' . get_term_link($term) . '">' . esc_html($term->name) . '</a></li>';
                }
            }
        }

        // Téma
        if (!empty($item['secondary_menu_navigator_tema'])) {
            foreach ($item['secondary_menu_navigator_tema'] as $term_id) {
                $term = get_term($term_id, 'post_tag');
                if ($term && !is_wp_error($term)) {
                    echo '<li><a href="' . get_term_link($term) . '">' . esc_html($term->name) . '</a></li>';
                }
            }
        }
    }
    echo '</ul>';
} else {
    echo 'Žádné navigační položky nebyly nalezeny.';
}

echo '</div>';
echo '</div>';
echo '</div>';

echo '<div id="primary-menu" class="primary-menu">';
echo '<button class="primary-more-btn">Další</button>';
wp_nav_menu(
    array(
        'theme_location' => 'primary',
        'menu_class'     => 'header',
        'container'      => 'nav'
    )
);

echo '<ul class="primary-more"></ul>';
echo '<a class="primary-sport">Sport</a>';
echo '<a class="primary-live">Živé vysílání<a>';
echo '</div>';
?>
</header>
<main id="primary" class="site-main" role="main">
