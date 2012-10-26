<?php
/**
 * @package BCMH_base
 * @since BCMH_base 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( "post" ); ?>>
	<header class="entry-header">
		<h1 class="titling"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->

	<?php the_content(); ?>
	<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'BCMH' ), 'after' => '</div>' ) ); ?>

	<?php edit_post_link( __( 'Edit', 'BCMH' ), '<span class="edit-link">', '</span>' ); ?>
</article><!-- #post-<?php the_ID(); ?> -->
