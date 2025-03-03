<?php
/**
 * Template for displaying the header (header-1).
 *
 * Please do not make any edits to this file. All edits should be done in a child theme.
 *
 * @package Lito
 * @since 1.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
?>
<div class="site-header__inner__col">
    <?php lito_custom_logo(); ?>
    <?php lito_header_menu(); ?>
    <?php lito_social_menu(); ?>
    <?php lito_header_search(); ?>
</div>