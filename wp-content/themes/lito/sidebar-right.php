<?php
/**
 * The sidebar containing the main widget area.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<aside id="sidebar-right" class="<?php echo esc_attr(lito_sidebar_classes('right')); ?>" role="complementary">
    <?php 
    if ( is_single() && is_active_sidebar( 'sidebar-post-right' ) ) {
        dynamic_sidebar( 'sidebar-post-right' );
    } elseif ( is_page() && is_active_sidebar( 'sidebar-page-right' ) ) {
        dynamic_sidebar( 'sidebar-page-right' );
    } elseif ( (is_archive() || is_search() || is_home()) && is_active_sidebar( 'sidebar-right' ) ) {
        dynamic_sidebar( 'sidebar-right' ); 
    } else {
        lito_empty_sidebar();
    }
    ?>
</aside><!-- #idebar-right -->