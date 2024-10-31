<?php
/**
 * Block - Photo gallery block (to post/page or external)
 *
 * @package ct22
 */

$gallery_array = get_field('block_gallery_repeater');
?>
<div class="photo-gallery">
    <button class="photo-main" id="gallery-photo-0">
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
                <button id=<?php echo "gallery-photo-" . $i ?> class="<?php echo $photo_row_button_class?>">
                    <img src="<?php echo $gallery_array[$i]["block_gallery_img"] ?: get_template_directory_uri() . '/assets/img/placeholder.webp'; ?>" alt="<?php echo $gallery_array[$i]["block_gallery_desc"]?>">
                    <?php
                        if ($i === 3 && count($gallery_array) > 4):
                    ?>
                    <div class="photo-more photo-more-second">
                        <img src="<?php echo get_template_directory_uri()?>/assets/icons/camera.svg" alt="ikona kamery">
                        <span>+ <?php echo count($gallery_array) - 3 ?> dalších</span>
                    </div>
                    <?php
                        endif;
                    ?>
                    <?php
                        if ($i === 4 && count($gallery_array) > 5):
                    ?>
                    <div class="photo-more photo-more-first">
                        <img src="<?php echo get_template_directory_uri()?>/assets/icons/camera.svg" alt="ikona kamery">
                        <span>+ <?php echo count($gallery_array) - 4 ?> dalších</span>
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

<div class="photo-gallery-modal">
    <div class="modal-header">
        <div class="modal-header-logo">
            <img src="<?php echo get_template_directory_uri() . "/assets/icons/ct22-logo-white.svg"?>" alt="ČT22 logo">
        </div>
        <div class="modal-header-article-content">
            <div class="modal-header-title">
                <h2>
                    <?php
                    $title = get_the_title();
                    echo $title;
                    ?>
                </h2>
            </div>
            <?php
                if (count($gallery_array) > 1):
            ?>
            <div class="modal-header-article-content-right">
                <div class="swiper-pagination"></div>
                <button class="modal-header-library-button">
                    <img src="<?php echo get_template_directory_uri() . "/assets/icons/gallery.svg"?>" alt="Otevřít galerii">
                    <span>zobrazit galerii</span>
                </button>
            </div>
            <?php endif; ?>
        </div>
        <button class="modal-header-close-button">
            <img src="<?php echo get_template_directory_uri() . "/assets/icons/exit-icon-modal.svg"?>" alt="Zavřít modální okno">
        </button>
    </div>
    <div class="modal-gallery">
        <?php
        for ($i = 0; $i < count($gallery_array); $i++):
        ?>
        <div class="modal-gallery-image-container">
        <button id=<?php echo "modal-gallery-img-" . $i ?>>
            <img src="<?php echo $gallery_array[$i]["block_gallery_img"] ?: get_template_directory_uri() . '/assets/img/placeholder.webp'; ?>" alt="<?php echo $gallery_array[$i]["block_gallery_desc"] ?: "Obrázek"?>">
        </button>
            <div class="modal-photo-description">
                <?php if ($gallery_array[$i]["block_gallery_desc"])?> <span><?php echo $gallery_array[$i]["block_gallery_desc"];?></span>
                <?php if ($gallery_array[$i]["block_gallery_source"])?> <span class="photo-overlay-sources">Zdroj: <?php echo $gallery_array[0]["block_gallery_source"];?></span>
            </div>
        </div>
        <?php
        endfor;
        ?>
    </div>
    <div class="modal-desktop">

        <div class="swiper swiper-gallery">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <?php
                for ($i = 0; $i < count($gallery_array); $i++):
                ?>
                <!-- Slides -->
                <div class="swiper-slide">
                    <img src="<?php echo $gallery_array[$i]["block_gallery_img"] ?: get_template_directory_uri() . '/assets/img/placeholder.webp'; ?>" alt="<?php echo $gallery_array[0]["block_gallery_desc"]?>">
                    <div class="swiper-slide-description">
                        <?php if($gallery_array[$i]["block_gallery_desc"]){?><span><?php echo $gallery_array[$i]["block_gallery_desc"];?></span><?php } ?>
                        <?php if($gallery_array[$i]["block_gallery_source"]){?><span class="photo-sources">Zdroj: <?php echo $gallery_array[$i]["block_gallery_source"];?></span><?php } ?>
                    </div>
                </div>
                <?php
                endfor;
                ?>
            </div>
            <!-- If we need navigation buttons -->
            <div class="swiper-button-prev">
                <img src=<?php echo get_template_directory_uri() . "/assets/icons/swiper-arrow.svg"?>>
            </div>
            <div class="swiper-button-next">
                <img src=<?php echo get_template_directory_uri() . "/assets/icons/swiper-arrow.svg"?>>
            </div>
        </div>
    </div>
</div>
