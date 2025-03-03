<?php
/**
 * The footer for the theme
 *
 * @package Lito
 * @since 1.0
 * @version 1.0
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
?>

<?php
/**
 * Hook: lito_before_footer.
 *
 * @since 1.0.0
 */
do_action('lito_before_footer');
?>

<footer id="site-footer" class="<?php echo esc_attr(lito_footer_classes()); ?>">
    <?php
    /**
     * Hook: lito_footer.
     * @hooked lito_footer - 10
     *
     * @since 1.0.0
     */
    do_action('lito_footer');
    ?>
</footer><!-- #site-footer -->

<?php
/**
 * Hook: lito_after_footer.
 *
 * @since 1.0.0
 */
do_action('lito_after_footer');
?>

<?php wp_footer(); ?>

</body>