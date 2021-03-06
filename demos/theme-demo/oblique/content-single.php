<?php
/**
 * @package Oblique
 */
?>
	
<div class="svg-container single-post-svg svg-block">
	<?php oblique_svg_1(); ?>
</div>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-meta">
			<?php oblique_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="single-thumb">
			<?php the_post_thumbnail('oblique-single-thumb'); ?>
		</div>	
	<?php endif; ?>		

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'oblique' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php oblique_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
<div class="svg-container single-post-svg single-svg-bottom svg-block">
	<?php oblique_svg_4(); ?>
</div>