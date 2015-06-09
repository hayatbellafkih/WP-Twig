<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Oblique
 */
?>

		</div>
	</div><!-- #content -->

	<div class="svg-container footer-svg svg-block">
		<?php oblique_svg_1(); ?>
	</div>
	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info container">
			<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'oblique' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'oblique' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( __( 'Theme: %2$s by %1$s.', 'oblique' ), 'FlyFreeMedia', '<a href="http://flyfreemedia.com/themes/oblique" rel="designer">Oblique</a>' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
