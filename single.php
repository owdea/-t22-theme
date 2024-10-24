<?php
get_header();
?>
<div class="article-container">
    <div class="article-main">
        <?php
        $title = get_the_title();
        echo '<h1>' . $title . '</h1>';
        ?>
        <div class="metadata-container">
            <div class="metadata-authors">
<?php
if ( function_exists( 'get_multiple_authors' ) ) {
    $authors = publishpress_authors_get_post_authors();
    if ( ! empty( $authors ) ) {
        foreach ( $authors as $author ) {
            echo '<a href="https://ct24.ceskatelevize.cz/tema/autori-webu-ct24-84343">';
            echo esc_html( $author->display_name );
            echo '</a>';
        }
    }
}
?>
            </div>
            <div class="metadata-info-row">
                <?php
                $publish_time = get_the_time('U');
                $modified_time = get_the_modified_time('U');

                $time_diff = $modified_time - $publish_time;

                if ($time_diff > 0) {
                    $hours_diff = floor($time_diff / (60 * 60));
                }
                ?>
                <span class="metadata-date-published"><?php echo get_the_date('j. m. Y'); ?></span>
                <span><?php the_modified_time(); ?></span>
                <span><?php echo $hours_diff ?></span>
            </div>
        </div>
<?php
the_content();
?>
    <div>
<div>
<?php
get_footer();
?>
