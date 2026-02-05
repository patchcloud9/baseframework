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
