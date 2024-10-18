<?php
/**
 * Block - Photo gallery block (to post/page or external)
 *
 * @package ct22
 */

$gallery_array = get_field('block_gallery_repeater');
?>
<div class="photo-gallery">
    <button class="photo-main">
        <img src="<?php echo $gallery_array[0]["block_gallery_img"]?>" alt="<?php echo $gallery_array[0]["block_gallery_desc"]?>">
        <?php
        if (count($gallery_array) > 1):
        ?>
            <span><?php echo $gallery_array[0]["block_gallery_desc"];?></span>
            <span><?php echo $gallery_array[0]["block_gallery_source"];?></span>
        <?php
        endif;
        ?>
    </button>
    <?php
        if (count($gallery_array) === 1):
    ?>
    <span><?php echo $gallery_array[0]["block_gallery_desc"];?></span>
    <span><?php echo $gallery_array[0]["block_gallery_source"];?></span>
    <?php endif; ?>

<?php
if (count($gallery_array) > 1):
?>
    <div class="">
    <?php
        for($i = 1; $i < count($gallery_array); $i++):
            ?>
                <button>
                    <img src="<?php echo $gallery_array[$i]["block_gallery_img"]?>" alt="<?php echo $gallery_array[$i]["block_gallery_desc"]?>">
                </button>
            <?php
        endfor;
    ?>
    </div>
<?php endif; ?>
</div>
