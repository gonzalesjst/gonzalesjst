<?php
/**
 * Customizer options.
 */
use Lito\Lito_Fonts;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

require_once get_template_directory() . '/inc/customizer-custom-controls/font/class-font-control.php';

add_action( 'customize_controls_enqueue_scripts', 'lito_customizer_controls_js' );
/**
 * Include scripts for customizer controls sidebar
 * 
 * @since 1.0
 */
function lito_customizer_controls_js(){
	$lito_fonts = new Lito_Fonts();
	wp_enqueue_script( 'lito-customizer-controls', get_template_directory_uri() . '/assets/js/customizer-controls.js', [ 'jquery', 'customize-preview' ], null, true );
	wp_enqueue_script( 'lito-jquery-blockUI', get_template_directory_uri() . '/assets/js/jquery.blockUI.js', [ 'jquery', 'customize-preview' ], null, true );
	wp_enqueue_script( 'lito-select2', get_template_directory_uri() . '/assets/js/select2.min.js', [ 'jquery', 'customize-preview' ], null, true );
	wp_enqueue_script( 'lito-jquery-ui', get_template_directory_uri() . '/assets/js/jquery-ui.min.js', [ 'jquery', 'customize-preview' ], null, true );
	
	wp_enqueue_style( 'lito-select2-css', get_template_directory_uri() . '/assets/css/select2.min.css', array(), null );
	wp_enqueue_style( 'lito-jquery-ui-css', get_template_directory_uri() . '/assets/css/jquery-ui.css', array(), null );
	wp_enqueue_style( 'lito-customizer-css', get_template_directory_uri() . '/assets/css/customizer.css', array(), null );

	wp_localize_script( 'lito-customizer-controls', 'litoCustomizer',
		array(
			'url' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('lito_nonce'),
			'googlefonts' => $lito_fonts->get_all_google_fonts(),
			'defaultArchiveURL' => get_post_type_archive_link('post'),
			'defaultSinglePostURL' => get_permalink( 
				get_posts( 
					array(
						'posts_per_page' => 1,
						'orderby' => 'date',
						'order' => 'DESC',
						'post_type' => 'post',
						'post_status' => 'publish',
						'ignore_sticky_posts' => true,
					) 
				)[0] 
			),
			'defaultSinglePageURL' => get_permalink( 
				get_posts( 
					array(
						'posts_per_page' => 1,
						'orderby' => 'date',
						'order' => 'DESC',
						'post_type' => 'page',
						'post_status' => 'publish',
						'ignore_sticky_posts' => true,
					) 
				)[0] 
			),
		)
	);
	wp_enqueue_editor();
}

add_action( 'customize_preview_init', 'lito_customizer_preview_js' );
/**
 * Include scripts for customizer preview
 * 
 * @since 1.0
 */
function lito_customizer_preview_js(){
	wp_enqueue_script( 'lito-customizer-preview', get_template_directory_uri() . '/assets/js/customizer-preview.js', [ 'jquery', 'customize-preview' ], null, true );
}

add_action( 'customize_register', 'lito_customizer_init' );
/**
 * Customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @since 1.0
 */
function lito_customizer_init(WP_Customize_Manager $wp_customize) {
	$defaults = lito_get_defaults();

    $panel = 'lito_header_panel';

	if ( ! $wp_customize->get_panel( $panel ) ) {
		
		$wp_customize->add_panel(
			$panel,
			array(
				'priority' => 21,
				'title' => __( 'Header', 'lito' ),
			)
		);
	}

	if ($section = 'lito_header_options' ){

		$wp_customize->add_section( 
			$section,
			array (
				'title'    => __('Header options', 'lito'),
				'priority' => 1,
				'panel' => $panel,
			) 
		);

		$setting = 'header_type';

		$wp_customize->add_setting( 
			"lito_options[$setting]", 
			array (
				'type'     => 'theme_mod',
				'default'     => $defaults[$setting],
				'transport'   => 'postMessage',
				'sanitize_callback' => 'sanitize_key'
			)
		);

		$wp_customize->add_control(
			$setting, 
			array (
				'type' => 'radio',
				'label'    => __('Site header type', 'lito'),
				'section'  => $section,
				'settings' => "lito_options[$setting]",
				'choices' => array(
					'header_1' => __('Header 1', 'lito'),
					'header_2' => __('Header 2', 'lito'),
				),
			)
		);

		$setting = 'header_layout';

		$wp_customize->add_setting( 
			"lito_options[$setting]", 
			array (
				'type'     => 'theme_mod',
				'default'     => $defaults[$setting],
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_key'
			)
		);

		$wp_customize->add_control(
			$setting, 
			array (
				'type' => 'radio',
				'label'    => __('Site header layout', 'lito'),
				'section'  => $section,
				'settings' => "lito_options[$setting]",
				'choices' => array(
					'container' => __('Container', 'lito'),
					'full_width' => __('Full width', 'lito'),
				),
			)
		);

		$setting = 'header_is_sticky';

		$wp_customize->add_setting( 
			"lito_options[$setting]", 
			array (
				'type'     => 'theme_mod',
				'default'     => $defaults[$setting],
				'transport'   => 'refresh',
				'sanitize_callback' => 'lito_sanitize_checkbox'
			)
		);

		$wp_customize->add_control(
			$setting, 
			array (
				'type' => 'checkbox',
				'label'    => __('Sticky header', 'lito'),
				'section'  => $section,
				'settings' => "lito_options[$setting]",
			)
		);

		$setting = 'header_is_hide_on_scroll';

		$wp_customize->add_setting( 
			"lito_options[$setting]", 
			array (
				'type'     => 'theme_mod',
				'default'     => $defaults[$setting],
				'transport'   => 'refresh',
				'sanitize_callback' => 'lito_sanitize_checkbox'
			)
		);

		$wp_customize->add_control(
			$setting, 
			array (
				'type' => 'checkbox',
				'label'    => __('Hide header on scroll down', 'lito'),
				'section'  => $section,
				'settings' => "lito_options[$setting]",
				'active_callback' => function() {return lito_is_control_enabled('header_is_sticky');}
			)
		);

		$setting = 'header_has_search';

		$wp_customize->add_setting( 
			"lito_options[$setting]", 
			array (
				'type' => 'theme_mod',
				'default' => $defaults[$setting],
				'transport' => 'postMessage',
				'sanitize_callback' => 'lito_sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			$setting,
			array (
				'type' => 'checkbox',
				'label' => __('Enable search in the header', 'lito'),
				'section' => $section,
				'settings' => "lito_options[$setting]",
			)
		);

	}

	$panel = 'lito_footer_panel';

	if ( ! $wp_customize->get_panel( $panel ) ) {
		
		$wp_customize->add_panel(
			$panel,
			array(
				'priority' => 21,
				'title' => __( 'Footer', 'lito' ),
			)
		);
	}

	if ($section = 'lito_footer_options' ){

		$wp_customize->add_section( 
			$section,
			array (
				'title'    => __('Footer options', 'lito'),
				'priority' => 1,
				'panel' => $panel,
			) 
		);

		$setting = 'footer_layout';

		$wp_customize->add_setting( 
			"lito_options[$setting]", 
			array (
				'type'     => 'theme_mod',
				'default'     => $defaults[$setting],
				'transport'   => 'postMessage',
				'sanitize_callback' => 'sanitize_key'
			)
		);

		$wp_customize->add_control(
			$setting, 
			array (
				'type' => 'radio',
				'label'    => __('Site footer layout', 'lito'),
				'section'  => $section,
				'settings' => "lito_options[$setting]",
				'choices' => array(
					'container' => __('Container', 'lito'),
					'full_width' => __('Full width', 'lito'),
				),
			)
		);

		$setting = 'footer_cols';

		$wp_customize->add_setting( 
			"lito_options[$setting]", 
			array (
				'type'     => 'theme_mod',
				'default'     => $defaults[$setting],
				'transport'   => 'postMessage',
				'sanitize_callback' => 'absint',
				'validate_callback' => 'lito_validate_footer_cols'
			)
		);

		$wp_customize->add_control(
			$setting, 
			array (
				'type' => 'number',
				'label'    => __('Number of footer columns', 'lito'),
				'section'  => $section,
				'settings' => "lito_options[$setting]",
				'input_attrs' => array(
					'min' => 1,
					'max' => 5,
					'step' => 1,
				),
			)
		);

		$setting = 'footer_has_copyright';

		$wp_customize->add_setting( 
			"lito_options[$setting]", 
			array (
				'type'     => 'theme_mod',
				'default'     => $defaults[$setting],
				'transport'   => 'refresh',
				'sanitize_callback' => 'lito_sanitize_checkbox'
			)
		);

		$wp_customize->add_control(
			$setting, 
			array (
				'type' => 'checkbox',
				'label'    => __('Enable copyright section in the footer', 'lito'),
				'section'  => $section,
				'settings' => "lito_options[$setting]",
			)
		);

	}

	$panel = 'lito_archive_panel';

	if ( ! $wp_customize->get_panel( $panel ) ) {
		
		$wp_customize->add_panel(
			$panel,
			array(
				'priority' => 21,
				'title' => __( 'Archive', 'lito' ),
			)
		);
	}

	if ($section = 'lito_archive_options' ){

		$wp_customize->add_section( 
			$section,
			array (
				'title'    => __('Archive options', 'lito'),
				'priority' => 1,
				'panel' => $panel,
			) 
		);

		$setting = 'archive_type';

		$wp_customize->add_setting( 
			"lito_options[$setting]", 
			array (
				'type'     => 'theme_mod',
				'default'     => $defaults[$setting],
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_key'
			)
		);

		$wp_customize->add_control(
			$setting, 
			array (
				'type' => 'radio',
				'label'    => __('Archive post type', 'lito'),
				'description' => __('Choose the type of archive posts.', 'lito'),
				'section'  => $section,
				'settings' => "lito_options[$setting]",
				'choices' => array(
					'default' => __('Default', 'lito'),
					'cover' => __('Cover', 'lito'),
					'side' => __('Side', 'lito'),
				),
			)
		);

		$setting = 'archive_layout';

		$wp_customize->add_setting( 
			"lito_options[$setting]", 
			array (
				'type'     => 'theme_mod',
				'default'     => $defaults[$setting],
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_key'
			)
		);

		$wp_customize->add_control(
			$setting, 
			array (
				'type' => 'radio',
				'label'    => __('Archive layout', 'lito'),
				'section'  => $section,
				'settings' => "lito_options[$setting]",
				'choices' => array(
					'container' => __('Container', 'lito'),
					'full_width' => __('Full width', 'lito'),
				),
			)
		);

		$setting = 'archive_grid';

		$wp_customize->add_setting( 
			"lito_options[$setting]", 
			array (
				'type'     => 'theme_mod',
				'default'     => $defaults[$setting],
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_key'
			)
		);

		$wp_customize->add_control(
			$setting, 
			array (
				'type' => 'radio',
				'label'    => __('Archive grid', 'lito'),
				'section'  => $section,
				'settings' => "lito_options[$setting]",
				'choices' => array(
					'default' => __('Default', 'lito'),
					'masonry' => __('Masonry', 'lito'),
					'sticky' => __('Sticky', 'lito'),
				),
				//'active_callback' => function() {return lito_is_control_not_equals('side', 'archive_type');}
			)
		);

		$setting = 'archive_cols';

		$wp_customize->add_setting( 
			"lito_options[$setting]", 
			array (
				'type'     => 'theme_mod',
				'default'     => $defaults[$setting],
				'transport'   => 'refresh',
				'sanitize_callback' => 'absint',
				'validate_callback' => 'lito_validate_archive_cols'
			)
		);

		$wp_customize->add_control(
			$setting, 
			array (
				'type' => 'number',
				'label'    => __('Max. number of columns', 'lito'),
				'description' => __('The number of columns shown depends on the screen size.', 'lito'),
				'section'  => $section,
				'settings' => "lito_options[$setting]",
				'input_attrs' => array(
					'min' => 1,
					'max' => 6,
					'step' => 1,
				),
				'active_callback' => function() {return lito_is_control_not_equals('sticky', 'archive_grid') /*&& lito_is_control_not_equals('side', 'archive_type')*/;}
			)
		);

		$setting = 'archive_header';

		$wp_customize->add_setting( 
			"lito_options[$setting]", 
			array (
				'type'     => 'theme_mod',
				'default'     => $defaults[$setting],
				'transport'   => 'postMessage',
				'sanitize_callback' => 'sanitize_key',
			)
		);

		$wp_customize->add_control(
			$setting, 
			array (
				'type' => 'radio',
				'label'    => __('Archive header', 'lito'),
				'section'  => $section,
				'settings' => "lito_options[$setting]",
				'choices' => array(
					'default' => __('Default', 'lito'),
					'modern' => __('Modern', 'lito'),
					'cover' => __('Cover', 'lito'),
				),
				'active_callback' => function () { return is_archive(); } // show only on archive pages (not for home)
			)
		);

		$setting = 'archive_has_breadcrumbs';

		$wp_customize->add_setting( 
			"lito_options[$setting]", 
			array (
				'type'     => 'theme_mod',
				'default'     => $defaults[$setting],
				'transport'   => 'postMessage',
				'sanitize_callback' => 'lito_sanitize_checkbox'
			)
		);

		$wp_customize->add_control(
			$setting, 
			array (
				'type' => 'checkbox',
				'label'    => __('Show breadcrumbs', 'lito'),
				'section'  => $section,
				'settings' => "lito_options[$setting]",
				'active_callback' => function () { return is_archive(); } // show only on archive pages (not for home)
			)
		);

		$setting = 'archive_has_excerpt';

		$wp_customize->add_setting( 
			"lito_options[$setting]", 
			array (
				'type' => 'theme_mod',
				'default' => $defaults[$setting],
				'transport' => 'refresh',
				'sanitize_callback' => 'lito_sanitize_checkbox'
			)
		);

		$wp_customize->add_control(
			$setting,
			array (
				'type' => 'checkbox',
				'label' => __('Show excerpt', 'lito'),
				'section' => $section,
				'settings' => "lito_options[$setting]",
			)
		);

		$setting = 'archive_has_read_more';

		$wp_customize->add_setting( 
			"lito_options[$setting]", 
			array (
				'type' => 'theme_mod',
				'default' => $defaults[$setting],
				'transport' => 'refresh',
				'sanitize_callback' => 'lito_sanitize_checkbox'
			)
		);

		$wp_customize->add_control(
			$setting,
			array (
				'type' => 'checkbox',
				'label' => __('Show "Read more" button', 'lito'),
				'section' => $section,
				'settings' => "lito_options[$setting]",
				'active_callback' => function () { return (bool) lito_get_option('archive_has_excerpt'); }
			)
		);

		$setting = 'archive_has_author';

		$wp_customize->add_setting( 
			"lito_options[$setting]", 
			array (
				'type' => 'theme_mod',
				'default' => $defaults[$setting],
				'transport' => 'refresh',
				'sanitize_callback' => 'lito_sanitize_checkbox'
			)
		);

		$wp_customize->add_control(
			$setting,
			array (
				'type' => 'checkbox',
				'label' => __('Show author', 'lito'),
				'section' => $section,
				'settings' => "lito_options[$setting]",
			)
		);

		$setting = 'archive_has_date';

		$wp_customize->add_setting( 
			"lito_options[$setting]", 
			array (
				'type' => 'theme_mod',
				'default' => $defaults[$setting],
				'transport' => 'refresh',
				'sanitize_callback' => 'lito_sanitize_checkbox'
			)
		);

		$wp_customize->add_control(
			$setting,
			array (
				'type' => 'checkbox',
				'label' => __('Show date', 'lito'),
				'section' => $section,
				'settings' => "lito_options[$setting]",
			)
		);

		$setting = 'archive_has_tags';

		$wp_customize->add_setting( 
			"lito_options[$setting]", 
			array (
				'type' => 'theme_mod',
				'default' => $defaults[$setting],
				'transport' => 'refresh',
				'sanitize_callback' => 'lito_sanitize_checkbox'
			)
		);

		$wp_customize->add_control(
			$setting,
			array (
				'type' => 'checkbox',
				'label' => __('Show tags', 'lito'),
				'section' => $section,
				'settings' => "lito_options[$setting]",
			)
		);

		$setting = 'archive_has_categories';

		$wp_customize->add_setting( 
			"lito_options[$setting]", 
			array (
				'type' => 'theme_mod',
				'default' => $defaults[$setting],
				'transport' => 'refresh',
				'sanitize_callback' => 'lito_sanitize_checkbox'
			)
		);

		$wp_customize->add_control(
			$setting,
			array (
				'type' => 'checkbox',
				'label' => __('Show categories', 'lito'),
				'section' => $section,
				'settings' => "lito_options[$setting]",
			)
		);

		$setting = 'archive_hide_title_prefix';

		$wp_customize->add_setting( 
			"lito_options[$setting]", 
			array (
				'type' => 'theme_mod',
				'default' => $defaults[$setting],
				'transport' => 'postMessage',
				'sanitize_callback' => 'lito_sanitize_checkbox'
			)
		);

		$wp_customize->add_control(
			$setting,
			array (
				'type' => 'checkbox',
				'label' => __('Hide title prefix', 'lito'),
				'description' => __('Hide the prefix "Category:" or "Tag:" in the title of the archive page.', 'lito'),
				'section' => $section,
				'settings' => "lito_options[$setting]",
				'active_callback' => function () { return is_archive(); } // show only on archive pages (not for home)
			)
		);

		$setting = 'archive_include_sticky_posts';

		$wp_customize->add_setting( 
			"lito_options[$setting]", 
			array (
				'type' => 'theme_mod',
				'default' => $defaults[$setting],
				'transport' => 'refresh',
				'sanitize_callback' => 'lito_sanitize_checkbox'
			)
		);

		$wp_customize->add_control(
			$setting,
			array (
				'type' => 'checkbox',
				'label' => __('Include sticky posts', 'lito'),
				'description' => __('Show sticky posts in the archive.', 'lito'),
				'section' => $section,
				'settings' => "lito_options[$setting]",
			)
		);

		$setting = 'archive_sidebar';

		$wp_customize->add_setting( 
			"lito_options[$setting]", 
			array (
				'type'     => 'theme_mod',
				'default'     => $defaults[$setting],
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_key'
			)
		);

		$wp_customize->add_control(
			$setting, 
			array (
				'type' => 'radio',
				'label'    => __('Archive sidebar', 'lito'),
				'section'  => $section,
				'settings' => "lito_options[$setting]",
				'choices' => array(
					'none' => __('None', 'lito'),
					'left' => __('Left side', 'lito'),
					'right' => __('Right side', 'lito'),
					'both' => __('Both sides', 'lito'),
				),
			)
		);

		$setting = 'archive_sidebar_sticky';

		$wp_customize->add_setting( 
			"lito_options[$setting]", 
			array (
				'type'     => 'theme_mod',
				'default'     => $defaults[$setting],
				'transport'   => 'postMessage',
				'sanitize_callback' => 'lito_sanitize_checkbox'
			)
		);

		$wp_customize->add_control(
			$setting, 
			array (
				'type' => 'checkbox',
				'label'    => __('Sticky sidebar', 'lito'),
				'section'  => $section,
				'settings' => "lito_options[$setting]",
				'active_callback' => function() {return lito_is_control_not_equals('none', 'archive_sidebar');}
			)
		);

		$setting = 'archive_show_featured_video';

		$wp_customize->add_setting( 
			"lito_options[$setting]", 
			array (
				'type'     => 'theme_mod',
				'default'     => $defaults[$setting],
				'transport'   => 'refresh',
				'sanitize_callback' => 'lito_sanitize_checkbox'
			)
		);

		$wp_customize->add_control(
			$setting, 
			array (
				'type' => 'checkbox',
				'label'    => __('Show featured video', 'lito'),
				'description' => __('If the post has a video format with featured video, the video will be displayed instead of the featured image.', 'lito'),
				'section'  => $section,
				'settings' => "lito_options[$setting]",
			)
		);

		$setting = 'archive_show_featured_gallery';

		$wp_customize->add_setting( 
			"lito_options[$setting]", 
			array (
				'type'     => 'theme_mod',
				'default'     => $defaults[$setting],
				'transport'   => 'refresh',
				'sanitize_callback' => 'lito_sanitize_checkbox'
			)
		);

		$wp_customize->add_control(
			$setting, 
			array (
				'type' => 'checkbox',
				'label'    => __('Show featured gallery', 'lito'),
				'description' => __('If the post has a gallery format with featured gallery, the gallery will be displayed instead of the featured image.', 'lito'),
				'section'  => $section,
				'settings' => "lito_options[$setting]",
			)
		);

		$setting = 'archive_show_featured_audio';

		$wp_customize->add_setting( 
			"lito_options[$setting]", 
			array (
				'type'     => 'theme_mod',
				'default'     => $defaults[$setting],
				'transport'   => 'refresh',
				'sanitize_callback' => 'lito_sanitize_checkbox'
			)
		);

		$wp_customize->add_control(
			$setting, 
			array (
				'type' => 'checkbox',
				'label'    => __('Show featured audio', 'lito'),
				'description' => __('If the post has an audio format with featured audio, the audio will be displayed instead of the featured image.', 'lito'),
				'section'  => $section,
				'settings' => "lito_options[$setting]",
			)
		);

	}

	$panel = 'lito_single_panel';

	if ( ! $wp_customize->get_panel( $panel ) ) {
		
		$wp_customize->add_panel(
			$panel,
			array(
				'priority' => 21,
				'title' => __( 'Single', 'lito' ),
			)
		);
	}

	if ($section = 'lito_single_post_options' ){

		$wp_customize->add_section( 
			$section,
			array (
				'title'    => __('Single post options', 'lito'),
				'priority' => 1,
				'panel' => $panel,
			) 
		);

		$setting = 'single_post_header';

		$wp_customize->add_setting( 
			"lito_options[$setting]", 
			array (
				'type'     => 'theme_mod',
				'default'     => $defaults[$setting],
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_key'
			)
		);

		$wp_customize->add_control(
			$setting, 
			array (
				'type' => 'radio',
				'label'    => __('Single post header type', 'lito'),
				'section'  => $section,
				'settings' => "lito_options[$setting]",
				'choices' => array(
					'default' => __('Default', 'lito'),
					'cover' => __('Cover', 'lito'),
					'side' => __('Side', 'lito'),
				),
			)
		);

		$setting = 'single_post_layout';

		$wp_customize->add_setting( 
			"lito_options[$setting]", 
			array (
				'type'     => 'theme_mod',
				'default'     => $defaults[$setting],
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_key'
			)
		);

		$wp_customize->add_control(
			$setting, 
			array (
				'type' => 'radio',
				'label'    => __('Single post layout', 'lito'),
				'section'  => $section,
				'settings' => "lito_options[$setting]",
				'choices' => array(
					'container' => __('Container', 'lito'),
					'full_width' => __('Full width', 'lito'),
				),
			)
		);

		$setting = 'single_post_has_breadcrumbs';

		$wp_customize->add_setting( 
			"lito_options[$setting]", 
			array (
				'type' => 'theme_mod',
				'default' => $defaults[$setting],
				'transport' => 'refresh',
				'sanitize_callback' => 'lito_sanitize_checkbox'
			)
		);

		$wp_customize->add_control(
			$setting,
			array (
				'type' => 'checkbox',
				'label' => __('Show breadcrumbs', 'lito'),
				'section' => $section,
				'settings' => "lito_options[$setting]",
			)
		);

		$setting = 'single_post_has_author';

		$wp_customize->add_setting( 
			"lito_options[$setting]", 
			array (
				'type' => 'theme_mod',
				'default' => $defaults[$setting],
				'transport' => 'refresh',
				'sanitize_callback' => 'lito_sanitize_checkbox'
			)
		);

		$wp_customize->add_control(
			$setting,
			array (
				'type' => 'checkbox',
				'label' => __('Show author', 'lito'),
				'section' => $section,
				'settings' => "lito_options[$setting]",
			)
		);

		$setting = 'single_post_has_date';

		$wp_customize->add_setting( 
			"lito_options[$setting]", 
			array (
				'type' => 'theme_mod',
				'default' => $defaults[$setting],
				'transport' => 'refresh',
				'sanitize_callback' => 'lito_sanitize_checkbox'
			)
		);

		$wp_customize->add_control(
			$setting,
			array (
				'type' => 'checkbox',
				'label' => __('Show date', 'lito'),
				'section' => $section,
				'settings' => "lito_options[$setting]",
			)
		);

		$setting = 'single_post_has_tags';

		$wp_customize->add_setting( 
			"lito_options[$setting]", 
			array (
				'type' => 'theme_mod',
				'default' => $defaults[$setting],
				'transport' => 'refresh',
				'sanitize_callback' => 'lito_sanitize_checkbox'
			)
		);

		$wp_customize->add_control(
			$setting,
			array (
				'type' => 'checkbox',
				'label' => __('Show tags', 'lito'),
				'section' => $section,
				'settings' => "lito_options[$setting]",
			)
		);

		$setting = 'single_post_has_categories';

		$wp_customize->add_setting( 
			"lito_options[$setting]", 
			array (
				'type' => 'theme_mod',
				'default' => $defaults[$setting],
				'transport' => 'refresh',
				'sanitize_callback' => 'lito_sanitize_checkbox'
			)
		);

		$wp_customize->add_control(
			$setting,
			array (
				'type' => 'checkbox',
				'label' => __('Show categories', 'lito'),
				'section' => $section,
				'settings' => "lito_options[$setting]",
			)
		);

		$setting = 'single_post_has_posts_nav';

		$wp_customize->add_setting( 
			"lito_options[$setting]", 
			array (
				'type' => 'theme_mod',
				'default' => $defaults[$setting],
				'transport' => 'refresh',
				'sanitize_callback' => 'lito_sanitize_checkbox'
			)
		);

		$wp_customize->add_control(
			$setting,
			array (
				'type' => 'checkbox',
				'label' => __('Show posts navigation', 'lito'),
				'section' => $section,
				'settings' => "lito_options[$setting]",
			)
		);

		$setting = 'single_post_sidebar';

		$wp_customize->add_setting( 
			"lito_options[$setting]", 
			array (
				'type' => 'theme_mod',
				'default' => $defaults[$setting],
				'transport' => 'refresh',
				'sanitize_callback' => 'sanitize_key'
			)
		);

		$wp_customize->add_control(
			$setting,
			array (
				'type' => 'radio',
				'label' => __('Single post sidebar', 'lito'),
				'section' => $section,
				'settings' => "lito_options[$setting]",
				'choices' => array(
					'none' => __('None', 'lito'),
					'left' => __('Left side', 'lito'),
					'right' => __('Right side', 'lito'),
					'both' => __('Both sides', 'lito'),
				),
			)
		);

		$setting = 'single_post_sidebar_sticky';

		$wp_customize->add_setting( 
			"lito_options[$setting]", 
			array (
				'type' => 'theme_mod',
				'default' => $defaults[$setting],
				'transport' => 'postMessage',
				'sanitize_callback' => 'lito_sanitize_checkbox'
			)
		);

		$wp_customize->add_control(
			$setting,
			array (
				'type' => 'checkbox',
				'label' => __('Sticky sidebar', 'lito'),
				'section' => $section,
				'settings' => "lito_options[$setting]",
				'active_callback' => function() {return lito_is_control_not_equals('none', 'single_post_sidebar');}
			)
		);

	}

	if ($section = 'lito_single_page_options' ){

		$wp_customize->add_section( 
			$section,
			array (
				'title'    => __('Single page options', 'lito'),
				'priority' => 1,
				'panel' => $panel,
			) 
		);

		$setting = 'single_page_header';

		$wp_customize->add_setting( 
			"lito_options[$setting]", 
			array (
				'type'     => 'theme_mod',
				'default'     => $defaults[$setting],
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_key'
			)
		);

		$wp_customize->add_control(
			$setting, 
			array (
				'type' => 'radio',
				'label'    => __('Single page header type', 'lito'),
				'section'  => $section,
				'settings' => "lito_options[$setting]",
				'choices' => array(
					'default' => __('Default', 'lito'),
					'cover' => __('Cover', 'lito'),
					'side' => __('Side', 'lito'),
				),
			)
		);

		$setting = 'single_page_layout';

		$wp_customize->add_setting( 
			"lito_options[$setting]", 
			array (
				'type'     => 'theme_mod',
				'default'     => $defaults[$setting],
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_key'
			)
		);

		$wp_customize->add_control(
			$setting, 
			array (
				'type' => 'radio',
				'label'    => __('Single page layout', 'lito'),
				'section'  => $section,
				'settings' => "lito_options[$setting]",
				'choices' => array(
					'container' => __('Container', 'lito'),
					'full_width' => __('Full width', 'lito'),
				),
			)
		);

		$setting = 'single_page_has_breadcrumbs';

		$wp_customize->add_setting( 
			"lito_options[$setting]", 
			array (
				'type' => 'theme_mod',
				'default' => $defaults[$setting],
				'transport' => 'refresh',
				'sanitize_callback' => 'lito_sanitize_checkbox'
			)
		);

		$wp_customize->add_control(
			$setting,
			array (
				'type' => 'checkbox',
				'label' => __('Show breadcrumbs', 'lito'),
				'section' => $section,
				'settings' => "lito_options[$setting]",
			)
		);

		$setting = 'single_page_sidebar';

		$wp_customize->add_setting( 
			"lito_options[$setting]", 
			array (
				'type' => 'theme_mod',
				'default' => $defaults[$setting],
				'transport' => 'refresh',
				'sanitize_callback' => 'sanitize_key'
			)
		);

		$wp_customize->add_control(
			$setting,
			array (
				'type' => 'radio',
				'label' => __('Single page sidebar', 'lito'),
				'section' => $section,
				'settings' => "lito_options[$setting]",
				'choices' => array(
					'none' => __('None', 'lito'),
					'left' => __('Left side', 'lito'),
					'right' => __('Right side', 'lito'),
					'both' => __('Both sides', 'lito'),
				),
			)
		);

		$setting = 'single_page_sidebar_sticky';

		$wp_customize->add_setting( 
			"lito_options[$setting]", 
			array (
				'type' => 'theme_mod',
				'default' => $defaults[$setting],
				'transport' => 'postMessage',
				'sanitize_callback' => 'lito_sanitize_checkbox'
			)
		);

		$wp_customize->add_control(
			$setting,
			array (
				'type' => 'checkbox',
				'label' => __('Sticky sidebar', 'lito'),
				'section' => $section,
				'settings' => "lito_options[$setting]",
				'active_callback' => function() {return lito_is_control_not_equals('none', 'single_page_sidebar');}
			)
		);

	}

	$panel = 'lito_colors_panel';

	if ( ! $wp_customize->get_panel( $panel ) ) {
		
		$wp_customize->add_panel(
			$panel,
			array(
				'priority' => 21,
				'title' => __( 'Colors', 'lito' ),
			)
		);
	}

	if ($section = 'lito_general_colors_options' ){

		$wp_customize->add_section( 
			$section,
			array (
				'title'    => __('General colors', 'lito'),
				'priority' => 1,
				'panel' => $panel,
			) 
		);

		$setting = 'color_primary';

		$wp_customize->add_setting( 
			"lito_options[$setting]",
			array (
				'type'     => 'theme_mod',
				'default' => $defaults[$setting],
				'transport'   => 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color',
			) 
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control( 
				$wp_customize,	
				$setting, 
				array (
					'label'    => __('Primary color', 'lito'),
					'description' => __('Used for primary buttons, links, important call-to-action elements, and highlights.', 'lito'),
					'section'  => $section,
					'settings' => "lito_options[$setting]",
				)
			)
		);

		$setting = 'color_primary_hover';

		$wp_customize->add_setting( 
			"lito_options[$setting]",
			array (
				'type'     => 'theme_mod',
				'default' => $defaults[$setting],
				'transport'   => 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color',
			) 
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control( 
				$wp_customize,	
				$setting, 
				array (
					'label'    => __('Primary hover color', 'lito'),
					'description' => __('Used for hover effects on primary elements.', 'lito'),
					'section'  => $section,
					'settings' => "lito_options[$setting]",
				)
			)
		);

		$setting = 'color_primary_contrast';

		$wp_customize->add_setting( 
			"lito_options[$setting]",
			array (
				'type'     => 'theme_mod',
				'default' => $defaults[$setting],
				'transport'   => 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color',
			) 
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control( 
				$wp_customize,	
				$setting, 
				array (
					'label'    => __('Primary contrast color', 'lito'),
					'description' => __('Contrast color to the primary color. If your primary color is dark - provide a light color here and vice versa.', 'lito'),
					'section'  => $section,
					'settings' => "lito_options[$setting]",
				)
			)
		);

		$setting = 'color_secondary';

		$wp_customize->add_setting( 
			"lito_options[$setting]",
			array (
				'type'     => 'theme_mod',
				'default' => $defaults[$setting],
				'transport'   => 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color',
			) 
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control( 
				$wp_customize,	
				$setting, 
				array (
					'label'    => __('Secondary color', 'lito'),
					'description' => __('Used for secondary buttons, accents, and complementary elements.', 'lito'),
					'section'  => $section,
					'settings' => "lito_options[$setting]",
				)
			)
		);

		$setting = 'color_secondary_hover';

		$wp_customize->add_setting( 
			"lito_options[$setting]",
			array (
				'type'     => 'theme_mod',
				'default' => $defaults[$setting],
				'transport'   => 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color',
			) 
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control( 
				$wp_customize,	
				$setting, 
				array (
					'label'    => __('Secondary hover color', 'lito'),
					'description' => __('Used for hover effects on secondary elements.', 'lito'),
					'section'  => $section,
					'settings' => "lito_options[$setting]",
				)
			)
		);

		$setting = 'color_secondary_contrast';

		$wp_customize->add_setting( 
			"lito_options[$setting]",
			array (
				'type'     => 'theme_mod',
				'default' => $defaults[$setting],
				'transport'   => 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color',
			) 
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control( 
				$wp_customize,	
				$setting, 
				array (
					'label'    => __('Secondary contrast color', 'lito'),
					'description' => __('Contrast color to the secondary color. If your secondary color is dark - provide a light color here and vice versa.', 'lito'),
					'section'  => $section,
					'settings' => "lito_options[$setting]",
				)
			)
		);

		$setting = 'color_light';

		$wp_customize->add_setting( 
			"lito_options[$setting]",
			array (
				'type'     => 'theme_mod',
				'default' => $defaults[$setting],
				'transport'   => 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color',
			) 
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control( 
				$wp_customize,	
				$setting, 
				array (
					'label'    => __('Light color', 'lito'),
					'description' => __('Used for elements on dark backgrounds or for subtle accents.', 'lito'),
					'section'  => $section,
					'settings' => "lito_options[$setting]",
				)
			)
		);

		$setting = 'color_background';

		$wp_customize->add_setting( 
			"lito_options[$setting]",
			array (
				'type'     => 'theme_mod',
				'default' => $defaults[$setting],
				'transport'   => 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color',
			) 
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control( 
				$wp_customize,	
				$setting, 
				array (
					'label'    => __('Page background color', 'lito'),
					'description' => __('Main background color for the website, providing a neutral backdrop.', 'lito'),
					'section'  => $section,
					'settings' => "lito_options[$setting]",
				)
			)
		);

	}

	if ($section = 'lito_header_colors_options') {

		$wp_customize->add_section( 
			$section,
			array (
				'title'    => __('Header colors', 'lito'),
				'priority' => 1,
				'panel' => $panel,
			) 
		);

		$setting = 'color_header_menu_item';

		$wp_customize->add_setting( 
			"lito_options[$setting]",
			array (
				'type'     => 'theme_mod',
				'default' => $defaults[$setting],
				'transport'   => 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color',
			) 
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control( 
				$wp_customize,	
				$setting, 
				array (
					'label'    => __('Menu item color', 'lito'),
					'section'  => $section,
					'settings' => "lito_options[$setting]",
				)
			)
		);

		$setting = 'color_header_menu_item_hover';

		$wp_customize->add_setting( 
			"lito_options[$setting]",
			array (
				'type'     => 'theme_mod',
				'default' => $defaults[$setting],
				'transport'   => 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color',
			) 
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control( 
				$wp_customize,	
				$setting, 
				array (
					'label'    => __('Menu item hover color', 'lito'),
					'section'  => $section,
					'settings' => "lito_options[$setting]",
				)
			)
		);

		$setting = 'color_header_bg';

		$wp_customize->add_setting( 
			"lito_options[$setting]",
			array (
				'type'     => 'theme_mod',
				'default' => $defaults[$setting],
				'transport'   => 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color',
			) 
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control( 
				$wp_customize,	
				$setting, 
				array (
					'label'    => __('Header background color', 'lito'),
					'description' => __('Leave empty for the transparent background.', 'lito'),
					'section'  => $section,
					'settings' => "lito_options[$setting]",
				)
			)
		);

	}

	if ($section = 'lito_footer_colors_options') {

		$wp_customize->add_section( 
			$section,
			array (
				'title'    => __('Footer colors', 'lito'),
				'priority' => 1,
				'panel' => $panel,
			) 
		);

		$setting = 'color_footer_bg';

		$wp_customize->add_setting( 
			"lito_options[$setting]",
			array (
				'type'     => 'theme_mod',
				'default' => $defaults[$setting],
				'transport'   => 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color',
			) 
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control( 
				$wp_customize,	
				$setting, 
				array (
					'label'    => __('Footer background color', 'lito'),
					'description' => __('Leave empty for the transparent background.', 'lito'),
					'section'  => $section,
					'settings' => "lito_options[$setting]",
				)
			)
		);

		$setting = 'color_footer_text';

		$wp_customize->add_setting( 
			"lito_options[$setting]",
			array (
				'type'     => 'theme_mod',
				'default' => $defaults[$setting],
				'transport'   => 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color',
			) 
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control( 
				$wp_customize,	
				$setting, 
				array (
					'label'    => __('Footer text color', 'lito'),
					'section'  => $section,
					'settings' => "lito_options[$setting]",
				)
			)
		);

	}

	if ($section = 'lito_content_colors_options') {

		$wp_customize->add_section( 
			$section,
			array (
				'title'    => __('Content colors', 'lito'),
				'priority' => 1,
				'panel' => $panel,
			) 
		);

		$setting = 'color_text';

		$wp_customize->add_setting( 
			"lito_options[$setting]",
			array (
				'type'     => 'theme_mod',
				'default' => $defaults[$setting],
				'transport'   => 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color',
			) 
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control( 
				$wp_customize,	
				$setting, 
				array (
					'label'    => __('Text color', 'lito'),
					'section'  => $section,
					'settings' => "lito_options[$setting]",
				)
			)
		);

		$setting = 'color_text_secondary';

		$wp_customize->add_setting( 
			"lito_options[$setting]",
			array (
				'type'     => 'theme_mod',
				'default' => $defaults[$setting],
				'transport'   => 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color',
			) 
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control( 
				$wp_customize,	
				$setting, 
				array (
					'label'    => __('Secondary text color', 'lito'),
					'section'  => $section,
					'settings' => "lito_options[$setting]",
				)
			)
		);

		$setting = 'color_heading';

		$wp_customize->add_setting( 
			"lito_options[$setting]",
			array (
				'type'     => 'theme_mod',
				'default' => $defaults[$setting],
				'transport'   => 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color',
			) 
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control( 
				$wp_customize,	
				$setting, 
				array (
					'label'    => __('Heading color', 'lito'),
					'section'  => $section,
					'settings' => "lito_options[$setting]",
				)
			)
		);

		$setting = 'color_outline';

		$wp_customize->add_setting( 
			"lito_options[$setting]",
			array (
				'type'     => 'theme_mod',
				'default' => $defaults[$setting],
				'transport'   => 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color',
			) 
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control( 
				$wp_customize,	
				$setting, 
				array (
					'label'    => __('Outline color', 'lito'),
					'description' => __('Used for outlining focused or selected elements, providing visual emphasis.', 'lito'),
					'section'  => $section,
					'settings' => "lito_options[$setting]",
				)
			)
		);

		$setting = 'color_content_bg';

		$wp_customize->add_setting( 
			"lito_options[$setting]",
			array (
				'type'     => 'theme_mod',
				'default' => $defaults[$setting],
				'transport'   => 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color',
			) 
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control( 
				$wp_customize,	
				$setting, 
				array (
					'label'    => __('Content background color', 'lito'),
					'description' => __('Background color for the various content areas, such as sidebars, posts grid, comments.', 'lito').'<br />'.__('Leave empty for the transparent background.', 'lito'),
					'section'  => $section,
					'settings' => "lito_options[$setting]",
				)
			)
		);

		$setting = 'color_border';

		$wp_customize->add_setting( 
			"lito_options[$setting]",
			array (
				'type'     => 'theme_mod',
				'default' => $defaults[$setting],
				'transport'   => 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color',
			) 
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control( 
				$wp_customize,	
				$setting, 
				array (
					'label'    => __('Border color', 'lito'),
					'description' => __('Used for borders around elements such as buttons, forms, or containers.', 'lito'),
					'section'  => $section,
					'settings' => "lito_options[$setting]",
				)
			)
		);

	}
	
	$panel = 'lito_typo_panel';

	if ( ! $wp_customize->get_panel( $panel ) ) {
		
		$wp_customize->add_panel(
			$panel,
			array(
				'priority' => 21,
				'title' => __( 'Typography', 'lito' ),
			)
		);
	}

	if ($section = 'lito_typo_options' ){

		$wp_customize->add_section( 
			$section,
			array (
				'title'    => __('Typography options', 'lito'),
				'priority' => 1,
				'panel' => $panel,
			) 
		);

		$setting = 'typo_body';

		$wp_customize->add_setting( 
			"lito_options[$setting]",
			array (
				'type'     => 'theme_mod',
				'default'     => $defaults[$setting],
				'transport'   => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field'
			)
		);

		$wp_customize->add_control( 
			new Lito_Customize_Control_Font (
				$wp_customize,
				$setting, 
				array (
					'type' => 'font',
					'label'    => __('Body font', 'lito'),
					'description'    => __('The standard body text used for general content throughout the website.', 'lito'),
					'section'  => $section,
					'settings' => "lito_options[$setting]",
					'font_size_attrs' => array(
						'min' => 0.75,
						'max' => 10,
						'step' => 0.25,
					),
				)
			)
		);

		$setting = 'typo_header';

		$wp_customize->add_setting( 
			"lito_options[$setting]",
			array (
				'type'     => 'theme_mod',
				'default'     => $defaults[$setting],
				'transport'   => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field'
			)
		);

		$wp_customize->add_control( 
			new Lito_Customize_Control_Font (
				$wp_customize,
				$setting, 
				array (
					'type' => 'font',
					'label'    => __('Header font', 'lito'),
					'description'    => __('Provide a font for the site header.', 'lito'),
					'section'  => $section,
					'settings' => "lito_options[$setting]",
					'font_size_attrs' => array(
						'min' => 0.75,
						'max' => 5,
						'step' => 0.25,
					),
				)
			)
		);

		for ( $i = 1; $i <= 6; $i++ ){
			$setting = 'typo_h'.$i;

			$wp_customize->add_setting( 
				"lito_options[$setting]",
				array (
					'type'     => 'theme_mod',
					'default'     => $defaults[$setting],
					'transport'   => 'postMessage',
					'sanitize_callback' => 'sanitize_text_field'
				)
			);

			$wp_customize->add_control( 
				new Lito_Customize_Control_Font (
					$wp_customize,
					$setting, 
					array (
						'type' => 'font',
						'label'    => sprintf(__('H%d font', 'lito'), $i),
						'description'    => sprintf(__('Provide font for H%d headings.', 'lito'), $i),
						'section'  => $section,
						'settings' => "lito_options[$setting]",
						'font_size_attrs' => array(
							'min' => 0.75,
							'max' => 8,
							'step' => 0.25,
						),
					)
				)
			);
		}

	}

	$panel = 'lito_global_panel';

	if ( ! $wp_customize->get_panel( $panel ) ) {
		
		$wp_customize->add_panel(
			$panel,
			array(
				'priority' => 21,
				'title' => __( 'Global', 'lito' ),
			)
		);
	}

	if ($section = 'lito_global_options' ){

		$wp_customize->add_section( 
			$section,
			array (
				'title'    => __('Global options', 'lito'),
				'priority' => 1,
				'panel' => $panel,
			) 
		);

		$setting = 'content_width';

		$wp_customize->add_setting( 
			"lito_options[$setting]",
			array (
				'type'     => 'theme_mod',
				'default'     => $defaults[$setting],
				'transport'   => 'refresh',
				'sanitize_callback' => 'absint',
				//'validate_callback' => 'lito_validate_content_width_value'
			)
		);

		$wp_customize->add_control( 
			$setting, 
			array (
				'type' => 'number',
				'label'    => __('Content width', 'lito'),
				'description'    => __('Adjust the width of the inner (text) content within your posts and pages. <br />Provide an integer number. <br /><strong>Must be smaller than the container width below!</strong>', 'lito'),
				'section'  => $section,
				'settings' => "lito_options[$setting]",
				'input_attrs' => array(
					'max' => lito_get_option('container_width'),
					'step' => 1,
				),
			)
		);

		$setting = 'container_width';

		$wp_customize->add_setting( 
			"lito_options[$setting]",
			array (
				'type'     => 'theme_mod',
				'default'     => $defaults[$setting],
				'transport'   => 'refresh',
				'sanitize_callback' => 'absint',
				//'validate_callback' => 'lito_validate_container_width_value'
			)
		);

		$wp_customize->add_control( 
			$setting, 
			array (
				'type' => 'number',
				'label'    => __('Container width', 'lito'),
				'description'    => __('Set the overall width of the content container for your site. This defines the maximum width for all content areas, including headers, footers. <br /> Provide an integer number. <br /><strong>Must be bigger than the content width above!</strong>', 'lito'),
				'section'  => $section,
				'settings' => "lito_options[$setting]",
				'input_attrs' => array(
					'min' => lito_get_option('content_width'),
					'step' => 1,
				),
			)
		);

		$setting = 'width_units';

		$wp_customize->add_setting( 
			"lito_options[$setting]",
			array (
				'type'     => 'theme_mod',
				'default'     => $defaults[$setting],
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_key'
			)
		);

		$wp_customize->add_control( 
			$setting, 
			array (
				'type' => 'select',
				'label'    => __('Width units', 'lito'),
				'description'    => __('Select the units for the width values above.', 'lito'),
				'section'  => $section,
				'settings' => "lito_options[$setting]",
				'choices' => array(
					'px' => esc_attr( 'px' ),
					'percent' => esc_attr( '%' ),
					'em' => esc_attr( 'em' ),
					'rem' => esc_attr( 'rem' ),
					'vw' => esc_attr( 'vw' ),
				),
			)
		);

		$setting = 'smooth_scroll';

		$wp_customize->add_setting( 
			"lito_options[$setting]",
			array (
				'type'     => 'theme_mod',
				'default'     => $defaults[$setting],
				'transport'   => 'refresh',
				'sanitize_callback' => 'lito_sanitize_checkbox'
			)
		);

		$wp_customize->add_control( 
			$setting, 
			array (
				'type' => 'checkbox',
				'label'    => __('Smooth scroll', 'lito'),
				'section'  => $section,
				'settings' => "lito_options[$setting]",
			)
		);

	}


}

add_action( 'customize_register', 'lito_customizer_register_partials' );
/**
 * Register partials for selective refresh.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function lito_customizer_register_partials( $wp_customize ) {
	// Abort if selective refresh is not available.
    if ( ! isset( $wp_customize->selective_refresh ) ) {
        return;
    }
	
	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector' => '.site-title a',
		'render_callback' => function() {bloginfo( 'name' );},
	) );

	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector' => '.site-description',
		'render_callback' => function() {bloginfo( 'description' );},
	) );

	$wp_customize->selective_refresh->add_partial( 'lito_options[header_type]', array(
		'selector' => '.site-header',
		'settings' => 'lito_options[header_type]',
		'container_inclusive' => true,
		'render_callback' => function() {
			?>
			<header id="site-header" class="<?php echo esc_attr(lito_header_classes()); ?>" style="opacity: 1">
				<?php lito_header(); ?>
			</header>
			<?php
		},
		'fallback_refresh' => true,
	) );

	$wp_customize->selective_refresh->add_partial( 'lito_options[header_layout]', array(
		'selector' => '.site-header',
		'settings' => 'lito_options[header_layout]',
		'container_inclusive' => true,
		'render_callback' => function() {
			?>
			<header id="site-header" class="<?php echo esc_attr(lito_header_classes()); ?>">
				<?php lito_header(); ?>
			</header>
			<?php
		},
		'fallback_refresh' => true,
	) );

	$wp_customize->selective_refresh->add_partial( 'lito_options[header_has_search]', array(
		'selector' => '.site-header',
		'settings' => 'lito_options[header_has_search]',
		'container_inclusive' => true,
		'render_callback' => function() {
			?>
			<header id="site-header" class="<?php echo esc_attr(lito_header_classes()); ?>" style="opacity: 1">
				<?php lito_header(); ?>
			</header>
			<?php
		},
		'fallback_refresh' => true,
	) );

	$wp_customize->selective_refresh->add_partial( 'lito_options[footer_layout]', array(
		'selector' => '.site-footer',
		'settings' => 'lito_options[footer_layout]',
		'container_inclusive' => true,
		'render_callback' => function() {
			?>
			<footer id="site-footer" class="<?php echo esc_attr(lito_footer_classes()); ?>">
				<?php lito_footer(); ?>
			</footer>
			<?php
		},
		'fallback_refresh' => true,
	) );

	$wp_customize->selective_refresh->add_partial( 'lito_options[footer_cols]', array(
		'selector' => '.site-footer',
		'settings' => 'lito_options[footer_cols]',
		'container_inclusive' => true,
		'render_callback' => function() {
			?>
			<footer id="site-footer" class="<?php echo esc_attr(lito_footer_classes()); ?>">
				<?php lito_footer(); ?>
			</footer>
			<?php
		},
		'fallback_refresh' => true,
	) );

	$wp_customize->selective_refresh->add_partial( 'lito_options[archive_header]', array(
		'selector' => '.archive-header',
		'settings' => 'lito_options[archive_header]',
		'container_inclusive' => true,
		'render_callback' => function() {
			lito_archive_header();
		},
		'fallback_refresh' => true,
	) );

	$wp_customize->selective_refresh->add_partial( 'lito_options[archive_has_breadcrumbs]', array(
		'selector' => '.archive-header',
		'settings' => 'lito_options[archive_has_breadcrumbs]',
		'container_inclusive' => true,
		'render_callback' => function() {
			lito_archive_header();
		},
		'fallback_refresh' => true,
	) );

	$wp_customize->selective_refresh->add_partial( 'lito_options[archive_hide_title_prefix]', array(
		'selector' => '.archive-header',
		'settings' => 'lito_options[archive_hide_title_prefix]',
		'container_inclusive' => true,
		'render_callback' => function() {
			lito_archive_header();
		},
		'fallback_refresh' => true,
	) );

}


/**
 * Sanitize functions
 */
function lito_sanitize_checkbox($input) {
	return ( ( isset( $input ) && true === (bool) trim($input) ) ? true : false );
}

function lito_is_control_enabled ($control) {
	$is_control_enabled = (bool) lito_get_option( $control );
    return $is_control_enabled;
}

function lito_is_control_equals ($value, $control) {
	$is_control_equals = lito_get_option( $control ) === $value ? true : false;
    return $is_control_equals;
}

function lito_is_control_not_equals ($value, $control) {
	$is_control_not_equals = lito_get_option( $control ) !== $value ? true : false;
    return $is_control_not_equals;
}

function lito_validate_footer_cols( $validity, $value ) {
	if ( ! in_array( $value, array( '1', '2', '3', '4', '5' ) ) ) {
		$validity->add( 'invalid_footer_cols', __( 'Invalid footer columns number.', 'lito' ) );
	}
	return $validity;
}

function lito_validate_archive_cols( $validity, $value ) {
	if ( ! in_array( $value, array( '1', '2', '3', '4', '5', '6' ) ) ) {
		$validity->add( 'invalid_archive_cols', __( 'Invalid archive columns number.', 'lito' ) );
	}
	return $validity;
}

function lito_validate_content_width_value( $validity, $value ) {
	$container_width = lito_get_option( 'container_width' );
	if ( (int) $value >= (int) $container_width ) {
		$validity->add( 'invalid_content_width_value', __( 'Content width must be less than container width.', 'lito' ) );
	}
	return $validity;
}

function lito_validate_container_width_value( $validity, $value ) {
	$content_width = lito_get_option( 'content_width' );
	if ( (int) $value <= (int) $content_width ) {
		$validity->add( 'invalid_container_width_value', __( 'Container width must be greater than content width.', 'lito' ) );
	}
	return $validity;
}