<?php
/**
 * Customizer Custom Font Control
 * 
 * @package Lito
 * @since 1.0
 */
use Lito\Lito_Fonts;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (!class_exists('WP_Customize_Control')) {
    return null;
}

/**
 * Font selection control (family, size, weight, transform, style)
 * TBD: write tests for this class
 */
class Lito_Customize_Control_Font extends \WP_Customize_Control {

    /**
     * The type of customize control being rendered.
     */
    public $type = 'font';

    /**
     * Custom attributes
     */
    public $font_size_attrs = array();

    public $google_fonts = array();

    public $custom_fonts = array();

    public $custom_fonts_weights = array();

    /**
     * The saved font values decoded from json
     */
    private $selected_font = array();

    private $default_values = array();

    
    public function __construct( $manager, $id, $args = array(), $options = array() ) {
        parent::__construct( $manager, $id, $args );

        // Decode the default json font value
        $this->selected_font = json_decode( $this->value(), true );
        $lito_fonts = new Lito_Fonts();
        $this->google_fonts = $lito_fonts->get_all_google_fonts();
        $this->custom_fonts = $lito_fonts->get_custom_fonts_list();
        $this->custom_fonts_weights = $lito_fonts->get_custom_fonts_list(true);
        $this->default_values = lito_get_defaults();
    }

    /**
    * Get fonts for customizer
    * 
    * @return array Array of fonts
    */
    public function get_customizer_fonts(){
        $google_fonts = $this->google_fonts['items'];
        $google_fonts_names = $all_fonts = $custom_fonts = array();

        foreach($google_fonts as $id => $attrs) {
            $google_fonts_names[$attrs['family']] = $attrs['family'];
        }

       $custom_fonts = $this->custom_fonts;

       $all_fonts = $custom_fonts ? array_merge($custom_fonts, $google_fonts_names) : array_merge($google_fonts_names);
       
       return apply_filters( 'lito_customizer_fonts', $all_fonts );
    }
    

    public function get_text_transforms() {
        return apply_filters('lito_text_transforms', array(
            'none' => __('None', 'lito'),
            'capitalize' => __('Capitalize', 'lito'),
            'uppercase' => __('Uppercase', 'lito'),
            'lowercase' => __('Lowercase', 'lito'),
        ));
    }

    /**
	 * Get weights for a single Font.
	 *
	 * @param string $font Font name
     * @return array Array of weights for a single Font.
	 */
	public function get_font_weight( $font = 'Montserrat' ) {
		$google_fonts = $this->google_fonts['items'];
        $font_name = str_replace('+', ' ', $font);

        foreach($google_fonts as $id => $attrs) {
            if ($font_name === $attrs['family']) {
				$font_weights = array();
				foreach ($attrs['variants'] as $variant) {
					$font_weights[sanitize_text_field($variant)] = $variant;
				}
                return $font_weights;
                break;
            }
        }

		$custom_fonts_weights_list = $this->$custom_fonts_weights;

		if ($custom_fonts_weights_list) {
			if (isset($custom_fonts_weights_list[$font])) {
				$custom_font_weights = array();			
				foreach ($custom_fonts_weights_list[$font] as $file_name => $weight) {
					$font_weight = strtolower($weight);

					$custom_font_weights[$font_weight] = $font_weight;
				}
				return $custom_font_weights;
			}
		}

        return array('regular' => 'regular'); // default value for custom fonts
    }

    /**
     * Displays the font selection on the customize screen.
     */
    public function render_content() {

        $fonts = $this->get_customizer_fonts();
        $selected_font = $this->selected_font;
        $selected_font_weights = $this->get_font_weight( $selected_font['font'] );
        $text_transforms = $this->get_text_transforms();

        $default_values = $this->default_values;
        $default_font_value = json_decode($default_values[$this->id], true);

        $font_size = isset($selected_font['size']) ? $selected_font['size'] : $default_font_value['size'];
        $font_size_max = isset($selected_font['size_max']) ? $selected_font['size_max'] : $default_font_value['size_max'];
        $font_family = isset($selected_font['font']) ? $selected_font['font'] : $default_font_value['font'];
        $font_weight = isset($selected_font['weight']) ? $selected_font['weight'] : $default_font_value['weight'];
        $text_transform = isset($selected_font['transform']) ? $selected_font['transform'] : $default_font_value['transform'];
        $line_height = isset($selected_font['line_height']) ? $selected_font['line_height'] : $default_font_value['line_height'];
        $letter_spacing = isset($selected_font['letter_spacing']) ? $selected_font['letter_spacing'] : $default_font_value['letter_spacing'];
        
        $font_size_attrs = '';
        if ( !empty( $this->font_size_attrs ) ) {
            foreach ($this->font_size_attrs as $attr_name => $attr_value) {
                $font_size_attrs .= " $attr_name=$attr_value";
            }
        }
        ?>

        <input type="hidden" id="<?php echo esc_attr( $this->id ); ?>" name="<?php echo esc_attr( $this->id ); ?>" value='<?php echo esc_attr( $this->value() ); ?>' class="customize-control-google-font-selection" <?php $this->link(); ?> />
        
        <p>
        <label for="_customize-input-<?php echo esc_attr( $this->id ); ?>-font-family" class="customize-control-title">
            <?php echo esc_html( $this->label ); ?>
        </label>
        <span id="_customize-description-<?php echo esc_attr( $this->id ); ?>-font-family" class="description customize-control-description">
            <?php echo esc_html( $this->description ); ?>
        </span>
        <select id="_customize-input-<?php echo esc_attr( $this->id ); ?>-font-family" class="customize-control-font-family" style="height: 100%;">
            <option value=""><?php _e('Default font', 'lito'); ?></option>
            <?php
                foreach ( $fonts as $value => $label ) {
                    $selected = selected( $value, $font_family, false );
                    echo '<option value="' . esc_attr( $value ) . '"' . $selected . '>' . $label . '</option>';
                }
            ?>
        </select>
        </p>
        
        <p>
        <label for="_customize-input-<?php echo esc_attr( $this->id ); ?>-font-size" class="customize-control-title">
            <?php echo __( 'Font size in rem', 'lito' ); ?>
            <button class="customize-control-info-button"><span class="dashicons dashicons-info-outline"></span></button>
        </label>
        <span id="_customize-description-<?php echo esc_attr( $this->id ); ?>-font-size" style="display: none;" class="description customize-control-description customize-control-description-font-size">
            <?php echo __("<code>rem</code> is a font size of the root element. This value depends on browser settings. For your browser <code>1rem = <span></span></code>", "lito"); ?>
        </span>
        </p>
        
        <div class="">
            
            <input type="hidden" id="_customize-input-<?php echo esc_attr( $this->id ); ?>-font-size" class="customize-control-font-size" value="<?php echo esc_attr($font_size); ?>" />
            <input type="hidden" id="_customize-input-<?php echo esc_attr( $this->id ); ?>-font-size-max" class="customize-control-font-size-max" value="<?php echo esc_attr($font_size_max); ?>" />
            <output id="_customize-output-<?php echo esc_attr( $this->id ); ?>-font-size" class="customize-control-font-size-output"><?php echo esc_html($font_size).'rem - '.esc_html($font_size_max).'rem'; ?></output>
            <div id="_customize-output-<?php echo esc_attr( $this->id ); ?>-font-size-slider" class="customize-control-font-size-slider" <?php echo esc_attr($font_size_attrs); ?>></div>
        
        </div>
        
        <div class="row-flex">
            
            <p>
            <label for="_customize-input-<?php echo esc_attr( $this->id ); ?>-font-weight" class="customize-control-title">
                <?php echo __( 'Font weight', 'lito' ); ?>
            </label>
            <select id="_customize-input-<?php echo esc_attr( $this->id ); ?>-font-weight" class="customize-control-font-weight" style="height: 100%;">
                <?php
                    foreach ( $selected_font_weights as $value => $label ) {
                        $selected = selected( $value, $font_weight, false );
                        echo '<option class="font-weight-'.esc_attr( $value ).'" value="' . esc_attr( $value ) . '"' . $selected . '>' . $label . '</option>';
                    }
                ?>
            </select>
            </p>
        
            <p>
            <label for="_customize-input-<?php echo esc_attr( $this->id ); ?>-text-transform" class="customize-control-title">
                <?php echo __( 'Text transform', 'lito' ); ?>
            </label>
            <select id="_customize-input-<?php echo esc_attr( $this->id ); ?>-text-transform" class="customize-control-text-transform" style="height: 100%;">
                <?php
                    foreach ( $text_transforms as $value => $label ) {
                        $selected = selected( $value, $text_transform, false );
                        echo '<option class="text-transform-'.esc_attr( $value ).'" value="' . esc_attr( $value ) . '"' . $selected . '>' . $label . '</option>';
                    }
                ?>
            </select>
            </p>

        </div>
        
        <div class="row-flex">

            <p>
            <label for="_customize-input-<?php echo esc_attr( $this->id ); ?>-line-height" class="customize-control-title">
                <?php echo __( 'Line height', 'lito' ); ?>
            </label>
            <input type="text" id="_customize-input-<?php echo esc_attr( $this->id ); ?>-line-height" class="customize-control-line-height" value="<?php echo esc_attr($line_height); ?>" />
            </p>
            
            <p>
            <label for="_customize-input-<?php echo esc_attr( $this->id ); ?>-letter-spacing" class="customize-control-title">
                <?php echo __( 'Letter spacing', 'lito' ); ?>
            </label>
            <input type="text" id="_customize-input-<?php echo esc_attr( $this->id ); ?>-letter-spacing" class="customize-control-letter-spacing" value="<?php echo esc_attr($letter_spacing); ?>" />
            </p>

        </div>

        <?php
    }
}