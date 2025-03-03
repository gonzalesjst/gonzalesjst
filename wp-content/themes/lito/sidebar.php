<?php
/**
 * The sidebar containing the main widget area.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<aside id="sidebar" class="<?php echo esc_attr(lito_sidebar_classes('left')); ?>" role="complementary">
    <?php 
    if ( is_single() && is_active_sidebar( 'sidebar-post' ) ) {
        dynamic_sidebar( 'sidebar-post' );
    } elseif ( is_page() && is_active_sidebar( 'sidebar-page' ) ) {
        dynamic_sidebar( 'sidebar-page' );
    } elseif ( (is_archive() || is_search() || is_home()) && is_active_sidebar( 'sidebar' ) ) {
        dynamic_sidebar( 'sidebar' );
    } else {
        lito_empty_sidebar();
    }
    ?>
</aside><!-- #sidebar -->