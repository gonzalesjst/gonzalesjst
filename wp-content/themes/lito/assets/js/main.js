import { setVWVHInPx, handleAutostackColumns, addWrapClasses, isStickyElement } from './utils.js';
import SimpleBar from 'simplebar'; // or "import SimpleBar from 'simplebar';" if you want to use it manually.

// You will need a ResizeObserver polyfill for browsers that don't support it! (iOS Safari, Edge, ...)
import ResizeObserver from 'resize-observer-polyfill';
window.ResizeObserver = ResizeObserver;

( function() {
'use strict';

setVWVHInPx(document.documentElement); // should be called as soon as possible

jQuery(document).ready(function ($) {
    console.log('Hello from main.js');
    const headerSearchButtons = document.querySelectorAll('.header-search__toggle');
    const submenuButtons = document.querySelectorAll("ul.menu .menu-item-has-children > .menu-item-arrow");
    const mobileMenuToggleButton = document.querySelector(".main-navigation .menu-toggle");
    const togglePlayMediaButtons = document.querySelectorAll('.entry-media .toggle-play-media');
    const entryMedias = document.querySelectorAll('.entry-media video, .entry-media audio');
    const anchors = document.querySelectorAll('a[href*="#"]');

    // Apply arguments for the Slick slider 
    $('.post-gallery-slider').slick(Object.assign({}, litoMain.slickArgs));
    
    let resizeTimeout; // timeout ID

    // Define a variable that will store the Lenis smooth scrolling object
    let lenis;

    const initSimpleBar = () => {
        // Init SimpleBar
        Array.prototype.forEach.call(
            document.querySelectorAll('.sidebar'),
            (el) => new SimpleBar(el)
        );
    }

    // Function to initialize Lenis for smooth scrolling
    const initSmoothScrolling = () => {
        if (typeof Lenis === 'undefined') {
            return;
        }

        // Instantiate the Lenis object with specified properties
        lenis = new Lenis({
            lerp: 0.1, // Lower values create a smoother scroll effect
            smoothWheel: true, // Enables smooth scrolling for mouse wheel events
        });

        // Update ScrollTrigger each time the user scrolls
        if (typeof ScrollTrigger !== 'undefined') {
            lenis.on('scroll', () => ScrollTrigger.update());
        }

        // Define a function to run at each animation frame
        const scrollFn = (time) => {
            lenis.raf(time); // Run Lenis' requestAnimationFrame method
            requestAnimationFrame(scrollFn); // Recursively call scrollFn on each frame
        };
        // Start the animation frame loop
        requestAnimationFrame(scrollFn);
    };

    const handleScrollInsideSimpleBar = () => {
        const simpleBarScrollables = document.querySelectorAll('.simplebar-scrollable-y');
        simpleBarScrollables.forEach((scrollable) => {
            scrollable.setAttribute('data-lenis-prevent', '');
        });
    }

    const handleScrollToAnchor = () => {
		anchors.forEach(anchor => {
			anchor.addEventListener('click', function (e) {

				const currentFullURL = window.location.href;
				const url = new URL(currentFullURL);
				const currentURL = url.origin + url.pathname;
				let target = document.getElementById(this.getAttribute('href').replace('#', '').replace(currentURL, ''));

				if (target) {
					e.preventDefault();
					lenis.scrollTo(target);
				}
			});
		});
	}

    const setHeaderHeight = () => {
        const header = document.querySelector('.site-header');

        if (header) {
            let headerHeight = header.getBoundingClientRect().height;
            document.querySelector(":root").style.setProperty('--lito-header-height', `${headerHeight}px`);
        }
    }

    /* When the user scrolls down, hide the navbar. When the user scrolls up, show the navbar */
    const handleHideHeaderOnScroll = () => {
        const header = $('.site-header');
        const mobileMenu = $('.site-mobile-menu');
        let prevScroll = window.scrollY;

        window.addEventListener('scroll', function () {
            if (!header.hasClass('hide-on-scroll')) {
                header.addClass('header-is-visible');
                return;
            }

            let currentScroll = window.scrollY;
            if (prevScroll > currentScroll) {
                header.addClass('header-scroll-up');
                header.addClass('header-is-visible');

            } else {
                if (isStickyElement(header[0]) && currentScroll > header.outerHeight()) {
                    header.removeClass('header-scroll-up');
                    header.removeClass('header-is-visible');
                }
            }
            if ($('#wpadminbar').length > 0 && $('#wpadminbar').css('position') === 'absolute' && mobileMenu.length > 0) {
                if (currentScroll > $('#wpadminbar').outerHeight()) {
                    mobileMenu.addClass('adminbar-was-scrolled');
                } else {
                    mobileMenu.removeClass('adminbar-was-scrolled');
                }
            }
            prevScroll = currentScroll;
        })
    }

    /**
     * Detect when the header is over the cover post entry header
     */
    const handleHeaderOverCoverPostEntryHeader = () => {
        const header = $('.site-header');
        const coverPost = $('.entry-header.is-cover-post');
        if (coverPost.length === 0) {
            return;
        }
        
        let coverPostBottom = coverPost.offset().top + coverPost.outerHeight();
        let headerBottom = header.offset().top + header.outerHeight();

        const handleHeaderClasses = (headerBottom, coverPostBottom) => {
            if (headerBottom < coverPostBottom) {
                header.addClass('is-over-cover-post');
            } else {
                header.removeClass('is-over-cover-post');
            }
        }
        handleHeaderClasses(headerBottom, coverPostBottom);

        window.addEventListener('scroll', function () {
            headerBottom = header.offset().top + header.outerHeight();
            coverPostBottom = coverPost.offset().top + coverPost.outerHeight();
            handleHeaderClasses(headerBottom, coverPostBottom);
        })
    }

    /**
     * Set appropriate spanning to any masonry item
     *
     * Get different properties we already set for the masonry, calculate 
     * height or spanning for any cell of the masonry grid based on its 
     * content-wrapper's height, the (row) gap of the grid, and the size 
     * of the implicit row tracks.
     *
     * @param item Object A brick/tile/cell inside the masonry
     * @see https://w3bits.com/css-grid-masonry/ 
     */
    const resizeMasonryItem = (item) => {
        /* Get the grid object, its row-gap, and the size of its implicit rows */
        let grid = document.querySelector('.site-content--masonry .content-posts'),
            rowGap = parseInt(window.getComputedStyle(grid).getPropertyValue('grid-row-gap')),
            rowHeight = parseInt(window.getComputedStyle(grid).getPropertyValue('grid-auto-rows'));

        /*
         * Spanning for any brick = S
         * Grid's row-gap = G
         * Size of grid's implicitly create row-track = R
         * Height of item content = H
         * Net height of the item = H1 = H + G
         * Net height of the implicit row-track = T = G + R
         * S = H1 / T
         */
        const innerContent = item.classList.contains('post') ? item.querySelector('.post__inner') : item.querySelector('.nav-links');
        let rowSpan = Math.ceil((innerContent.getBoundingClientRect().height + rowGap) / (rowHeight + rowGap));

        /* Set the spanning as calculated above (S) */
        item.style.gridRowEnd = 'span ' + rowSpan;
    }

    /**
     * Apply spanning to all the masonry items
     *
     * Loop through all the items and apply the spanning to them using 
     * `resizeMasonryItem()` function.
     *
     * @uses resizeMasonryItem
     * @see https://w3bits.com/css-grid-masonry/ 
     */
    const resizeAllMasonryItems = () => {
        // Get all item class objects in one list
        const allItems = document.querySelectorAll('.site-content--masonry .content-posts > *');

        /*
         * Loop through the above list and execute the spanning function to
         * each list-item (i.e. each masonry item)
         */
        for (let i = 0; i < allItems.length; i++) {
            allItems[i].style.gridRowEnd = '';
            resizeMasonryItem(allItems[i]);
        }
    }

    const handleMobileMenuClose = () => {
        const siteHeader = document.querySelector(".site-header");
        if (!siteHeader) {
            return;
        }
        const mobileMenuToggleButton = document.querySelector(".main-navigation .menu-toggle");
        const mobileMenu = document.querySelector(".site-mobile-menu");
        const body = document.querySelector("body");

        if (!mobileMenu || !mobileMenuToggleButton) {
            return;
        }

        mobileMenuToggleButton.classList.remove("is-active");
        siteHeader.classList.remove("is-mobile-menu-active");
        mobileMenu.classList.remove("is-active");
        body.classList.remove("is-mobile-menu-active");
        toggleNonVisibleElementsFocus();
    }

    const handleHeaderSearchToggle = (e) => {
        const searchButton = $(e.target);
        if (!searchButton) {
            return;
        }
        const searchBlock = searchButton.closest('.header-search');
        const searchBlockCol = searchButton.closest('.site-header__inner__col');
        const searchField = searchBlock.find('.search-field');

        searchBlock.toggleClass('is-active');
        searchBlockCol.toggleClass('is-search-active');
        handleMobileMenuClose();

        if (searchBlock.hasClass('is-active')) {
            searchField.focus();
        }
        toggleNonVisibleElementsFocus();
    }

    const handleMainNavCollapse = (e) => {
        const siteHeader = document?.querySelector(".site-header");
        const mainNavMenu = siteHeader?.querySelector(".main-navigation > .menu");
        if (!siteHeader || !mainNavMenu) {
            return;
        }
        const cols = mainNavMenu.querySelectorAll(":scope > *");

        addWrapClasses(siteHeader, cols, 'menu-collapsed');

        $(window).on('litoActualResizeHandler', function () {
            addWrapClasses(siteHeader, cols, 'menu-collapsed');
        });

        $(siteHeader).on('litoTypoChange', function () {
            addWrapClasses(siteHeader, cols, 'menu-collapsed');
        })
    }

    const handleFooterCollapse = (e) => {
        const siteFooter = document.querySelector(".site-footer");
        if (!siteFooter) {
            return;
        }
        const footerInner = siteFooter.querySelector(".site-footer__inner");
        const cols = footerInner.querySelectorAll(":scope > *");

        addWrapClasses(siteFooter, cols, 'footer-collapsed');

        $(window).on('litoActualResizeHandler', function () {
            addWrapClasses(siteFooter, cols, 'footer-collapsed');
        });
    }

    const handleSidebarCollapse = (e) => {
        if ($(".site-content.has-sidebar").length > 0) {
            const siteContent = document.querySelector(".site-content.has-sidebar");
            const wrapContent = siteContent.querySelector(".content-area");
            const cols = wrapContent.querySelectorAll(":scope > .sidebar, :scope > .content-posts, :scope > .single");

            addWrapClasses(wrapContent, cols, 'content-collapsed');

            $(window).on('litoActualResizeHandler', function () {
                addWrapClasses(wrapContent, cols, 'content-collapsed');
            });
        }
    }

    const handleHeaderCollapse = (e) => {
        if ($(".entry-header.is-side-post").length > 0) {
            const entryHeader = document.querySelector(".entry-header.is-side-post");
            const cols = entryHeader.querySelectorAll(":scope > *");

            addWrapClasses(entryHeader, cols, 'content-collapsed');

            $(window).on('litoActualResizeHandler', function () {
                addWrapClasses(entryHeader, cols, 'content-collapsed');
            });
        }
    }

    const handleSidePostCollapse = (e) => {
        const sidePosts = document.querySelectorAll(".post.is-side-post");

        if (sidePosts.length === 0) {
            return;
        }

        sidePosts.forEach((sidePost) => {
            const cols = sidePost.querySelector('.post__inner')?.querySelectorAll(":scope > *");

            if (!cols) {
                return;
            }

            addWrapClasses(sidePost, cols, 'content-collapsed');

            $(window).on('litoActualResizeHandler', function () {
                addWrapClasses(sidePost, cols, 'content-collapsed');
            });
        });
    }

    const handleSubmenuButtonClick = (e) => {
        e.preventDefault();

        const button = e.target;
        const li = button.closest("li");
        const submenu = li.querySelector(":scope > .sub-menu");
        const allPrimaryLis = button.closest(".menu").querySelectorAll(":scope > .menu-item-has-children");
        const isMobileMenu = button.closest(".site-mobile-menu");
        const transitionDuration = litoMain.transitionDuration || 300;

        if (submenu) {
            allPrimaryLis.forEach((el) => {
                if (el !== li && !el.contains(li)) {
                    el.classList.remove("is-active");

                    const submenus = el.querySelectorAll(".sub-menu");
                    submenus.forEach((submenu) => {
                        submenu.classList.remove("is-active");

                        if (isMobileMenu) {
                            $(submenu).slideUp(transitionDuration);
                        }
                    });
                }
            });
            submenu.classList.toggle("is-active");
            li.classList.toggle("is-active");

            if (button.closest(".site-mobile-menu")) {
                $(submenu).slideToggle(transitionDuration);
            }
            toggleNonVisibleElementsFocus();
        }
    }

    const handleMobileMenuToggle = (e) => {
        e.preventDefault();

        const button = e.target;
        const siteHeader = button.closest(".site-header");
        const mobileMenu = document.querySelector(".site-mobile-menu");
        const body = document.querySelector("body");

        if (!siteHeader || !mobileMenu) {
            return;
        }

        button.classList.toggle("is-active");
        siteHeader.classList.toggle("is-mobile-menu-active");
        mobileMenu.classList.toggle("is-active");
        body.classList.toggle("is-mobile-menu-active");
        toggleNonVisibleElementsFocus();
    }

    const termSiblingsSliderInit = () => {
        const termSiblings = document.querySelector(".term-siblings");
        if (termSiblings) {
            const currentSlide = termSiblings.querySelector(".current-cat");
            const currentSlideIndex = Array.from(termSiblings.children).indexOf(currentSlide);

            $(termSiblings).slick({
                centerMode: true,
                centerPadding: 'var(--lito-spacing-grid)',
                swipe: false,
                infinite: false,
                draggable: false,
                dots: false,
                arrows: false,
                initialSlide: currentSlideIndex,
                variableWidth: true,
            });
        }
    }

    const handleClickOutsideMenu = (e) => {
        const menu = document.querySelector(".site-header .main-navigation");
        if (!menu) {
            return;
        }
        const lis = menu.querySelectorAll("li");
        const subMenus = menu.querySelectorAll(".sub-menu");

        if (menu && !menu.contains(e.target)) {
            for (let i = 0; i < lis.length; i++) {
                lis[i].classList.remove("is-active");
            }
            for (let i = 0; i < subMenus.length; i++) {
                subMenus[i].classList.remove("is-active");
            }
            toggleNonVisibleElementsFocus();
        }
    }

    const toggleNonVisibleElementsFocus = () => {
        const nonVisibleSelectors = [
            '.screen-reader-text a',
            '.sub-menu:not(.is-active) > li > a',
            '.sub-menu:not(.is-active) > li > button',
            '.site-mobile-menu:not(.is-active) a',
            '.header-search:not(.is-active) .header-search__form button',
            '.header-search:not(.is-active) .header-search__form input'
        ];
        const nonVisibleElements = document.querySelectorAll(nonVisibleSelectors.join(','));
        const visibleSelectors = [
            '.sub-menu.is-active > li > a',
            '.sub-menu.is-active > li > button',
            '.site-mobile-menu.is-active a',
            '.header-search.is-active .header-search__form button',
            '.header-search.is-active .header-search__form input'
        ];
        const visibleElements = document.querySelectorAll(visibleSelectors.join(','));
        nonVisibleElements.forEach((el) => {
            el.setAttribute('tabindex', '-1');
        });
        visibleElements.forEach((el) => {
            el.setAttribute('tabindex', '0');
        });
    }

    const lockTabInsideMobileMenu = (e) => {
        const target = e.target;
        const shiftPressed = e.shiftKey;
        const mobileMenuSelector = '.site-mobile-menu';
        const mobileMenu = document.querySelector(mobileMenuSelector);
        if (!mobileMenu) {
            return;
        }
        const headerSelector = '.site-header';
        const headerElements = document.querySelectorAll('.site-header a, .site-header button');
        const menuElements = mobileMenu.querySelectorAll("a[href], button");
        let focusElements = Array.prototype.slice.call(headerElements).concat(Array.prototype.slice.call(menuElements));

        // If TAB key pressed
        if (e.keyCode === 9) {
            // If inside a fullscreen menu or header and the menu is open
            if ( (target.closest(mobileMenuSelector) || target.closest(headerSelector)) && mobileMenu.classList.contains('is-active') ) {
                
                // Find the first or the last input element in the dialog parent (depending on whether Shift was pressed).
                let borderElem = shiftPressed
                    ? focusElements[0]
                    : focusElements[focusElements.length - 1];

                if (borderElem) {
                    // If the current target element is the first or last focusable element in the dialog, prevent the default behaviour.
                    if (target === borderElem) {
                        e.preventDefault();

                        // move focus to the first element when the last one is reached and vice versa
                        borderElem === focusElements[0]
                            ? focusElements[focusElements.length - 1].focus()
                            : focusElements[0].focus();
                    }
                }
            }
        }
    }

    const handleVideoPostHover = () => {
        const videoPosts = document.querySelectorAll('.post.format-video');
        videoPosts.forEach((post) => {
            const video = post.querySelector('video');
            if (video) {
                post.addEventListener('mouseenter', function () {
                    video.play();
                });
                post.addEventListener('mouseleave', function () {
                    video.pause();
                });
            }
        });
    }

    const fixSubmenuPosition = () => {
        const submenus = document.querySelectorAll('.sub-menu');
        submenus.forEach((submenu) => {
            const submenuRect = submenu.getBoundingClientRect();
            const submenuBottom = submenuRect.bottom + window.scrollY;
            const bodyHeight = document.body.getBoundingClientRect().height;

            if (submenuBottom > bodyHeight) {
                submenu.style.maxHeight = `${submenuRect.height - (submenuBottom - bodyHeight)}px`;
                submenu.classList.add('overflow-bottom');
            }
        })
    }

    const handleTogglePlayMediaButton = (e) => {
        const button = e.target;
        const mediaWrapper = button.closest('.entry-media');
        const media = mediaWrapper.querySelector('video, audio');

        if (media) {
            if (media.paused) {
                media.play();
                button.classList.add('is-playing');
            } else {
                media.pause();
                button.classList.remove('is-playing');
            }
        }
    }

    const handleLoadMedia = (e) => {
        const media = e.target;
        const mediaWrapper = media.closest('.entry-media');
        const togglePlayMediaButton = mediaWrapper.querySelector('.toggle-play-media');

        if (media.duration > 0 && !media.paused && !media.ended) {
            togglePlayMediaButton.classList.add('active');
            togglePlayMediaButton.classList.add('is-playing');
        }

        if (media.paused) {
            togglePlayMediaButton.classList.remove('is-playing');
        }
    }

    entryMedias.forEach((media) => {
        media.addEventListener('timeupdate', handleLoadMedia) // loadeddata event is not working if the media is already loaded by autoplay
    })

    togglePlayMediaButtons.forEach((button) => {
        button.addEventListener('click', handleTogglePlayMediaButton);
    });

    headerSearchButtons.forEach((button) => {
        button.addEventListener('click', handleHeaderSearchToggle);
    })
    
    submenuButtons.forEach((button) => {
        button.addEventListener("click", handleSubmenuButtonClick);
    });
    
    mobileMenuToggleButton?.addEventListener("click", handleMobileMenuToggle);

    document.addEventListener("keydown", lockTabInsideMobileMenu);
    
    initSimpleBar();
    initSmoothScrolling();
    handleScrollInsideSimpleBar();
    handleScrollToAnchor();
    handleHideHeaderOnScroll();
    handleHeaderOverCoverPostEntryHeader();
    resizeAllMasonryItems();
    handleMainNavCollapse();
    handleFooterCollapse();
    handleSidebarCollapse();
    handleHeaderCollapse();
    handleSidePostCollapse();
    handleAutostackColumns();
    termSiblingsSliderInit();
    toggleNonVisibleElementsFocus();
    handleVideoPostHover();
    fixSubmenuPosition();
    setVWVHInPx(document.documentElement); // call it again to fix the issue with the preview mode
    setHeaderHeight(); // should be called after all events
    
    window.addEventListener('load', resizeAllMasonryItems);
    
    window.addEventListener('resize', setVWVHInPx.bind(null, document.documentElement));
    window.addEventListener('resize', fixSubmenuPosition);

    $(window).on('litoActualResizeHandler', function () {
        setHeaderHeight();
    });

    window.addEventListener('click', handleClickOutsideMenu);


    function resizeThrottler() {
        // ignore resize events as long as an actualResizeHandler execution is in the queue
        if (!resizeTimeout) {
            // set a timeout to prevent multiple event’s firing
            resizeTimeout = setTimeout(function () {
                resizeTimeout = null;
                actualResizeHandler();

                // The actualResizeHandler will execute once in every 250ms
            }, 250);
        }
    }

    function actualResizeHandler() {
        // handle the resize event
        console.log("resized per 250ms");
        $(window).trigger('litoActualResizeHandler');
        resizeAllMasonryItems();
    }

    window.addEventListener("resize", resizeThrottler, false);
})

}() );