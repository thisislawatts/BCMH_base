<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package BCMH_base
 * @since BCMH_base 1.0
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @since BCMH_base 1.0
 */
function BCMH_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'BCMH_page_menu_args' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @since BCMH_base 1.0
 */
function BCMH_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'BCMH_body_classes' );

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 *
 * @since BCMH_base 1.0
 */
function BCMH_enhanced_image_navigation( $url, $id ) {
	if ( ! is_attachment() && ! wp_attachment_is_image( $id ) )
		return $url;

	$image = get_post( $id );
	if ( ! empty( $image->post_parent ) && $image->post_parent != $id )
		$url .= '#main';

	return $url;
}
add_filter( 'attachment_link', 'BCMH_enhanced_image_navigation', 10, 2 );



/**
 * Login Page
 * 
 * Customisations to the login page
 * 
 * @since BCMH_base 1.2
 */

function bcmh_login_url() {
	return "http://bcmh.co.uk/";
}
add_filter( 'login_headerurl', 'bcmh_login_url' );


function bcmh_login_styles() {
	wp_enqueue_style( 'login_css', get_template_directory_uri() . "/inc/admin/css/login.css" );
}
add_filter( 'login_head', 'bcmh_login_styles' );


/* 		Admin Page */
function bcmh_admin_footer() {
	echo '&copy; ' . date("Y") . ' <a href="http://bcmh.co.uk">BCMH</a>';
}
add_filter( 'admin_footer_text', 'bcmh_admin_footer' );



/*
 * Typekit scripts
 *
 * @since BCMH_base 1.2
 */
 function bcmh_print_typekit( $typekit_id ) { ?>
	<script src="//use.typekit.net/<?php echo $typekit_id; ?>.js"></script>
    <script>try{Typekit.load();}catch(e){}</script>
	<?php 
}