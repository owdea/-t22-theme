<?php
get_header();
?>
<div class="article-container">
    <div class="article-main">
        <?php
        $title = get_the_title();
        echo '<h1 class="article-title">' . $title . '</h1>';
        ?>
        <div class="metadata-container">
            <div class="metadata-authors">
                <?php
                if ( function_exists( 'get_field' ) ) {
                    if ( have_rows( 'authors_repeater' ) ) {
                        $author_links = [];

                        while ( have_rows( 'authors_repeater' ) ) {
                            the_row();

                            $author_select = get_sub_field( 'authors_select' );
                            $wp_author = get_sub_field( 'authors_with_wp_account' );

                            // if custom author is selected
                            if ( $author_select ) {
                                $author_links[] = '<a href="https://ct24.ceskatelevize.cz/tema/autori-webu-ct24-84343">' . esc_html( $author_select ) . '</a>';
                            }

                            // if WP user is chosen
                            if ( $wp_author ) {
                                $author_links[] = '<a href="https://ct24.ceskatelevize.cz/tema/autori-webu-ct24-84343">' . $wp_author["nickname"] . '</a>';

                            }
                        }
                        if ( !empty( $author_links ) ) {
                            echo implode( ',&nbsp;', $author_links );
                        }
                    }
                }
                ?>
            </div>
            <div class="metadata-info-row">
                <?php
                echo display_post_time_info(get_the_ID())
                ?>
                <span class="metadata-divider">|</span>
                <span class="metadata-sources">Zdroj: <?php echo get_field('article_sources');?></span>
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
