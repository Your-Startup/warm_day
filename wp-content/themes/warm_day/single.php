<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Тёплый_день
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php
			$template_part = get_template_part( 'template-parts/posts/content', $post->post_type );

			if ($template_part === false) {
				get_template_part( 'template-parts/posts/content', 'default' );
			}
		?>

	</main><!-- #main -->

<?php
get_footer();
