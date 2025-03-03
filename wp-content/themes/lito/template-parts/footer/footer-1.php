<?php
/**
 * Template for displaying the footer.
 *
 * Please do not make any edits to this file. All edits should be done in a child theme.
 *
 * @package Lito
 * @since 1.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
$footer_cols_number = lito_get_footer_cols_number();
?>
    
<?php for ($i = 1; $i <= $footer_cols_number; $i++) : ?>
    <?php if (is_active_sidebar('footer-' . $i)) : ?>
        <div class="site-footer__column site-footer__column--widgets site-footer__column--<?php echo esc_attr($i); ?>">
            <div class="site-footer__widget-area">
                <?php dynamic_sidebar('footer-' . $i); ?>
            </div>
        </div>
    <?php endif; ?>
<?php endfor; ?>