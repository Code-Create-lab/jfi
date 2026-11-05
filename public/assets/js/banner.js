/**
 * Home hero banner slider. The slides are rendered in the Blade view, so the
 * first banner shows without JavaScript; this script only cross-fades between
 * them. Autoplay stops while the pointer or keyboard focus is on the slider,
 * while the tab is hidden, and entirely for visitors who prefer reduced motion.
 */
(function () {
    var slider = document.querySelector('[data-hero-slider]');

    if (!slider) {
        return;
    }

    var slides = slider.querySelectorAll('.hero-slide');

    if (slides.length < 2) {
        return;
    }

    var dots = slider.querySelectorAll('[data-hero-dot]');
    var prevButton = slider.querySelector('[data-hero-prev]');
    var nextButton = slider.querySelector('[data-hero-next]');
    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var interval = 6000;
    var current = 0;
    var timer = null;
    var isHovered = false;
    var hasFocus = false;

    function show(index) {
        current = (index + slides.length) % slides.length;

        Array.prototype.forEach.call(slides, function (slide, slideIndex) {
            var isActive = slideIndex === current;

            slide.classList.toggle('is-active', isActive);
            slide.setAttribute('aria-hidden', isActive ? 'false' : 'true');

            Array.prototype.forEach.call(slide.querySelectorAll('a'), function (link) {
                if (isActive) {
                    link.removeAttribute('tabindex');
                } else {
                    link.setAttribute('tabindex', '-1');
                }
            });
        });

        Array.prototype.forEach.call(dots, function (dot, dotIndex) {
            if (dotIndex === current) {
                dot.setAttribute('aria-current', 'true');
            } else {
                dot.removeAttribute('aria-current');
            }
        });
    }

    function stop() {
        window.clearInterval(timer);
        timer = null;
    }

    function start() {
        stop();

        if (reduceMotion || isHovered || hasFocus || document.hidden) {
            return;
        }

        timer = window.setInterval(function () {
            show(current + 1);
        }, interval);
    }

    function goTo(index) {
        show(index);
        start();
    }

    if (prevButton) {
        prevButton.addEventListener('click', function () {
            goTo(current - 1);
        });
    }

    if (nextButton) {
        nextButton.addEventListener('click', function () {
            goTo(current + 1);
        });
    }

    Array.prototype.forEach.call(dots, function (dot) {
        dot.addEventListener('click', function () {
            goTo(parseInt(dot.getAttribute('data-hero-dot'), 10));
        });
    });

    slider.addEventListener('keydown', function (event) {
        if (event.key === 'ArrowLeft') {
            goTo(current - 1);
        } else if (event.key === 'ArrowRight') {
            goTo(current + 1);
        }
    });

    slider.addEventListener('mouseenter', function () {
        isHovered = true;
        stop();
    });

    slider.addEventListener('mouseleave', function () {
        isHovered = false;
        start();
    });

    slider.addEventListener('focusin', function () {
        hasFocus = true;
        stop();
    });

    slider.addEventListener('focusout', function (event) {
        if (!slider.contains(event.relatedTarget)) {
            hasFocus = false;
            start();
        }
    });

    document.addEventListener('visibilitychange', start);

    start();
})();
