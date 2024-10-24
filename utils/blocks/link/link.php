<?php
/**
 * Block - Link block (to post/page or external)
 *
 * @package ct22
 */

$page_link = get_field('block_link_page');
if ($page_link || (get_field('block_link_title') && get_field('block_link_link'))):
    $title = get_field('block_link_title') ? get_field('block_link_title') : get_the_title($page_link->ID);
    $link = get_field('block_link_custom') ? get_field('block_link_link') : get_permalink($page_link->ID);
    if (get_field('block_link_image')) {
        $img = get_field('block_link_image');
    } else if ($page_link && get_the_post_thumbnail_url($page_link->ID, 'full')){
        $img = get_the_post_thumbnail_url($page_link->ID, 'full');
    } else {
        $img = get_template_directory_uri() . '/assets/img/placeholder.webp';
    }
    ?>
    <div class="block-link-component">
        <a href="<?php echo $link?>">
            <div>
                <span>ODKAZ</span>
                <h3><?php echo $title ?></h3>
            </div>
            <?php if($img): ?>
            <div class="block-link-img-container">
                <img src="<?php echo $img ?>" alt="obrázek týkající se <?php echo $title ?>">
            </div>
            <?php endif; ?>
        </a>
    </div>

    <?php
endif;