{{-- Full-screen loading screen, shown until the page's images and fonts are in.
     The ring tracks real progress (non-lazy images, fonts, DOM ready) and holds at
     92% until window load. The ring fills over at least 3 seconds, then holds
     and fades, so the screen shows for about 3.5 to 4 seconds as the client
     asked. It never stays longer than 12 seconds. Without
     JavaScript it is hidden by the noscript rule below. Styles: jfi-components.css. --}}
<div aria-busy="true" aria-label="Loading {{ $site['name'] }}" aria-live="polite" class="page-loader" id="page-loader" role="status">
<div aria-hidden="true" class="page-loader-bg">
<img alt="" decoding="async" fetchpriority="high" height="720" src="{{ asset('assets/images/loader-background.jpeg') }}" width="1280"/>
</div>
<div class="page-loader-stack">
<div class="page-loader-dial">
<svg aria-hidden="true" class="page-loader-ring" viewBox="0 0 100 100">
<circle class="page-loader-track" cx="50" cy="50" r="48"></circle>
<circle class="page-loader-sweep" cx="50" cy="50" r="48"></circle>
<circle class="page-loader-bar" cx="50" cy="50" r="48"></circle>
</svg>
<div class="page-loader-disc">
<img alt="" height="513" src="{{ asset('assets/images/jfi-logo.png') }}" width="640"/>
</div>
</div>
<div aria-hidden="true" class="page-loader-meta">
<span class="page-loader-name">{{ $site['name'] }}</span>
<span class="page-loader-status"><span class="page-loader-live"></span><span>Loading</span><span class="page-loader-percent" data-loader-percent>0%</span></span>
</div>
</div>
</div>
<noscript><style>.page-loader{display:none!important}html.is-loading,html.is-loading body{overflow:auto!important}</style></noscript>
<script>
(function () {
    var root = document.documentElement;
    var loader = document.getElementById('page-loader');

    if (! loader) {
        return;
    }

    root.classList.add('is-loading');

    var bar = loader.querySelector('.page-loader-bar');
    var percent = loader.querySelector('[data-loader-percent]');
    var CIRCUMFERENCE = 301.6;
    var MIN_SHOW = 3000;
    var MAX_WAIT = 12000;
    var start = Date.now();
    var shown = 0;
    var target = 0;
    var total = 1;
    var done = 0;
    var finished = false;

    // Ease the shown value toward the target so jumps read as motion, not snaps.
    // The ring is also paced by time, so it fills steadily across MIN_SHOW
    // rather than racing to 92% and sitting there.
    function paint() {
        var paced = Math.min(target, ((Date.now() - start) / MIN_SHOW) * 100);

        shown += (paced - shown) * 0.12;

        if (paced - shown < 0.4) {
            shown = paced;
        }

        bar.style.strokeDashoffset = CIRCUMFERENCE * (1 - shown / 100);
        percent.textContent = Math.round(shown) + '%';

        if (shown < 100) {
            requestAnimationFrame(paint);
        }
    }

    // Hold at 92% until window load; the last stretch belongs to it.
    function tick() {
        done++;
        target = Math.max(target, Math.min(92, (done / total) * 100));
    }

    function finish() {
        if (finished) {
            return;
        }

        finished = true;
        clearInterval(trickle);
        target = 100;

        setTimeout(function () {
            loader.classList.add('is-done');
            loader.setAttribute('aria-busy', 'false');
            root.classList.remove('is-loading');
            setTimeout(function () {
                loader.remove();
            }, 500);
        }, Math.max(0, MIN_SHOW - (Date.now() - start)) + 450);
    }

    requestAnimationFrame(paint);

    // Creep toward 30% while the document is still parsing, so a slow
    // connection never shows a frozen 0%. Real progress takes over after.
    var trickle = setInterval(function () {
        target = Math.max(target, target + (30 - target) * 0.06);
    }, 200);

    document.addEventListener('DOMContentLoaded', function () {
        clearInterval(trickle);
        var images = Array.prototype.filter.call(document.images, function (image) {
            return ! loader.contains(image) && image.loading !== 'lazy';
        });

        total = images.length + 2;
        tick();

        images.forEach(function (image) {
            if (image.complete) {
                return tick();
            }

            image.addEventListener('load', tick, { once: true });
            image.addEventListener('error', tick, { once: true });
        });

        if (document.fonts && document.fonts.ready) {
            document.fonts.ready.then(tick, tick);
        } else {
            tick();
        }
    });

    if (document.readyState === 'complete') {
        finish();
    } else {
        window.addEventListener('load', finish);
    }

    // Never trap visitors behind the loader on a slow connection.
    setTimeout(finish, MAX_WAIT);
})();
</script>
