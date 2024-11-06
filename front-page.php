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
echo $homepage_id;

if ($custom_query->have_posts()) : ?>
    <div class="homepage">

        <?php
        $displayed_posts = [];

        if ($custom_query->have_posts()) {
            $custom_query->the_post();

            $pinned_post_title = get_the_title();
            $pinned_post_url = get_permalink();
            $pinned_post_excerpt = get_the_excerpt();
            $pinned_post_img = get_the_post_thumbnail_url(null, 'full') ?: get_template_directory_uri() . '/assets/img/placeholder.webp';
            $pinned_post_sources = get_field('article_sources');

            $displayed_posts[] = get_the_ID();
        }
        ?>

        <article class="pinned-post">
            <a href="<?php echo esc_url($pinned_post_url); ?>">
                <div class="pinned-post-img">
                    <img src="<?php echo esc_url($pinned_post_img); ?>" alt="<?php echo esc_attr($pinned_post_title); ?>">
                </div>
                <div class="pinned-post-info">
                    <h2><?php echo esc_html($pinned_post_title); ?></h2>
                    <span><?php echo esc_html($pinned_post_excerpt); ?></span>
                    <span><?php echo esc_html($pinned_post_sources); ?></span>
                </div>
            </a>
        </article>



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
