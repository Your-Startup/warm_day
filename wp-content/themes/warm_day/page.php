<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Тёплый_день
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php
			
			$template_part = get_template_part( 'template-parts/pages/content', $post->post_name );

			if ($template_part === false) {
				get_template_part( 'template-parts/pages/content', 'default' );
			}
		?>

	</main><!-- #main -->

<?php
get_footer();
