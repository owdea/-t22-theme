<footer>
    <div class="footer-container">
        <a class="footer-logo">
            <?php $main_logo = get_field('footer_main_logo', 'options');?>
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/acf/<?php echo $main_logo; ?>.svg" alt="Logo České Televize">
        </a>
        <div class="footer-contact">
            <div class="footer-contact-center">
                <span class="font-semibold text-black mb-2 tablet:mb-0"><?php echo get_field('footer_contact', 'options')['footer_contact_title']; ?></span>
                <br class="tablet:hidden">
                <span class="tablet:mt-2"><?php echo get_field('footer_contact', 'options')['footer_contact_open_hours']; ?></span>
            </div>
            <div class="footer-contact-contacts-list">
                <?php
                    $phone_number = get_field('footer_contact', 'options')['footer_contact_phone_number'];
                    $mail_address = get_field('footer_contact', 'options')['footer_contact_email'];
                ?>
                <a href="tel:<?php echo $phone_number;?>">
                    <img src="<?php get_site_url();?>/wp-content/themes/ct22-theme/assets/icons/phone.svg">
                    <span><?php echo $phone_number; ?></span>
                </a>
                <a href="mailto:<?php echo $mail_address;?>">
                    <img src="<?php get_site_url();?>/wp-content/themes/ct22-theme/assets/icons/mail.svg">
                    <span><?php echo get_field('footer_contact', 'options')['footer_contact_email']; ?></span>
                </a>
            </div>
        </div>
        <hr class="tablet:hidden">
        <?php
          wp_nav_menu(
               array(
                   'theme_location' => 'footer',
                   'menu_class'     => 'footer',
                   'container'      => 'nav'
               )
           );
        ?>
        <hr class="tablet:hidden">
        <?php if( have_rows('footer_socials', 'option') ): ?>
        <div class="footer-socials">
            <div>
                <span>Česká televize na sociálních sítích:</span>
            </div>
            <ul>
                <?php while( have_rows('footer_socials', 'option') ): the_row();
                    $icon = get_sub_field('social_network_icon');
                    $icon_hover = get_sub_field('social_network_active_icon');
                    $name = get_sub_field('social_network_name');
                    $link = get_sub_field('social_network_link');
                    ?>
                    <li>
                        <a href="<?php echo $link ?>">
                            <img id="socials-icon" src="<?php echo get_template_directory_uri(); ?>/assets/img/acf/<?php echo $icon; ?>.svg" alt="<?php $name = get_sub_field('social_network_name'); ?> ikona">
                            <img id="socials-icon-hover" class="hidden" src="<?php echo get_template_directory_uri(); ?>/assets/img/acf/<?php echo $icon_hover; ?>.svg" alt="<?php $name = get_sub_field('social_network_name'); ?> aktivní ikona">
                            <span><?php echo $name ?></span>
                        </a>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
        <?php endif; ?>
        <hr class="footer-subfooter-hr">
        <div class="footer-subfooter">
            <div>
                <span class="text-darkscale-40 block sm:inline ">© Česká televize</span>
                <span class="separator hidden sm:inline">•</span>
                <a href="">English version</a>
                <span class="separator">•</span>
                <a href="">Ochrana soukromí</a>
            </div>
            <div>
                <a href="">Mapa stránek</a>
                <span class="separator">•</span>
                <a href="">RSS</a>
            </div>
        </div>
        <?php if( have_rows('footer_logos', 'option') ): ?>
        <ul class="footer-logos">
            <?php while( have_rows('footer_logos', 'option') ): the_row();
                $icon = get_sub_field('footer_tv_logo');
                $link = get_sub_field('footer_tv_link');
                ?>
                <li>
                    <a href="<?php $link ?>">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/acf/<?php echo $icon; ?>.svg" alt="">
                    </a>
                </li>
            <?php endwhile; ?>
        </ul>
        <?php endif; ?>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
