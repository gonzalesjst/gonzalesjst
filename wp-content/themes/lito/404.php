<?php
/**
 * The single page template file.
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
        ?>

            <?php
            /**
             * lito_before_single hook.
             * 
             * @hooked lito_wrap_tags_open - 10
             * @hooked lito_single_header - 20
             * @hooked lito_content_area_tags_open - 25
             * @hooked lito_content_posts_tags_open - 30
             *
             * @since 1.0.0
             */
            do_action( 'lito_before_single', 'page' );

            while ( have_posts() ) :

                the_post();

                get_template_part( 'template-parts/content/content', 'single' );

            endwhile;

            /**
             * lito_after_single hook.
             * 
             * @hooked lito_content_posts_tags_close - 10
             * @hooked lito_sidebar - 30
             * @hooked lito_wrap_tags_close - 40
             *
             * @since 1.0.0
             */
            do_action( 'lito_after_single', 'page' );
            ?>

        <?php

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
