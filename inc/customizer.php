<?php

defined( 'ABSPATH' ) || exit;

/**
 * Implement Theme Customizer additions and adjustments.
 * https://codex.wordpress.org/Theme_Customization_API
 *
 * How do I "output" custom theme modification settings? https://developer.wordpress.org/reference/functions/get_theme_mod
 * echo get_theme_mod( 'copyright_info' );
 * or: echo get_theme_mod( 'copyright_info', 'Default (c) Copyright Info if nothing provided' );
 *
 * "sanitize_callback": https://codex.wordpress.org/Data_Validation
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 *
 * @return void
 */
function experimental_bootstrap_theme_customize( $wp_customize ) {
	/**
	 * Initialize sections
	 */
	$wp_customize->add_section(
		'theme_header_section',
		array(
			'title'    => __( 'Header', 'experimental-bootstrap-theme' ),
			'priority' => 1000,
		)
	);

	/**
	 * Section: Page Layout
	 */
	// Header Logo.
	$wp_customize->add_setting(
		'header_logo',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'header_logo',
			array(
				'label'       => __( 'Upload Header Logo', 'experimental-bootstrap-theme' ),
				'description' => __( 'Height: &gt;80px', 'experimental-bootstrap-theme' ),
				'section'     => 'theme_header_section',
			)
		)
	);

	// Predefined Navbar scheme.
	$wp_customize->add_setting(
		'navbar_scheme',
		array(
			'default'           => 'default',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'navbar_scheme',
		array(
			'type'    => 'radio',
			'label'   => __( 'Navbar Scheme', 'experimental-bootstrap-theme' ),
			'section' => 'theme_header_section',
			'choices' => array(
				'navbar-light bg-light'  => __( 'Default', 'experimental-bootstrap-theme' ),
				'navbar-dark bg-dark'    => __( 'Dark', 'experimental-bootstrap-theme' ),
				'navbar-dark bg-primary' => __( 'Primary', 'experimental-bootstrap-theme' ),
			),
		)
	);

	// Fixed Header?
	$wp_customize->add_setting(
		'navbar_position',
		array(
			'default'           => 'static',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'navbar_position',
		array(
			'type'    => 'radio',
			'label'   => __( 'Navbar', 'experimental-bootstrap-theme' ),
			'section' => 'theme_header_section',
			'choices' => array(
				'static'       => __( 'Static', 'experimental-bootstrap-theme' ),
				'fixed_top'    => __( 'Fixed to top', 'experimental-bootstrap-theme' ),
				'fixed_bottom' => __( 'Fixed to bottom', 'experimental-bootstrap-theme' ),
			),
		)
	);

	// Search?
	$wp_customize->add_setting(
		'search_enabled',
		array(
			'default'           => '1',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'search_enabled',
		array(
			'type'    => 'checkbox',
			'label'   => __( 'Show Searchfield?', 'experimental-bootstrap-theme' ),
			'section' => 'theme_header_section',
		)
	);
}
add_action( 'customize_register', 'experimental_bootstrap_theme_customize' );

/**
 * Bind JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @return void
 */
function experimental_bootstrap_theme_customize_preview_js() {
	wp_enqueue_script( 'customizer', get_template_directory_uri() . '/inc/customizer.js', array( 'jquery' ), null, true );
}
add_action( 'customize_preview_init', 'experimental_bootstrap_theme_customize_preview_js' );
