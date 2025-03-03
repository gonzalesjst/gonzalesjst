<?php
/**
 * Template for displaying single post.
 * 
 * @package Lito
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="post__inner">

        <?php
		/**
		 * lito_before_content hook.
         * 
         * @hooked lito_featured_media - 10
		 *
		 * @since 1.0
		 */
		do_action( 'lito_before_content' );
        ?>

        <div class="entry-content">
            <?php the_content(); ?>
            <?php
            wp_link_pages(
                array(
                    'before' => '<div class="page-links">' . __( 'Pages:', 'lito' ),
                    'after'  => '</div>',
                )
            );
            ?>
        </div>
        
        <?php
        /**
		 * lito_after_content hook.
         * 
         * @hooked lito_posts_navigation - 10
		 *
		 * @since 1.0
		 */
		do_action( 'lito_after_content' );
        ?>

        <?php
        /**
         * lito_before_entry_footer hook.
         *
         * @since 1.0
         */
        do_action( 'lito_before_entry_footer' );
        ?>

        <?php
            /**
             * lito_entry_footer hook.
             * 
             * @hooked lito_post_entry_footer_open_tag - 5
             * @hooked lito_post_meta - 10
             * @hooked lito_post_tax - 20
             * @hooked lito_post_edit_link - 99
             * @hooked lito_post_entry_footer_close_tag - 100
             *
             * @since 1.0
             */
            do_action( 'lito_entry_footer' );
        ?>

        <?php
        /**
         * lito_after_entry_footer hook.
         * 
         * @hooked lito_comments_template - 10
         *
         * @since 1.0
         */
        do_action( 'lito_after_entry_footer' );
		?>
	</div>
</article>

