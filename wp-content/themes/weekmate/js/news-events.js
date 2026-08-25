jQuery(document).ready(function ($) {

    var currentType = $('.news-listing__tab--active').data('type') || 'upcoming-events';
    var currentPage = 1;

    function setLoadMoreState(type, page, hasMore) {
        var $btn = $('.news-load-more');
        $btn
            .data('type', type)
            .data('page', page)
            .prop('disabled', false)
            .text('Load More')
            .toggle(!!hasMore);
    }

    function requestNews(type, page, append) {
        $.ajax({
            url: newsAjax.ajax_url,
            type: 'POST',
            data: {
                action: 'filter_news_posts',
                type: type,
                paged: page,
                nonce: newsAjax.nonce
            },
            beforeSend: function () {
                if (append) {
                    $('.news-load-more').prop('disabled', true).text('Loading...');
                } else {
                    $('#news-listing-results').html('<p>Loading...</p>');
                    $('.news-load-more').hide();
                }
            },
            success: function (response) {

                // Upcoming Events: raw HTML response (no pagination)
                if (type === 'upcoming-events') {
                    $('#news-listing-results').replaceWith(response);
                    initAnnouncementSlider();
                    $('.news-load-more').hide();
                    return;
                }

                // News / Latest Updates: JSON response { html, has_more, paged }
                if (append) {
                    $('#news-listing-results').append(response.html);
                } else {
                    var gridClass = (type === 'latest-updates') ? 'blog-grid' : 'news-listing__grid';
                    var $wrapper = $('<div id="news-listing-results"></div>')
                        .addClass(gridClass)
                        .html(response.html);
                    $('#news-listing-results').replaceWith($wrapper);
                }

                currentType = type;
                currentPage = response.paged;

                setLoadMoreState(type, currentPage, response.has_more);
            },
            error: function () {
                if (append) {
                    $('.news-load-more').prop('disabled', false).text('Load More');
                }
            }
        });
    }

    // ── Tab switching ────────────────────────────────
    $('.news-listing__tab').on('click', function () {

        $('.news-listing__tab').removeClass('news-listing__tab--active');
        $(this).addClass('news-listing__tab--active');

        var type = $(this).data('type');
        currentPage = 1;

        requestNews(type, 1, false);
    });

    // ── Load More ────────────────────────────────────
    $(document).on('click', '.news-load-more', function () {
        var type    = $(this).data('type') || currentType;
        var nextPage = currentPage + 1;

        requestNews(type, nextPage, true);
    });

});
