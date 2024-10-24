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
                    if ( function_exists( 'get_multiple_authors' ) ) {
                        $authors = publishpress_authors_get_post_authors();
                        if ( ! empty( $authors ) ) {
                            $author_links = []; // Vytvoříme prázdné pole pro odkazy na autory

                            // Projdeme všechny autory a vytvoříme odkaz pro každého
                            foreach ( $authors as $author ) {
                                $author_links[] = '<a href="https://ct24.ceskatelevize.cz/tema/autori-webu-ct24-84343">' . esc_html( $author->display_name ) . '</a>';
                            }

                            // Sloučíme odkazy a oddělíme čárkou a mezerou, bez čárky za posledním
                            echo implode(',&nbsp;', $author_links);
                        }
                    }
                ?>
            </div>
            <div class="metadata-info-row">
                <?php
                $publish_time = get_the_time('U');
                $modified_time = get_the_modified_time('U');

                $current_time = current_time('timestamp');

                $time_diff_publish = $current_time - $publish_time;
                $time_diff_modify = $current_time - $modified_time;

                // Time since publish
                if ($time_diff_publish >= 60 * 60 * 24) {
                    echo '<span class="published-date">' . get_the_date('j. m. Y') . '</span>';
                } elseif ($time_diff_publish >= 60 * 60) {
                    $hours = floor($time_diff_publish / (60 * 60)) == 1 ? "hodinou" : "hodinami";
                    echo '<span class="published-date">před ' . floor($time_diff_publish / (60 * 60)) .' '. $hours .'</span>';
                } else {
                    $minutes = floor($time_diff_publish / (60)) == 1 ? "minutou" : "minutami";
                    echo '<span class="published-date">před ' . floor($time_diff_publish / 60) .' '. $minutes .'</span>';
                }

                // Time since last update (if there was any)
                if ($modified_time != $publish_time) {
                    echo '<img src="' . get_template_directory_uri() .'/assets/icons/update.svg" alt="aktualizováno">';

                    if ($time_diff_modify >= 60 * 60 * 24) {
                        echo '<span>' . get_the_modified_date('j. m. Y') . '</span>';
                    } elseif ($time_diff_modify >= 60 * 60) {
                        $hours = floor($time_diff_modify / (60 * 60)) == 1 ? "hodinou" : "hodinami";
                        echo '<span>před ' . floor($time_diff_modify / (60 * 60)) .' '. $hours .'</span>';
                    } else {
                        $minutes = floor($time_diff_modify / 60) == 1 ? "minutou" : "minutami";
                        echo '<span>před ' . floor($time_diff_modify / 60) .' '. $minutes .'</span>';
                    }
                }
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
