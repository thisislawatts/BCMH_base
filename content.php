<?php
/**
 * @package BCMH_base
 * @since BCMH_base 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="titling"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'BCMH' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php BCMH_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'BCMH' ) ); ?>
	<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'BCMH' ), 'after' => '</div>' ) ); ?>

	<footer class="entry-meta">
		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( __( ', ', 'BCMH' ) );
				if ( $categories_list && BCMH_categorized_blog() ) :
			?>
			<span class="cat-links">
				<?php printf( __( 'Posted in %1$s', 'BCMH' ), $categories_list ); ?>
			</span>
			<?php endif; // End if categories ?>

			<?php
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', __( ', ', 'BCMH' ) );
				if ( $tags_list ) :
			?>
			<span class="sep"> | </span>
			<span class="tag-links">
				<?php printf( __( 'Tagged %1$s', 'BCMH' ), $tags_list ); ?>
			</span>
			<?php endif; // End if $tags_list ?>
		<?php endif; // End if 'post' == get_post_type() ?>

		<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
		<span class="sep"> | </span>
		<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'BCMH' ), __( '1 Comment', 'BCMH' ), __( '% Comments', 'BCMH' ) ); ?></span>
		<?php endif; ?>

		<?php edit_post_link( __( 'Edit', 'BCMH' ), '<span class="sep"> | </span><span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->
