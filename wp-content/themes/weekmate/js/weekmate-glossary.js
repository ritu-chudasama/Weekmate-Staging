jQuery(document).ready(function ($) {

     // AJAX search for archive filtering
    function glossaryAjaxSearch(keyword = '', letter = '', targetDiv = '#glossary-results') {
        $.ajax({
            url: glossaryAjax.ajaxurl,
            type: 'POST',
            data: {
                action: 'glossary_ajax_search',
                nonce: glossaryAjax.nonce,
                keyword: keyword,
                letter: letter,
                mode: 'archive'
            },
            beforeSend: function () {
                $(targetDiv).html('<p>Loading...</p>');
            },
            success: function (response) {
                $(targetDiv).html(response);
            }
        });
    }

    // ARCHIVE: normal search
    $(document).on('submit', '#glossary-search-form', function (e) {
        e.preventDefault();
        let keyword = $('#glossary-search-input').val().trim();
        if (!keyword) return;
        $('.glossary-letter').removeClass('active');
        $('.glossary-all').addClass('active');
        glossaryAjaxSearch(keyword, '');
    });

    // SINGLE: redirect + suggestions
    $(document).on('submit', '#glossary-single-search-form', function (e) {
        e.preventDefault();
        let keyword = $(this).find('input[name="glossary_search"]').val().trim();
        if (!keyword) return;

        // Redirect to first matching glossary term
        $.ajax({
            url: glossaryAjax.ajaxurl,
            type: 'POST',
            data: {
                action: 'glossary_ajax_search',
                nonce: glossaryAjax.nonce,
                keyword: keyword,
                mode: 'redirect'
            },
            success: function (response) {
                if (response.startsWith('http')) {
                    window.location.href = response;
                } else {
                    $('#glossary-single-suggestions').html('<p>No exact match found.</p>');
                    // Show related suggestions
                    showGlossarySuggestions(keyword);
                }
            }
        });
    });

    // LIVE SUGGESTIONS while typing
    $(document).on('keyup', '#glossary-single-search-form input[name="glossary_search"]', function () {
        let keyword = $(this).val().trim();

        if (keyword.length < 2) {
            $('#glossary-single-suggestions').empty();
            return;
        }

        showGlossarySuggestions(keyword);
    });


     function showGlossarySuggestions(keyword) {
        $.ajax({
            url: glossaryAjax.ajaxurl,
            type: 'POST',
            data: {
                action: 'glossary_ajax_search',
                nonce: glossaryAjax.nonce,
                keyword: keyword,
                mode: 'suggest' // ✅ MUST BE suggest
            },
            success: function (response) {
                $('#glossary-single-suggestions').html(response);
            }
        });
    }


    // 🔤 A–Z click (delegated)
    $(document).on('click', '.glossary-letter', function (e) {
        e.preventDefault();

        let letter = $(this).data('letter') || '';

        $('.glossary-letter').removeClass('active');
        $(this).addClass('active');

        $('#glossary-search-input').val('');
        glossaryAjaxSearch('', letter);
    });

});




