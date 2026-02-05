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

    function equalizeHomeCards() {
        const mq = window.matchMedia('(max-width: 768px)');
        const bodies = Array.from(document.querySelectorAll('.home-cards .column .box .card-body'));
        if (!bodies.length) return;

        // On mobile, clear any inline heights
        if (mq.matches) {
            bodies.forEach(b => {
                b.style.height = '';
            });
            return;
        }

        // Reset heights first
        bodies.forEach(b => b.style.height = 'auto');

        // Measure tallest
        const heights = bodies.map(b => b.getBoundingClientRect().height);
        const max = Math.max(...heights, 0);

        // Apply max height (pixel-perfect)
        bodies.forEach(b => b.style.height = max + 'px');
    }

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
