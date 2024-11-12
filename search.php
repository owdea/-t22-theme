<?php get_header(); ?>

<?php
$start_time = microtime(true);
?>
<div class="search-results-page">
    <div class="search-results-page-top">
        <h1>Vyhledávání</h1>

        <?php
        $total_results = $wp_query->found_posts;
        ?>

        <div class="search-bar">
            <form role="search" method="get" action="<?php echo home_url( '/' ); ?>">
                <label>
                    <span class="screen-reader-text"><?php echo _x( 'Search for:', 'label' ) ?></span>
                    <input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Hledat ...', 'placeholder' ) ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>" />
                </label>
                <button type="submit" class="search-submit">
                    <span>Hledej</span>
                </button>
            </form>
        </div>
    </div>
    <div class="info-row">
<?php
global $query_time;
?>
        <p>Počet výsledků: <?php echo number_format_i18n($total_results); ?> (<?php echo number_format_i18n($query_time, 4)?> s)</p>

        <div class="sorting-dropdown">
            <form method="get" action="">
                <input type="hidden" name="s" value="<?php echo get_search_query(); ?>">

                <label for="orderby">Řadit podle:</label>
                <select name="orderby" id="orderby" onchange="this.form.submit()">
                    <option value="relevance" <?php selected(get_query_var('orderby'), 'relevance'); ?>>Relevance</option>
                    <option value="date" <?php selected(get_query_var('orderby'), 'date'); ?>>Datum</option>
                </select>
            </form>
        </div>
    </div>

<?php if ( have_posts() ) : ?>
    <div class="search-results">
        <?php while ( have_posts() ) : the_post(); ?>
            <article class="search-results-post" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <h2><a href="<?php the_permalink(); ?>"><?php echo highlight_search_text(get_the_title()); ?></a></h2>
                <div class="article-info">
                    <?php
                    $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                    if ($thumbnail_url) {
                        echo '<img src="' . esc_url($thumbnail_url) . '" alt="' . get_the_title() . '">';
                    }
                    echo '<p>';
                    echo highlight_search_text(get_the_excerpt());
                    echo '</p>';
                    ?>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
    ?>

<?php else : ?>
    <p class="no-results"><?php _e( 'Nebyly nalezeny zádné výsledky', 'textdomain' ); ?></p>
<?php endif; ?>
</div>
<?php get_footer(); ?>
