<?php
/**
 * Demo content for the theme
 * 
 * @package Lito
 * @since 1.0
 */


add_filter( 'ocdi/register_plugins', 'lito_ocdi_register_plugins' );
/**
 * List of plugins for Demo Import Plugin
 * @see https://ocdi.com/quick-integration-guide/
 */
function lito_ocdi_register_plugins( $plugins ) {
	$theme_plugins = [
		[ // A WordPress.org plugin repository example.
			'name'     => 'Contact Form 7', // Name of the plugin.
			'slug'     => 'contact-form-7', // Plugin slug - the same as on WordPress.org plugin repository.
			'required' => false, // If the plugin is required or not.
		],
		[
			'name'     => 'Yoast SEO',
			'slug'     => 'wordpress-seo',
			'required' => false,
		],
		
	];
   
	return array_merge( $plugins, $theme_plugins );
}

add_filter( 'ocdi/import_files', 'lito_ocdi_import_files' );
/**
 * List of files with demo content for Demo Import Plugin
 * @see https://ocdi.com/quick-integration-guide/
 */
function lito_ocdi_import_files() {
	return [
		[
			'import_file_name'           => 'Blog',
			'import_file_url'            => 'https://lito.bogdan.kyiv.ua/demo_data/lito-content-blog.xml',
			'import_widget_file_url'     => 'https://lito.bogdan.kyiv.ua/demo_data/lito-widgets-blog.wie',
			'import_customizer_file_url' => 'https://lito.bogdan.kyiv.ua/demo_data/lito-customizer-blog.dat',
			'import_preview_image_url'   => 'https://lito.bogdan.kyiv.ua/demo_data/lito-preview-blog.jpg',
			'preview_url'                => 'https://lito.bogdan.kyiv.ua/',
		]
	];
}

add_filter( 'cei_export_option_keys', 'lito_export_option_keys' );
/**
 * Add custom customizer options for import/export
 */
function lito_export_option_keys( $keys ) {
    $keys[] = 'lito_options';
	
    return $keys;
}

add_action( 'ocdi/after_import', 'lito_ocdi_after_import_setup' );
/**
 * Setup theme options after demo import
 * @see https://ocdi.com/advanced-integration-guide/
 */
function lito_ocdi_after_import_setup() {
  // Assign menus to their locations.
  $primary_menu = get_term_by( 'slug', 'primary-menu', 'nav_menu' );
  $social_menu = get_term_by( 'slug', 'social-menu', 'nav_menu' );

  set_theme_mod( 'nav_menu_locations', 
    [
      'primary' => $primary_menu->term_id,
      'social' => $social_menu->term_id,
    ]
  );
  
  // Get the front page.
  $front_page = get_posts(
    [
      'post_type'              => 'page',
      'title'                  => 'Modern Blog Home',
      'post_status'            => 'all',
      'numberposts'            => 1,
      'update_post_term_cache' => false,
      'update_post_meta_cache' => false,
    ]
  );
  
  if ( ! empty( $front_page ) ) {
    update_option( 'page_on_front', $front_page[0]->ID );
  }
  
  // Get the blog page.
  $blog_page = get_posts(
    [
      'post_type'              => 'page',
      'title'                  => 'Blog',
      'post_status'            => 'all',
      'numberposts'            => 1,
      'update_post_term_cache' => false,
      'update_post_meta_cache' => false,
    ]
  );
  
  if ( ! empty( $blog_page ) ) {
    update_option( 'page_for_posts', $blog_page[0]->ID );
  }
  
  if ( ! empty( $blog_page ) || ! empty( $front_page ) ) {
    update_option( 'show_on_front', 'page' );
  }

  update_option( 'posts_per_page', 5 );
}