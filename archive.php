<?php get_header(); ?>

<?php if ( have_posts() ) : ?>
    <div class="taxonomy-page">
        <?php
        // first article
        $term = get_queried_object();
        $term_id = $term->term_id;
        if (get_field('taxonomy-pinned-post', 'term_' . $term_id)) {
            $pinned_post = (get_field('taxonomy-pinned-post', 'term_' . $term_id));
            $pinned_post_title = $pinned_post->post_title;
            $pinned_post_url = get_permalink($pinned_post->ID);
            $pinned_post_excerpt = $pinned_post->post_excerpt;
            $pinned_post_img = get_the_post_thumbnail_url($pinned_post, 'full') ?: get_template_directory_uri() . '/assets/img/placeholder.webp';
            $pinned_post_sources = get_field('article_sources', $pinned_post->ID);
        } else {
            the_post();
            $pinned_post_title = get_the_title();
            $pinned_post_url = get_permalink();
            $pinned_post_excerpt = get_the_excerpt();
            $pinned_post_img = get_the_post_thumbnail_url(null, 'full') ?: get_template_directory_uri() . '/assets/img/placeholder.webp';
            $pinned_post_sources = get_field('article_sources');
        }
        ?>
        <div class="pinned-post">
            <a href="<?php echo $pinned_post_url ?>">
                <div class="pinned-post-img">
                    <img src="<?php echo $pinned_post_img?>" alt="<?php echo $pinned_post_title ?>">
                </div>
                <div class="pinned-post-info">
                    <h2><?php echo $pinned_post_title ?></h2>
                    <span><?php echo $pinned_post_excerpt ?></span>
                    <span><?php echo $pinned_post_sources ?></span>
                </div>
            </a>
        </div>

    </div>
<?php endif; ?>

<?php get_footer(); ?>
