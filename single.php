<?php
get_header();
echo '<div class="article-main">';
$title = get_the_title();
echo '<h1>' . $title . '</h1>';
the_content();
echo '<div>';
get_footer();
?>
