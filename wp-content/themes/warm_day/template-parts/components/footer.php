<footer id="colophon" class="site-footer">
    <div class="site-info">
        <a href="<?php echo esc_url( __( 'https://wordpress.org/', 'warm_day' ) ); ?>">
            <?php
            /* translators: %s: CMS name, i.e. WordPress. */
            printf( esc_html__( 'Proudly powered by %s', 'warm_day' ), 'WordPress' );
            ?>
        </a>
        <span class="sep"> | </span>
            <?php
            /* translators: 1: Theme name, 2: Theme author. */
            printf( esc_html__( 'Theme: %1$s by %2$s.', 'warm_day' ), 'warm_day', '<a href="https://your-startup.space/">Your Startup</a>' );
            ?>
    </div><!-- .site-info -->
</footer><!-- #colophon -->