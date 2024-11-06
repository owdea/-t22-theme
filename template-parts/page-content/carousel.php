<?php
/*
 * Template part - Carousel
 *
 *
 * "youtube_links" => Required (array of youtube links)
 * "title" => Optional (Title of the component, default "Videa")
 * */

if ( ! empty($args)):
    $youtube_links = $args["youtube_links"] ?? null;
    $title = $args["title"] ?? null;

    if ($youtube_links): ?>
        <div class="swiper carouselSwiper">
            <h2><?= $title ?: "Videa"?></h2>
            <div class="swiper-wrapper">
                <?php foreach ($youtube_links as $youtube_link): ?>
                    <div class="swiper-slide">
                        <iframe src="<?php echo esc_url($youtube_link); ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-button-next">
                <img src="<?php echo esc_url(get_template_directory_uri() . "/assets/icons/swiper-arrow-black.svg"); ?>">
            </div>
            <div class="swiper-button-prev">
                <img src="<?php echo esc_url(get_template_directory_uri() . "/assets/icons/swiper-arrow-black.svg"); ?>">
            </div>
        </div>
    <?php
    endif;
endif;
?>