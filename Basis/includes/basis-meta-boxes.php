<?php
################################################################################
/*
Meta Boxes:

I prefer to use the excellent Meta Boxes plugin (http://wordpress.org/plugins/meta-box/) by Rilwis to create custom meta boxes and custom fields. Everything currently in this file merely serves as a brief demo with some commonly used field types. Nothing here will work unless the Meta Box plugin is installed.

If you prefer to use another method to create your custom fields and meta boxes, simply delete all of the current code in this f le and replace it with your own. If you do not need custom fields and meta boxes, you may remove ths file entirely, but be sure to also remove the reference to it in functions.php.
*/
################################################################################

/**
 * Registering meta boxes
 *
 * You also should read the changelog to know what has been changed before updating.
 *
 * For more information, please visit: 
 * @link http://www.deluxeblogtips.com/2010/04/how-to-create-meta-box-wordpress-post.html
 */

/********************* META BOX DEFINITIONS ***********************/

/**
 * Prefix of meta keys (optional)
 * Use underscore (_) at the beginning to make keys hidden
 * Alt.: You also can make prefix empty to disable it
 */
$prefix = 'basis_';

global $meta_boxes;

$meta_boxes = array();

// Post box
$meta_boxes[] = array(
	'id'		=> 'postinfo',
	'title'		=> 'Meta Box',
	'pages'		=> array( 'post'),

	'fields'	=> array(
		// Text
		array(
			'name'  => __( 'Text', 'rwmb' ),
			'id'    => "{$prefix}text",
			'desc'  => __( 'Text description', 'rwmb' ),
			'type'  => 'text',
			'std'   => __( 'Default text value', 'rwmb' ),
			'clone' => true,
		),
		// CHECKBOX
		array(
			'name' => __( 'Checkbox', 'rwmb' ),
			'id'   => "{$prefix}checkbox",
			'type' => 'checkbox',
			// Value can be 0 or 1
			'std'  => 1,
		),
		// RADIO BUTTONS
		array(
			'name'    => __( 'Radio', 'rwmb' ),
			'id'      => "{$prefix}radio",
			'type'    => 'radio',
			// Array of 'value' => 'Label' pairs for radio options.
			// Note: the 'value' is stored in meta field, not the 'Label'
			'options' => array(
				'value1' => __( 'Label1', 'rwmb' ),
				'value2' => __( 'Label2', 'rwmb' ),
			),
		),
		// SELECT BOX
		array(
			'name'     => __( 'Select', 'rwmb' ),
			'id'       => "{$prefix}select",
			'type'     => 'select',
			// Array of 'value' => 'Label' pairs for select box
			'options'  => array(
				'value1' => __( 'Label1', 'rwmb' ),
				'value2' => __( 'Label2', 'rwmb' ),
			),
			// Select multiple values, optional. Default is false.
			'multiple' => false,
			'std'	=> __( 'Select an Item', 'rwmb' ),
		),
		// TEXTAREA
		array(
			'name' => __( 'Textarea', 'rwmb' ),
			'desc' => __( 'Textarea description', 'rwmb' ),
			'id'   => "{$prefix}textarea",
			'type' => 'textarea',
			'cols' => 20,
			'rows' => 3,
		),
	)
);

//2nd Post box
$meta_boxes[] = array(
	'id'		=> 'pageinfo',
	'title'		=> 'Meta Box',
	'pages'		=> array( 'page'),

	'fields'	=> array(
		// DATE
				array(
					'name' => __( 'Date picker', 'rwmb' ),
					'id'   => "{$prefix}date",
					'type' => 'date',
		
					// jQuery date picker options. See here http://api.jqueryui.com/datepicker
					'js_options' => array(
						'appendText'      => __( '(yyyy-mm-dd)', 'rwmb' ),
						'dateFormat'      => __( 'yy-mm-dd', 'rwmb' ),
						'changeMonth'     => true,
						'changeYear'      => true,
						'showButtonPanel' => true,
					),
				),
		// WYSIWYG/RICH TEXT EDITOR
		array(
			'name' => __( 'WYSIWYG / Rich Text Editor', 'rwmb' ),
			'id'   => "{$prefix}wysiwyg",
			'type' => 'wysiwyg',
			// Set the 'raw' parameter to TRUE to prevent data being passed through wpautop() on save
			'raw'  => false,
			'std'  => __( 'WYSIWYG default value', 'rwmb' ),

			// Editor settings, see wp_editor() function: look4wp.com/wp_editor
			'options' => array(
				'textarea_rows' => 4,
				'teeny'         => true,
				'media_buttons' => false,
			),
		),
	)
);

/********************* META BOX REGISTERING ***********************/

/**
 * Register meta boxes
 *
 * @return void
 */
function basis_register_meta_boxes()
{
	global $meta_boxes;

	// Make sure there's no errors when the plugin is deactivated or during upgrade
	if ( class_exists( 'RW_Meta_Box' ) )
	{
		foreach ( $meta_boxes as $meta_box )
		{
			new RW_Meta_Box( $meta_box );
		}
	}
}
// Hook to 'admin_init' to make sure the meta box class is loaded
//  before (in case using the meta box class in another plugin)
// This is also helpful for some conditionals like checking page template, categories, etc.
add_action( 'admin_init', 'basis_register_meta_boxes' );