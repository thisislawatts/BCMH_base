<?php
/**
 * BCMH_base Theme Options
 *
 * @package BCMH_base
 * @since BCMH_base 1.0
 */

/**
 * Register the form setting for our BCMH_options array.
 *
 * This function is attached to the admin_init action hook.
 *
 * This call to register_setting() registers a validation callback, BCMH_theme_options_validate(),
 * which is used when the option is saved, to ensure that our option values are properly
 * formatted, and safe.
 *
 * @since BCMH_base 1.0
 */
function BCMH_theme_options_init() {
	register_setting(
		'BCMH_options', // Options group, see settings_fields() call in BCMH_theme_options_render_page()
		'BCMH_theme_options', // Database option, see BCMH_get_theme_options()
		'BCMH_theme_options_validate' // The sanitization callback, see BCMH_theme_options_validate()
	);

	// Register our settings field group
	add_settings_section(
		'general', // Unique identifier for the settings section
		'General', // Section title (we don't want one)
		'__return_false', // Section callback (we don't want anything)
		'theme_options' // Menu slug, used to uniquely identify the page; see BCMH_theme_options_add_page()
	);

	add_settings_section(
		'vcard',
		'vCard',
		'__return_false',
		'theme_options'
	);

	// Register our individual settings fields
	add_settings_field(
		'hidden_checkbox', // Unique identifier for the field for this section
		__( 'Hide Site', 'BCMH' ), // Setting field label
		'BCMH_settings_field_hidden_checkbox', // Function that renders the settings field
		'theme_options', // Menu slug, used to uniquely identify the page; see BCMH_theme_options_add_page()
		'general' // Settings section. Same as the first argument in the add_settings_section() above
	);

	add_settings_field(
		'styleguide_checkbox',
		__( 'Link through to Styleguide', 'BCMH' ),
		'BCMH_settings_field_checkbox',
		'theme_options',
		'general',
		array(
			'label_for' => 'styleguide_checkbox'
	) );

	// vCard Settings
	add_settings_field( 'street_address', __( 'Street Address', 'BCMH' ), 'BCMH_settings_text_input', 'theme_options', 'vcard', array( 'label_for' => 'street_address' ) );
	add_settings_field( 'address_locality', __( 'City/Town', 'BCMH' ), 'BCMH_settings_text_input', 'theme_options', 'vcard', array( 'label_for' => 'address_locality' ) );
	add_settings_field( 'address_region', __( 'County/Region', 'BCMH' ), 'BCMH_settings_text_input', 'theme_options', 'vcard', array( 'label_for' => 'address_region' ) );
	add_settings_field( 'address_country', __( 'Country', 'BCMH' ), 'BCMH_settings_text_input', 'theme_options', 'vcard', array( 'label_for' => 'address_country' ) );
	add_settings_field( 'postal_code', __( 'Postal Code', 'BCMH' ), 'BCMH_settings_text_input', 'theme_options', 'vcard', array( 'label_for' => 'postal_code' ) );

	add_settings_field( 'telephone', __( 'Telephone', 'BCMH' ), 'BCMH_settings_text_input', 'theme_options', 'vcard', array( 'label_for' => 'telephone' ) );
	add_settings_field( 'email', __( 'Email', 'BCMH' ), 'BCMH_settings_text_input', 'theme_options', 'vcard', array( 'label_for' => 'email' ) );
	add_settings_field( 'url', __( 'URL', 'BCMH' ), 'BCMH_settings_text_input', 'theme_options', 'vcard', array( 'label_for' => 'url' ) );

	// Samples
	// add_settings_field(
	// 	'sample_checkbox', // Unique identifier for the field for this section
	// 	__( 'Sample Checkbox', 'BCMH' ), // Setting field label
	// 	'BCMH_settings_field_sample_checkbox', // Function that renders the settings field
	// 	'theme_options', // Menu slug, used to uniquely identify the page; see BCMH_theme_options_add_page()
	// 	'general' // Settings section. Same as the first argument in the add_settings_section() above
	// );

	// add_settings_field( 'sample_text_input', __( 'Sample Text Input', 'BCMH' ), 'BCMH_settings_field_sample_text_input', 'theme_options', 'general' );
	// add_settings_field( 'sample_select_options', __( 'Sample Select Options', 'BCMH' ), 'BCMH_settings_field_sample_select_options', 'theme_options', 'general' );
	// add_settings_field( 'sample_radio_buttons', __( 'Sample Radio Buttons', 'BCMH' ), 'BCMH_settings_field_sample_radio_buttons', 'theme_options', 'general' );
	// add_settings_field( 'sample_textarea', __( 'Sample Textarea', 'BCMH' ), 'BCMH_settings_field_sample_textarea', 'theme_options', 'general' );
}
add_action( 'admin_init', 'BCMH_theme_options_init' );

/**
 * Change the capability required to save the 'BCMH_options' options group.
 *
 * @see BCMH_theme_options_init() First parameter to register_setting() is the name of the options group.
 * @see BCMH_theme_options_add_page() The edit_theme_options capability is used for viewing the page.
 *
 * @param string $capability The capability used for the page, which is manage_options by default.
 * @return string The capability to actually use.
 */
function BCMH_option_page_capability( $capability ) {
	return 'edit_theme_options';
}
add_filter( 'option_page_capability_BCMH_options', 'BCMH_option_page_capability' );

/**
 * Add our theme options page to the admin menu.
 *
 * This function is attached to the admin_menu action hook.
 *
 * @since BCMH_base 1.0
 */
function BCMH_theme_options_add_page() {
	$theme_page = add_theme_page(
		__( 'Settings', 'BCMH' ),   // Name of page
		__( 'Settings', 'BCMH' ),   // Label in menu
		'edit_theme_options',          // Capability required
		'theme_options',               // Menu slug, used to uniquely identify the page
		'BCMH_theme_options_render_page' // Function that renders the options page
	);
}
add_action( 'admin_menu', 'BCMH_theme_options_add_page' );

/**
 * Prints out our textfield
 * 
 * @since BCMH_base 1.2
 */
function BCMH_settings_text_input( $params = array() ) {
	$options = BCMH_get_theme_options();
	?>
	<input type="text" name="BCMH_theme_options[<?php echo $params['label_for'] ?>]" id="<?php echo $params['label_for'] ?>" value="<?php echo $options[$params['label_for']] ?>">
	<?php 
}

/**
 * Prints out our checkbox
 * 
 * @since BCMH_base 1.2
 */
function BCMH_settings_field_checkbox( $params = array() ) {
	$options = BCMH_get_theme_options();
	?>
	<label for="<?php echo $params['label_for']; ?>">
	<input type="checkbox" name="BCMH_theme_options[<?php echo $params['label_for'] ?>]" id="hide-site" <?php checked( 'on', $options[$params['label_for']] ); ?> />
	<?php _e( $params['description'], 'BCMH' ); ?>
	</label>
	<?php 
}

/**
 * Returns an array of sample select options registered for BCMH_base.
 *
 * @since BCMH_base 1.0
 */
function BCMH_sample_select_options() {
	$sample_select_options = array(
		'0' => array(
			'value' =>	'0',
			'label' => __( 'Zero', 'BCMH' )
		),
		'1' => array(
			'value' =>	'1',
			'label' => __( 'One', 'BCMH' )
		),
		'2' => array(
			'value' => '2',
			'label' => __( 'Two', 'BCMH' )
		),
		'3' => array(
			'value' => '3',
			'label' => __( 'Three', 'BCMH' )
		),
		'4' => array(
			'value' => '4',
			'label' => __( 'Four', 'BCMH' )
		),
		'5' => array(
			'value' => '5',
			'label' => __( 'Five', 'BCMH' )
		)
	);

	return apply_filters( 'BCMH_sample_select_options', $sample_select_options );
}

/**
 * Returns an array of sample radio options registered for BCMH_base.
 *
 * @since BCMH_base 1.0
 */
function BCMH_sample_radio_buttons() {
	$sample_radio_buttons = array(
		'yes' => array(
			'value' => 'yes',
			'label' => __( 'Yes', 'BCMH' )
		),
		'no' => array(
			'value' => 'no',
			'label' => __( 'No', 'BCMH' )
		),
		'maybe' => array(
			'value' => 'maybe',
			'label' => __( 'Maybe', 'BCMH' )
		)
	);

	return apply_filters( 'BCMH_sample_radio_buttons', $sample_radio_buttons );
}

/**
 * Returns the options array for BCMH_base.
 *
 * @since BCMH_base 1.0
 */
function BCMH_get_theme_options() {
	$saved = (array) get_option( 'BCMH_theme_options' );

	$defaults = array(
		'hidden_checkbox'		=> 'off',
		'sample_checkbox'       => 'off',
		'sample_text_input'     => '',
		'sample_select_options' => '',
		'sample_radio_buttons'  => '',
		'sample_textarea'       => '',
	);

	$defaults = apply_filters( 'BCMH_default_theme_options', $defaults );

	$options = wp_parse_args( $saved, $defaults );

	//$options = array_intersect_key( $options, $defaults );

	return $options;
}

/**
 * Renders the 'hide-site' checkbox setting field.
 */
function BCMH_settings_field_hidden_checkbox() {
	$options = BCMH_get_theme_options();

	?>
	<label for="hide-site">
		<input type="checkbox" name="BCMH_theme_options[hidden_checkbox]" id="hide-site" <?php checked( 'on', $options['hidden_checkbox'] ); ?> />
		<?php _e( 'Prevent logged out users from accessing the site.', 'BCMH' ); ?>
	</label>
	<?php
}

/**
 * Renders the sample checkbox setting field.
 */
function BCMH_settings_field_sample_checkbox() {
	$options = BCMH_get_theme_options();

	?>
	<label for="sample-checkbox">
		<input type="checkbox" name="BCMH_theme_options[sample_checkbox]" id="sample-checkbox" <?php checked( 'on', $options['sample_checkbox'] ); ?> />
		<?php _e( 'A sample checkbox.', 'BCMH' ); ?>
	</label>
	<?php
}

/**
 * Renders the sample text input setting field.
 */
function BCMH_settings_field_sample_text_input() {
	$options = BCMH_get_theme_options();

	?>
	<input type="text" name="BCMH_theme_options[sample_text_input]" id="sample-text-input" value="<?php echo esc_attr( $options['sample_text_input'] ); ?>" />
	<label class="description" for="sample-text-input"><?php _e( 'Sample text input', 'BCMH' ); ?></label>
	<?php
}

/**
 * Renders the sample select options setting field.
 */
function BCMH_settings_field_sample_select_options() {
	$options = BCMH_get_theme_options();
	?>
	<select name="BCMH_theme_options[sample_select_options]" id="sample-select-options">
		<?php
			$selected = $options['sample_select_options'];
			$p = '';
			$r = '';

			foreach ( BCMH_sample_select_options() as $option ) {
				$label = $option['label'];
				if ( $selected == $option['value'] ) // Make default first in list
					$p = "\n\t<option style=\"padding-right: 10px;\" selected='selected' value='" . esc_attr( $option['value'] ) . "'>$label</option>";
				else
					$r .= "\n\t<option style=\"padding-right: 10px;\" value='" . esc_attr( $option['value'] ) . "'>$label</option>";
			}
			echo $p . $r;
		?>
	</select>
	<label class="description" for="sample_theme_options[selectinput]"><?php _e( 'Sample select input', 'BCMH' ); ?></label>
	<?php
}

/**
 * Renders the radio options setting field.
 *
 * @since BCMH_base 1.0
 */
function BCMH_settings_field_sample_radio_buttons() {
	$options = BCMH_get_theme_options();

	foreach ( BCMH_sample_radio_buttons() as $button ) {
	?>
	<div class="layout">
		<label class="description">
			<input type="radio" name="BCMH_theme_options[sample_radio_buttons]" value="<?php echo esc_attr( $button['value'] ); ?>" <?php checked( $options['sample_radio_buttons'], $button['value'] ); ?> />
			<?php echo $button['label']; ?>
		</label>
	</div>
	<?php
	}
}

/**
 * Renders the sample textarea setting field.
 */
function BCMH_settings_field_sample_textarea() {
	$options = BCMH_get_theme_options();
	?>
	<textarea class="large-text" type="text" name="BCMH_theme_options[sample_textarea]" id="sample-textarea" cols="50" rows="10" /><?php echo esc_textarea( $options['sample_textarea'] ); ?></textarea>
	<label class="description" for="sample-textarea"><?php _e( 'Sample textarea', 'BCMH' ); ?></label>
	<?php
}

function bcmh_admin_tabs() {
	return false;
	$tabs = array(
		'general' => 'General',
		'vcard'	  => 'vCard'
	);

	echo '<h2 class="nav-tab-wrapper">';
	foreach ( $tabs as $tab => $name ) {
		$class = $tab == $current ? ' nav-tab-active' : '';
		echo "<a class='nav-tab$class' href='?page=theme_options&tab=$tab'>$name</a>";
	}
	echo '</h2>';

}

/**
 * Renders the Theme Options administration screen.
 *
 * @since BCMH_base 1.0
 */
function BCMH_theme_options_render_page() {
	?>
	<div class="wrap">
		<?php screen_icon(); ?>
		<?php $theme_name = function_exists( 'wp_get_theme' ) ? wp_get_theme() : get_current_theme(); ?>
		<h2><?php printf( __( '%s Options', 'BCMH' ), $theme_name ); ?></h2>
		
		<?php settings_errors(); ?>
		<?php bcmh_admin_tabs(); ?>
		
		<form method="post" action="options.php">
			<?php
				settings_fields( 'BCMH_options' );
				do_settings_sections( 'theme_options' );
				submit_button();
			?>
		</form>
	</div>
	<?php
}

/**
 * Sanitize and validate form input. Accepts an array, return a sanitized array.
 *
 * @see BCMH_theme_options_init()
 * @todo set up Reset Options action
 *
 * @param array $input Unknown values.
 * @return array Sanitized theme options ready to be stored in the database.
 *
 * @since BCMH_base 1.0
 */
function BCMH_theme_options_validate( $input ) {
	$output = array();

	$text_field_inputs = array(
		'street_address',
		'address_locality',
		'address_region',
		'address_country',
		'postal_code',
		'telephone',
		'email',
		'url'
	);

	foreach ( $input as $key => $value ) {

		// If checkboxes are present then they're set to 'on'
		if ( preg_match( '/checkbox/', $key) )
			$output[$key] = 'on';

		if ( in_array( $key, $text_field_inputs ) && isset( $value ) && ! empty( $value ) ) 
			$output[$key] = $value;
	}


	// The sample text input must be safe text with no HTML tags
	if ( isset( $input['sample_text_input'] ) && ! empty( $input['sample_text_input'] ) )
		$output['sample_text_input'] = wp_filter_nohtml_kses( $input['sample_text_input'] );

	// The sample select option must actually be in the array of select options
	if ( isset( $input['sample_select_options'] ) && array_key_exists( $input['sample_select_options'], BCMH_sample_select_options() ) )
		$output['sample_select_options'] = $input['sample_select_options'];

	// The sample radio button value must be in our array of radio button values
	if ( isset( $input['sample_radio_buttons'] ) && array_key_exists( $input['sample_radio_buttons'], BCMH_sample_radio_buttons() ) )
		$output['sample_radio_buttons'] = $input['sample_radio_buttons'];

	// The sample textarea must be safe text with the allowed tags for posts
	if ( isset( $input['sample_textarea'] ) && ! empty( $input['sample_textarea'] ) )
		$output['sample_textarea'] = wp_filter_post_kses( $input['sample_textarea'] );

	return apply_filters( 'BCMH_theme_options_validate', $output, $input );
}

add_action( 'init', 'bcmh_hidden_checkbox' );

/**
 * Redirect site to static site during development/downtime
 * 
 * @return false
 * 
 * @since BCMH_base 1.1
 */
if ( !function_exists('bcmh_hidden_checkbox') ) {

	function bcmh_hidden_checkbox() {
	$options = BCMH_get_theme_options();
	
	$login = in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));

	if ( "on" == $options['hidden_checkbox'] && !is_user_logged_in() && !$login ) {
		require get_template_directory() . "/inc/static/site-hidden.php";
		
		die();
	}
}
}