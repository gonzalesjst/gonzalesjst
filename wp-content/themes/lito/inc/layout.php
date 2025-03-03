<?php
/**
 * Build layout components
 *
 * Please do not make any edits to this file. All edits should be done in a child theme.
 *
 * @package Lito
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (!function_exists('lito_header')) {
    add_action('lito_header', 'lito_header', 10);
    /**
     * Builds Theme Header
     *
     * @since 1.0.0
     */
    function lito_header() {
        $header_type = lito_get_option('header_type');
        $header_layout = lito_get_option('header_layout');
        $header_layout_class = $header_layout === 'container' ? 'container' : 'container-full';
        ?>

        <div class="<?php echo esc_attr($header_layout_class); ?>">
            <div class="site-header__inner">

            <?php
            switch ($header_type) {
                case 'header_1':
                    get_template_part('template-parts/header/header', '1');
                    break;
                case 'header_2':
                    get_template_part('template-parts/header/header', '2');
                    break;
                default:
                    get_template_part('template-parts/header/header', '1');
            }
            ?>

            </div><!-- .site-header__inner -->
        </div>

        <?php
    }
}

if (! function_exists('lito_header_menu')) {
    /**
     * Displays header menu
     *
     * @since 1.0.0
     */
    function lito_header_menu() {
        if (has_nav_menu('primary')) {
            ?>
            <nav id="site-navigation" class="navigation main-navigation">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'primary',
                        'menu_id' => 'primary-menu',
                        'container' => false,
                        'fallback_cb' => false,
                    )
                );
                ?>
                <button class="menu-toggle">
                    <span class="screen-reader-text"><?php esc_html_e('Menu', 'lito'); ?></span>
                </button>
                <?php echo apply_filters( 'lito_menu_separator', '<span class="menu-separator"></span>', 'primary' ); ?>
            </nav><!-- #site-navigation -->
            <?php
        }
    }
}

if (! function_exists('lito_social_menu')) {
    /**
     * Displays social menu
     *
     * @since 1.0.0
     */
    function lito_social_menu() {
        if (has_nav_menu('social')) {
            ?>
            <nav id="social-navigation" class="navigation social-navigation">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'social',
                        'menu_id' => 'social-menu',
                        'container' => false,
                        'fallback_cb' => false,
                        'depth' => 1,
                    )
                );
                ?>
                <?php 
                $header_has_search = lito_get_option('header_has_search');
                if ($header_has_search) {
                    echo apply_filters( 'lito_menu_separator', '<span class="menu-separator"></span>', 'social' ); 
                }
                ?>
            </nav><!-- #social-navigation -->
            <?php
        }
    }
}

if (! function_exists('lito_mobile_menu')) {
    add_action( 'lito_after_header', 'lito_mobile_menu', 10 );
    /**
     * Displays mobile menu
     *
     * @since 1.0.0
     */
    function lito_mobile_menu() {
        if (has_nav_menu('primary') || has_nav_menu('social')) {
            ?>
            <section id="site-mobile-menu" class="site-mobile-menu">
                <div class="site-mobile-menu__inner">
                    <nav id="mobile-navigation" class="navigation mobile-navigation" data-lenis-prevent>
                        <?php
                        wp_nav_menu(
                            array(
                                'theme_location' => 'primary',
                                'menu_id' => 'primary-mobile-menu',
                                'menu_class' => 'menu primary-mobile-menu',
                                'container' => false,
                                'fallback_cb' => false,
                            )
                        );
                        wp_nav_menu(
                            array(
                                'theme_location' => 'social',
                                'menu_id' => 'social-mobile-menu',
                                'menu_class' => 'menu social-mobile-menu',
                                'container' => false,
                                'fallback_cb' => false,
                                'depth' => 1,
                            )
                        );
                        ?>
                    </nav><!-- #mobile-navigation -->
                </div>
            </section><!-- #site-mobile-menu -->
            <?php
        }
    }

}

if (! function_exists('lito_header_search')) {
    /**
     * Displays search bar
     *
     * @since 1.0.0
     */
    function lito_header_search() {
        $header_has_search = lito_get_option('header_has_search');
        if (!$header_has_search) {
            return;
        }
        ?>
        <div class="header-search">
            <button class="header-search__toggle" aria-expanded="false">
                <span class="screen-reader-text"><?php esc_html_e('Search open', 'lito'); ?></span>
            </button>
            <div class="header-search__form">
                <?php echo get_search_form(); ?>
                <button class="header-search__toggle" aria-expanded="false">
                    <span class="screen-reader-text"><?php esc_html_e('Search close', 'lito'); ?></span>
                </button>
            </div>
        </div>
        <?php
    }
}

if ( ! function_exists( 'lito_custom_logo' ) ) {
    /**
     * Displays the optional custom logo.
     *
     * Does nothing if the custom logo is not available.
     *
     * @since 1.0.0
     */
    function lito_custom_logo() {
        if ( function_exists( 'the_custom_logo' ) ) {
            if ( has_custom_logo() ) {
                echo apply_filters('lito_custom_logo', get_custom_logo());
            } else {
                $logo = '';
                if ( is_front_page() ) {
                    $logo .=  '<span class="custom-logo-link"><span class="custom-logo-title">' . get_bloginfo( 'name' ) . '</span></span>';
                } else {
                    $logo .= '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home" class="custom-logo-link"><span class="custom-logo-title">' . get_bloginfo( 'name' ) . '</span></a>';
                }

                echo apply_filters('lito_custom_logo', $logo); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            }
        }
    }
}

if (!function_exists('lito_footer')) {
    add_action('lito_footer', 'lito_footer', 10);
    /**
     * Builds Theme footer
     *
     * @since 1.0.0
     */
    function lito_footer() {
        $footer_layout = lito_get_option('footer_layout');
        $footer_layout_class = $footer_layout === 'container' ? 'container' : 'container-full';

        $footer_layout_class = apply_filters('lito_footer_layout_class', $footer_layout_class);
        ?>

        <div class="<?php echo esc_attr($footer_layout_class); ?>">
            <div class="site-footer__inner">
                <?php get_template_part('template-parts/footer/footer', '1'); ?>
            </div><!-- .site-footer__inner -->
            <?php lito_copyright(); ?>
        </div>

        <?php
    }
}

if ( !function_exists('lito_post_entry_footer_open_tag') ) {
    add_action('lito_loop_footer', 'lito_post_entry_footer_open_tag', 5);
    add_action('lito_entry_footer', 'lito_post_entry_footer_open_tag', 5);
    /**
     * Displays opening footer tag for post entry
     *
     * @since 1.0.0
     */
    function lito_post_entry_footer_open_tag() {
        if (is_page()) {
            return;
        }
        $footer_classes = array('entry-footer');
        $footer_classes = apply_filters('lito_post_entry_footer_classes', $footer_classes);
        ?>
        <footer class="<?php echo esc_attr(implode(' ', $footer_classes)); ?>">
        <?php
    }
}

if ( !function_exists('lito_post_entry_footer_close_tag') ) {
    add_action('lito_loop_footer', 'lito_post_entry_footer_close_tag', 100);
    add_action('lito_entry_footer', 'lito_post_entry_footer_close_tag', 100);
    /**
     * Displays closing footer tag for post entry
     *
     * @since 1.0.0
     */
    function lito_post_entry_footer_close_tag() {
        if (is_page()) {
            return;
        }
        ?>
        </footer>
        <?php
    }
}

if (!function_exists('lito_copyright')) {
    /**
     * Displays footer copyright section
     *
     * @since 1.0.0
     */
    function lito_copyright() {
        $footer_has_copyright = lito_get_option('footer_has_copyright');

        if (!$footer_has_copyright){
            return;
        }
        ?>

        <section id="site-copyright" class="site-copyright">
            <div class="site-copyright__inner">

                <?php
                echo apply_filters('lito_copyright_separator', '<hr class="copyright-separator" />');

                if ( is_active_sidebar( 'copyright' ) ) {
                    dynamic_sidebar( 'copyright' );
                } else {
                    echo '<p>'.'&copy; ' . date('Y') . ' ' . get_bloginfo('name').'</p>';
                }
                ?>

            </div>
        </section>

        <?php
    }
}

/**
 * Returns max number of footer widgets
 *
 * @since 1.0.0
 * @return int
 */
function lito_get_footer_cols_number() {
    $footer_cols =  lito_get_option('footer_cols');
    return apply_filters('lito_get_footer_cols_number', (int) $footer_cols);
}

if (!function_exists('lito_wrap_tags_open')) {
    add_action('lito_before_loop', 'lito_wrap_tags_open', 10);
    add_action('lito_before_single', 'lito_wrap_tags_open', 10);
    /**
     * Displays opening wrap tags for content
     * 
     * @since 1.0.0
     */
    function lito_wrap_tags_open() {
        ?>
        <section class="wrap-content">
        <?php
    }
}

if (!function_exists('lito_wrap_tags_close')) {
    add_action('lito_after_loop', 'lito_wrap_tags_close', 40);
    add_action('lito_after_single', 'lito_wrap_tags_close', 40);
    /**
     * Displays closing wrap tags for content
     * 
     * @since 1.0.0
     */
    function lito_wrap_tags_close() {
        ?>
        </section> <!-- .wrap-content -->
        <?php
    }
}

if (!function_exists('lito_content_posts_tags_open')) {
    add_action('lito_before_loop', 'lito_content_posts_tags_open', 30);
    /**
     * Displays opening tags for content posts
     * 
     * @since 1.0.0
     */
    function lito_content_posts_tags_open() {
        ?>
        <section class="content-posts">
        <?php
    }
}

if (!function_exists('lito_content_posts_tags_close')) {
    add_action('lito_after_loop', 'lito_content_posts_tags_close', 10);
    /**
     * Displays closing tags for content posts
     * 
     * @since 1.0.0
     */
    function lito_content_posts_tags_close() {
        ?>
        </section> <!-- .content-posts -->
        <?php
    }
}

if (!function_exists('lito_content_area_tags_open')) {
    add_action('lito_before_loop', 'lito_content_area_tags_open', 25);
    add_action('lito_before_single', 'lito_content_area_tags_open', 25);
    add_action('lito_before_content_none', 'lito_content_area_tags_open', 25);
    /**
     * Displays opening tags for content area
     * 
     * @since 1.0.0
     */
    function lito_content_area_tags_open() {
        ?>
        <div id="primary" class="content-area">
        <?php
    }
}

if (!function_exists('lito_content_area_tags_close')) {
    add_action('lito_after_loop', 'lito_content_area_tags_close', 25);
    add_action('lito_after_single', 'lito_content_area_tags_close', 25);
    add_action('lito_after_content_none', 'lito_content_area_tags_close', 25);
    /**
     * Displays closing tags for content area
     * 
     * @since 1.0.0
     */
    function lito_content_area_tags_close() {
        ?>
        </div> <!-- #primary -->
        <?php
    }
}

if (!function_exists('lito_content_sticky_tags_open')) {
    add_action( 'lito_before_loop_post', 'lito_content_sticky_tags_open', 10 );
    /**
     * Displays opening tags for sticky posts
     * 
     * @since 1.0.0
     */
    function lito_content_sticky_tags_open() {
        if (!is_archive() && !is_search() && !is_home()) {
            return;
        }

        global $wp_query;
        if (lito_is_sticky_archive() && $wp_query->current_post === 0) {
            ?>
            <div class="content-posts__sticky">
            <?php
        }
    }
}

if (!function_exists('lito_content_sticky_tags_close')) {
    add_action( 'lito_after_loop_post', 'lito_content_sticky_tags_close', 10 );
    /**
     * Displays closing tags for sticky posts
     * 
     * @since 1.0.0
     */
    function lito_content_sticky_tags_close() {
        if (!is_archive() && !is_search() && !is_home()) {
            return;
        }
        
        global $wp_query;
        if (lito_is_sticky_archive()) {
            $is_include_sticky_posts = lito_get_option('archive_include_sticky_posts');
            $sticky_posts = get_option( 'sticky_posts' );
            $is_sticky_posts_belong_to_query = array_intersect($sticky_posts, wp_list_pluck($wp_query->posts, 'ID'));

            if ( $is_include_sticky_posts && $sticky_posts && $is_sticky_posts_belong_to_query && ( is_archive() || is_search() || is_home() ) ) {
                $sticky_posts = is_serialized($sticky_posts) ? unserialize($sticky_posts) : $sticky_posts;
                $sticky_posts_count = count($sticky_posts);

                if ( $wp_query->current_post === $sticky_posts_count - 1 ) {
                    ?>
                    </div> <!-- .content-posts__sticky -->
                    <div class="content-posts__not-sticky">
                    <?php
                }
                if ( $wp_query->current_post === $wp_query->post_count - 1 ) {
                    ?>
                    </div> <!-- .content-posts__not-sticky -->
                    <?php
                }
            } elseif ( $wp_query->current_post === 0 ) {
                ?>
                </div> <!-- .content-posts__sticky -->
                <div class="content-posts__not-sticky">
                <?php
            } elseif ( $wp_query->current_post === $wp_query->post_count - 1 ) {
                ?>
                </div> <!-- .content-posts__not-sticky -->
                <?php
            }
            if ($wp_query->post_count === 1) { // edge case when there is only one post
                ?>
                </div> <!-- .content-posts__not-sticky -->
                <?php
            }
        }
    }
}

if (!function_exists('lito_sidebar')) {
    add_action('lito_after_loop', 'lito_sidebar', 15);
    add_action('lito_after_single', 'lito_sidebar', 15);
    /**
     * Displays sidebars
     * 
     * @since 1.0.0
     */
    function lito_sidebar() {
        if (is_front_page()) {
            return;
        }
        $sidebar_position = 'left';

        if (is_archive() || is_search() || is_home()) {
            $sidebar_position = lito_get_option('archive_sidebar');
        }
        if (is_single()) {
            $sidebar_position = lito_get_option('single_post_sidebar');
        }
        if (is_page()) {
            $sidebar_position = lito_get_option('single_page_sidebar');
        }

        switch ($sidebar_position) {
            case 'left':
                get_sidebar();
                break;
            case 'right':
                get_sidebar('right');
                break;
            case 'both':
                get_sidebar();
                get_sidebar('right');
                break;
        }
    }
}

if (!function_exists('lito_post_meta')) {
    add_action('lito_entry_header', 'lito_post_meta', 10);
    add_action('lito_entry_footer', 'lito_post_meta', 10);
    add_action('lito_loop_header', 'lito_post_meta', 10);
    /**
     * Displays post meta
     * 
     * @since 1.0.0
     */
    function lito_post_meta() {
        $is_single_footer = false;
        $is_show_author = $is_show_date = false;

        if (is_single()) {
            $is_show_author = lito_get_option('single_post_has_author');
            $is_show_date = lito_get_option('single_post_has_date');
        }

        if (is_archive() || is_search() || is_home()) {
            $is_show_author = lito_get_option('archive_has_author');
            $is_show_date = lito_get_option('archive_has_date');
        }

        if ($is_show_author || $is_show_date) {
            ?>
            <div class="entry-meta">
                <?php
                if ($is_show_author) {
                    if (current_filter() === 'lito_entry_footer' && is_singular()) {
                        $is_single_footer = true;
                    }
                    lito_post_author($is_single_footer);
                }

                if ($is_show_date) {
                    lito_post_date();
                }
                ?>
            </div>
            <?php
        }
        
    }
}

if (!function_exists('lito_post_author')) {
    /**
     * Displays post author
     * 
     * @param bool $is_single_footer - if this block is in the single post footer
     * @since 1.0.0
     */
    function lito_post_author($is_single_footer = false) {
        $is_show_author_url = lito_get_option('show_author_url');
        $author_id = get_the_author_meta('ID');
        $author_name = get_the_author_meta('display_name');
        $author_url = get_author_posts_url($author_id);
        $author_bio = apply_filters('lito_author_bio', get_the_author_meta('description'));
        ?>
        <span class="entry-author <?php if (is_singular() && $author_bio && $is_single_footer) echo 'with-bio'; ?>">
            <span class="screen-reader-text"><?php esc_html_e('Author', 'lito'); ?></span>
            <?php if ($is_show_author_url) : ?><a href="<?php echo esc_url($author_url); ?>" rel="author"><?php endif; ?>
                <?php echo get_avatar($author_id, 96, '', $author_name); ?>
            <?php if ($is_show_author_url) : ?></a><?php endif; ?>
            <?php if ($is_show_author_url) : ?><a href="<?php echo esc_url($author_url); ?>" rel="author"><?php endif; ?>
                <span class="entry-author__inner">
                    <span class="author-name"><?php echo esc_html($author_name); ?></span>
                    <?php if (is_singular() && $author_bio && $is_single_footer) : ?>
                        <span class="author-bio"><?php echo esc_html($author_bio); ?></span>
                    <?php endif; ?>
                </span>
            <?php if ($is_show_author_url) : ?></a><?php endif; ?>
        </span>
        <?php
    }
}

if (!function_exists('lito_post_date')) {
    /**
     * Displays post date
     * 
     * @since 1.0.0
     */
    function lito_post_date() {
        $is_show_date_url = apply_filters('lito_is_show_date_url', false);
        $post_date = get_the_date();
        $archive_year  = get_the_time('Y'); 
        $archive_month = get_the_time('m'); 
        $archive_day   = get_the_time('d'); 
        $date_url = get_day_link( $archive_year, $archive_month, $archive_day);
        ?>
        <span class="entry-date">
            <span class="screen-reader-text"><?php esc_html_e('Posted on', 'lito'); ?></span>
            <?php if ($is_show_date_url) : ?><a href="<?php echo esc_url($date_url); ?>" rel="bookmark"><?php endif; ?>
                <?php echo esc_html($post_date); ?>
            <?php if ($is_show_date_url) : ?></a><?php endif; ?>
        </span>
        <?php
    }
}

if (!function_exists('lito_post_tax')) {
    add_action('lito_entry_footer', 'lito_post_tax', 20);
    add_action('lito_entry_header', 'lito_post_tax', 30);
    add_action('lito_loop_footer', 'lito_post_tax', 10);
    /**
     * Displays post taxonomies
     * 
     * @since 1.0.0
     */
    function lito_post_tax() {
        $is_show_categories = $is_show_tags = false;

        if (is_archive() || is_search() || is_home()) {
            $is_show_categories = lito_get_option('archive_has_categories');
            $is_show_tags = lito_get_option('archive_has_tags');
        }

        if (is_single()) {
            $is_show_categories = lito_get_option('single_post_has_categories');
            $is_show_tags = lito_get_option('single_post_has_tags');
        }

        if ( ($is_show_categories || $is_show_tags) && (has_category() || has_tag()) ){
            ?>
            <div class="entry-tax">
                <?php
                if ($is_show_categories && has_category()) {
                    lito_post_categories();
                }

                if ($is_show_tags && has_tag()) {
                    lito_post_tags();
                }
                ?>
            </div>
            <?php
        }
    }
}

if (!function_exists('lito_post_categories')) {
    /**
     * Displays post categories
     * 
     * @since 1.0.0
     */
    function lito_post_categories() {
        $is_show_categories = lito_get_option('show_categories') ?: true ;
        if ($is_show_categories) {
            ?>
            <div class="entry-categories">
                <span class="screen-reader-text"><?php esc_html_e('Categories', 'lito'); ?></span>
                <?php the_category(', '); ?>
            </div>
            <?php
        }
    }
}

if (!function_exists('lito_post_tags')) {
    /**
     * Displays post tags
     * 
     * @since 1.0.0
     */
    function lito_post_tags() {
        $is_show_tags = lito_get_option('show_tags') ?: true ;
        if ($is_show_tags) {
            ?>
            <div class="entry-tags">
                <span class="screen-reader-text"><?php esc_html_e('Tags', 'lito'); ?></span>
                <?php the_tags('', ', '); ?>
            </div>
            <?php
        }
    }
}

if (!function_exists('lito_post_comments')) {
    /**
     * Displays post comments
     * 
     * @since 1.0.0
     */
    function lito_post_comments() {
        $is_show_comments = lito_get_option('show_comments') ?: true ;
        if ($is_show_comments) {
            ?>
            <div class="entry-comments">
                <span class="screen-reader-text"><?php esc_html_e('Comments', 'lito'); ?></span>
                <?php comments_popup_link(esc_html__('Leave a comment', 'lito'), esc_html__('1 Comment', 'lito'), esc_html__('% Comments', 'lito')); ?>
            </div>
            <?php
        }
    }
}

if (!function_exists('lito_post_edit_link')) {
    add_action('lito_loop_footer', 'lito_post_edit_link', 99);
    /**
     * Displays post edit link
     * 
     * @since 1.0.0
     */
    function lito_post_edit_link() {
        if ( current_user_can('edit_posts') && !is_customize_preview() ) {
            ?>
            <div class="entry-edit-link">
                <?php edit_post_link(esc_html__('Edit', 'lito')); ?>
            </div>
            <?php
        }
    }
}

if (!function_exists('lito_archive_header')) {
    add_action( 'lito_before_loop', 'lito_archive_header', 5 );
    add_action( 'lito_before_content_none', 'lito_archive_header', 5 );
    /**
     * Displays archive header
     * 
     * @since 1.0.0
     */
    function lito_archive_header() {
        if (is_front_page()) {
            return; 
        }
        if (!is_archive() && !is_search() && !is_home()) {
            return;
        }

        $header_type = lito_get_option('archive_header') ?: 'default';
        $is_show_description = lito_get_option('show_archive_description') ?: true ;
        ?>
        <header class="<?php echo esc_attr(lito_archive_header_classes()); ?>">
            <?php
            if ($header_type === 'cover') {
                $header_thumb = get_term_meta(get_queried_object_id(), 'lito_archive_header_thumb', true);
                if ($header_thumb) {
                    ?>
                    <div class="archive-header__cover">
                        <img src="<?php echo esc_url($header_thumb); ?>" alt="<?php echo esc_attr(get_queried_object()->name); ?>">
                    </div>
                    <?php
                }
            }
            ?>
            <div class="archive-header__inner">
                <?php

                lito_breadcrumbs();

                lito_title();

                if ($is_show_description) {
                    lito_archive_description();
                }
                if (is_search()) {
                    echo get_search_form();
                }
                ?>
            </div>
        </header>
        <?php
    }
}

if (!function_exists('lito_single_header')) {
    add_action( 'lito_before_single', 'lito_single_header', 20 );
    /**
     * Displays header on a single post/page
     * 
     * @since 1.0.0
     */
    function lito_single_header() {
        if (!is_singular() || is_front_page()) {
            return;
        }
        ?>
        <header class="<?php echo esc_attr(lito_single_header_classes()); ?>">
            
            <?php
            /**
             * lito_entry_header hook.
             * 
             * @hooked lito_featured_media - 1
             * @hooked lito_entry_header_inner_open_tags - 5
             * @hooked lito_breadcrumbs - 5
             * @hooked lito_post_meta - 10
             * @hooked lito_title - 20
             * @hooked lito_post_tax - 30
             * @hooked lito_entry_header_inner_close_tags - 99
             *
             * @since 1.0
             */
            do_action( 'lito_entry_header' );
            ?>

        </header>
        <?php
    }
}

if (!function_exists('lito_entry_header_inner_open_tags')) {
    add_action('lito_entry_header', 'lito_entry_header_inner_open_tags', 5);
    /**
     * Displays opening tags for entry header
     * 
     * @since 1.0.0
     */
    function lito_entry_header_inner_open_tags() {
        $entry_header_classes = array('entry-header__inner', 'container');
        $is_show_breadcrumbs = lito_is_show_breadcrumbs();
        if (!$is_show_breadcrumbs) {
            $entry_header_classes[] = 'no-breadcrumbs';
        }
        $entry_header_classes = apply_filters('lito_entry_header_inner_classes', $entry_header_classes);
        ?>
        <div class="<?php echo esc_attr(implode(' ', $entry_header_classes)); ?>">
        <?php
    }
}

if (!function_exists('lito_entry_header_inner_close_tags')) {
    add_action('lito_entry_header', 'lito_entry_header_inner_close_tags', 99);
    /**
     * Displays closing tags for entry header
     * 
     * @since 1.0.0
     */
    function lito_entry_header_inner_close_tags() {
        ?>
        </div>
        <?php
    }
}

if (!function_exists('lito_breadcrumbs')) {
    add_action('lito_entry_header', 'lito_breadcrumbs', 5);
    /**
     * Displays breadcrumbs
     * 
     * @since 1.0.0
     */
    function lito_breadcrumbs() {        
        if (lito_is_show_breadcrumbs() && function_exists('yoast_breadcrumb')) {
            yoast_breadcrumb('<div class="breadcrumbs">', '</div>');
        }
    }
}

if (!function_exists('lito_title')) {
    add_action('lito_entry_header', 'lito_title', 20);
    /**
     * Displays title
     * 
     * @since 1.0.0
     */
    function lito_title() {
        if (is_front_page() && get_option('show_on_front') === 'page') {
            return; // do not display title on the STATIC front page 
        }

        if (is_home() && get_option('show_on_front') === 'page') { // blog page
            $title = get_the_title(get_option('page_for_posts', true));
        } elseif (is_front_page() && get_option('show_on_front') === 'posts') { // main site page with "Your latest posts" on front page
            $title = __('Your Latest Posts', 'lito');
        } elseif (is_archive()) {
            $title = get_the_archive_title();
        } elseif (is_search()) {
            $title = sprintf(esc_html__('Search Results for: %s', 'lito'), '<span>' . get_search_query() . '</span>');
        } elseif (is_404()) {
            $title = esc_html__('404 Not Found', 'lito');
        } else {
            $title = get_the_title();
        }

        $before_title = apply_filters('lito_title_before', '<h1 class="entry-title">');
        $after_title = apply_filters('lito_title_after', '</h1>');
        $title = apply_filters('lito_title', $title);
        $title = $before_title . $title . $after_title;

        echo wp_kses_post($title);

    }
}

if (!function_exists('lito_entry_header_open_tag')) {
    add_action('lito_loop_header', 'lito_entry_header_open_tag', 1);
    /**
     * Displays opening tags for entry header
     * 
     * @since 1.0.0
     */
    function lito_entry_header_open_tag() {
        $header_classes = array('entry-header');
        $header_classes = apply_filters('lito_entry_header_classes', $header_classes);
        ?>
        <header class="<?php echo esc_attr(implode(' ', $header_classes)); ?>">
        <?php
    }
}

if (!function_exists('lito_entry_header_close_tag')) {
    add_action('lito_loop_header', 'lito_entry_header_close_tag', 100);
    /**
     * Displays closing tags for entry header
     * 
     * @since 1.0.0
     */
    function lito_entry_header_close_tag() {
        ?>
        </header>
        <?php
    }
}

if (!function_exists('lito_loop_title')) {
    add_action('lito_loop_content', 'lito_loop_title', 5);
    /**
     * Displays title in loop
     * 
     * @since 1.0.0
     */
    function lito_loop_title() {
        global $post;

        $before_title = apply_filters('lito_loop_title_before', '<h2 class="entry-title">');
        $after_title = apply_filters('lito_loop_title_after', '</h2>');
        $title = '<a href="'.esc_url(get_permalink($post->ID)).'" rel="bookmark">'.get_the_title( $post->ID ).'</a>';
        $title = apply_filters('lito_loop_title', $title);
        $title = $before_title . $title . $after_title;

        echo wp_kses_post($title);
    }
}

if (!function_exists('lito_loop_excerpt')) {
    add_action('lito_loop_content', 'lito_loop_excerpt', 10);
    /**
     * Displays excerpt in loop
     * 
     * @since 1.0.0
     */
    function lito_loop_excerpt() {
        if (lito_is_show_post_excerpt()) { ?>
            <div class="entry-summary">
                <?php the_excerpt(); ?>

                <?php if (lito_is_show_post_read_more()) { ?>
                    <a href="<?php the_permalink(); ?>" class="more-link button"><?php esc_html_e('Read more', 'lito'); ?></a>
                <?php } ?>
            </div>
        <?php } 
    }
}

if (!function_exists('lito_archive_description')) {
    /**
     * Displays archive description
     * 
     * @since 1.0.0
     */
    function lito_archive_description() {
        $description = get_the_archive_description();
        if ($description) {
            ?>
            <div class="archive-description">
                <?php echo wp_kses_post($description); ?>
            </div>
            <?php
        }
    }
}

if (!function_exists('lito_before_featured_media')) {
    add_action('lito_before_featured_media', 'lito_before_featured_media', 1);
    /**
     * Displays opening tags for featured media
     * 
     * @since 1.0.0
     */
    function lito_before_featured_media() {
        ?>
        <div class="entry-media">
        <?php
    }
}

if (!function_exists('lito_after_featured_media')) {
    add_action('lito_after_featured_media', 'lito_after_featured_media', 99);
    /**
     * Displays closing tags for featured media
     * 
     * @since 1.0.0
     */
    function lito_after_featured_media() {
        ?>
        </div>
        <?php
    }
}

if (!function_exists('lito_featured_media')) {
    add_action('lito_entry_header', 'lito_featured_media', 1);
    add_action('lito_before_loop_content', 'lito_featured_media', 10);
    /**
     * Displays featured media
     * 
     * @since 1.0.0
     */
    function lito_featured_media() {
        if (!lito_has_featured_media()) {
            return;
        }
        /**
         * lito_before_featured_media hook.
         * 
         * @hooked lito_before_featured_media - 1
         */
        do_action('lito_before_featured_media');
        
        if (is_archive() || is_search() || is_home()) {
            $is_archive_show_featured_video = lito_get_option('archive_show_featured_video');
            $is_archive_show_featured_audio = lito_get_option('archive_show_featured_audio');
            $is_archive_show_featured_gallery = lito_get_option('archive_show_featured_gallery');

            if (has_post_format( 'gallery' ) && $is_archive_show_featured_gallery) {
                lito_featured_gallery();
            } elseif (has_post_format( 'video' ) && $is_archive_show_featured_video) {
                lito_featured_video();
            } elseif (has_post_format( 'audio' ) && $is_archive_show_featured_audio) {
                lito_featured_audio();
            } else {
                lito_featured_image();
            }
        } else {
            if (has_post_format( 'gallery' )) {
                lito_featured_gallery();
            } elseif (has_post_format( 'video' )) {
                lito_featured_video();
            } elseif (has_post_format( 'audio' )) {
                lito_featured_audio();
            } else {
                lito_featured_image();
            }
        }

        /**
         * lito_after_featured_media hook.
         * 
         * @hooked lito_after_featured_media - 99
         */
        do_action('lito_after_featured_media');
            
    }
}

if (!function_exists('lito_featured_image')) {
    /**
     * Displays featured image
     * 
     * @since 1.0.0
     * @param bool $echo - whether to display the image or return it
     * @return string
     */
    function lito_featured_image($echo = true) {
        if (has_post_thumbnail()) {
            $size = apply_filters('lito_featured_image_size', is_singular() ? 'full' : 'large');
            if (!$echo) {
                return get_the_post_thumbnail(null, $size);
            }
            ?>
            <figure class="post-thumbnail">
                <?php if (!is_singular()) : ?>
                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                <?php endif; ?>

                <?php the_post_thumbnail($size); ?>

                <?php if (!is_singular()) : ?>
                    </a>
                <?php endif; ?>
            </figure>
            <?php
        } else {
            // trying to get the first image from the post content
            $post_content = apply_filters( 'the_content', get_the_content());
            $first_image = lito_get_first_image_from_content($post_content);
            if ($first_image) {
                if (!$echo) {
                    return $first_image;
                }
                ?>
                <figure class="post-thumbnail">
                    <?php if (!is_singular()) : ?>
                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                    <?php endif; ?>

                    <img src="<?php echo esc_url($first_image); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">

                    <?php if (!is_singular()) : ?>
                        </a>
                    <?php endif; ?>
                </figure>
                <?php
            } else {
                // if no featured image and no images in the content
                return;
            }
        }
    }
}

if (!function_exists('lito_get_first_image_from_content')) {
    /**
     * Returns the first image from the post content
     * 
     * @since 1.0.4
     * @param string $content - post content
     * @return string
     */
    function lito_get_first_image_from_content($content) {
        $first_image = '';
        $output = preg_match_all('/<img(?!.*\bclass=[\'"][^\'"]*\bavatar\b)[^>]+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches);
        if (isset($matches[1][0])) {
            $first_image = $matches[1][0];
        }
        return $first_image;
    }
}

if (!function_exists('lito_featured_gallery')) {
    /**
     * Displays post gallery
     * 
     * @since 1.0.0
     * @param bool $echo - whether to display the gallery or return it
     * @return string
     */
    function lito_featured_gallery($echo = true) {
        global $post;
        if ( ! has_post_format( 'gallery' ) ) {
            return;
        }
        if ( has_post_format( 'gallery' ) ) {
            $is_include_featured_image = lito_get_option('is_include_featured_image') ?: true ;
            $gallery_srcs = get_post_gallery_images( $post );

            if ($is_include_featured_image) {
                $gallery_srcs[] = get_the_post_thumbnail_url( $post, 'full' );
            }

            if ( $gallery_srcs ) {
                if (!$echo) {
                    return $gallery_srcs;
                }
                ?>
                <div class="post-gallery">
                    <div class="post-gallery-slider">
                    <?php
                    foreach ( $gallery_srcs as $src ) {
                        ?>
                        <div class="post-gallery__item">
                            <img src="<?php echo esc_url($src); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                        </div>
                        <?php
                    }
                    ?>
                    </div>
                </div>
                <?php
            } else {
                lito_featured_image();
            }
        }
    }
}

if (!function_exists('lito_featured_video')) {
    /**
     * Displays featured video
     * 
     * @since 1.0.0
     * @param bool $echo - whether to display the video or return it
     * @return string
     */
    function lito_featured_video($echo = true) {
        global $post;
        if ( ! has_post_format( 'video' ) ) {
            return;
        }
        if ( has_post_format( 'video' ) ) {
            $post_content = apply_filters( 'the_content', get_the_content());
            // Only get video from the content if a playlist isn't present.
            if ( false === strpos( $post_content, 'wp-playlist-script' ) ) {
                $post_videos = get_media_embedded_in_content( $post_content, array( 'video', 'object', 'embed', 'iframe' ) );
            }

            $first_video = $post_videos[0];
            if ( $first_video ) {
                $first_video = str_replace( 'controls', '', $first_video );
                if (strpos($first_video, 'autoplay') === false) {
                    $first_video = str_replace('<video', '<video autoplay', $first_video);
                }
                if (strpos($first_video, 'muted') === false) {
                    $first_video = str_replace('<video', '<video muted', $first_video);
                }
                if (strpos($first_video, 'playsinline') === false) {
                    $first_video = str_replace('<video', '<video playsinline', $first_video);
                }
                if (!is_singular()) {
                    $first_video = str_replace( 'autoplay', '', $first_video );
                }
                if (!$echo) {
                    return $first_video.lito_toggle_play_media_button(false);
                }
                ?>
                <div class="post-video">
                    <?php echo $first_video.lito_toggle_play_media_button(); ?>
                </div>
                <?php
            } else {
                lito_featured_image();
            }
        }
    }
}

if (!function_exists('lito_toggle_play_media_button')) {
    /**
     * Displays toggle play media button
     * 
     * @since 1.0.0
     * @param bool $echo - whether to display the button or return it
     * @return string
     */
    function lito_toggle_play_media_button($echo = true) {
        $play_button = apply_filters('lito_toggle_play_media_button', '<button class="toggle-play-media" aria-label="' . esc_attr__('Play media', 'lito') . '"><span class="screen-reader-text">' . esc_html__('Play media', 'lito') . '</span></button>', $echo);
        if (!$echo) {
            return $play_button;
        }
        echo $play_button;
    }
}

if (!function_exists('lito_featured_audio')) {
    /**
     * Displays featured audio
     * 
     * @since 1.0.0
     * @param bool $echo - whether to display the audio or return it
     * @return string
     */
    function lito_featured_audio($echo = true) {
        global $post;
        if ( ! has_post_format( 'audio' ) ) {
            return;
        }
        if ( has_post_format( 'audio' ) ) {
            $post_content = apply_filters( 'the_content', get_the_content());
            // Only get audio from the content if a playlist isn't present.
            if ( false === strpos( $post_content, 'wp-playlist-script' ) ) {
                $post_audios = get_media_embedded_in_content( $post_content, array( 'audio', 'object', 'embed', 'iframe' ) );
            }

            $first_audio = $post_audios[0];
            if ( $first_audio ) {
                if (!$echo) {
                    return $first_audio;
                }
                ?>
                <div class="post-audio">
                    <?php echo $first_audio; ?>
                </div>
                <?php
            } else {
                lito_featured_image();
            }
        }
    }
}

if (!function_exists('lito_comment')) {
    /**
     * Displays a single comment
     * 
     * @since 1.0.0
     * @param object $comment - comment object
     * @param array $args - comment arguments
     * @param int $depth - comment depth
     * @return void
     */
    function lito_comment($comment, $args, $depth) {
        $tag = ($args['style'] === 'div') ? 'div' : 'li';
        ?>
        <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class('comment'); ?>>
            <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
                <footer class="comment-meta">
                    <div class="comment-author vcard">
                        <?php
                        $avatar_size = 96;
                        if ('0' != $comment->comment_parent) {
                            $avatar_size = 64;
                        }

                        echo get_avatar($comment, $avatar_size);

                        /* translators: %s: comment author link */
                        printf(
                            wp_kses(
                                __('%s <span class="says">says:</span>', 'lito'),
                                array(
                                    'span' => array(
                                        'class' => array(),
                                    ),
                                )
                            ),
                            sprintf(
                                '<b class="fn">%s</b>',
                                get_comment_author_link()
                            )
                        );
                        ?>
                    </div><!-- .comment-author -->

                    <div class="comment-metadata">
                        <a href="<?php echo esc_url(get_comment_link($comment->comment_ID, $args)); ?>">
                            <time datetime="<?php comment_time('c'); ?>">
                                <?php
                                /* translators: 1: comment date, 2: comment time */
                                printf(
                                    esc_html__('%1$s at %2$s', 'lito'),
                                    get_comment_date(),
                                    get_comment_time()
                                );
                                ?>
                            </time>
                        </a>
                        <?php edit_comment_link(esc_html__('Edit', 'lito'), '<span class="edit-link">', '</span>'); ?>
                    </div><!-- .comment-metadata -->

                    <?php if ('0' === $comment->comment_approved) : ?>
                        <p class="comment-awaiting-moderation"><?php esc_html_e('Your comment is awaiting moderation.', 'lito'); ?></p>
                    <?php endif; ?>
                </footer><!-- .comment-meta -->

                <div class="comment-content">
                    <?php comment_text(); ?>
                </div><!-- .comment-content -->

                <?php
                comment_reply_link(
                    array_merge(
                        $args,
                        array(
                            'add_below' => 'div-comment',
                            'depth'     => $depth,
                            'max_depth' => $args['max_depth'],
                            'before'    => '<div class="reply">',
                            'after'     => '</div>',
                        )
                    )
                );
                ?>
            </article><!-- .comment-body -->
        </<?php echo $tag; ?>><!-- .comment -->
        <?php
    }
}

if (!function_exists('lito_comments_template')) {
    add_action('lito_after_entry_footer', 'lito_comments_template', 10);
    /**
     * Displays comments template
     * 
     * @since 1.0.0
     */
    function lito_comments_template() {
        if (comments_open() || get_comments_number()) {
            ?>
            <div class="comments-area">
				<?php comments_template(); ?>
			</div>
            <?php
        }
    }
}

if (!function_exists('lito_pagination')) {
    add_action('lito_after_loop', 'lito_pagination', 5);
    /**
     * Displays pagination
     * 
     * @since 1.0.0
     */
    function lito_pagination() {
        if (!is_archive() && !is_search() && !is_home()) {
            return;
        }

        the_posts_pagination(
            array(
                'type' => 'list',
                'mid_size'  => 2,
                'prev_text' => '<span class="screen-reader-text">' . esc_html__('Previous page', 'lito') . '</span>',
                'next_text' => '<span class="screen-reader-text">' . esc_html__('Next page', 'lito') . '</span>',
            )
        );     
        
    }
}

add_filter('walker_nav_menu_start_el', 'lito_add_arrow_to_menu_item', 10, 4);
/**
 * Output menu item's dropdown arrow for sub-menu
 * 
 * @since 1.0.0
 */
function lito_add_arrow_to_menu_item ($item_output, $item, $depth, $args) {
	if( in_array('menu-item-has-children', $item->classes) ) {
		$item_output = str_replace("</a>", "</a><button class='menu-item-arrow' aria-label='".__("Expand menu", "lito")."'></button>", $item_output);
	}
	
	return $item_output;
}

if (!function_exists('lito_empty_sidebar')) {
    /**
     * Displays empty sidebar notice for admins
     * 
     * @since 1.0.0
     */
    function lito_empty_sidebar() {
        if (!current_user_can('edit_theme_options')) {
            return;
        }
        ?>
        <div class="widget widget-empty">
            <p><?php esc_html_e('You have no widgets in this sidebar area.', 'lito'); ?></p>
            <p><?php echo sprintf(esc_html__('To insert a widget here, go to %s and add widgets to the suitable sidebar.', 'lito'), '<a href="'.esc_url(admin_url('widgets.php')).'">'.esc_html__('Appearance', 'lito').' &rarr; '.esc_html__('Widgets', 'lito').'</a>'); ?></p>
        </div>
        <?php
    }
}

if (!function_exists('lito_posts_navigation')) {
    add_action('lito_after_content', 'lito_posts_navigation', 10);
    /**
     * Displays posts navigation
     * 
     * @since 1.0.0
     */
    function lito_posts_navigation() {
        $is_show_posts_nav = lito_get_option('single_post_has_posts_nav');

        if (!$is_show_posts_nav || !is_single()) {
            return;
        }

        $prev_post = get_previous_post();
        $prev_post_thumbnail = $prev_post ? get_the_post_thumbnail( $prev_post->ID, 'thumbnail' ) : '';
        $prev_post_html = $prev_post_thumbnail;
        $prev_post_html .= '<span class="post-link__inner">';
        $prev_post_html .= '<span class="post-link__text">'.esc_html__('Previous Post', 'lito').'</span>';
        $prev_post_html .= '<span class="post-link__title">'.esc_html('%title').'</span>';
        $prev_post_html .= '</span>';

        $next_post = get_next_post();
        $next_post_thumbnail = $next_post ? get_the_post_thumbnail( $next_post->ID, 'thumbnail' ) : '';
        $next_post_html = $next_post_thumbnail;
        $next_post_html .= '<span class="post-link__inner">';
        $next_post_html .= '<span class="post-link__text">'.esc_html__('Next Post', 'lito').'</span>';
        $next_post_html .= '<span class="post-link__title">'.esc_html('%title').'</span>';
        $next_post_html .= '</span>';
        ?>
        <nav class="posts-navigation"> 
            <div class="prev-post-link"> 
                <?php previous_post_link('%link', $prev_post_html); ?>
            </div> 
            <div class="next-post-link"> 
                <?php next_post_link('%link', $next_post_html); ?> 
            </div> 
        </nav> 
        <?php
    }
}

if (!function_exists('lito_skip_to_content_link')) {
    add_action('lito_before_header', 'lito_skip_to_content_link', 5);
    /**
     * Displays skip to content link
     * 
     * @since 1.0.0
     */
    function lito_skip_to_content_link() {
        ?>
        <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'lito'); ?></a>
        <?php
    }
}