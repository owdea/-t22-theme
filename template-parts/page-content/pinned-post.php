<?php
/*Template part - Pinned post (on Homepage, Taxonomy page etc)
 *
 * List of $args
 *
 * "post_url"       => Required (url)
 * "post_img"       => Required (url)
 * "post_title"     => Required (String)
 * "post_excerpt"   => Optional (String)
 * "post_sources"   => Optional (String)
 *
 */

if (!empty($args)):
$pinned_post_url = $args['post_url'] ?? null;
$pinned_post_img = $args['post_img'] ?? null;
$pinned_post_title = $args['post_title'] ?? null;
$pinned_post_excerpt = $args['post_excerpt'] ?? null;
$pinned_post_sources = $args['post_sources'] ?? null;
if ($pinned_post_url && $pinned_post_img) {}
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