<?php
/*
 * Template part - post-table;
 *
 * $args:
 *
 * "post_data" => Required
 * including:
 *          "id"         => Required (String)
 *          "url"        => Required (url)
 *          "thumbnail"  => Required (url)
 *          "title"      => Required (String)
 *          "source"     => Required (String)
 *
 *
*/
if (! empty($args)):
$posts_data = $args['posts_data'];

?>
<div class="template-part-post-table">
        <?php foreach ($args['posts_data'] as $post): ?>
            <a id="post-<?php echo esc_attr($post['id']); ?>" href="<?php echo esc_url($post['url']); ?>">
                <img class="post-thumbnail" src="<?php echo esc_url($post['thumbnail']); ?>" alt="<?php echo esc_attr($post['title']); ?>">
                <div>
                    <h3><?php echo esc_html($post['title']); ?></h3>
                    <span><?php echo esc_html($post['source']); ?></span>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
<?php
endif;
?>