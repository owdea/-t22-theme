<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header>
<div>
<?php
echo '<img src="' . get_site_url() . '/wp-content/themes/ct22-theme/assets/icons/ct22-logo-gradient.svg" >';
get_search_form();
wp_nav_menu(
    array(
        'theme_location' => 'secondary',
        'menu_class'     => 'header',
        'container'      => 'nav'
    )
);
echo '</div>';
wp_nav_menu(
    array(
        'theme_location' => 'primary',
        'menu_class'     => 'header',
        'container'      => 'nav'
    )
);
?>
</header>
<main id="primary" class="site-main" role="main">
