<?php

class BCMH_base {

	public $typekit_id;

	function __construct() {
		add_action( 'wp_footer', array( &$this, 'print_typekit' ) );
	}

	// If the Typekit has been declared in the Theme then add it into our site.
	public function print_typekit() {

		if ( !isset( $this->typekit_id ) ) return false; ?>

		<script src="//use.typekit.net/<?php echo $this->typekit_id; ?>.js"></script>
	    <script>try{Typekit.load();}catch(e){}</script>

		<?php 
	}
}

