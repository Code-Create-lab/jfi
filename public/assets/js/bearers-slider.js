/**
 * Home office bearers slider. On desktop (992px and up) the card grid becomes
 * a Swiper carousel with arrows and pagination; below that it stays the plain
 * Bootstrap grid rendered by Blade. The grid classes are swapped for Swiper's
 * classes on the way in and restored on the way out, so resizing across the
 * breakpoint switches cleanly between the two layouts.
 */
(function () {
    var slider = document.querySelector('[data-bearers-slider]');

    if (!slider || typeof window.Swiper === 'undefined') {
        return;
    }

    var track = slider.querySelector('[data-bearers-track]');
    var slides = slider.querySelectorAll('[data-bearers-slide]');
    var controls = slider.querySelector('[data-bearers-controls]');
    var desktop = window.matchMedia('(min-width: 992px)');
    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var sliderClasses = slider.className;
    var trackClasses = track.className;
    var slideClasses = slides.length ? slides[0].className : 'col';
    var swiper = null;

    function revealCards() {
        Array.prototype.forEach.call(slider.querySelectorAll('[data-animate]'), function (card) {
            card.classList.add(card.getAttribute('data-animate'));
        });
    }

    function enable() {
        if (swiper) {
            return;
        }

        slider.classList.add('swiper');
        track.className = 'swiper-wrapper';
        Array.prototype.forEach.call(slides, function (slide) {
            slide.className = 'swiper-slide';
        });
        controls.hidden = false;

        // Cards off to the side never enter the viewport on their own, so
        // play their entrance animation up front instead of leaving them hidden.
        revealCards();

        swiper = new window.Swiper(slider, {
            slidesPerView: 3,
            slidesPerGroup: 1,
            spaceBetween: 24,
            speed: reduceMotion ? 0 : 700,
            grabCursor: true,
            watchOverflow: true,
            autoplay: reduceMotion ? false : {
                delay: 5000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },
            breakpoints: {
                1200: {
                    slidesPerView: 4,
                },
            },
            navigation: {
                prevEl: slider.querySelector('[data-bearers-prev]'),
                nextEl: slider.querySelector('[data-bearers-next]'),
                disabledClass: 'is-disabled',
                lockClass: 'is-locked',
            },
            pagination: {
                el: slider.querySelector('[data-bearers-pagination]'),
                clickable: true,
                bulletClass: 'bearers-slider-dot',
                bulletActiveClass: 'is-active',
                lockClass: 'is-locked',
            },
            a11y: {
                prevSlideMessage: 'Previous office bearers',
                nextSlideMessage: 'Next office bearers',
            },
            on: {
                lock: function () {
                    setLocked(true);
                },
                unlock: function () {
                    setLocked(false);
                },
            },
        });

        setLocked(swiper.isLocked);
    }

    /**
     * When every bearer already fits on screen there is nothing to slide, so
     * hide the controls and center the cards the way the grid does.
     */
    function setLocked(isLocked) {
        controls.hidden = isLocked;
        slider.classList.toggle('is-locked', isLocked);
    }

    function disable() {
        if (!swiper) {
            return;
        }

        swiper.destroy(true, true);
        swiper = null;

        slider.className = sliderClasses;
        track.className = trackClasses;
        Array.prototype.forEach.call(slides, function (slide) {
            slide.className = slideClasses;
        });
        controls.hidden = true;
    }

    function sync() {
        if (desktop.matches) {
            enable();
        } else {
            disable();
        }
    }

    sync();

    if (typeof desktop.addEventListener === 'function') {
        desktop.addEventListener('change', sync);
    } else {
        desktop.addListener(sync);
    }
})();
