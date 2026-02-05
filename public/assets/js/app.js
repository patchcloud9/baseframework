/**
 * Custom Application JavaScript
 * 
 * Add your custom JS here.
 */

document.addEventListener('DOMContentLoaded', function() {
    console.log('App loaded!');

    // Equalize homepage card bodies so they match the tallest card (fallback for older browsers)
    function debounce(fn, wait) {
        let t;
        return function(...args) {
            clearTimeout(t);
            t = setTimeout(() => fn.apply(this, args), wait);
        };
    }

    // Make equalize function globally available so console calls always work
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
    }; // end window.equalizeHomeCards

    // Add alias for the common typo and notify
    window.equalizeHomeCars = window.equalizeHomeCards;
    console.info('equalizeHomeCards() ready — call window.equalizeHomeCards() (alias: window.equalizeHomeCars()) to force a layout recalculation.');

    // Also run on window.load and shortly after to account for late font / image layout changes
    window.addEventListener('load', function() {
        equalizeHomeCards();
        setTimeout(equalizeHomeCards, 150);
    });

    // Run immediately and on resize (debounced)
    equalizeHomeCards();
    window.addEventListener('resize', debounce(equalizeHomeCards, 120));

    // Also run when navigating via bfcache (pageshow)
    window.addEventListener('pageshow', function(e) {
        if (e.persisted) equalizeHomeCards();
    });

    // Expose for debugging
    window.equalizeHomeCards = equalizeHomeCards;
});
