document.addEventListener('wpcf7mailsent', function(event) {
    console.log("Hello World");
    if (typeof window.wrlPdfUrl === 'undefined' || !window.wrlPdfUrl) return;

    setTimeout(function() {
        // Open in new tab
        window.open(window.wrlPdfUrl, '_blank');

        // Also trigger download
        var link = document.createElement('a');
        link.href = window.wrlPdfUrl;
        link.download = '';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }, 500);

}, false);