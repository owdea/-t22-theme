<?php get_header(); ?>

<?php
$WP_Query_args = array(
    'post_type' => 'post',
    'posts_per_page' => -1, // Load all posts
    'post_status' => 'publish',
);
$custom_query = new WP_Query($WP_Query_args);

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


        $posts_data = array();
        $counter = 0;

        while (have_posts()) : the_post();
            if (in_array(get_the_ID(), $displayed_posts)) continue;
            if ($counter >= 4) break;

            $posts_data[] = array(
                'id' => get_the_ID(),
                'url' => get_permalink(),
                'thumbnail' => get_the_post_thumbnail_url(null, 'full') ?: get_template_directory_uri() . '/assets/img/placeholder.webp',
                'title' => get_the_title(),
                'source' => get_field('article_sources'),
            );

            $displayed_posts[] = get_the_ID();
            $counter++;
        endwhile;

        get_template_part(
            'template-parts/page-content/post-table',
            null,
            array(
                'posts_data' => $posts_data
            )
        );


        get_template_part(
            'template-parts/page-content/carousel',
            null,
            array(
                "youtube_links" => $youtube_links,
            )
        );


        $posts_data = array();
        $counter = 0;

        while (have_posts()) : the_post();
            if (in_array(get_the_ID(), $displayed_posts)) continue;
            if ($counter >= 4) break;

            $posts_data[] = array(
                'id' => get_the_ID(),
                'url' => get_permalink(),
                'thumbnail' => get_the_post_thumbnail_url(null, 'full') ?: get_template_directory_uri() . '/assets/img/placeholder.webp',
                'title' => get_the_title(),
                'source' => get_field('article_sources'),
            );

            $displayed_posts[] = get_the_ID();
            $counter++;
        endwhile;

        get_template_part(
            'template-parts/page-content/post-table',
            null,
            array(
                'posts_data' => $posts_data
            )
        );


        get_template_part(
            'template-parts/page-content/themes-block',
            null,
            array(
                "page_id" => $homepage_id,
                "is_page_taxonomy" => false,
                "repeater_name" => "linked_themes_repeater",
            )
        );
        ?>


        <?php
        $post_list_data = array();
        while ($custom_query->have_posts()) : $custom_query->the_post();
            if (in_array(get_the_ID(), $displayed_posts)) continue;
            $post_list_data[] = array(
                'id' => get_the_ID(),
                'url' => get_permalink(),
                'thumbnail' => get_the_post_thumbnail_url(null, 'full') ?: get_template_directory_uri() . '/assets/img/placeholder.webp',
                'title' => get_the_title(),
                'excerpt' => get_the_excerpt(),
                'source' => get_field('article_sources'),
            );
            ?>
        <?php endwhile;
        get_template_part(
            'template-parts/page-content/post-list',
            null,
            array(
                "post_list_data" => $post_list_data
            )
        )
        ?>

</div>
<?php endif; ?>

<?php
// Reset the global post data to ensure any additional queries are not affected
wp_reset_postdata();
?>

<?php get_footer(); ?>
