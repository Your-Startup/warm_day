<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Тёплый_день
 */

?>

	<?php include_once get_template_directory() . '/template-parts/components/footer.php' ?>
</div><!-- #page -->

<?php include_once get_template_directory() . '/template-parts/components/popups.php' ?>
<?php include_once get_template_directory() . '/template-parts/components/snow.php' ?>
<?php wp_footer(); ?>

</body>
</html>
