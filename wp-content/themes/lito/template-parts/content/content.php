<?php
/**
 * Template for displaying posts within the loop.
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
 * lito_before_loop_post hook.
 * 
 * @hooked lito_content_sticky_tags_open - 10
 *
 * @since 1.0
 */
do_action( 'lito_before_loop_post' );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="post__inner">
		<?php
		/**
		 * lito_before_loop_content hook.
         * 
         * @hooked lito_featured_media - 10
		 *
		 * @since 1.0
		 */
		do_action( 'lito_before_loop_content' );
        ?>

        <div class="post-content">

            <?php
            /**
             * lito_before_loop_header hook.
             *
             * @since 1.0
             */
            do_action( 'lito_before_loop_header' );
            ?>

            <?php
            /**
             * lito_loop_header hook.
             * 
             * @hooked lito_entry_header_open_tag - 5
             * @hooked lito_post_meta - 10
             * @hooked lito_entry_header_close_tag - 100
             *
             * @since 1.0
             */
            do_action( 'lito_loop_header' );
            ?>
            
            <?php
            /**
             * lito_after_loop_header hook.
             *
             * @since 1.0
             */
            do_action( 'lito_after_loop_header' );
            ?>

            <?php
            /**
             * lito_loop_content hook.
             * 
             * @hooked lito_loop_title - 5
             * @hooked lito_loop_excerpt - 10
             *
             * @since 1.0
             */
            do_action( 'lito_loop_content' );
            ?>

            <?php
            /**
             * lito_before_loop_footer hook.
             *
             * @since 1.0
             */
            do_action( 'lito_before_loop_footer' );
            ?>

            <?php
            /**
             * lito_loop_footer hook.
             * 
             * @hooked lito_post_entry_footer_open_tag - 5
             * @hooked lito_post_tax - 10
             * @hooked lito_post_edit_link - 99
             * @hooked lito_post_entry_footer_close_tag - 100
             *
             * @since 1.0
             */
            do_action( 'lito_loop_footer' );
            ?>

            <?php
            /**
             * lito_after_loop_footer hook.
             *
             * @since 1.0
             */
            do_action( 'lito_after_loop_footer' );
            ?>

        </div><!-- .post-content -->

        <?php
		/**
		 * lito_after_loop_content hook.
		 *
		 * @since 1.0
		 */
		do_action( 'lito_after_loop_content' );
		?>
	</div>
</article>
<?php
/**
 * lito_after_loop_post hook.
 * 
 * @hooked lito_content_sticky_tags_close - 10
 *
 * @since 1.0
 */
do_action( 'lito_after_loop_post' );
?>
