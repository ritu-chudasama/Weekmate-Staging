jQuery(document).ready(function ($) {

    function loadBlogs() {
        $.ajax({
            url: homeBlogFilter.ajaxurl,
            type: "POST",
            data: {
                action: "ajax_blog_filter",
                search: $("#blog-search").val(),
                category: $("#blog-category").val()
            },
            beforeSend: function () {
                $("#blog-posts").html("<p>Loading...</p>");
            },
            success: function (response) {
                $("#blog-posts").html(response);
            }
        });
    }

    $("#blog-filter-form").on("submit", function (e) {
        e.preventDefault();
        loadBlogs();
    });jQuery(document).ready(function ($) {

    let currentCategory = '';

    function loadBlogs(page = 1, append = false) {
        let search = $('#blog-search').val();

        if (!append) {
            $('#blog-posts').html('<p>Loading...</p>');
        } else {
            $('#load-more').prop('disabled', true).text('Loading...');
        }

        $.ajax({
            url: homeBlogFilter.ajaxurl,
            type: 'POST',
            data: {
                action: 'ajax_blog_filter',
                search: search,
                category: currentCategory,
                paged: page
            },
            success: function (response) {
                if (!response || response.trim() === '') {
                    $('#blog-posts').html('<p>Something went wrong. Please try again.</p>');
                    return;
                }

                response = response.trim();

                if (append) {
                    let $temp = $('<div></div>').append(response);
                    let $newPosts = $temp.find('.blog-grid-item');

                    if ($newPosts.length) {
                        $('#blog-posts .blog-grid').append($newPosts);
                    }

                    $('#load-more-wrapper').remove();

                    let $newButton = $temp.find('#load-more-wrapper');
                    if ($newButton.length) {
                        $('#blog-posts').append($newButton);
                    }
                } else {
                    $('#blog-posts').html(response);
                }
            },
            error: function () {
                $('#blog-posts').html('<p>Something went wrong. Please try again.</p>');
            }
        });
    }

    // Desktop tabs
    $(document).on('click', '#nav-tabs-main .nav-link, #nav-tabs-main .dropdown-item', function (e) {
        e.preventDefault();

        $('#nav-tabs-main .nav-link, #nav-tabs-main .dropdown-item, #nav-tabs-main .dropdown-toggle-bar')
            .removeClass('active');
        $(this).addClass('active');

        let $toggleBar = $('#nav-tabs-main .dropdown-toggle-bar');
        if ($(this).hasClass('dropdown-item')) {
            $toggleBar.text($(this).text().trim());
        } else {
            $toggleBar.text($toggleBar.data('default-text'));
        }

        currentCategory = $(this).data('cat') || '';
        $('#blog-category').val(currentCategory);

        loadBlogs(1, false);
    });

    // Mobile dropdown toggle
    $(document).on('click', '.mobile-dropdown-toggle', function (e) {
        e.preventDefault();
        e.stopPropagation();
        $('#nav-tabs-mobile').toggleClass('show');
    });

    $(document).on('click', function (e) {
        if (!$(e.target).closest('#nav-tabs-mobile').length) {
            $('#nav-tabs-mobile').removeClass('show');
        }
    });

    // Mobile tabs
    $(document).on('click', '#nav-tabs-mobile .dropdown-item', function (e) {
        e.preventDefault();

        $('#nav-tabs-mobile .dropdown-item').removeClass('active');
        $(this).addClass('active');
        $('.mobile-selected-text').text($(this).text().trim());

        let slug = $(this).attr('href').replace('#', '');

        $('#nav-tabs-main .nav-link, #nav-tabs-main .dropdown-item, #nav-tabs-main .dropdown-toggle-bar')
            .removeClass('active');
        $('#nav-tabs-main .nav-link[href="#' + slug + '"], #nav-tabs-main .dropdown-item[href="#' + slug + '"]')
            .addClass('active');

        currentCategory = $(this).data('cat') || '';
        $('#blog-category').val(currentCategory);

        loadBlogs(1, false);
    });

    // Category <select>
    $('#blog-category').on('change', function () {
        currentCategory = $(this).val() || '';
        loadBlogs(1, false);
    });

    // Search
    $('#blog-filter-form').on('submit', function (e) {
        e.preventDefault();
        loadBlogs(1, false);
    });

    // Load More
    $(document).on('click', '#load-more', function (e) {
        e.preventDefault();

        let button = $(this);
        if (button.data('loading')) return;
        button.data('loading', true);

        let page = parseInt(button.attr('data-page'));
        loadBlogs(page, true);

        button.data('loading', false);
    });

});

    $("#blog-category").on("change", function () {
        loadBlogs();
    });
});
