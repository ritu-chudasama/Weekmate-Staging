document.addEventListener('DOMContentLoaded', function () {

    const btn = document.getElementById('load-more-author-posts');
    const container = document.getElementById('author-posts-container');




    console.log("Author Page")

    if (!btn) return;

    btn.addEventListener('click', function () {

        let page   = parseInt(btn.dataset.page) + 1;
        let author = btn.dataset.author;

        btn.textContent = 'Loading...';
        btn.disabled = true;

        const formData = new FormData();
        formData.append('action', 'load_more_author_posts');
        formData.append('page', page);
        formData.append('author', author);

        fetch(authorLoadMore.ajax_url, {
            method: 'POST',
            body: formData
        })
        .then(res => res.text())
        .then(html => {

            html = html.trim();

            // No more posts
            if (!html) {

                btn.insertAdjacentHTML(
                    'afterend',
                    '<p id="no-more-posts" class="author-page-no-more-text text-center">No more posts found</p>'
                );

                btn.remove();
                return;
            }

            container.insertAdjacentHTML('beforeend', html);
            btn.dataset.page = page;

            btn.textContent = 'Load More';
            btn.disabled = false;
        })
        .catch(() => {
            btn.textContent = 'Load More';
            btn.disabled = false;
        });

    });
});
