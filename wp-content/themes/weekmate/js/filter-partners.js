jQuery(document).ready(function($) {
    var partnersContainer = $('#partners-container');
    var countryCheckboxes = $('.filter-list .tag-input');
    var searchInput = $('.search-input'); // This targets both search inputs on the page
    var searchBtn = $('.search-btn');
    var filterTimer;

    // Function to perform the AJAX request
    function performFilter() {
        var selectedCountries = [];
        countryCheckboxes.each(function() {
            if ($(this).is(':checked')) {
                selectedCountries.push($(this).val());
            }
        });

        // Use the value of the new search input field
        var searchQuery = $('.partners-header-wrapper .search-input').val();

        var data = {
            'action': 'filter_partners',
            'country': selectedCountries.join(','),
            's': searchQuery // Pass the search query to the backend
        };

        // Show a loading state
        partnersContainer.html('<div class="col-12 text-center">Loading partners...</div>');

        $.ajax({
            url: my_ajax_object.ajax_url,
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(response) {
                // Directly replace the partners HTML.
                partnersContainer.html(response.html);

                // Re-check the checkboxes based on the response.
                countryCheckboxes.prop('checked', false);
                $('.tag').removeClass('tag--active'); // Remove active class from all
                
                response.countries.forEach(function(country_slug) {
                    $(`input.tag-input[value="${country_slug}"]`).prop('checked', true);
                    // Add the 'tag--active' class to the parent <li>
                    $(`input.tag-input[value="${country_slug}"]`).closest('li.tag').addClass('tag--active');
                });
            },
            error: function(error) {
                console.log('Error:', error);
                partnersContainer.html('<p class="no-results-message col-12">An error occurred. Please try again later.</p>');
            }
        });
    }

    // Event listener for country checkboxes and the new class toggling
    countryCheckboxes.on('change', function() {
        $(this).closest('li.tag').toggleClass('tag--active', $(this).is(':checked'));
        performFilter();
    });

    // Event listener for the new search input
    searchInput.on('keyup', function() {
        clearTimeout(filterTimer);
        filterTimer = setTimeout(performFilter, 500);
    });

    // Event listener for the search button
    searchBtn.on('click', function(e) {
        e.preventDefault();
        clearTimeout(filterTimer);
        performFilter();
    });

    // Initial page load: display all partners
    //performFilter();
});