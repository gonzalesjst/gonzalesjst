<?php
/**
 * The header for the theme
 *
 * @package Lito
 * @since 1.0
 * @version 1.0
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
?>
<!DOCTYPE html>
<html <?php language_attributes();?>>
<head>
    <meta charset="<?php bloginfo('charset');?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="http://gmpg.org/xfn/11">

    <?php wp_head();?>
</head>

<body <?php body_class();?>>

    <?php wp_body_open(); ?>

    <?php
    /**
     * Hook: lito_before_header.
     * 
     * @hooked lito_skip_to_content_link - 5
     *
     * @since 1.0.0
     */
    do_action('lito_before_header');
    ?>

    <header id="site-header" class="<?php echo esc_attr(lito_header_classes()); ?>">
        <?php
        /**
         * Hook: lito_header.
         * @hooked lito_header - 10
         *
         * @since 1.0.0
         */
        do_action('lito_header');
        ?>
    </header><!-- #site-header -->

    <?php
    /**
     * Hook: lito_after_header.
     *
     * @since 1.0.0
     */
    do_action('lito_after_header');