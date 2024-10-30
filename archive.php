<?php get_header(); ?>

<?php if ( have_posts() ) : ?>
    <div class="taxonomy-page">
        <?php
        $displayed_posts = [];

        // First article
        $term = get_queried_object();
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
        ?>
        <article class="pinned-post">
            <a href="<?php echo $pinned_post_url ?>">
                <div class="pinned-post-img">
                    <img src="<?php echo $pinned_post_img ?>" alt="<?php echo $pinned_post_title ?>">
                </div>
                <div class="pinned-post-info">
                    <h2><?php echo $pinned_post_title ?></h2>
                    <span><?php echo $pinned_post_excerpt ?></span>
                    <span><?php echo $pinned_post_sources ?></span>
                </div>
            </a>
        </article>

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

        <div>
            <h2>Carousel placeholder</h2>
        </div>
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

        <div>
            <h2>Themes blocks placeholder</h2>
        </div>
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