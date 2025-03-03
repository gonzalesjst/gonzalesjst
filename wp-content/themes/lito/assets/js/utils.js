/**
 * Utils JS
 * 
 * This file is required for both the front-end and the editor.
 */

const setVWVHInPx = (element) => {
    const vwInPx = element.getBoundingClientRect().width / 100;
    const vhInPx = element.getBoundingClientRect().height / 100;
    let root = element.closest("body") ? element.closest("body") : element;
    root.style.setProperty('--lito-vw-in-px', `${vwInPx}`);
    root.style.setProperty('--lito-vh-in-px', `${vhInPx}`);
}

const isStickyElement = (element) => {
    return element.classList.contains('is-sticky') || element.classList.contains('is-position-sticky');
}

/**
 * Detect when elements become wrapped
 *
 * @param {NodeList} items - list of elements to check
 * @returns {array} Array of items that were wrapped
 */
const detectWrap = (items) => {
    let wrappedItems = [];
    let prevItem = {};
    let currItem = {};

    for (let i = 0; i < items.length; i++) {
        const isSticky = isStickyElement(items[i])

        // if the item is sticky - remove sticky position to detect actual position
        // https://stackoverflow.com/a/58574139/2573521
        if (isSticky) {
            items[i].style.position = 'static';
        }

        currItem = items[i].getBoundingClientRect();

        if (isSticky) {
            items[i].style.position = 'sticky';
        }

        if (prevItem) {
            let prevItemTop = prevItem.top;
            let currItemTop = currItem.top;
            let prevItemBottom = prevItem.bottom;
            let currItemBottom = currItem.bottom;
            
            if (items[i].closest('.wp-block-group.is-style-autostack-columns.is-layout-flex:not(.is-vertical)')) {
                if (prevItemBottom < currItemTop) {
                    wrappedItems.push(items[i]);
                }
            } else {

                // if current's item top position is different from previous
                // that means that the item is wrapped
                if (prevItemTop < currItemTop || prevItemTop > currItemTop) {
                    wrappedItems.push(items[i]);
                }
            }
        }

        prevItem = currItem;
    }

    return wrappedItems;
};

const addWrapClasses = (cover, cols, cssClass = 'wrapped') => {

    // remove ".wrapped" classes to detect which items was actually wrapped
    cover.classList.remove(cssClass);

    if (cover.classList.contains('is-style-autostack-columns') && ! cover.classList.contains('wp-block-group') && ! cover.classList.contains('wp-block-media-text')) {

        const lastCol = cols[cols.length - 1];
        let lastColPosRight = Math.round(lastCol.getBoundingClientRect().right);
        let parent = cover.closest('.wp-block-column') ? cover.closest('.wp-block-column') : cover; // check if inside other column
        let parentPosRight = Math.round(parent.getBoundingClientRect().right);

        if (lastColPosRight > parentPosRight) {
            cover.classList.add(cssClass);
        }
    } else {
        // only after that detect wrap items
        let wrappedItems = detectWrap(cols); // get wrapped items

        // if there are any elements that were wrapped - add a special class to menu
        if (wrappedItems.length > 0) {
            cover.classList.add(cssClass);
        }

        if (cover.classList.contains('site-header')) {
            cover.classList.add('header-is-visible');
        }
    }
}

const handleAutostackColumns = (rootEl = null) => {
    rootEl = rootEl || document;
    const autostackCols = rootEl.querySelectorAll(".wp-block-columns.is-style-autostack-columns, .wp-block-post-template.is-style-autostack-columns, .wp-block-media-text.is-style-autostack-columns, .wp-block-group.is-style-autostack-columns.is-layout-flex:not(.is-vertical)");

    if (autostackCols.length === 0) {
        return;
    }

    autostackCols.forEach((col) => {
        const subCols = col.querySelectorAll(":scope > *");

        addWrapClasses(col, subCols, 'content-collapsed');

        jQuery(window).on('litoActualResizeHandler', function () {
            addWrapClasses(col, subCols, 'content-collapsed');
        });
    });
}

export { setVWVHInPx, handleAutostackColumns, addWrapClasses, isStickyElement };