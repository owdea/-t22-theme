<?php
/*
 * Template part - Themes block
 *
 *
 * */



if (!empty($args)):
    $is_taxonomy = $args['is_page_taxonomy'];
    $repeater_name = $args['repeater_name'];
    $term_id = $is_taxonomy ? 'term_' . $args['page_id'] : $args['page_id'];
?>
<div class="template-part-themes-container">
    <?php
    $repeater_rows = get_field($repeater_name, $term_id);
    $row_count = $repeater_rows ? count($repeater_rows) : 0;
    switch ($row_count) {
        case 0:
            $theme_class = "theme-count-0";
            break;
        case 1:
        case 2:
            $theme_class = "theme-count-2";
            break;
        case 3:
            $theme_class = "theme-count-3";
            break;
        case 4:
            $theme_class = "theme-count-4";
            break;
        default:
            $theme_class = "";
            break;
    }


    if (have_rows($repeater_name, $term_id)):
        while( have_rows($repeater_name, $term_id) ) : the_row();
            $theme = get_sub_field('linked_themes_group');
            $theme_id = $theme['taxonomy_theme_object'][0]->term_id;
            $theme_img = $theme['taxonomy_theme_custom_img']['url'] ?: get_field('taxonomy_title_img', 'term_' .$theme_id);
            $theme_url = get_term_link($theme_id);
            $theme_title = $theme['taxonomy_theme_custom_name'] ?: $theme['taxonomy_theme_object'][0]->name;
            ?>
            <div class="theme-container <?php echo $theme_class;?>" style="background-image: url('<?php echo $theme_img ?>')">
                <a href="<?php echo $theme_url ?>">
                    <div class="theme-text-container">
                        <span><?php echo $theme_title ?></span>
                        <img src="<?php echo get_template_directory_uri()?>/assets/icons/arrow.svg" alt="Navštívit stránku">
                    </div>
                </a>
            </div>
        <?php
        endwhile;
    endif;
    ?>
</div>
<?php
endif;
?>