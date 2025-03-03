<?php
/**
 * Template for displaying the header (header-2).
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
<div class="site-header__inner__col site-header__inner__col--first">
    <?php lito_header_menu(); ?>
</div>
<div class="site-header__inner__col site-header__inner__col--center">
    <?php lito_custom_logo(); ?>
</div>
<div class="site-header__inner__col site-header__inner__col--last">
    <?php lito_social_menu(); ?>
    <?php lito_header_search(); ?>
</div>