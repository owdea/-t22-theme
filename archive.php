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
            $pinned_post_img = get_the_post_thumbnail_url($pinned_post) ?: get_template_directory_uri() . '/assets/img/placeholder.webp';
            $pinned_post_sources = get_field('article_sources', $pinned_post->ID);
            echo $pinned_post_title;
            echo $pinned_post_url;
            echo $pinned_post_excerpt;
            echo $pinned_post_img;
            echo $pinned_post_sources;
        } else {
            the_post();
        }


        ?>

    </div>
<?php endif; ?>

<?php get_footer(); ?>
