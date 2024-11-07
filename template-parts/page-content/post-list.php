<?php
/*
 *
 *
 *
 * */

if (!empty($args['post_list_data'])):


    ?>
    <div class="template-part-post-list">
        <?php foreach ($args['post_list_data'] as $post): ?>
            <a id="post-<?php echo esc_attr($post['id']); ?>" href="<?php echo esc_url($post['url']); ?>">
                <img class="post-thumbnail" src="<?php echo esc_url($post['thumbnail']); ?>" alt="<?php echo esc_attr($post['title']); ?>">
                <div>
                    <h3><?php echo esc_html($post['title']); ?></h3>
                    <span><?php echo esc_html($post['excerpt']); ?></span>
                    <div>
                        <?php echo display_post_time_info($post['id']) ?>
                        <span>|</span>
                        <span><?php echo get_field('article_sources', $post['id']); ?></span>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
