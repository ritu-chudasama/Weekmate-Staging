document.addEventListener('DOMContentLoaded', function () {
    console.log('Mira Ai');

    const video = document.querySelector('.mira-ai-video .video');
    if (!video) return;

    // Remove controls after a short delay to override browser restore
    setTimeout(() => {
        video.removeAttribute('controls');
    }, 50); // 50ms is usually enough

    const enableControls = () => {
        if (!video.hasAttribute('controls')) {
            video.setAttribute('controls', 'controls');
        }
    };

    video.addEventListener('click', enableControls);
    video.addEventListener('touchstart', enableControls);
    video.addEventListener('mouseenter', enableControls);
});
