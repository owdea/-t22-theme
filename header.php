<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<?php wp_head(); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
    <style>
        .primary-navigator:hover {
            background-color: <?php echo get_field('selected_navigator_bg', 'option') ? get_field('selected_navigator_bg', 'option') : get_field_object('selected_navigator_bg', 'option')['default_value']; ?>;
            color: <?php echo get_field('selected_navigator_text_color', 'option') ? get_field('selected_navigator_text_color', 'option') : get_field_object('selected_navigator_text_color', 'option')['default_value']; ?>;
        }
    </style>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header id="header">
    <div class="header-top">
        <a id="header-logo" href="<?php echo get_site_url(); ?>">
            <img class="header-logo" src="<?php echo get_template_directory_uri(); ?>/assets/icons/ct22-logo-white.svg" alt="Logo ČT22">
        </a>
        <div class="header-top-right">
            <button id="mobile-search-bar-button">
                <img id="mobile-search-magnifier" src="<?php echo get_template_directory_uri(); ?>/assets/icons/magnifier.svg" alt="Ikona lupy">
                <img id="mobile-search-exit" class="hidden" src="<?php echo get_template_directory_uri(); ?>/assets/icons/exit-icon.svg" alt="Zavírací ikona">
            </button>
            <?php get_search_form(); ?>
            <button class="secondary-menu-btn">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/secondary-menu.svg" alt="Ikona sekundárního menu">
                <span>ČT</span>
            </button>
            <div class="secondary-menu-container transition-custom">
                <div class="secondary-menu">
                    <div class="secondary-menu-icons">

<?php
//Getting Icons from the ACF plugin and showing them in Secondary menu (first part). (Array of fields [image and url])
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
                echo '</div>'; //secondary-menu-icons

//Getting h5 headings from the ACF plugin and showing them in Secondary menu (second part). (Array of Post Objects)
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
endif;

//Getting chosen navigators from the ACF plugin and showing them in Secondary menu (third part). (Array containing Post Objects or Taxonomies (Rubrika or Tema)
$menu_items = get_field('secondary_menu_navigators', 'options');
if ($menu_items) :
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
endif;

?>
                </div> <!--secondary-menu-->
            </div> <!--secondary-menu-container-->
        </div> <!--header-top-right-->
    </div> <!--header-top-->
    <div class="primary-menu-container"> <!--IP-567 - začátek tiketu na spodní část headeru-->
    <?php
        //Storing primary menu in the $primary_menu variable
        ob_start();
        wp_nav_menu(
            array(
                'theme_location' => 'primary',
                'menu_class' => 'header',
                'menu_id' => 'primary-menu-ul',
                'container' => 'nav'
                )
        );
        $primary_menu = ob_get_clean();
    ?>
    <div id="primary-menu" class="primary-menu">
        <button class="primary-menu-mobile-icon" id="primary-menu-mobile-icon">
            <svg  fill="none" height="24" viewBox="0 0 24 25" width="24" xmlns="http://www.w3.org/2000/svg"><path clip-rule="evenodd" d="M20.4 16.5a.6.6 0 01.6.6v.8a.6.6 0 01-.6.6H3.6a.6.6 0 01-.6-.6v-.8a.6.6 0 01.6-.6h16.8zm0-5a.6.6 0 01.6.6v.8a.6.6 0 01-.6.6H3.6a.6.6 0 01-.6-.6v-.8a.6.6 0 01.6-.6h16.8zm0-5a.6.6 0 01.6.6v.8a.6.6 0 01-.6.6H3.6a.6.6 0 01-.6-.6v-.8a.6.6 0 01.6-.6h16.8z" fill="currentColor" fill-rule="evenodd"></path></svg>
            <a>Rubriky</a>
        </button>
        <div class="primary-menu-desktop">
            <?php
                echo $primary_menu ?: '';
            ?>
            <div class="primary-more-container">
                <button id="primary-button" class="primary-more-btn">Další...</button>
                <ul id="primary-more" class="primary-more"></ul>
            </div>
        </div>
        <?php
            //Getting ACF settings for showing Live Stream option in primary menu. (True/False)
            $show_live_stream_button = get_field('show_live_stream_button', 'option');
        ?>
        <div>
            <?php
                //Getting 'selected navigator' option from ACF (on ČT24 website it is Sport)
                $selected_navigator = get_field('selected_primary_navigator', 'option');

                if ($selected_navigator) {
                    $link = get_permalink($selected_navigator);
                    $name = get_the_title($selected_navigator);

                    if ($link && $name) {
                        echo '<a id="primary-navigator" class="primary-navigator" href="' . esc_url($link) . '">' . esc_html($name) . '</a>';
                    }
                }
            ?>

            <?php if ($show_live_stream_button) : ?>
            <button id="primary-live" class="primary-live">
                <svg fill="none" height="8" viewBox="0 0 8 8" width="8" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="4" cy="4" fill="currentColor" r="4"></circle>
                </svg>
                <a class="primary-live-mobile">ŽIVĚ</a>
                <a class="primary-live-tablet">ŽIVÉ VYSÍLÁNÍ</a>
            </button>
            <?php endif; ?>
        </div>
    </div>
    <div class="primary-menu-mobile">
        <?php
        echo $primary_menu ?: '';
            ?>
    </div>
</div>
</header>
<main id="primary" class="site-main" role="main">
