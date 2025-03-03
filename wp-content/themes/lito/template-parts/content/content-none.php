<?php
/**
 * Template for displaying a message that posts cannot be found.
 * 
 * @package Lito
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
?>
<?php
/**
 * lito_loop_empty hook.
 * 
 * @hooked lito_archive_header - 5
 * @hooked lito_content_area_tags_open - 25
 *
 * @since 1.0.0
 */
do_action( 'lito_before_content_none' );
?>
<div class="container-inner">
    <div class="entry-content entry-content--none">

        <?php if (!is_404()) : ?>
            <h2 class="entry-title"><?php esc_html_e( 'Nothing Found', 'lito' ); ?></h2>
        <?php else : ?>
            <h1 class="entry-title"><?php esc_html_e( 'Page Not Found', 'lito' ); ?></h1>
        <?php endif; ?>

        <?php if ( is_archive() ) : ?>
            <p><?php esc_html_e( 'Sorry, but there are no posts in this category.', 'lito' ); ?></p>
            <?php get_search_form(); ?>
        <?php elseif ( is_search() ) : ?>
            <p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'lito' ); ?></p>
        <?php else : ?>
            <p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'lito' ); ?></p>
            <?php get_search_form(); ?>
        <?php endif; ?>
        
    </div>
</div>
<?php
/**
 * lito_after_content_none hook.
 * 
 * @hooked lito_content_area_tags_close - 25
 *
 * @since 1.0.0
 */
do_action( 'lito_after_content_none' );
?>
