<?php
/**
 * Block - Photo gallery block (to post/page or external)
 *
 * @package ct22
 */

$gallery_array = get_field('block_gallery_repeater');
if (count($gallery_array) === 1):
?>
<div>
    <button>
        <img src="<?php echo $gallery_array[0]["block_gallery_img"]?>" alt="<?php echo $gallery_array[0]["block_gallery_desc"]?>">
    </button>
</div>
<?php
endif;