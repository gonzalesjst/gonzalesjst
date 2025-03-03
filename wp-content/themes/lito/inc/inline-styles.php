<?php
/**
 * Inline styles
 *
 * @package Lito
 * @since 1.0
 * @version 1.0
 */
use Lito\Lito_Fonts;

if ( ! function_exists( 'lito_inline_styles' ) ) {
	add_action( 'wp_enqueue_scripts', 'lito_inline_styles', 99 );
	if ( is_admin() ) { 
        add_action( 'enqueue_block_assets', 'lito_inline_styles' );
    }
	/**
	 * Add inline styles based on Customizer options
	 * 
	 * @since 1.0
	 */
	function lito_inline_styles() {
		global $content_width;

        $lito_fonts = new Lito_Fonts();
		$custom_css = '';
		$all_fonts = array();
		
		$content_width = lito_get_option( 'content_width' );
		$container_width = lito_get_option( 'container_width' );
		$width_units = preg_replace( '/percent/', '%', lito_get_option( 'width_units' ) );
		$custom_css .= "
		:root {
			--lito-width-content: {$content_width}{$width_units};
			--lito-width-container: {$container_width}{$width_units};
			--lito-width-units: {$width_units};
		}
		";

		$color_primary = lito_get_option( 'color_primary' );
		$color_primary_hover = lito_get_option( 'color_primary_hover' );
		$color_primary_contrast = lito_get_option( 'color_primary_contrast' );
		$color_secondary = lito_get_option( 'color_secondary' );
		$color_secondary_hover = lito_get_option( 'color_secondary_hover' );
		$color_secondary_contrast = lito_get_option( 'color_secondary_contrast' );
		$color_light = lito_get_option( 'color_light' );
		$color_background = lito_get_option( 'color_background' );
		$color_content_bg = lito_get_option( 'color_content_bg' ) !== '' ? lito_get_option( 'color_content_bg' ) : 'transparent';
		$color_border = lito_get_option( 'color_border' );
		$color_text = lito_get_option( 'color_text' );
		$color_text_secondary = lito_get_option( 'color_text_secondary' );
		$color_heading = lito_get_option( 'color_heading' );
		$color_outline= lito_get_option( 'color_outline' );
		$color_header_bg = lito_get_option( 'color_header_bg' ) !== '' ? lito_get_option( 'color_header_bg' ) : 'transparent';
		$color_header_menu_item = lito_get_option( 'color_header_menu_item' );
		$color_header_menu_item_hover = lito_get_option( 'color_header_menu_item_hover' );
		$color_footer_bg = lito_get_option( 'color_footer_bg' ) !== '' ? lito_get_option( 'color_footer_bg' ) : 'transparent';
		$color_footer_text = lito_get_option( 'color_footer_text' );

		$custom_css .= "
		:root {
			--lito-color-primary: {$color_primary};
			--lito-color-primary-hover: {$color_primary_hover};
			--lito-color-primary-contrast: {$color_primary_contrast};
			--lito-color-secondary: {$color_secondary};
			--lito-color-secondary-hover: {$color_secondary_hover};
			--lito-color-secondary-contrast: {$color_secondary_contrast};
			--lito-color-light: {$color_light};
			--lito-color-background: {$color_background};
			--lito-color-content-bg: {$color_content_bg};
			--lito-color-border: {$color_border};
			--lito-color-text: {$color_text};
			--lito-color-text-secondary: {$color_text_secondary};
			--lito-color-heading: {$color_heading};
			--lito-color-outline: {$color_outline};
			--lito-color-header-bg: {$color_header_bg};
			--lito-color-header-menu-item: {$color_header_menu_item};
			--lito-color-header-menu-item-hover: {$color_header_menu_item_hover};
			--lito-color-footer-bg: {$color_footer_bg};
			--lito-color-footer-text: {$color_footer_text};
		}
		";

		for ( $i = 1; $i <= 6; $i++ ) {
			$heading_font_json = json_decode( lito_get_option( 'typo_h' . $i ), true );
			$heading_font_family = $heading_font_json['font'];
			$heading_font_weight_combined = $heading_font_json['weight'];
			$heading_font_weight = $lito_fonts->convert_font_weight_to_css($heading_font_weight_combined);
			$heading_font_style = $lito_fonts->convert_font_style_to_css($heading_font_weight_combined);
			$heading_font_size = $heading_font_json['size'];
			$heading_font_size_max = $heading_font_json['size_max'];
			$heading_text_transform = $heading_font_json['transform'];
			$heading_line_height = $heading_font_json['line_height'];
			$heading_letter_spacing = $heading_font_json['letter_spacing'];

			$custom_css .= "
			:root {
				--lito-font-family-h{$i}: '{$heading_font_family}', sans-serif;
				--lito-font-size-h{$i}: {$heading_font_size}rem;
				--lito-font-size-max-h{$i}: {$heading_font_size_max}rem;
				--lito-font-weight-h{$i}: {$heading_font_weight};
				--lito-font-style-h{$i}: {$heading_font_style};
				--lito-text-transform-h{$i}: {$heading_text_transform};
				--lito-line-height-h{$i}: {$heading_line_height};
				--lito-letter-spacing-h{$i}: {$heading_letter_spacing};

				--lito-font-size-value-h{$i}: {$heading_font_size};
				--lito-font-size-max-value-h{$i}: {$heading_font_size_max};
			}
			";

			$all_fonts[] = array(
				'font' => $heading_font_family,
				'weights' => $heading_font_weight
			);
		}

		$body_font_json = json_decode( lito_get_option( 'typo_body' ), true );
		$body_font_family = $body_font_json['font'];
		$body_font_weight_combined = $body_font_json['weight'];
		$body_font_weight = $lito_fonts->convert_font_weight_to_css($body_font_weight_combined);
		$body_font_style = $lito_fonts->convert_font_style_to_css($body_font_weight_combined);
		$body_font_size = $body_font_json['size'];
		$body_font_size_max = $body_font_json['size_max'];
		$body_text_transform = $body_font_json['transform'];
		$body_line_height = $body_font_json['line_height'];
		$body_letter_spacing = $body_font_json['letter_spacing'];
		$body_dynamic_font_size = (($body_font_size + $body_font_size_max) / 2);
		$custom_css .= "
		:root { 
			--lito-font-size-body: {$body_font_size}rem;
			--lito-font-size-max-body: {$body_font_size_max}rem;
			--lito-font-family-body: '{$body_font_family}', sans-serif;
			--lito-font-weight-body: {$body_font_weight};
			--lito-font-style-body: {$body_font_style};
			--lito-text-transform-body: {$body_text_transform};
			--lito-line-height-body: {$body_line_height};
			--lito-letter-spacing-body: {$body_letter_spacing};

			--lito-font-size-value-body: {$body_font_size};
			--lito-font-size-max-value-body: {$body_font_size_max};
		}";

		$header_font_json = json_decode( lito_get_option( 'typo_header' ), true );
		$header_font_family = $header_font_json['font'];
		$header_font_weight_combined = $header_font_json['weight'];
		$header_font_weight = $lito_fonts->convert_font_weight_to_css($header_font_weight_combined);
		$header_font_style = $lito_fonts->convert_font_style_to_css($header_font_weight_combined);
		$header_font_size = $header_font_json['size'];
		$header_font_size_max = $header_font_json['size_max'];
		$header_text_transform = $header_font_json['transform'];
		$header_line_height = $header_font_json['line_height'];
		$header_letter_spacing = $header_font_json['letter_spacing'];
		$custom_css .= ":root { 
			--lito-font-size-header: {$header_font_size}rem; 
			--lito-font-size-max-header: {$header_font_size_max}rem;
			--lito-font-family-header: '{$header_font_family}', sans-serif;
			--lito-font-weight-header: {$header_font_weight};
			--lito-font-style-header: {$header_font_style};
			--lito-text-transform-header: {$header_text_transform};
			--lito-line-height-header: {$header_line_height};
			--lito-letter-spacing-header: {$header_letter_spacing};

			--lito-font-size-value-header: {$header_font_size};
			--lito-font-size-max-value-header: {$header_font_size_max};
		}";

		$all_fonts[] = array(
			'font' => $body_font_family,
			'weights' => $body_font_weight
		);

		$all_fonts[] = array(
			'font' => $header_font_family,
			'weights' => $header_font_weight
		);

        $custom_css .= $lito_fonts->generate_custom_fonts_css(); // include custom fonts css
        
		wp_enqueue_style( 'lito-google-fonts', $lito_fonts->get_all_google_fonts_url($all_fonts), array(), null, 'all' );
		
		wp_add_inline_style( 'lito-inline', apply_filters('lito_inline_styles', $custom_css) );
		wp_add_inline_style( 'lito-block-editor', apply_filters('lito_inline_styles', $custom_css) );
    }
}

add_action('wp_head', 'lito_noscript_styles');
/**
 * Add noscript styles
 * 
 * @since 1.0.0
 */
function lito_noscript_styles() {
    ?>
    <noscript>
        <style>
            /**
            * Reinstate scrolling for non-JS clients
            */
            .simplebar-content-wrapper {
                scrollbar-width: auto;
                -ms-overflow-style: auto;
            }

            .simplebar-content-wrapper::-webkit-scrollbar,
            .simplebar-hide-scrollbar::-webkit-scrollbar {
                display: initial;
                width: initial;
                height: initial;
            }
        </style>
    </noscript>
    <?php
}