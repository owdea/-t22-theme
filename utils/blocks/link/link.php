<?php
/**
 * Block - Arrange Meeting
 *
 * @package ct22
 */

$page_link = get_field('block_link_page');
if ($page_link || (get_field('block_link_title') && get_field('block_link_link') && get_field('block_link_image'))) {

$title = get_field('block_link_title') ? get_field('block_link_title') : get_the_title($page_link->ID);
$link = get_field('block_link_link') ? get_field('block_link_link') : get_permalink($page_link->ID);;
$img = get_field('block_link_image') ? get_field('block_link_image') : get_the_post_thumbnail_url($page_link->ID, 'full');

?>
<div class="block-link-component">
    <a href="<?php echo $link?>">
        <div>
            <span>ODKAZ</span>
            <br>
            <h3><?php echo $title ?></h3>
        </div>
        <div class="block-link-img-container">
            <img src="<?php echo $img ?>">
        </div>
    </a>
</div>

<?php
}