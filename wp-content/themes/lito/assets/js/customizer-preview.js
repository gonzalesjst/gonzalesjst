jQuery( document ).ready( function($) {
	console.log( 'Customizer preview is loaded' );

	const parseFontWeight = (weight) => {
		if ( weight !== 'italic' && weight.indexOf('italic') !== -1 ) {
			weight = weight.replace("italic", "");
		}

		if ( weight === 'thin' || weight === 'hairline' ) {
			return '100';
		}

		if ( weight === 'extralight' || weight === 'ultralight' ) {
			return '200';
		}

		if ( weight === 'light' ) {
			return '300';
		}

		if ( weight === 'regular' || weight === 'italic' ) {
			return '400';
		}

		if ( weight === 'medium' ) {
			return '500';
		}

		if ( weight === 'semibold' ) {
			return '600';
		}

		if ( weight === 'bold' ) {
			return '700';
		}

		if ( weight === 'extrabold' || weight === 'ultrabold' ) {
			return '800';
		}

		if ( weight === 'black' || weight === 'heavy' ) {
			return '900';
		}

		const cssWeight = weight.replace('/[^0-9]/', '');

		return cssWeight;
	}

	const parseFontStyle = ( weight = 'regular' ) => {

		if ( weight === 'regular' ) {
			return 'normal';
		}

		if ( weight === 'italic' || weight.indexOf('italic') !== -1 ) {
			return 'italic';
		}

		return 'normal';
	}

	wp.customize(
		'lito_options[archive_sidebar_sticky]',
		function( setting ) {
			setting.bind( 
				function( newValue ) {
					if ( newValue ) {
						$( '.sidebar' ).addClass( 'is-sticky' );
					} else {
						$( '.sidebar' ).removeClass( 'is-sticky' );
					}
				} 
			);
		}
	);

	wp.customize(
		'lito_options[single_post_sidebar_sticky]',
		function( setting ) {
			setting.bind( 
				function( newValue ) {
					if ( newValue ) {
						$( '.sidebar' ).addClass( 'is-sticky' );
					} else {
						$( '.sidebar' ).removeClass( 'is-sticky' );
					}
				} 
			);
		}
	);

	wp.customize(
		'lito_options[single_page_sidebar_sticky]',
		function( setting ) {
			setting.bind( 
				function( newValue ) {
					if ( newValue ) {
						$( '.sidebar' ).addClass( 'is-sticky' );
					} else {
						$( '.sidebar' ).removeClass( 'is-sticky' );
					}
				} 
			);
		}
	);

	wp.customize(
		'lito_options[color_primary]',
		function( setting ) {
			setting.bind( 
				function( newValue ) {
					$( ':root' ).css( '--lito-color-primary', newValue );
				} 
			);
		}
	);

	wp.customize(
		'lito_options[color_primary_hover]',
		function( setting ) {
			setting.bind( 
				function( newValue ) {
					$( ':root' ).css( '--lito-color-primary-hover', newValue );
				} 
			);
		}
	);

	wp.customize(
		'lito_options[color_primary_contrast]',
		function( setting ) {
			setting.bind( 
				function( newValue ) {
					$( ':root' ).css( '--lito-color-primary-contrast', newValue );
				} 
			);
		}
	);

	wp.customize(
		'lito_options[color_secondary]',
		function( setting ) {
			setting.bind( 
				function( newValue ) {
					$( ':root' ).css( '--lito-color-secondary', newValue );
				} 
			);
		}
	);

	wp.customize(
		'lito_options[color_secondary_hover]',
		function( setting ) {
			setting.bind( 
				function( newValue ) {
					$( ':root' ).css( '--lito-color-secondary-hover', newValue );
				} 
			);
		}
	);

	wp.customize(
		'lito_options[color_secondary_contrast]',
		function( setting ) {
			setting.bind( 
				function( newValue ) {
					$( ':root' ).css( '--lito-color-secondary-contrast', newValue );
				} 
			);
		}
	);

	wp.customize(
		'lito_options[color_light]',
		function( setting ) {
			setting.bind( 
				function( newValue ) {
					$( ':root' ).css( '--lito-color-light', newValue );
				} 
			);
		}
	);

	wp.customize(
		'lito_options[color_background]',
		function( setting ) {
			setting.bind( 
				function( newValue ) {
					$( ':root' ).css( '--lito-color-background', newValue );
				} 
			);
		}
	);

	wp.customize(
		'lito_options[color_content_bg]',
		function( setting ) {
			setting.bind( 
				function( newValue ) {
					if ( newValue === '' ) {
						newValue = 'transparent';
					}
					$( ':root' ).css( '--lito-color-content-bg', newValue );
				} 
			);
		}
	);

	wp.customize(
		'lito_options[color_border]',
		function( setting ) {
			setting.bind( 
				function( newValue ) {
					$( ':root' ).css( '--lito-color-border', newValue );
				} 
			);
		}
	);

	wp.customize(
		'lito_options[color_header_menu_item]',
		function( setting ) {
			setting.bind( 
				function( newValue ) {
					$( ':root' ).css( '--lito-color-header-menu-item', newValue );
				} 
			);
		}
	);

	wp.customize(
		'lito_options[color_header_menu_item_hover]',
		function( setting ) {
			setting.bind( 
				function( newValue ) {
					$( ':root' ).css( '--lito-color-header-menu-item-hover', newValue );
				} 
			);
		}
	);

	wp.customize(
		'lito_options[color_header_bg]',
		function( setting ) {
			setting.bind( 
				function( newValue ) {
					if ( newValue === '' ) {
						newValue = 'transparent';
					}
					$( ':root' ).css( '--lito-color-header-bg', newValue );
				} 
			);
		}
	);

	wp.customize(
		'lito_options[color_footer_bg]',
		function( setting ) {
			setting.bind( 
				function( newValue ) {
					if ( newValue === '' ) {
						newValue = 'transparent';
					}
					$( ':root' ).css( '--lito-color-footer-bg', newValue );
				} 
			);
		}
	);

	wp.customize(
		'lito_options[color_footer_text]',
		function( setting ) {
			setting.bind( 
				function( newValue ) {
					$( ':root' ).css( '--lito-color-footer-text', newValue );
				} 
			);
		}
	);

	wp.customize(
		'lito_options[color_text]',
		function( setting ) {
			setting.bind( 
				function( newValue ) {
					$( ':root' ).css( '--lito-color-text', newValue );
				} 
			);
		}
	);

	wp.customize(
		'lito_options[color_text_secondary]',
		function( setting ) {
			setting.bind( 
				function( newValue ) {
					$( ':root' ).css( '--lito-color-text-secondary', newValue );
				} 
			);
		}
	);

	wp.customize(
		'lito_options[color_heading]',
		function( setting ) {
			setting.bind( 
				function( newValue ) {
					$( ':root' ).css( '--lito-color-heading', newValue );
				} 
			);
		}
	);

	wp.customize(
		'lito_options[color_outline]',
		function( setting ) {
			setting.bind( 
				function( newValue ) {
					$( ':root' ).css( '--lito-color-outline', newValue );
				} 
			);
		}
	);

	wp.customize(
		'lito_options[typo_body]',
		function( setting ) {
			setting.bind( 
				function( newValue ) {
					const font = JSON.parse( newValue );
					$( ':root' ).css( '--lito-font-family-body', font.font );
					$( ':root' ).css( '--lito-font-size-body', `${font.size}rem` );
					$( ':root' ).css( '--lito-font-size-value-body', `${font.size}` );
					$( ':root' ).css( '--lito-font-size-max-body', `${font.size_max}rem` );
					$( ':root' ).css( '--lito-font-size-max-value-body', `${font.size_max}` );
					$( ':root' ).css( '--lito-font-weight-body', `${parseFontWeight(font.weight)}` );
					$( ':root' ).css( '--lito-font-style-body', `${parseFontStyle(font.weight)}` );
					$( ':root' ).css( '--lito-text-transform-body', `${font.transform}` );
					$( ':root' ).css( '--lito-line-height-body', `${font.line_height}` );
					$( ':root' ).css( '--lito-letter-spacing-body', `${font.letter_spacing}` );
				}
			);
		}
	);

	wp.customize(
		'lito_options[typo_body_small]',
		function( setting ) {
			setting.bind( 
				function( newValue ) {
					const font = JSON.parse( newValue );
					$( ':root' ).css( '--lito-font-family-body-small', font.font );
					$( ':root' ).css( '--lito-font-size-body-small', `${font.size}rem` );
					$( ':root' ).css( '--lito-font-size-value-body-small', `${font.size}` );
					$( ':root' ).css( '--lito-font-size-max-body-small', `${font.size_max}rem` );
					$( ':root' ).css( '--lito-font-size-max-value-body-small', `${font.size_max}` );
					$( ':root' ).css( '--lito-font-weight-body-small', `${parseFontWeight(font.weight)}` );
					$( ':root' ).css( '--lito-font-style-body-small', `${parseFontStyle(font.weight)}` );
					$( ':root' ).css( '--lito-text-transform-body-small', `${font.transform}` );
					$( ':root' ).css( '--lito-line-height-body-small', `${font.line_height}` );
					$( ':root' ).css( '--lito-letter-spacing-body-small', `${font.letter_spacing}` );
				}
			);
		}
	);

	wp.customize(
		'lito_options[typo_body_large]',
		function( setting ) {
			setting.bind( 
				function( newValue ) {
					const font = JSON.parse( newValue );
					$( ':root' ).css( '--lito-font-family-body-large', font.font );
					$( ':root' ).css( '--lito-font-size-body-large', `${font.size}rem` );
					$( ':root' ).css( '--lito-font-size-value-body-large', `${font.size}` );
					$( ':root' ).css( '--lito-font-size-max-body-large', `${font.size_max}rem` );
					$( ':root' ).css( '--lito-font-size-max-value-body-large', `${font.size_max}` );
					$( ':root' ).css( '--lito-font-weight-body-large', `${parseFontWeight(font.weight)}` );
					$( ':root' ).css( '--lito-font-style-body-large', `${parseFontStyle(font.weight)}` );
					$( ':root' ).css( '--lito-text-transform-body-large', `${font.transform}` );
					$( ':root' ).css( '--lito-line-height-body-large', `${font.line_height}` );
					$( ':root' ).css( '--lito-letter-spacing-body-large', `${font.letter_spacing}` );
				}
			);
		}
	);

	wp.customize(
		'lito_options[typo_header]',
		function( setting ) {
			setting.bind(
				function( newValue ) {
					const font = JSON.parse( newValue );
					$( ':root' ).css( '--lito-font-family-header', font.font );
					$( ':root' ).css( '--lito-font-size-header', `${font.size}rem` );
					$( ':root' ).css( '--lito-font-size-value-header', `${font.size}` );
					$( ':root' ).css( '--lito-font-size-max-header', `${font.size_max}rem` );
					$( ':root' ).css( '--lito-font-size-max-value-header', `${font.size_max}` );
					$( ':root' ).css( '--lito-font-weight-header', `${parseFontWeight(font.weight)}` );
					$( ':root' ).css( '--lito-font-style-header', `${parseFontStyle(font.weight)}` );
					$( ':root' ).css( '--lito-text-transform-header', `${font.transform}` );
					$( ':root' ).css( '--lito-line-height-header', `${font.line_height}` );
					$( ':root' ).css( '--lito-letter-spacing-header', `${font.letter_spacing}` );

					$( '#site-header' ).trigger( 'litoTypoChange' );
				}
			);
		}
	);
	
	for ( let i = 1; i <= 6; i++ ) {
		wp.customize(
			'lito_options[typo_h' + i + ']',
			function( setting ) {
				setting.bind( 
					function( newValue ) {
						const font = JSON.parse( newValue );
						$( ':root' ).css( '--lito-font-family-h' + i, font.font );
						$( ':root' ).css( '--lito-font-size-h' + i, `${font.size}rem` );
						$( ':root' ).css( '--lito-font-size-value-h' + i, `${font.size}` );
						$( ':root' ).css( '--lito-font-size-max-h' + i, `${font.size_max}rem` );
						$( ':root' ).css( '--lito-font-size-max-value-h' + i, `${font.size_max}` );
						$( ':root' ).css( '--lito-font-weight-h' + i, `${parseFontWeight(font.weight)}` );
						$( ':root' ).css( '--lito-font-style-h' + i, `${parseFontStyle(font.weight)}` );
						$( ':root' ).css( '--lito-text-transform-h' + i, `${font.transform}` );
						$( ':root' ).css( '--lito-line-height-h' + i, `${font.line_height}` );
						$( ':root' ).css( '--lito-letter-spacing-h' + i, `${font.letter_spacing}` );
					} 
				);
			}
		);
	}

	wp.customize.preview.bind( 'active', function() {
		let bodyClass = document.querySelector('body').className,
			bodyClassArr = bodyClass.split(" ");
  
			wp.customize.preview.send( 'litoGetBodyClasses', bodyClassArr );
	} );

})