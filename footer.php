<footer>
  <p>Copyright © 2024</p>
  <?php
  wp_nav_menu(
      array(
          'theme_location' => 'footer',
          'menu_class'     => 'footer',
          'container'      => 'nav'
      )
  );
  ?>
</footer>
<?php wp_footer(); ?>
</body>
</html>
