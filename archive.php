<?php get_header();
    $youtube_links = [];

    if (have_posts()) :
        while (have_posts()) : the_post();
            $youtube_link = get_field('article_youtube_embed');
            if ($youtube_link) {
                $youtube_links[] = getYoutubeEmbedUrl($youtube_link);
            }
        endwhile;
        rewind_posts();
    endif;
    $term = get_queried_object();
    $taxonomy = get_queried_object()->taxonomy;
    $taxonomy_name = $term->name;

    if ( have_posts() ) : ?>
    <div class="taxonomy-page">
        <?php
            if ($taxonomy == 'post_tag'):
        ?>
        <div class="taxonomy-title">
            <h2><?php echo $taxonomy_name ?></h2>
        </div>
        <?php
        endif;
        $displayed_posts = [];

        // First article
        $term_id = $term->term_id;
        if (get_field('taxonomy-pinned-post', 'term_' . $term_id)) {
            $pinned_post = get_field('taxonomy-pinned-post', 'term_' . $term_id);
            $pinned_post_title = $pinned_post->post_title;
            $pinned_post_url = get_permalink($pinned_post->ID);
            $pinned_post_excerpt = $pinned_post->post_excerpt;
            $pinned_post_img = get_the_post_thumbnail_url($pinned_post, 'full') ?: get_template_directory_uri() . '/assets/img/placeholder.webp';
            $pinned_post_sources = get_field('article_sources', $pinned_post->ID);

            $displayed_posts[] = $pinned_post->ID;
        } else {
            the_post();
            $pinned_post_title = get_the_title();
            $pinned_post_url = get_permalink();
            $pinned_post_excerpt = get_the_excerpt();
            $pinned_post_img = get_the_post_thumbnail_url(null, 'full') ?: get_template_directory_uri() . '/assets/img/placeholder.webp';
            $pinned_post_sources = get_field('article_sources');

            $displayed_posts[] = get_the_ID();
        }


        get_template_part(
            'template-parts/page-content/pinned-post',
            null,
            array(
                'post_url' => $pinned_post_url,
                'post_img' => $pinned_post_img,
                'post_title' => $pinned_post_title,
                'post_excerpt' => $pinned_post_excerpt,
                'post_sources' => $pinned_post_sources,
            )
        );
        ?>


        <div class="post-table">
            <?php
            $counter = 0;
            while ( have_posts() ) : the_post();
                if (in_array(get_the_ID(), $displayed_posts)) continue; //Skips already displayed post
                if ($counter >= 4) break;

                ?>
                <a id="post-<?php the_ID(); ?>" href="<?php the_permalink();?>">
                    <img class="post-thumbnail" src="<?php echo get_the_post_thumbnail_url(null, 'full') ?: get_template_directory_uri() . '/assets/img/placeholder.webp' ?>">
                    <div>
                        <h3><?php the_title() ?></h3>
                        <span><?php echo get_field('article_sources'); ?></span>
                    </div>
                </a>
                <?php
                $displayed_posts[] = get_the_ID();
                $counter++;
            endwhile;
            ?>
        </div>


        <?php
        get_template_part(
        'template-parts/page-content/themes-block',
        null,
            array(
                    "page_id"          =>  $term_id,
                    "is_page_taxonomy" =>  true,
                    "repeater_name"    =>  "linked_themes_repeater",
            )
        );
        ?>




        <div class="post-list">
            <?php
            while ( have_posts() ) : the_post();
                if (in_array(get_the_ID(), $displayed_posts)) continue;
                ?>
                <a id="post-<?php the_ID(); ?>" href="<?php the_permalink();?>">
                    <img class="post-thumbnail" src="<?php echo get_the_post_thumbnail_url(null, 'full') ?: get_template_directory_uri() . '/assets/img/placeholder.webp' ?>">
                    <div>
                        <h3><?php the_title() ?></h3>
                        <span><?php the_excerpt(); ?></span>
                        <div>
                            <?php echo display_post_time_info(get_the_ID()) ?>
                            <span>|</span>
                            <span><?php echo get_field('article_sources'); ?></span>
                        </div>
                    </div>
                </a>
                <?php
                $displayed_posts[] = get_the_ID();
            endwhile;
            ?>
        </div>

    </div>
<?php endif; ?>

<?php get_footer(); ?>
