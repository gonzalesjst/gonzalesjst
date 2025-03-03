import { setVWVHInPx } from './utils.js';

( function() {
    'use strict';

    /**
     * @see https://gist.github.com/KevinBatdorf/fca19e1f3b749b5c57db8158f4850eff 
     */
    const select = wp.data.select;
    const subscribe = wp.data.subscribe;

    function whenEditorIsReady() {
        return new Promise((resolve) => {
            const unsubscribe = subscribe(() => {
                // This will trigger after the initial render blocking, before the window load event
                // This seems currently more reliable than using __unstableIsEditorReady
                if (select('core/editor')?.isCleanNewPost() || select('core/block-editor')?.getBlockCount() > 0) {
                    unsubscribe()
                    resolve()
                }
            })
        })
    }

    function listenEditorViewporWidthChange(callback) {
        let previousWidth;

        if (document.querySelector('.is-root-container')) {
            previousWidth = document.querySelector('.is-root-container').clientWidth;
        } else {
            if (document.querySelector('.editor-canvas__iframe')) {
                previousWidth = document.querySelector('.editor-canvas__iframe').contentDocument.querySelector('.is-root-container')?.clientWidth;
            }
        }

        // Subscribe to changes in the viewport mode
        const unsubscribe = subscribe(() => {
            let currentWidth;

            if (document.querySelector('.is-root-container')) {
                currentWidth = document.querySelector('.is-root-container').clientWidth;
            } else {
                if (document.querySelector('.editor-canvas__iframe')) {
                    currentWidth = document.querySelector('.editor-canvas__iframe').contentDocument.querySelector('.is-root-container')?.clientWidth;
                }
            }

            // If the viewport mode changes, trigger the callback function
            if (currentWidth !== previousWidth) {
                callback(currentWidth);
                previousWidth = currentWidth;
            }
        });

        return unsubscribe;

    }

    const unsubscribeEditorViewporWidthChange = listenEditorViewporWidthChange((newWidth) => {
        //console.log('Editor viewport width changed to:', newWidth);

        if (document.querySelector('.is-root-container')) {
            setVWVHInPx(document.querySelector('.is-root-container'));
        } else if(document.querySelector('.editor-canvas__iframe')) {
            setTimeout(() => {
                setVWVHInPx(document.querySelector('.editor-canvas__iframe').contentDocument.querySelector('.is-root-container'));
            }, 300);
        }

    });
    
    // To stop listening, call the unsubscribe function
    // unsubscribeViewModeChange();

    whenEditorIsReady().then(() => {

        console.log('Editor is ready!')

        setVWVHInPx(document.querySelector('.is-root-container'));
        
        window.addEventListener('resize', function() {
            if (document.querySelector('.is-root-container')) {
                setVWVHInPx(document.querySelector('.is-root-container'));
            }
        })
    })

} )();