<header id="masthead" class="site-header">
    <div class="site-branding">
        <a href="#">
            <img src="" alt="logo 1">
        </a>
        <div class="logo-separator"></div>
        <?php the_custom_logo(); ?>
    </div>

    <nav id="site-navigation" class="main-navigation">
        <?php
        wp_nav_menu(
            array(
                'theme_location' => 'menu-1',
                'menu_id'        => 'primary-menu',
            )
        );
        ?>
    </nav>
</header>