<?php get_header(); ?>

<?php
$args = array(
    'post_type' => 'post',
    'posts_per_page' => -1, // Load all posts
    'post_status' => 'publish',
);
$custom_query = new WP_Query($args);

// Getting YT links
$youtube_links = [];
if ($custom_query->have_posts()) :
    while ($custom_query->have_posts()) : $custom_query->the_post();
        $youtube_link = get_field('article_youtube_embed');
        if ($youtube_link) {
            $youtube_links[] = getYoutubeEmbedUrl($youtube_link);
        }
    endwhile;
    $custom_query->rewind_posts();
endif;

$homepage_id = get_option('page_on_front');

if ($custom_query->have_posts()) : ?>
    <div class="homepage">

        <?php
        $displayed_posts = [];

        if (get_field('homepage-pinned-post', $homepage_id)) {
            $pinned_post = get_field('homepage-pinned-post', $homepage_id);
            $pinned_post_title = $pinned_post->post_title;
            $pinned_post_url = get_permalink($pinned_post->ID);
            $pinned_post_excerpt = $pinned_post->post_excerpt;
            $pinned_post_img = get_the_post_thumbnail_url($pinned_post, 'full') ?: get_template_directory_uri() . '/assets/img/placeholder.webp';
            $pinned_post_sources = get_field('article_sources', $pinned_post->ID);

            $displayed_posts[] = $pinned_post->ID;
        } else {
            the_post();
            $pinned_post_title = get_the_title();
            $pinned_post_url = get_permalink();
            $pinned_post_excerpt = get_the_excerpt();
            $pinned_post_img = get_the_post_thumbnail_url(null, 'full') ?: get_template_directory_uri() . '/assets/img/placeholder.webp';
            $pinned_post_sources = get_field('article_sources');

            $displayed_posts[] = get_the_ID();
        }


        get_template_part(
            'template-parts/page-content/pinned-post',
            null,
            array(
                'post_url' => $pinned_post_url,
                'post_img' => $pinned_post_img,
                'post_title' => $pinned_post_title,
                'post_excerpt' => $pinned_post_excerpt,
                'post_sources' => $pinned_post_sources,
            )
        );
        ?>



        <div class="post-table">
            <?php
            $counter = 0;
            while ($custom_query->have_posts()) : $custom_query->the_post();
                if (in_array(get_the_ID(), $displayed_posts)) continue;
                if ($counter >= 4) break;
                ?>
                <a id="post-<?php the_ID(); ?>" href="<?php the_permalink(); ?>">
                    <img class="post-thumbnail" src="<?php echo esc_url(get_the_post_thumbnail_url(null, 'full') ?: get_template_directory_uri() . '/assets/img/placeholder.webp'); ?>">
                    <div>
                        <h3><?php the_title(); ?></h3>
                        <span><?php echo esc_html(get_field('article_sources')); ?></span>
                    </div>
                </a>
                <?php
                $displayed_posts[] = get_the_ID();
                $counter++;
            endwhile;
            ?>
        </div>



        <?php if ($youtube_links): ?>
            <div class="swiper carouselSwiper">
                <h2>Videa</h2>
                <div class="swiper-wrapper">
                    <?php foreach ($youtube_links as $youtube_link): ?>
                        <div class="swiper-slide">
                            <iframe src="<?php echo esc_url($youtube_link); ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="swiper-button-next">
                    <img src="<?php echo esc_url(get_template_directory_uri() . "/assets/icons/swiper-arrow-black.svg"); ?>">
                </div>
                <div class="swiper-button-prev">
                    <img src="<?php echo esc_url(get_template_directory_uri() . "/assets/icons/swiper-arrow-black.svg"); ?>">
                </div>
            </div>
        <?php endif; ?>



        <div class="post-table">
            <?php
            $counter = 0;
            while ($custom_query->have_posts()) : $custom_query->the_post();
                if (in_array(get_the_ID(), $displayed_posts)) continue;
                if ($counter >= 4) break;
                ?>
                <a id="post-<?php the_ID(); ?>" href="<?php the_permalink(); ?>">
                    <img class="post-thumbnail" src="<?php echo esc_url(get_the_post_thumbnail_url(null, 'full') ?: get_template_directory_uri() . '/assets/img/placeholder.webp'); ?>">
                    <div>
                        <h3><?php the_title(); ?></h3>
                        <span><?php echo esc_html(get_field('article_sources')); ?></span>
                    </div>
                </a>
                <?php
                $displayed_posts[] = get_the_ID();
                $counter++;
            endwhile;
            ?>
        </div>



        <div class="themes-container">
            <?php
            $repeater_rows = get_field('linked_themes_repeater', $homepage_id);
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

            if (have_rows('linked_themes_repeater', $homepage_id)):
                while( have_rows('linked_themes_repeater', $homepage_id) ) : the_row();
                    $theme = get_sub_field('linked_themes_group');
                    $theme_id = $theme['taxonomy_theme_object'][0]->term_id;
                    $theme_img = $theme['taxonomy_theme_custom_img']['url'] ?: get_field('taxonomy_title_img', 'term_' .$theme_id);
                    $theme_link = get_term_link($theme_id);
                    $theme_title = $theme['taxonomy_theme_custom_name'] ?: $theme['taxonomy_theme_object'][0]->name;
                    ?>
                    <div class="theme-container <?php echo $theme_class;?>" style="background-image: url('<?php echo $theme_img ?>')">
                        <a href="<?php echo $theme_link ?>">
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



        <div class="post-list">
            <?php while ($custom_query->have_posts()) : $custom_query->the_post();
                if (in_array(get_the_ID(), $displayed_posts)) continue;
                ?>
                <a id="post-<?php the_ID(); ?>" href="<?php the_permalink(); ?>">
                    <img class="post-thumbnail" src="<?php echo esc_url(get_the_post_thumbnail_url(null, 'full') ?: get_template_directory_uri() . '/assets/img/placeholder.webp'); ?>">
                    <div>
                        <h3><?php the_title(); ?></h3>
                        <span><?php the_excerpt(); ?></span>
                        <div>
                            <?php echo display_post_time_info(get_the_ID()); ?>
                            <span>|</span>
                            <span><?php echo esc_html(get_field('article_sources')); ?></span>
                        </div>
                    </div>
                </a>
            <?php endwhile; ?>
        </div>
    </div>
<?php endif; ?>

<?php
// Reset the global post data to ensure any additional queries are not affected
wp_reset_postdata();
?>

<?php get_footer(); ?>
