<header id="masthead" class="site-header">
    <div class="site-branding">
        <?php the_custom_logo(); ?>
        <div class="logo-separator"></div>
        <a href="/">
            <?php the_custom_logo_2(); ?>
        </a>
    </div>

    <button class="mobile-menu-btn">
        <svg width="24" height="18" viewBox="0 0 24 18" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M1 9H23" stroke="#145C8E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M1 1H23" stroke="#145C8E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M1 17H23" stroke="#145C8E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </button>

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