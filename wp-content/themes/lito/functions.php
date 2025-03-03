<?php
/**
 * Lito.
 *
 * Please do not make any edits to this file. All edits should be done in a child theme.
 *
 * @package Lito
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Set our theme version.
define( 'LITO_VERSION', '1.0.8' );

if ( ! function_exists( 'lito_theme_setup' ) ) {
	add_action( 'after_setup_theme', 'lito_theme_setup' );
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * @since 1.0.0
	 */
	function lito_theme_setup() {
		// Make theme available for translation.
		load_theme_textdomain( 'lito', get_template_directory() . '/languages' );

		// Add theme support for various features.
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'post-formats', array( 'gallery', 'video', 'link', 'audio' ) );
		add_theme_support( 'woocommerce' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'script', 'style' ) );
		add_theme_support( 'customize-selective-refresh-widgets' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'responsive-embeds' );
        add_theme_support( 'wp-block-styles' );

		add_theme_support(
			'custom-logo',
			array(
				'height' => 70,
				'width' => 350,
				'flex-height' => true,
				'flex-width' => true,
			)
		);

        add_theme_support( 'starter-content', array(
            'widgets' => array(
                'footer-1' => array(
                    'text_about',
                ),
                'footer-2' => array(
                    'categories',
                ),
                'footer-3' => array(
                    'text_business_info',
                ),
                'footer-4' => array(
                    'meta',
                ),
            ),
            'posts' => array(
                'home' =>  array(
                    'post_type'    => 'page',
                    'post_title'   => _x( 'Home', 'lito' ),
                    'post_content' => '<!-- wp:pattern {"slug":"lito/template-home-blog"} /-->',
                ),
                'blog',
            ),
            'nav_menus' => array(
                'primary' => array(
                    'name' => __( 'Primary Menu', 'lito' ),
                    'items' => array(
                        'home' => array(
                            'type' => 'post_type',
                            'object' => 'page',
                            'object_id' => '{{home}}',
                        ),
                        'blog' => array(
                            'type' => 'post_type',
                            'object' => 'page',
                            'object_id' => '{{blog}}',
                        ),
                    ),
                ),
            ),
            'options' => array(
                'show_on_front' => 'page',
                'page_on_front' => '{{home}}',
                'page_for_posts' => '{{blog}}',
                'custom_logo' => '{{logo}}',
            ),
            'attachments' => array(
                'logo' => array(
                    'post_title' => _x( 'Logo', 'lito' ),
                    'file' => 'assets/images/logo.png',
                ),
            ),
        ) );

		// Register primary menu.
		register_nav_menus(
			array(
				'primary' => __( 'Primary Menu', 'lito' ),
				'social' => __( 'Social Menu', 'lito' ),
			)
		);

	}
}

if ( ! function_exists( 'lito_widget_setup' ) ) {
    add_action( 'widgets_init', 'lito_widget_setup' );
    /**
     * Register widget area.
     *
     * @since 1.0.0
     */
    function lito_widget_setup() {
        $footer_cols_number = lito_get_footer_cols_number();

        for ($i = 1; $i <= $footer_cols_number; $i++) {
            register_sidebar(
                array(
                    'name' => sprintf(__( 'Footer %d', 'lito' ), $i),
                    'id' => 'footer-' . $i,
                    'description' => __( 'Add widgets here to appear in your footer.', 'lito' ),
                    'before_widget' => '<section id="%1$s" class="widget %2$s">',
                    'after_widget' => '</section>',
                    'before_title' => '<h2 class="widget-title">',
                    'after_title' => '</h2>',
                )
            );
        }

        register_sidebar(
            array(
                'name' => __( 'Copyright', 'lito' ),
                'id' => 'copyright',
                'description' => __( 'Add widgets here to appear in your copyright.', 'lito' ),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget' => '</section>',
                'before_title' => '<h2 class="widget-title">',
                'after_title' => '</h2>',
            )
        );

        register_sidebar(
            array(
                'name' => __( 'Sidebar on the left (archive)', 'lito' ),
                'id' => 'sidebar',
                'description' => __( 'Add widgets here to appear in your left sidebar on archive pages (categories, tags, search).', 'lito' ),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget' => '</section>',
                'before_title' => '<h2 class="widget-title">',
                'after_title' => '</h2>',
            )
        );
    
        register_sidebar(
            array(
                'name' => __( 'Sidebar on the right (archive)', 'lito' ),
                'id' => 'sidebar-right',
                'description' => __( 'Add widgets here to appear in your right sidebar on archive pages (categories, tags, search).', 'lito' ),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget' => '</section>',
                'before_title' => '<h2 class="widget-title">',
                'after_title' => '</h2>',
            )
        );

        register_sidebar(
            array(
                'name' => __( 'Sidebar on the left (single post)', 'lito' ),
                'id' => 'sidebar-post',
                'description' => __( 'Add widgets here to appear in your left sidebar on single post pages.', 'lito' ),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget' => '</section>',
                'before_title' => '<h2 class="widget-title">',
                'after_title' => '</h2>',
            )
        );

        register_sidebar(
            array(
                'name' => __( 'Sidebar on the right (single post)', 'lito' ),
                'id' => 'sidebar-post-right',
                'description' => __( 'Add widgets here to appear in your right sidebar on single post pages.', 'lito' ),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget' => '</section>',
                'before_title' => '<h2 class="widget-title">',
                'after_title' => '</h2>',
            )
        );

        register_sidebar(
            array(
                'name' => __( 'Sidebar on the left (single page)', 'lito' ),
                'id' => 'sidebar-page',
                'description' => __( 'Add widgets here to appear in your left sidebar on single page pages.', 'lito' ),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget' => '</section>',
                'before_title' => '<h2 class="widget-title">',
                'after_title' => '</h2>',
            )
        );

        register_sidebar(
            array(
                'name' => __( 'Sidebar on the right (single page)', 'lito' ),
                'id' => 'sidebar-page-right',
                'description' => __( 'Add widgets here to appear in your right sidebar on single page pages.', 'lito' ),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget' => '</section>',
                'before_title' => '<h2 class="widget-title">',
                'after_title' => '</h2>',
            )
        );
        
    }
}

if ( ! function_exists( 'lito_enqueue_scripts' ) ) {
    add_action( 'wp_enqueue_scripts', 'lito_enqueue_scripts' );
    /**
     * Enqueue scripts.
     *
     * @since 1.0.0
     */
    function lito_enqueue_scripts() {
        global $wp_query;

        $is_smooth_scroll = lito_get_option('smooth_scroll');

        if ($is_smooth_scroll) {
            wp_enqueue_script( 'lito-smooth-scroll', get_template_directory_uri() . '/assets/js/lenis.min.js', array( 'jquery' ), '1.0.34', true );
        }

        wp_enqueue_script( 'lito-slick', get_template_directory_uri() . '/assets/js/slick.min.js', array( 'jquery' ), '1.8.1', true );
        wp_enqueue_script( 'lito-main', get_template_directory_uri() . '/assets/js/dist/main.js', array( 'jquery' ), LITO_VERSION, true );

        wp_localize_script(
			'lito-main',
			'litoMain',
			apply_filters(
				'lito_localize_js_args',
				array (
                    'ajaxURL' => admin_url( 'admin-ajax.php' ),
					'slickArgs' => array(
                        'dots' => false,
                        'arrows' => true,
                        'infinite' => true,
                        'speed' => 300,
                        'slidesToShow' => 1,
                        'slidesToScroll' => 1,
                        'autoplay' => false,
                        'adaptiveHeight' => false,
                    ),
                    'posts' => json_encode( $wp_query->query_vars ), // everything about your loop is here
					'currentPostID' => get_the_ID(),
					'currentPage' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
					'maxPage' => $wp_query->max_num_pages,
                    'isMasonryArchive' => lito_is_masonry_archive(),
                    'isStickyArchive' => lito_is_sticky_archive(),
                    'transitionDuration' => 300,
				)
			)
		);

        if ( is_singular() && comments_open() ) {
			wp_enqueue_script( 'comment-reply' );
		}

    }
}

if ( ! function_exists( 'lito_enqueue_styles' ) ) {
    add_action( 'wp_enqueue_scripts', 'lito_enqueue_styles', 99 );
    /**
     * Enqueue styles.
     *
     * @since 1.0.0
     */
    function lito_enqueue_styles() {
        // Placeholder style.
		wp_register_style( 'lito-inline', false ); // phpcs:ignore
		wp_enqueue_style( 'lito-inline', null, array('global-styles-inline') );

        wp_enqueue_style( 'lito-vars', get_stylesheet_directory_uri() . '/assets/css/vars.css', array(), LITO_VERSION );
        wp_enqueue_style( 'lito-blocks', get_stylesheet_directory_uri() . '/assets/css/blocks.css', array(), LITO_VERSION );
        
        wp_enqueue_style( 'dashicons' );
        wp_enqueue_style( 'lito-normalize', get_template_directory_uri() . '/assets/css/normalize.css', array(), '8.0.1' );
        wp_enqueue_style( 'lito-slick', get_template_directory_uri() . '/assets/css/slick.css', array(), '1.8.1' );
        wp_enqueue_style( 'lito-slick-theme', get_template_directory_uri() . '/assets/css/slick-theme.css', array(), '1.8.1' );
        wp_enqueue_style( 'lito-simplebar', get_template_directory_uri() . '/assets/css/simplebar.css', array(), '6.2.6' );
        wp_enqueue_style( 'lito-main', get_template_directory_uri() . '/assets/css/main.css', array(), LITO_VERSION );

        wp_enqueue_style( 'lito-style', get_stylesheet_uri(), array(), LITO_VERSION );

    }
}

if ( ! function_exists( 'lito_enqueue_block_editor_assets' ) ) {
    if ( is_admin() ) { 
        add_action( 'enqueue_block_assets', 'lito_enqueue_block_editor_assets' );
    }
    /**
     * Enqueue block editor assets.
     *
     * @since 1.0.0
     */
    function lito_enqueue_block_editor_assets() {

        // Add block-editor js.
        wp_enqueue_script( 'lito-block-editor', get_template_directory_uri() . '/assets/js/dist/block-editor.js', array( 'wp-blocks', 'jquery' ), LITO_VERSION, false );

        // Add block-editor css.
        wp_enqueue_style( 'lito-vars', get_stylesheet_directory_uri() . '/assets/css/vars.css', array(), LITO_VERSION );
        wp_enqueue_style( 'lito-blocks', get_stylesheet_directory_uri() . '/assets/css/blocks.css', array(), LITO_VERSION );
        wp_enqueue_style( 'lito-block-editor', get_template_directory_uri() . '/assets/css/block-editor.css', array(), LITO_VERSION );

    }
}

if ( ! function_exists( 'lito_block_stylesheets' ) ) {
    add_action( 'init', 'lito_block_stylesheets' );
    /**
	 * Enqueue custom block stylesheets
	 *
	 * @since 1.0
	 */
	function lito_block_stylesheets() {
        /**
		 * The wp_enqueue_block_style() function allows us to enqueue a stylesheet
		 * for a specific block. These will only get loaded when the block is rendered
		 * (both in the editor and on the front end), improving performance
		 * and reducing the amount of data requested by visitors.
		 *
		 * See https://make.wordpress.org/core/2021/12/15/using-multiple-stylesheets-per-block/ for more info.
		 */
		wp_enqueue_block_style(
			'core/button',
			array(
				'handle' => 'lito-button-style-outline',
				'src'    => get_parent_theme_file_uri( 'assets/css/button-outline.css' ),
				'ver'    => wp_get_theme( get_template() )->get( 'Version' ),
				'path'   => get_parent_theme_file_path( 'assets/css/button-outline.css' ),
			)
		);

    }

}

if ( ! function_exists( 'lito_excerpt_length' ) ) {
    add_filter( 'excerpt_length', 'lito_excerpt_length', 10 );
    /**
     * Filter the except length.
     *
     * @since 1.0.0
     */
    function lito_excerpt_length( $length ) {
        if ( is_admin() ) return $length;
        return (int) lito_get_option( 'excerpt_length' );
    }
}

if ( ! function_exists( 'lito_excerpt_more' ) ) {
    add_filter( 'excerpt_more', 'lito_excerpt_more' );
    /**
     * Filter the excerpt more string.
     *
     * @since 1.0.0
     */
    function lito_excerpt_more( $more ) {
        if ( is_admin() ) return $more;
        return '...';
    }
}

add_filter('post_class', 'lito_post_classes');
/**
 * Add custom post classes.
 *
 * @since 1.0.0
 */
function lito_post_classes( $classes = array() ) {
    $classes[] = 'post';

    if ( is_sticky() ) {
        $classes[] = 'sticky';
    }

    if ( is_single() ) {
        $single_post_header = lito_get_option('single_post_header');
        $classes[] = 'single';
        $classes[] = 'is-'.$single_post_header.'-post';
    }

    if ( is_page() ) {
        $single_page_header = lito_get_option('single_page_header');
        $classes[] = 'single';
        $classes[] = 'page';
        $classes[] = 'is-'.$single_page_header.'-post';
    }

    if ( is_archive() || is_search() || is_home() ) {
        $archive_type = lito_get_option('archive_type');
        $post_format = get_post_format();
        if (lito_is_sticky_post_in_sticky_grid()) {
            $archive_type = 'cover'; // force cover layout for sticky posts in sticky grid
        }
        if (!lito_has_featured_media()) {
            $classes[] = 'no-featured-media';
        }
        if ($post_format === 'audio') {
            $is_archive_show_featured_audio = lito_get_option('archive_show_featured_audio');

            if (!$is_archive_show_featured_audio) {
                $classes[] = 'no-featured-audio';
            }
        }
        $classes[] = 'in-archive';
        $classes[] = 'is-'.$archive_type.'-post';
    }

    if ( is_search() ) {
        $classes[] = 'in-search';
    }

    if ( is_404() ) {
        $classes[] = 'error';
    }

    return apply_filters( 'lito_post_classes', $classes );
}

/**
 * Register custom block styles
 */
add_action('init', 'lito_register_block_styles');
function lito_register_block_styles() {
    register_block_style('core/columns', array(
		'name' => 'autostack-columns',
		'label' => __('Autostack columns', 'lito'),
    ));
    register_block_style('core/post-template', array(
		'name' => 'autostack-columns',
		'label' => __('Autostack columns', 'lito'),
    ));
    register_block_style('core/media-text', array(
		'name' => 'autostack-columns',
		'label' => __('Autostack columns', 'lito'),
    ));
    register_block_style('core/group', array(
		'name' => 'autostack-columns',
		'label' => __('Autostack columns', 'lito'),
    ));
    register_block_style('core/table', array(
		'name' => 'compact-table',
		'label' => __('Compact', 'lito'),
    ));
    register_block_style('core/video', array(
        'name' => 'stretch-video',
        'label' => __('Stretch', 'lito'),
    ));
    register_block_style('core/cover', array(
        'name' => 'stretch-cover',
        'label' => __('Stretch', 'lito'),
    ));
    register_block_style('core/button', array(
        'name' => 'text',
        'label' => __('Text', 'lito'),
    ));
    register_block_style('core/button', array(
        'name' => 'secondary',
        'label' => __('Secondary', 'lito'),
    ));
    register_block_style('core/list', array(
        'name' => 'clean-list',
        'label' => __('Clean', 'lito'),
    ));
}

add_filter( 'get_the_archive_title_prefix', 'lito_hide_archive_title' );
/**
 * Remove prefix from archive title.
 *
 * @since 1.0.0
 */
function lito_hide_archive_title( $prefix  ) {
    $is_archive_hide_title_prefix = lito_get_option('archive_hide_title_prefix');

    if (!$is_archive_hide_title_prefix) {
        return $prefix;
    }

    return '';
}

add_filter( 'lito_title', 'lito_show_term_siblings_in_title' );
/**
 * Show term siblings in title.
 *
 * @since 1.0.0
 */
function lito_show_term_siblings_in_title( $title ) {
    $is_archive_has_categories = lito_get_option('archive_has_categories');
    $is_archive_has_tags = lito_get_option('archive_has_tags');

    if (!$is_archive_has_categories && !$is_archive_has_tags) {
        return $title;
    }

    if (!is_category() && !is_tag() && !is_tax()) {
        return $title;
    }

    $before_title = apply_filters('lito_title_before', '<h1 class="entry-title">');
    $after_title = apply_filters('lito_title_after', '</h1>');
    $args = array();
    $term = get_queried_object();
    $term_id = $term->term_id;

    if (is_category()) {
        $args = array(
            'taxonomy' => 'category',
            'parent' => $term->parent,
            'hide_empty' => false,
        );

    } elseif (is_tag()) {
        $args = array(
            'taxonomy' => 'post_tag',
            'hide_empty' => false,
        );
    } elseif (is_tax()) {
        $args = array(
            'taxonomy' => $term->taxonomy,
            'parent' => $term->parent,
            'hide_empty' => false,
        );
    }

    $args = apply_filters('lito_term_siblings_args', $args);
    $siblings = get_terms( $args );
    
    if (is_wp_error($siblings) || empty($siblings)) {
        return $title;
    }

    $title = ' <ul class="term-siblings">';

    foreach ($siblings as $sibling) {
        if ($sibling->term_id !== $term_id) {
            $title .= '<li><a href="' . get_category_link( $sibling->term_id ) . '">' . $sibling->name . '</a></li>';
        } else {
            $title .= '<li class="current-cat">' . $before_title . $sibling->name . $after_title . '</li>';
        }
    }

    $title .= '</ul>';

    return $title;
}

if (!function_exists('lito_enqueue_global_styles_custom_css_fix')) {
    add_action( 'wp_enqueue_scripts', 'lito_enqueue_global_styles_custom_css_fix' );
    /**
     * Enqueue global styles custom CSS fix.
     * @see https://github.com/WordPress/gutenberg/issues/52644 
     *
     * @since 1.0.0
     */
    function lito_enqueue_global_styles_custom_css_fix() {
        if ( ! wp_is_block_theme() && ! wp_theme_has_theme_json() ) {
            return;
        }

        // Don't enqueue Customizer's custom CSS separately.
        remove_action( 'wp_head', 'wp_custom_css_cb', 101 );

        $custom_css  = wp_get_custom_css();
        $custom_css .= wp_get_global_stylesheet();

        if ( ! empty( $custom_css ) ) {
            wp_add_inline_style( 'global-styles', $custom_css );
        }
    }
}

if (!function_exists('lito_include_sticky_posts')) {
    add_action( 'pre_get_posts', 'lito_include_sticky_posts', 10, 1 );
    /**
     * Include sticky posts in the loop
     * 
     * @see https://wordpress.stackexchange.com/a/183620/186146
     * @see https://wordpress.org/support/topic/create-a-wp_query-with-category-and-sticky-posts/ 
     */
    function lito_include_sticky_posts ( $q ) {
        $is_include_sticky_posts = lito_get_option('archive_include_sticky_posts');

        if (  $is_include_sticky_posts && !is_admin()
            && $q->is_main_query()
            && is_archive()
        ) {

            $q->set( 'post__not_in', get_option( 'sticky_posts' ) );

            if ( !$q->is_paged() ) {
                add_filter( 'the_posts', function ( $posts ) {
                    $qobj = get_queried_object();
                    $stickies = get_posts( 
                        array(
                            'post__in' => get_option( 'sticky_posts' ), 
                            'nopaging' => true,
                            'tax_query' => array(
                                array(
                                    'taxonomy' => $qobj->taxonomy,
                                    'field' => 'term_id',
                                    'terms' => $qobj->term_id,
                                )
                            )
                        ) 
                    );

                    $posts = array_merge( $stickies, $posts );

                    return $posts;

                }, 10, 2);
            }
        }
    }
}

if ( function_exists( 'register_block_pattern_category' ) ) {
    add_action( 'init', 'lito_register_block_pattern_category' );
    function lito_register_block_pattern_category() {
        register_block_pattern_category(
            'lito',
            array(
                'label' => __( 'Lito', 'lito' ),
                'description' => __( 'Lito theme block patterns', 'lito' ),
            )
        );
    }
}

require_once get_template_directory() . '/inc/theme-functions.php';
require_once get_template_directory() . '/inc/class-typography.php';
require_once get_template_directory() . '/inc/layout.php';
require_once get_template_directory() . '/inc/customizer.php';
require_once get_template_directory() . '/inc/inline-styles.php';
require_once get_template_directory() . '/inc/demo.php';