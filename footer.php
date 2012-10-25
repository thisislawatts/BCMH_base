<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package BCMH_base
 * @since BCMH_base 1.0
 */
?>

	</div><!-- #main .site-main.wrap -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<?php do_action( 'BCMH_credits' ); ?>
			<?php printf( __( 'Theme: %1$s by %2$s.', 'BCMH' ), 'BCMH', '<a href="http://bcmh.co.uk/" rel="designer">BCMH</a>' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon .site-footer -->
</div><!-- #page .hfeed .site -->

<?php wp_footer(); ?>

</body>
</html>