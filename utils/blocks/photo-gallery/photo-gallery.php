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
        <img src="<?php echo $gallery_array[0]["block_gallery_img"] ?: get_template_directory_uri() . '/assets/img/placeholder.webp'; ?>" alt="<?php echo $gallery_array[0]["block_gallery_desc"]?>">
        <?php
        if (count($gallery_array) > 1):
        ?>
        <div class="photo-overlay-description">
            <span><?php echo $gallery_array[0]["block_gallery_desc"];?></span>
            <span class="photo-overlay-sources">Zdroj: <?php echo $gallery_array[0]["block_gallery_source"];?></span>
        </div>
        <?php
        endif;
        ?>
    </button>
    <?php
        if (count($gallery_array) === 1):
    ?>
    <div class="photo-description">
        <?php if($gallery_array[0]["block_gallery_desc"])?><span><?php echo $gallery_array[0]["block_gallery_desc"];?></span>
        <?php if($gallery_array[0]["block_gallery_source"])?><span class="photo-sources">Zdroj: <?php echo $gallery_array[0]["block_gallery_source"];?></span>
    </div>
    <?php endif; ?>

<?php
if (count($gallery_array) > 1):
?>
    <div class="photo-row">
    <?php
        switch (count($gallery_array)):
        case 2:
        case 3:
            $photo_row_button_class = "photo-row-button-class-2";
            break;
        case 4:
            $photo_row_button_class = "photo-row-button-class-3";
            break;
        default:
            $photo_row_button_class = "photo-row-button-class-4";
            break;
        endswitch;
        for($i = 1; $i < count($gallery_array); $i++):
            ?>
                <button class="<?php echo $photo_row_button_class?>">
                    <img src="<?php echo $gallery_array[$i]["block_gallery_img"] ?: get_template_directory_uri() . '/assets/img/placeholder.webp'; ?>" alt="<?php echo $gallery_array[$i]["block_gallery_desc"]?>">
                    <?php
                        if ($i === 3 && count($gallery_array) > 4):
                    ?>
                    <div class="photo-more photo-more-second">
                        <img src="<?php echo get_template_directory_uri()?>/assets/icons/camera.svg" alt="ikona kamery">
                        <span>+ <span><?php echo count($gallery_array) - 3 ?></span> dalších</span>
                    </div>
                    <?php
                        endif;
                    ?>
                    <?php
                        if ($i === 4 && count($gallery_array) > 5):
                    ?>
                    <div class="photo-more photo-more-first">
                        <img src="<?php echo get_template_directory_uri()?>/assets/icons/camera.svg" alt="ikona kamery">
                        <span>+ <span><?php echo count($gallery_array) - 4 ?></span> dalších</span>
                    </div>
                    <?php
                        break;
                        endif;
                    ?>
                </button>
            <?php
        endfor;
    ?>
    </div>
<?php endif; ?>
</div>
