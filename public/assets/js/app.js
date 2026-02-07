/**
 * Custom Application JavaScript
 * 
 * Add your custom JS here.
 */

// Debounce helper
function debounce(fn, wait) {
    let t;
    return function(...args) {
        clearTimeout(t);
        t = setTimeout(() => fn.apply(this, args), wait);
    };
}

// Define the equalizer at top-level so it's available to console immediately
window.equalizeHomeCards = function() {
    const mq = window.matchMedia('(max-width: 768px)');
    const boxes = Array.from(document.querySelectorAll('.home-cards .column .box'));
    if (!boxes.length) return;

    // On mobile, clear any inline heights
    if (mq.matches) {
        boxes.forEach(b => {
            b.style.height = '';
        });
        return;
    }

    // Reset heights first
    boxes.forEach(b => b.style.height = 'auto');

    // Measure tallest box (includes body + footer + padding)
    const heights = boxes.map(b => b.getBoundingClientRect().height);
    const max = Math.max(...heights, 0);

    // Apply max height (pixel-perfect)
    boxes.forEach(b => b.style.height = max + 'px');
};

// Add alias for the common typo
window.equalizeHomeCars = window.equalizeHomeCards;

// Log availability
console.info('equalizeHomeCards() ready — call window.equalizeHomeCards() (alias: window.equalizeHomeCars()) to force a layout recalculation.');

// Run on DOMContentLoaded and on load+resize
document.addEventListener('DOMContentLoaded', function() {
    console.log('App loaded!');
    try { window.equalizeHomeCards(); } catch (e) { console.warn('equalizeHomeCards failed on DOMContentLoaded', e); }
});

window.addEventListener('load', function() {
    try { window.equalizeHomeCards(); } catch (e) { console.warn('equalizeHomeCards failed on load', e); }
    setTimeout(() => { try { window.equalizeHomeCards(); } catch (e) { console.warn('equalizeHomeCards failed on delayed retry', e); } }, 150);
});

window.addEventListener('resize', debounce(() => { try { window.equalizeHomeCards(); } catch (e) { /* ignore */ } }, 120));

window.addEventListener('pageshow', function(e) {
    if (e.persisted) {
        try { window.equalizeHomeCards(); } catch (err) { /* ignore */ }
    }
});

/* Mobile nav drawer and accessibility enhancements */
(function(){
    const NAV_DEBUG = true; // set to true to enable console logs for troubleshooting

    function dbg(...args) { if (NAV_DEBUG && console && console.log) console.log('[nav-debug]', ...args); }

    document.addEventListener('DOMContentLoaded', function() {
        const burger = document.querySelector('.navbar-burger');
        dbg('DOMContentLoaded - burger found?', !!burger);
        if (!burger) return;
        const target = document.getElementById(burger.dataset.target);
        dbg('target element id=', burger.dataset.target, 'found?', !!target);

        // Find or create overlay
        let overlay = document.getElementById('navOverlay');
        if (!overlay) {
            overlay = document.createElement('div');
            overlay.id = 'navOverlay';
            overlay.className = 'nav-overlay';
            overlay.setAttribute('aria-hidden','true');
            document.body.appendChild(overlay);
        } else {
            // ensure overlay lives directly under body so stacking behaves predictably
            if (overlay.parentElement !== document.body) document.body.appendChild(overlay);
        }
        console.debug('nav: overlay parent=', overlay.parentElement && overlay.parentElement.tagName, 'overlay z-index=', window.getComputedStyle(overlay).zIndex, 'menu z-index=', window.getComputedStyle(target).zIndex);

        // Find or create live region
        let live = document.getElementById('navLive');
        if (!live) {
            live = document.createElement('div');
            live.id = 'navLive';
            live.className = 'sr-only';
            live.setAttribute('aria-live','polite');
            live.setAttribute('aria-atomic','true');
            document.body.appendChild(live);
        }

        // Consider touch-capable devices as 'mobile' even if viewport width appears larger (in-app browsers, privacy browsers)
        const isMobile = () => window.matchMedia('(max-width: 1023px)').matches || ('ontouchstart' in window) || (navigator.maxTouchPoints > 0);
        function announce(msg) { try { live.textContent = msg; } catch (e) { /* ignore */ } }

        function openNav() {
            // ensure overlay only covers the area outside the drawer so menu remains clickable
            const rect = target.getBoundingClientRect();
            const menuWidth = Math.round(rect.width) || 280;
            overlay.style.right = menuWidth + 'px';
            overlay.style.left = '0';
            overlay.style.pointerEvents = 'auto';

            burger.classList.add('is-active');
            burger.setAttribute('aria-expanded','true');
            target.classList.add('is-open');
            target.setAttribute('aria-hidden','false');
            overlay.classList.add('is-active');
            overlay.setAttribute('aria-hidden','false');
            document.body.classList.add('nav-open');
            const first = target.querySelector('a, button, input, [tabindex]:not([tabindex="-1"])');
            if (first) first.focus();
            announce('Navigation menu opened');
        }

        function closeNav(returnFocus = true) {
            // reset overlay to cover the whole viewport and disable pointer events
            overlay.style.right = '';
            overlay.style.left = '';
            overlay.style.pointerEvents = 'none';

            burger.classList.remove('is-active');
            burger.setAttribute('aria-expanded','false');
            target.classList.remove('is-open');
            target.setAttribute('aria-hidden','true');
            overlay.classList.remove('is-active');
            overlay.setAttribute('aria-hidden','true');
            document.body.classList.remove('nav-open');
            target.querySelectorAll('.navbar-item.has-dropdown.is-active').forEach(el => el.classList.remove('is-active'));
            announce('Navigation menu closed');
            if (returnFocus) burger.focus();
        }

        burger.addEventListener('click', function(e) {
            if (isMobile()) {
                if (target.classList.contains('is-open')) closeNav();
                else openNav();
            } else {
                burger.classList.toggle('is-active');
                target.classList.toggle('is-active');
            }
        });

        overlay.addEventListener('click', closeNav);

        // Dropdowns: click-to-toggle on mobile with ARIA
        function setupDropdowns() {
            target.querySelectorAll('.navbar-item.has-dropdown').forEach(drop => {
                const link = drop.querySelector('.navbar-link');
                if (!link) return;
                if (link.dataset.mobileClickBound) return;

                // ensure keyboard accessibility
                link.setAttribute('role','button');
                link.setAttribute('tabindex','0');
                link.setAttribute('aria-expanded', drop.classList.contains('is-active') ? 'true' : 'false');

                const observer = new MutationObserver(() => {
                    link.setAttribute('aria-expanded', drop.classList.contains('is-active') ? 'true' : 'false');
                    dbg('mutation: drop active?', drop.classList.contains('is-active'), 'for', link.textContent.trim());
                });
                observer.observe(drop, { attributes: true, attributeFilter: ['class'] });

                // Use pointer events for better responsiveness on touch/pointer devices
                // Toggle function used by multiple handlers
                const toggleDropdown = function(e) {
                    dbg('toggleDropdown called for', link.textContent.trim(), 'event type', e && e.type, 'isMobile', isMobile());
                    if (!isMobile()) return;
                    if (e && (e.cancelable !== false)) {
                        e.preventDefault();
                        e.stopPropagation();
                    }
                    const isActive = drop.classList.contains('is-active');
                    dbg('isActive before toggle?', isActive);
                    // close others
                    target.querySelectorAll('.navbar-item.has-dropdown.is-active').forEach(other => { if (other !== drop) other.classList.remove('is-active'); });
                    if (isActive) {
                        drop.classList.remove('is-active');
                        dbg('removed is-active for', link.textContent.trim());
                        announce(link.textContent.trim() + ' collapsed');
                    } else {
                        drop.classList.add('is-active');
                        dbg('added is-active for', link.textContent.trim());
                        announce(link.textContent.trim() + ' expanded');
                        // focus first item in dropdown for keyboard users
                        const firstItem = drop.querySelector('.navbar-dropdown a, .navbar-dropdown button');
                        if (firstItem) firstItem.focus();
                    }
                };

                // Use suppression to avoid duplicate events (pointerup + click) firing twice
                let suppressClick = false;
                function markSuppress() { suppressClick = true; setTimeout(() => { suppressClick = false; }, 400); }

                link.addEventListener('pointerup', function(e) {
                    toggleDropdown(e);
                    markSuppress();
                });

                // Fallbacks: some browsers (eg. privacy-focused mobile browsers) may not consistently emit pointer events
                link.addEventListener('touchend', function(e) { toggleDropdown(e); markSuppress(); });

                link.addEventListener('click', function(e) {
                    // only handle on mobile (desktop uses hover)
                    if (!isMobile()) return;
                    if (suppressClick) return; // ignore duplicate click after pointerup
                    toggleDropdown(e);
                });

                // support keyboard 'Enter' and 'Space'
                link.addEventListener('keydown', function(e) {
                    if (!isMobile()) return;
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        toggleDropdown(e);
                    }
                });

                link.dataset.mobileClickBound = '1';
            });
        }

        setupDropdowns();

        window.addEventListener('resize', function() {
            if (!isMobile()) {
                closeNav(false);
                target.classList.remove('is-open');
                target.classList.remove('is-active');
            } else {
                setupDropdowns();
            }
        });

        // close on Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && target.classList.contains('is-open')) closeNav();
        });

    });
})();
