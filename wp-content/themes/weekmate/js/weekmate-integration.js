/**
 * weekmate-integration.js
 * Handles live search for the Integration page
 */

(function () {
    'use strict';

    const searchInput = document.getElementById('intg-search-input');
    const noResults   = document.getElementById('intg-no-results');

    if (!searchInput) return;

    searchInput.addEventListener('input', function () {
        const query = this.value.trim().toLowerCase();
        filterIntegrations(query);
    });

    function filterIntegrations(query) {
        const categories  = document.querySelectorAll('.intg-category');
        let totalVisible  = 0;

        categories.forEach(function (category) {
            const cards        = category.querySelectorAll('.intg-card');
            let visibleInCat   = 0;

            cards.forEach(function (card) {
                const name = card.getAttribute('data-name') || '';
                const tag  = card.getAttribute('data-tag')  || '';

                if (query === '' || name.includes(query) || tag.includes(query)) {
                    card.classList.remove('intg-card--hidden');
                    visibleInCat++;
                } else {
                    card.classList.add('intg-card--hidden');
                }
            });

            // Hide entire category if no cards match
            if (visibleInCat === 0) {
                category.classList.add('intg-category--hidden');
            } else {
                category.classList.remove('intg-category--hidden');
                totalVisible += visibleInCat;
            }
        });

        // Show/hide no results message
        if (noResults) {
            noResults.style.display = totalVisible === 0 && query !== '' ? 'block' : 'none';
        }
    }

})();