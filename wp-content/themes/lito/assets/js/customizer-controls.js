(function( $ ) {
    wp.customize.bind( 'ready', function() {
        console.log('Customizer controls are ready')

        let previewerBodyClasses = [];

        wp.customize.previewer.bind( 'litoGetBodyClasses', function( data ) {
            previewerBodyClasses = data;
        } );

        const updatePreviewerOnSectionChange = (section, bodyClass = [], defaultURL = wp.customize.settings.url.home) => {
            if (!section) {
                return;
            }
            /**
             * return to the previous URL when the section collapses
             * https://make.xwp.co/2016/07/21/navigating-to-a-url-in-the-customizer-preview-when-a-section-is-expanded/ 
             */
            let previousUrl, clearPreviousUrl, previewUrlValue;
            previewUrlValue = wp.customize.previewer.previewUrl;
            clearPreviousUrl = function() {
                previousUrl = null;
            };
    
            section.expanded.bind( function( isExpanded ) {
                let url;
                if ( isExpanded ) {
                    if ( !previewerBodyClasses.some(cssClass => bodyClass.includes(cssClass)) ) {
                        url = defaultURL;
                    }

                    if (url) {
                        previousUrl = previewUrlValue.get();
                        previewUrlValue.set( url );
                        previewUrlValue.bind( clearPreviousUrl );
                    }
                } else {
                    previewUrlValue.unbind( clearPreviousUrl );
                    if ( previousUrl ) {
                        previewUrlValue.set( previousUrl );
                    }
                }
            } );
        }

        /**
         * Copies classes from original <select><option> to select2 options
         * https://select2.org/dropdown
         * @param {*} data 
         * @param {*} container 
         * @returns string
         */
        const select2CopyClasses = (data, container) => {
            if (data.element) {
                $(container).addClass($(data.element).attr("class"));
            }
            return data.text;
        }

        // append select2 to all select inputs
        $('.customize-control select[multiple]').each(function(){
            $(this).select2({
                dropdownParent: $('#customize-controls'),
                templateResult: select2CopyClasses,
            });
        });

        $('.customize-control select:not([multiple])').each(function(){
            $(this).select2({
                dropdownParent: $('#customize-controls'),
                allowClear: false,                
                templateResult: select2CopyClasses,
            });
        })

        /**
         * Get weights for a Google Font
         * @param {string} font value of a font
         * @param {HTMLCollection} select jQuery dropdown with font weights
         */
        const getFontWeights = (font, select) => {
            const fontWeights = litoCustomizer.googlefonts?.items[font]?.variants;

            if (fontWeights.length > 0) {
                select.find('option').remove();
                fontWeights.forEach(fontVariant => {
                    let selected = (fontVariant === 'regular' ? 'selected' : '');
                    select.append($(`<option class="font-weight-${fontVariant}" ${selected} />`).val(fontVariant).text(fontVariant));
                })
                select.change();
            }
        }

        /**
         * Updates font value after change
         * @param {object} e event
         * TBD: create a class to make it easier to add new fields to the font control
         */
        const updateFont = (e) => {
            let fontControl = $(e.target).closest('.customize-control-font');
            const fontControlHidden = fontControl.find('.customize-control-google-font-selection');

            let selectedFont = {
                font: fontControl.find('.customize-control-font-family').val(),
                weight: fontControl.find('.customize-control-font-weight').val(),
                transform: fontControl.find('.customize-control-text-transform').val(),
                size: fontControl.find('.customize-control-font-size').val(),
                size_max: fontControl.find('.customize-control-font-size-max').val(),
                line_height: fontControl.find('.customize-control-line-height').val(),
                letter_spacing: fontControl.find('.customize-control-letter-spacing').val(),
            };
    
            // Important! Make sure to trigger change event so Customizer knows it has to save the field
            fontControlHidden.val(JSON.stringify(selectedFont)).trigger('change');
        }

        /**
         * @see https://brokul.dev/detecting-the-default-browser-font-size-in-javascript
         */
        const getDefaultFontSize = () => {
            const element = document.createElement('div');
            element.style.width = '1rem';
            element.style.display = 'none';
            document.body.append(element);
        
            const widthMatch = window
                .getComputedStyle(element)
                .getPropertyValue('width')
                .match(/\d+/);
        
            element.remove();
        
            if (!widthMatch || widthMatch.length < 1) {
                return null;
            }
        
            const result = Number(widthMatch[0]);
            return !isNaN(result) ? result : null;
        };

        const convertRemToPx = (rem) => {
            const defaultFontSize = getDefaultFontSize();
            return `${rem * defaultFontSize}`;
        }

        $('.customize-control-description-font-size').each(function(){
            const span = $(this).find('span');
            const value = getDefaultFontSize();

            span.text(`${value}px`);
        })
        
        // Trigger font update on weight change
        $('select.customize-control-font-weight').on('change', function(e){
            updateFont(e);
            wp.customize.previewer.refresh();
        })

        // Trigger font update on size change
        $('input.customize-control-font-size').on('input', function(e){
            const input = $(e.target);
            const value = input.siblings("output");
            const valueInPx = convertRemToPx(input.val());
            value.text(`${input.val()}rem = ${valueInPx}px`); // update output value

            updateFont(e);
        })

        // Trigger font update on line-height change
        $('input.customize-control-line-height').on('change', function(e){
            updateFont(e);
        })

        // Trigger font update on letter-spacing change
        $('input.customize-control-letter-spacing').on('change', function(e){
            updateFont(e);
        })

        // Trigger font update on font family change and get new values for font weights
        $('select.customize-control-font-family').on('change', function(e){
            
            let fontContainer = $(e.target).closest('.customize-control-font');
            let fontWeightSelect = fontContainer.find('select.customize-control-font-weight');
            let fontFamily = $(this).val();

            updateFont(e);

            getFontWeights(fontFamily, fontWeightSelect);

            wp.customize.previewer.refresh();
        })

        // Trigger font update on text transform change
        $('select.customize-control-text-transform').on('change', function(e){
            updateFont(e);
        })

        // Handle info box toggle
        $('.customize-control-info-button').on('click', function(e){
            e.preventDefault();
            const info = $(this).closest("label").siblings('.customize-control-description');
            info.slideToggle();
        })

        // Init jQuery UI slider
        $( ".customize-control-font-size-slider" ).each(function(){
            const slider = $(this);
            const min = parseFloat(slider.attr('min')) || 1;
            const max = parseFloat(slider.attr('max')) || 5;
            const step = parseFloat(slider.attr('step')) || 0.25;
            const fontSizeMinField = slider.siblings('.customize-control-font-size');
            const fontSizeMaxField = slider.siblings('.customize-control-font-size-max');
            const fontSizeMinVal = parseFloat(fontSizeMinField.val()) || min;
            const fontSizeMaxVal = parseFloat(fontSizeMaxField.val()) || max;
            const outputField = slider.siblings('.customize-control-font-size-output');
            const values = [fontSizeMinVal, fontSizeMaxVal]
            const handleSliderChange = (minValue, maxValue) => {
                const minValueInPx = convertRemToPx(minValue);
                const maxValueInPx = convertRemToPx(maxValue);
                fontSizeMinField.val( minValue );
                fontSizeMaxField.val( maxValue );
                outputField.val( `${minValue}rem (${minValueInPx}px) - ${maxValue}rem (${maxValueInPx}px)` );
            }

            slider.slider({
                range: true,
                min: min,
                max: max,
                step: step,
                values: values,
                create: function( event, ui ) {
                    handleSliderChange(fontSizeMinVal, fontSizeMaxVal);
                },
                slide: function( event, ui ) {
                    handleSliderChange(ui.values[0], ui.values[1]);
                    updateFont(event);
                }
            });
        })

        wp.customize.control('header_is_sticky', function (control) {
			control.setting.bind(function (value) {
				if (value) {
                    wp.customize.control('header_is_hide_on_scroll').activate();
                } else {
                    wp.customize.control('header_is_hide_on_scroll').deactivate();
                }
			});
		});

        wp.customize.control('content_width', function (control) {
            control.setting.bind(function (value) {
                const containerWidthControl = wp.customize.control('container_width');
                let containerWidth = containerWidthControl.setting.get();

                $(control.selector).find('input').attr('max', (containerWidth - 1));
                $(containerWidthControl.selector).find('input').attr('min', parseInt(value) + 1);

                if (containerWidth < value) {
                    control.setting.set(containerWidth - 1);
                }
            });
        });
        
        wp.customize.control('container_width', function (control) {
            control.setting.bind(function (value) {
                const contentWidthControl = wp.customize.control('content_width');
                let contentWidth = contentWidthControl.setting.get();

                $(control.selector).find('input').attr('min', parseInt(contentWidth) + 1);
                $(contentWidthControl.selector).find('input').attr('max', (value - 1));

                if (contentWidth > value) {
                    control.setting.set(parseInt(contentWidth) + 1);
                }
            });
        });

        wp.customize.section( 'lito_archive_options', function( section ) {
            updatePreviewerOnSectionChange(section, ['archive', 'blog', 'search', 'category', 'tag'], litoCustomizer.defaultArchiveURL);
        });

        wp.customize.section( 'lito_single_post_options', function( section ) {
            updatePreviewerOnSectionChange(section, ['single-post'], litoCustomizer.defaultSinglePostURL);
        });

        wp.customize.section( 'lito_single_page_options', function( section ) {
            updatePreviewerOnSectionChange(section, ['page'], litoCustomizer.defaultSinglePageURL);
        });
       
    });
}) ( jQuery );