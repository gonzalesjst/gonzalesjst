<?php
/**
 * Typography control class.
 * 
 * @package Lito
 * @since 1.0
 * 
 */
namespace Lito;

class Lito_Fonts {

    public $fonts_dir = '';
	public $fonts_uri = '';

	public function __construct() {
        $this->fonts_dir = get_stylesheet_directory().'/assets/fonts/';
		$this->fonts_uri = get_stylesheet_directory_uri().'/assets/fonts/';
	}

	public function get_all_google_fonts() {
        ob_start();
		include dirname(__FILE__).'/customizer-custom-controls/font/webfonts.json'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude
		return apply_filters( 'lito_google_fonts', json_decode( ob_get_clean(), true ));
	}

	/**
	 * Get a combined url of all google fonts
	 * @see https://developers.google.com/fonts/docs/css2 
	 *
	 * @param array $fonts Array of google fonts with weights
     * @return string combined URL of all google fonts
	 */
	public function get_all_google_fonts_url( $fonts ) {
		if ( is_array($fonts) ) {
			$url_prefix = '//fonts.googleapis.com/css2?';
			$url_suffix = '&display=swap';
			$fonts_urls = array();

			foreach ($fonts as $font_arr) {
				$font_url = $this->get_google_font_url($font_arr['font'], $font_arr['weights']);
				if ($font_url) {
					$fonts_urls[] = $font_url;
				}
			}

			if (count($fonts_urls) > 0) {
				return $url_prefix . implode("&", $fonts_urls) . $url_suffix;
			} else {
				return '';
			}
		} 
	}

	/**
	 * Get an url of a single google font
	 * @see https://developers.google.com/fonts/docs/css2 
	 *
	 * @param string $font Name of google font
	 * @param array $weights Array of font's weights
	 * @param bool $for_combined If true - uses for the combined url of all Google Fonts, else - single url with Google Font
     * @return string URL of google font
	 */
	public function get_google_font_url( $font = 'Montserrat', $weights = array('regular'), $for_combined = true ) {
		$google_fonts = $this->get_all_google_fonts()['items'];

		if ( !array_key_exists($font, $google_fonts) ) return ''; // check if font is in google fonts array

		$url_prefix = '//fonts.googleapis.com/css2?family=';
		$font_name = preg_replace('/\s+/', '+', $font);
        $url_suffix = '&display=swap';
		
		$font_weights = $font_ital_weights = $axis_tag_list = $axis_tuple_list = array();
		$axis_tag_str = $axis_tuple_str = $axis_delimeter_1 = $axis_delimeter_2 = '';

		if (!is_array($weights)) {
			$weights = explode(",", $weights);
		}

		asort($weights);

		foreach ($weights as $key => $value) {
			
			if ( $value === 'regular' || $value === 'italic' ) {
				$value = '400';
			}

			$numbered_value = preg_replace('/[^0-9]/', '', $value);

			if ( strpos($value, 'italic') !== false ) {
				$font_ital_weights[] = $numbered_value;
			} else {
				$font_weights[] = $numbered_value;
			}
		}

		if ( count($font_ital_weights) > 0 ) {
			$axis_tag_list[0] = 'ital';

			if ( count($font_ital_weights) === 1 ) {
				if ( $font_ital_weights[0] === '400' ) {
					$axis_tuple_list[] = '1';
				} else {
					$axis_tag_list[1] = 'wght';
					foreach ($font_ital_weights as $font) {
						$axis_tuple_list[] = '1,'.$font;
					}
				}
				
			} else {
				foreach ($font_ital_weights as $font) {
					$axis_tuple_list[] = '1,'.$font;
				}
			}

			
		}
		if ( count($font_weights) > 0 ) {
			if (count($font_weights) === 1) {
				if ( $font_weights[0] !== '400' ) {
					$axis_tag_list[1] = 'wght';
					$axis_tuple_list[] = $font_weights[0];
				}
			} else {
				$axis_tag_list[1] = 'wght';

				foreach ($font_weights as $font) {
					$axis_tuple_list[] = '0,'.$font;
				}
			}
			
		}

		$axis_tag_str = implode(",", $axis_tag_list);
		$axis_tuple_str = implode(";", $axis_tuple_list);
		$axis_delimeter_1 = ($axis_tag_str !== '') ? ':' : '';
		$axis_delimeter_2 = ($axis_tag_str !== '') ? '@' : '';

		if ( $for_combined ) {
			$font_url = 'family=' . $font_name . $axis_delimeter_1 . $axis_tag_str . $axis_delimeter_2 . $axis_tuple_str;
		} else {
			$font_url = $url_prefix . $font_name . $axis_delimeter_1 . $axis_tag_str . $axis_delimeter_2 . $axis_tuple_str . $url_suffix;
		}

		return $font_url;
    }

    /**
	 * Transform font's weight into css format
	 *
	 * @param string $weight font's weight
     * @return string weight in css format
	 */
	function convert_font_weight_to_css( $weight = 'regular' ) {

		if ( $weight !== 'italic' && strpos($weight, 'italic') !== false ) {
			$weight = str_replace("italic", "", $weight);
		}

		if ( $weight === 'thin' || $weight === 'hairline' ) {
			return '100';
		}

		if ( $weight === 'extralight' || $weight === 'ultralight' ) {
			return '200';
		}

		if ( $weight === 'light' ) {
			return '300';
		}

		if ( $weight === 'regular' || $weight === 'italic' ) {
			return '400';
		}

		if ( $weight === 'medium' ) {
			return '500';
		}

		if ( $weight === 'semibold' ) {
			return '600';
		}

		if ( $weight === 'bold' ) {
			return '700';
		}

		if ( $weight === 'extrabold' || $weight === 'ultrabold' ) {
			return '800';
		}

		if ( $weight === 'black' || $weight === 'heavy' ) {
			return '900';
		}

		$css_weight = preg_replace('/[^0-9]/', '', $weight);

		return $css_weight;
	}

    /**
	 * Transform font's style into css format
	 *
	 * @param string $weight font's weight with or without style variant
     * @return string font style in css format
	 */
	public function convert_font_style_to_css( $weight = 'regular' ) {

		if ( $weight === 'regular' ) {
			return 'normal';
		}

		if ( $weight === 'italic' || strpos($weight, 'italic') !== false ) {
			return 'italic';
		}

		return 'normal';
	}

	/**
	 * Get a combined css of all custom fonts from /assets/fonts folder
	 *
     * @return string combined css of all custom fonts
	 */
	public function generate_custom_fonts_css() {
		$custom_fonts_css = '';
		$custom_fonts_list = $this->get_custom_fonts_list();
		$custom_fonts_weights_list = $this->get_custom_fonts_list(true);

		if ($custom_fonts_list) {
			foreach($custom_fonts_list as $custom_font) {
				$font_name = $custom_font;
				$font_weight = 'normal';

				if ($custom_fonts_weights_list) {
					if (isset($custom_fonts_weights_list[$font_name])) {
						foreach ($custom_fonts_weights_list[$font_name] as $file_name => $weight) {
							$font_file_name = $file_name;
							$font_weight = $this->convert_font_weight_to_css(strtolower($weight));
							$font_style = $this->convert_font_style_to_css(strtolower($weight));

							$custom_fonts_css .= $this->get_custom_fonts_css($font_name, $font_file_name, $font_weight, $font_style);
						}
					}
				} else {
					$custom_fonts_css .= $this->get_custom_fonts_css($font_name, $font_name);
				}	
			}
		}

		return $custom_fonts_css;
	}

	/**
	 * Get @font-face CSS for custom fonts
	 */
	public function get_custom_fonts_css($font_name = '', $font_file_name = '', $font_weight = 'normal', $font_style= 'normal') {
		$custom_fonts_css = "
			@font-face {
				font-family: '$font_name';
				src: url('".$this->fonts_uri."$font_file_name.eot');
				src: url('".$this->fonts_uri."$font_file_name.eot?#iefix') format('embedded-opentype'),
					url('".$this->fonts_uri."$font_file_name.woff2') format('woff2'),
					url('".$this->fonts_uri."$font_file_name.woff') format('woff'),
					url('".$this->fonts_uri."$font_file_name.ttf') format('truetype'),
					url('".$this->fonts_uri."$font_file_name.svg#$font_file_name') format('svg');
				font-weight: ".$font_weight.";
				font-style: ".$font_style.";
				text-rendering: optimizeLegibility;
			}
		";

		return apply_filters('lito_custom_fonts_css', $custom_fonts_css);
	}

	/**
	 * Get custom fonts list
	 * 
	 * @param boolean $show_weight True, if to show font's weights instead of name
	 * @return array Array of custom fonts
	 */
	public function get_custom_fonts_list($show_weight = false){
		require_once ABSPATH . 'wp-admin/includes/file.php'; // must include to make work list_files()

		$custom_fonts_list = \list_files($this->fonts_dir, 1);
		$custom_fonts = array();

		if ($custom_fonts_list) {
			$pattern_weights = '/(italic|thin|ultralight|extralight|light|regular|medium|semibold|bold|extrabold|ultrabold|black)/i';
			foreach($custom_fonts_list as $custom_font) {
				$font_ext = pathinfo($custom_font, PATHINFO_EXTENSION);

				if (!preg_match('/(eot|ttf|otf|woff|woff2|svg)/i', $font_ext)) continue;

				$font_name_full = pathinfo($custom_font, PATHINFO_FILENAME);
				$font_display_name = $font_name_full;

				$has_weight = preg_match_all($pattern_weights, $font_name_full, $weights);

				$font_name = preg_replace($pattern_weights, '', $font_name_full);
				$font_display_name = preg_replace($pattern_weights, '', $font_display_name);

				if ($show_weight) {
					if ($has_weight) {
						$weights = array_map("unserialize", array_unique(array_map("serialize", $weights)));
						$weights = array_reduce($weights, 'array_merge', array());
						$font_weight = implode("", $weights);

						if (isset($custom_fonts[$font_name])) {
							$custom_fonts[$font_name][$font_name_full] = $font_weight;
						} else {
							$custom_fonts[$font_name] = array(
								$font_name_full => $font_weight
							);
						}
					} else {
						if (isset($custom_fonts[$font_name])) {
							$custom_fonts[$font_name][$font_name_full] = 'regular';
						} else {
							$custom_fonts[$font_name] = array(
								$font_name_full => 'regular'
							);
						}
						
					}
				} else {
					$custom_fonts[$font_name] = $font_display_name;
				}
			}

		}

		return apply_filters( 'lito_custom_fonts', $custom_fonts);
	}

}