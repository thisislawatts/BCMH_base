<?php 
/**
 * BCMH Responsive Images
 *
 * Adds the 
 * @package BCMH_bcmh
 * @since BCMH Theme 1.0
 */

add_action('init', 'bcmh_image_sizes');

function bcmh_image_sizes() {
    add_image_size( 'small', 500, 9999, false );
    add_image_size( 'medium', 800, 9999, false );
    add_image_size( 'large', 1024, 9999, false );
    add_image_size( 'extra-large', 1400, 9999, false );
}

add_filter('upload_mimes', 'custom_upload_mimes');

function custom_upload_mimes ( $existing_mimes=array() ) {
    // add the file extension to the array
    $existing_mimes['svg'] = 'image/svg+xml';
   return $existing_mimes;
}

add_action( 'wp_enqueue_scripts', 'bcmh_enqueue_picture' );

function bcmh_enqueue_picture() {

 // Check files exist
 if ( !file_exists( get_template_directory() . '/js/libs/picturefill.js') ) {

 	throw new Exception("Error Loading Dependency Picturefill", 1);
 	exit();
 } else {
	wp_enqueue_script( 'picturefill', get_template_directory_uri() . '/js/libs/picturefill.js', false, 0, true ); 	
 }
}



function orderImagesByWidth($a, $b) {
    if ( $a['width'] == $b['width'] ) {
        return 0;
    }

    return ($a['width'] < $b['width']) ? -1 : 1;
}

function get_image_ratio( $width, $height ) {
	return $width > $height ? $width / $height : $height / $width;
}

function bcmh_picture_element( $image_id ) { 

		$sizes_as_ems = array(
			'medium'	 => '',
			'tablet' 	 => '45em',
			'large-plus' => '64em',
			'original' 	 => '10em'
		);

		$image_meta = wp_get_attachment_metadata( $image_id );
		$upload_dir = wp_upload_dir();

		$image_ratio = get_image_ratio($image_meta['width'], $image_meta['height']);

		$sorted = array();
		$image_sizes = array(
			'original' => $upload_dir['baseurl'] . '/' . $image_meta['file']
		);

		// Only if there are multiple image sizes for this image
		if ( is_array( $image_meta['sizes'] ) ) {

			uasort( $image_meta['sizes'], 'orderImagesByWidth');

			var_dump($image_meta['sizes']);

			$image_upload_dir = substr($image_meta['file'], 0, strrpos( $image_meta['file'], '/' ) + 1 );
			
			foreach ( $image_meta['sizes'] as $size => $filename ) {
				if ( "thumbnail" != $size ) {
					$image_sizes[$size] = $upload_dir['baseurl'] . '/' . $image_upload_dir . $filename['file'];
				}
			}
		} ?>

 	<div data-picture width="<?php echo $image_meta['width']; ?>" height="<?php echo $image_meta['height']; ?>" class="figure-image">
		<?php 

		$iterator = 0;
		$image_sources = array_values( $image_sizes );

		if ( count( $image_sizes ) > 1 ) : ?>

			<?php foreach ( $image_sizes as $size => $image_url ) {

				if ( !is_null( $sizes_as_ems[ $size ] ) ) {
				
				 $x2 = $image_sources[$iterator + 1] ? $image_sources[$iterator + 1] : $image_url;

					if ( "" == $sizes_as_ems[$size] ) {
						echo '<div data-aspect-ratio="' . $image_ratio . '" data-id="' . $image_id . '" data-src="' . $image_url . '"></div>'. "\n";
					} else {
						echo '<div data-aspect-ratio="' . $image_ratio . '" data-id="' . $image_id . '" data-src="' . $image_url . '" data-media="(min-width: ' . $sizes_as_ems[$size] . ')" data-size="'.$size.'"></div>' . "\n";
					}
				}

				$iterator++;
			} ?>

		<?php else : ?>
			<div data-id="<?php echo $image_id; ?>" data-src="<?php echo array_pop( $image_sizes ); ?>"></div>
		<?php endif; ?>
		<noscript><?php echo wp_get_attachment_image( $image_id, 'large' ); ?></noscript>
	</div><!--  -->
	<?php
}