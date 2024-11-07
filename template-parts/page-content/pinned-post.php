<?php
/*Template part - Pinned post (on Homepage, Taxonomy page etc)
 *
 * List of $args
 *
 * "post_url" => Required
 * "post_img" => Required
 * "post_title" => Required
 * "post_excerpt" => Optional
 * "post_sources" => Optional
 *
 */

if (!empty($args)):
$pinned_post_url = $args['post_url'];
$pinned_post_img = $args['post_img'];
$pinned_post_title = $args['post_title'];
$pinned_post_excerpt = $args['post_excerpt'];
$pinned_post_sources = $args['post_sources'];
?>

<article class="template-part-pinned-post">

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
<?php
endif;
?>