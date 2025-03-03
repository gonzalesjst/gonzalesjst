<?php
/**
 * Theme functions
 *
 * Please do not make any edits to this file. All edits should be done in a child theme.
 *
 * @package Lito
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}


/**
 * Get default options.
 * 
 * @return string || false
 * @since 1.0.0
 */
function lito_get_option( $option_name ) {
    $defaults = lito_get_defaults();

	if ( ! isset( $defaults[ $option_name ] ) ) {
		return false;
	}

    $options = wp_parse_args(
		get_theme_mod( 'lito_options', array() ),
		$defaults
	);

    if ( strpos( $option_name, 'typo_' ) !== false && isset( $options[ $option_name ] ) ) {
        $typo = json_decode( $options[ $option_name ], true );
        $typo_defaults = json_decode( $defaults[ $option_name ], true );

        $typo = wp_parse_args( $typo, $typo_defaults );

        return json_encode( $typo );
    }

    if ( isset( $options[ $option_name ] ) ) {
        return $options[ $option_name ];
    }

    return false;
}

/**
 * Get default values for options
 * 
 * @return array
 * @since 1.0.0
 */
function lito_get_defaults() {
    $defaults = array(
        'excerpt_length' => 25,
		'header_type' => 'header_1',
		'header_layout' => 'full_width',
		'header_is_sticky' => '1',
		'header_is_hide_on_scroll' => '1',
		'header_has_search' => '1',
        'footer_layout' => 'full_width',
        'footer_cols' => '4',
        'footer_has_copyright' => '1',
        'archive_type' => 'cover',
        'archive_layout' => 'full_width',
        'archive_cols' => '4',
        'archive_grid' => 'masonry',
        'archive_header' => 'modern',
        'archive_has_breadcrumbs' => '1',
        'archive_has_excerpt' => '1',
        'archive_has_read_more' => '1',
        'archive_has_author' => '1',
        'archive_has_date' => '1',
        'archive_has_tags' => '1',
        'archive_has_categories' => '1',
        'archive_hide_title_prefix' => '1',
        'archive_include_sticky_posts' => '1',
        'archive_sidebar' => 'none',
        'archive_sidebar_sticky' => '1',
        'archive_show_featured_video' => '1',
        'archive_show_featured_gallery' => '1',
        'archive_show_featured_audio' => '1',
        'single_post_layout' => 'full_width',
        'single_post_header' => 'default',
        'single_post_has_breadcrumbs' => '1',
        'single_post_has_author' => '1',
        'single_post_has_date' => '1',
        'single_post_has_tags' => '1',
        'single_post_has_categories' => '1',
        'single_post_has_posts_nav' => '1',
        'single_post_sidebar' => 'none',
        'single_post_sidebar_sticky' => '1',

        'single_page_layout' => 'full_width',
        'single_page_header' => 'cover',
        'single_page_has_breadcrumbs' => '1',
        'single_page_sidebar' => 'none',
        'single_page_sidebar_sticky' => '1',

        'color_primary' => '#0000a3',
        'color_primary_hover' => '#0067b3',
        'color_primary_contrast' => '#ffffff',
        'color_secondary' => '#ffd53d',
        'color_secondary_hover' => '#ffc700',
        'color_secondary_contrast' => '#0067b3',
        'color_light' => '#FFFFFF',
        'color_background' => '#f6f6f6',
        'color_content_bg' => '#f0f1fa',
        'color_border' => '#c4caf1',
        'color_header_menu_item' => '#000',
        'color_header_menu_item_hover' => '#0067b3',
        'color_header_bg' => '#f6f6f6',
        'color_footer_bg' => '#f6f6f6',
        'color_footer_text' => '#141619',
        'color_text' => '#141619',
        'color_text_secondary' => '#5e5e5e',
        'color_heading' => '#0b0c10',
        'color_outline' => '#0000a3',
        'typo_body' => '{"font":"DM Sans","weight":"regular","transform":"none","size":"1","size_max":"1.25","line_height":"120%","letter_spacing":""}',
        'typo_header' => '{"font":"Darker Grotesque","weight":"600","transform":"uppercase","size":"1.25","size_max":"1.5","line_height":"120%","letter_spacing":""}',
        'typo_h1' => '{"font":"Darker Grotesque","weight":"900","transform":"none","size":"5","size_max":"6","line_height":"100%","letter_spacing":""}',
        'typo_h2' => '{"font":"Darker Grotesque","weight":"600","transform":"none","size":"4","size_max":"4.75","line_height":"100%","letter_spacing":""}',
        'typo_h3' => '{"font":"Darker Grotesque","weight":"600","transform":"none","size":"2.75","size_max":"3.5","line_height":"100%","letter_spacing":""}',
        'typo_h4' => '{"font":"Darker Grotesque","weight":"600","transform":"none","size":"2","size_max":"2.5","line_height":"100%","letter_spacing":""}',
        'typo_h5' => '{"font":"Darker Grotesque","weight":"600","transform":"none","size":"1.5","size_max":"1.75","line_height":"100%","letter_spacing":""}',
        'typo_h6' => '{"font":"Darker Grotesque","weight":"600","transform":"none","size":"1.25","size_max":"1.25","line_height":"100%","letter_spacing":""}',
        'smooth_scroll' => '1',
        'content_width' => apply_filters( 'lito_width_content', '50' ),
        'container_width' => apply_filters( 'lito_width_container', '70' ),
        'width_units' => apply_filters( 'lito_width_units', 'rem' ),
    );

    return apply_filters( 'lito_get_defaults', $defaults );
}

/**
 * Get post layout.
 *
 * @since 1.0.0
 */
function lito_get_post_layout() {
    $layout = lito_get_option('post_layout') ?: 'cover';

    return $layout;
}

/**
 * Check if show post excerpt.
 * 
 * @since 1.0.0
 * @return bool
 */
function lito_is_show_post_excerpt() {
    $is_show_excerpt = lito_get_option('archive_has_excerpt');
    $post_layout = lito_get_post_layout();

    return apply_filters('lito_is_show_post_excerpt', $is_show_excerpt);
}

/**
 * Check if show post read more.
 * 
 * @since 1.0.0
 * @return bool
 */
function lito_is_show_post_read_more() {
    $is_show_read_more = lito_get_option('archive_has_read_more');
    $post_layout = lito_get_post_layout();

    return apply_filters('lito_is_show_post_read_more', $is_show_read_more);
}


/**
 * Check if archive grid is masonry
 * 
 * @since 1.0.0
 * @return bool
 */
function lito_is_masonry_archive() {
    $archive_grid = lito_get_option('archive_grid');
    $is_masonry_archive = false;

    if ($archive_grid === 'masonry') {
        $is_masonry_archive = true;
    }

    return apply_filters('lito_is_masonry_archive', $is_masonry_archive);
}

/**
 * Check if archive grid is sticky
 * 
 * @since 1.0.0
 * @return bool
 */
function lito_is_sticky_archive() {
    $archive_grid = lito_get_option('archive_grid');
    $is_sticky_archive = false;

    if ($archive_grid === 'sticky') {
        $is_sticky_archive = true;
    }

    return apply_filters('lito_is_sticky_archive', $is_sticky_archive);
}

/**
 * Checks if post has featured media
 * 
 * @since 1.0.0
 * @return bool
 */
function lito_has_featured_media() {
    $echo = false;
    $has_featured_media = true;
    if ( empty(lito_featured_gallery($echo)) && empty(lito_featured_video($echo)) && empty(lito_featured_audio($echo)) && empty(lito_featured_image($echo)) ){
        $has_featured_media = false;
    }
    return apply_filters('lito_has_featured_media', $has_featured_media);
}

/**
 * Checks if breadcrumbs should be shown
 * 
 * @since 1.0.0
 * @return bool
 */
function lito_is_show_breadcrumbs() {
    $is_archive_has_breadcrumbs = lito_get_option('archive_has_breadcrumbs');
    $is_single_post_has_breadcrumbs = lito_get_option('single_post_has_breadcrumbs');
    $is_single_page_has_breadcrumbs = lito_get_option('single_page_has_breadcrumbs');
    $is_show_breadcrumbs = false;

    if ((is_archive() || is_home()) && $is_archive_has_breadcrumbs) {
        $is_show_breadcrumbs = true;
    }

    if (is_single() && $is_single_post_has_breadcrumbs) {
        $is_show_breadcrumbs = true;
    }

    if (is_page() && $is_single_page_has_breadcrumbs) {
        $is_show_breadcrumbs = true;
    }

    return apply_filters('lito_is_show_breadcrumbs', $is_show_breadcrumbs);
}

/**
 * Checks if sticky post is in sticky grid
 * 
 * @since 1.0.0
 * @return bool
 */
function lito_is_sticky_post_in_sticky_grid() {
    $is_sticky_post_in_sticky_grid = false;

    if (!is_archive() && !is_search() && !is_home()) {
        return false;
    }
    
    global $wp_query;
    if (lito_is_sticky_archive()) {
        $is_include_sticky_posts = lito_get_option('archive_include_sticky_posts');
        $sticky_posts = get_option( 'sticky_posts' );
        $is_sticky_posts_belong_to_query = array_intersect($sticky_posts, wp_list_pluck($wp_query->posts, 'ID'));

        if ( $is_include_sticky_posts && $sticky_posts && $is_sticky_posts_belong_to_query && ( is_archive() || is_search() || is_home() ) ) {
            $sticky_posts = is_serialized($sticky_posts) ? unserialize($sticky_posts) : $sticky_posts;
            $sticky_posts_count = count($sticky_posts);

            if ( $wp_query->current_post <= $sticky_posts_count - 1 ) {
                $is_sticky_post_in_sticky_grid = true;
            }
        } elseif ( $wp_query->current_post === 0 ) {
            $is_sticky_post_in_sticky_grid = true;
        }
    }

    return apply_filters('lito_is_sticky_post_in_sticky_grid', $is_sticky_post_in_sticky_grid);
}


/**
 * Generates classes for header
 * 
 * @since 1.0.0
 * @return string
 */
function lito_header_classes() {
    $header_type = lito_get_option('header_type');
    $header_is_sticky = lito_get_option('header_is_sticky');
    $header_is_hide_on_scroll = lito_get_option('header_is_hide_on_scroll');
    $header_classes = array('site-header');

    if ($header_type == 'header_1') {
        $header_classes[] = 'header-1';
    } elseif ($header_type == 'header_2') {
        $header_classes[] = 'header-2';
    }

    if ($header_is_sticky) {
        $header_classes[] = 'is-sticky';
    }

    if ($header_is_hide_on_scroll) {
        $header_classes[] = 'hide-on-scroll';
    }

    $header_classes = apply_filters('lito_header_classes', $header_classes);

    return implode(' ', $header_classes);
}

/**
 * Generates classes for footer
 * 
 * @since 1.0.0
 * @return string
 */
function lito_footer_classes() {
    $footer_cols = lito_get_footer_cols_number();
    $footer_has_copyright = lito_get_option('footer_has_copyright');
    $footer_classes = array('site-footer');

    $footer_classes[] = 'footer-1';

    $footer_classes[] = 'footer-cols-'.$footer_cols;

    if ($footer_has_copyright){
        $footer_classes[] = 'has-copyright';
    }

    $footer_classes = apply_filters('lito_footer_classes', $footer_classes);

    return implode(' ', $footer_classes);
}

/**
 * Generates classes for main content section
 * 
 * @since 1.0.0
 * @return string
 */
function lito_content_classes() {
    $content_classes = array('site-content');

    if (is_archive() || is_search() || is_home()) {
        $archive_grid = lito_get_option('archive_grid');
        $archive_cols = lito_get_option('archive_cols');
        $archive_sidebar = lito_get_option('archive_sidebar');
        $archive_type = lito_get_option('archive_type');

        
        $content_classes[] = 'site-content--'.$archive_grid;
        
        $content_classes[] = 'site-content--'.$archive_type;

        if ($archive_sidebar !== 'none') {
            $content_classes[] = 'has-sidebar';
            $content_classes[] = 'archive-sidebar-'.$archive_sidebar;
        }

        if ($archive_grid !== 'sticky') {
            $content_classes[] = 'site-content--'.$archive_cols.'-cols';
        }
    }

    if (is_single()) {
        $single_post_layout = lito_get_option('single_post_layout');
        $single_post_sidebar = lito_get_option('single_post_sidebar');

        $content_classes[] = 'site-content--'.$single_post_layout;

        if ($single_post_sidebar !== 'none') {
            $content_classes[] = 'has-sidebar';
            $content_classes[] = 'single-sidebar-'.$single_post_sidebar;
        }

    }

    if (is_page()) {
        $single_page_layout = lito_get_option('single_page_layout');
        $single_page_sidebar = lito_get_option('single_page_sidebar');

        $content_classes[] = 'site-content--'.$single_page_layout;

        if ($single_page_sidebar !== 'none' && !is_front_page()) {
            $content_classes[] = 'has-sidebar';
            $content_classes[] = 'single-sidebar-'.$single_page_sidebar;
        }

    }

    $content_classes = apply_filters('lito_content_classes', $content_classes);

    return implode(' ', $content_classes);
}

/**
 * Generates classes for sidebar
 * 
 * @since 1.0.0
 * @param string $sidebar - sidebar position
 * @return string
 */
function lito_sidebar_classes($sidebar) {
    $sidebar_classes = array('sidebar');
    $archive_sidebar_sticky = lito_get_option('archive_sidebar_sticky');
    $single_post_sidebar_sticky = lito_get_option('single_post_sidebar_sticky');
    $single_page_sidebar_sticky = lito_get_option('single_page_sidebar_sticky');


    if ($sidebar === 'left') {
        $sidebar_classes[] = 'sidebar--left';
    } elseif ($sidebar === 'right') {
        $sidebar_classes[] = 'sidebar--right';
    }

    if ( (is_archive() || is_search() || is_home()) && $archive_sidebar_sticky) {
        $sidebar_classes[] = 'is-sticky';
    }

    if (is_single() && $single_post_sidebar_sticky) {
        $sidebar_classes[] = 'is-sticky';
    }

    if (is_page() && $single_page_sidebar_sticky) {
        $sidebar_classes[] = 'is-sticky';
    }

    $sidebar_classes = apply_filters('lito_sidebar_classes', $sidebar_classes, $sidebar);

    return implode(' ', $sidebar_classes);
}

/**
 * Generates classes for main content container
 * 
 * @since 1.0.0
 * @return string
 */
function lito_container_classes() {
    $container_classes = array();

    if (is_archive() || is_search() || is_home()) {
        $archive_layout = lito_get_option('archive_layout');
        $container_classes[] = $archive_layout === 'container' ? 'container' : 'container-full';
    }

    if (is_single()) {
        $single_post_layout = lito_get_option('single_post_layout');
        $container_classes[] = $single_post_layout === 'container' ? 'container' : 'container-full';
    }

    if (is_page()) {
        $page_layout = lito_get_option('single_page_layout');
        $container_classes[] = $page_layout === 'container' ? 'container' : 'container-full';
    }
    
    $container_classes = apply_filters('lito_container_classes', $container_classes);

    return implode(' ', $container_classes);
}

/**
 * Generates classes for archive header
 * 
 * @since 1.0.0
 * @return string
 */
function lito_archive_header_classes() {
    $header_type = lito_get_option('archive_header');
    $header_classes = array('archive-header');

    $header_classes[] = 'archive-header--'.$header_type;

    if (is_search()) {
        $header_classes[] = 'archive-header--search';
    }

    $header_classes = apply_filters('lito_archive_header_classes', $header_classes);

    return implode(' ', $header_classes);
}

/**
 * Generates classes for single header
 * 
 * @since 1.0.0
 * @return string
 */
function lito_single_header_classes() {
    $single_header_type = '';
    if (is_single()) {
        $single_header_type = lito_get_option('single_post_header');
    }
    if (is_page()) {
        $single_header_type = lito_get_option('single_page_header');
    }
    $header_classes = array('entry-header');

    $header_classes[] = 'is-'.$single_header_type.'-post';

    if (!lito_has_featured_media()) {
        $header_classes[] = 'no-featured-media';
    }
    $header_classes[] = 'post_format-post-format-'.get_post_format();

    $header_classes = apply_filters('lito_single_header_classes', $header_classes);

    return implode(' ', $header_classes);
}

add_filter('body_class', 'lito_body_classes');
/**
 * Adds custom classes to the array of body classes.
 * 
 * @since 1.0.0
 * @param array $classes Default Classes for the body element.
 * @return array
 */
function lito_body_classes($classes) {
    $archive_grid = lito_get_option('archive_grid');
    $archive_cols = lito_get_option('archive_cols');
    $archive_layout = lito_get_option('archive_layout');
    $archive_sidebar = lito_get_option('archive_sidebar');
    $body_classes = array();

    $body_classes[] = 'archive-grid-'.$archive_grid;
    $body_classes[] = 'archive-cols-'.$archive_cols;
    $body_classes[] = 'archive-layout-'.$archive_layout;
    $body_classes[] = 'archive-sidebar-'.$archive_sidebar;

    if (!lito_has_featured_media()) {
        $body_classes[] = 'no-featured-media';
    }

    $body_classes = apply_filters('lito_body_classes', $body_classes);

    return array_merge($classes, $body_classes);
}