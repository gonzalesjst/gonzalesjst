<?php
/**
 * The main template file.
 *
 * @package Lito
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

<main id="main" class="<?php echo esc_attr(lito_content_classes()); ?>">
    <div class="<?php echo esc_attr(lito_container_classes()); ?>">
    <?php
        /**
         * lito_before_main_content hook.
         *
         * @since 1.0.0
         */
        do_action( 'lito_before_main_content' );
        
        if ( have_posts() ) :

            /**
             * lito_before_loop hook.
             * 
             * @hooked lito_archive_header - 10
             * @hooked lito_archive_content_tags_open - 20
             * @hooked lito_content_posts_tags_open - 30
             *
             * @since 1.0.0
             */
            do_action( 'lito_before_loop', 'index' );
            
            while ( have_posts() ) :

                the_post();

                get_template_part( 'template-parts/content/content', '' );

            endwhile;
            
            /**
             * lito_after_loop hook.
             * 
             * @hooked lito_pagination - 20
             * @hooked lito_content_posts_tags_close - 20
             * @hooked lito_sidebar - 30
             * @hooked lito_archive_content_tags_close - 40
             *
             * @since 1.0.0
             */
            do_action( 'lito_after_loop', 'index' );

        else :

            get_template_part( 'template-parts/content/content', 'none' );

        endif;
        
        /**
         * lito_after_main_content hook.
         *
         * @since 1.0.0
         */
        do_action( 'lito_after_main_content' );
        ?>
    </div> <!-- .container -->
</main> <!-- #main -->

<?php

get_footer();
