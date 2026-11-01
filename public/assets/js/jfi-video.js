/**
 * Video gallery: opens [data-video-embed] buttons in the #video-dialog element.
 * The iframe is only created on click, so no third-party request is made
 * until a visitor chooses to play a video.
 */
document.addEventListener('DOMContentLoaded', () => {
    const dialog = document.getElementById('video-dialog');

    if (! dialog) {
        return;
    }

    const frame = dialog.querySelector('.video-dialog-frame');

    dialog.addEventListener('close', () => {
        frame.replaceChildren();
    });

    dialog.querySelector('.video-dialog-close').addEventListener('click', () => dialog.close());

    dialog.addEventListener('click', (event) => {
        if (event.target === dialog) {
            dialog.close();
        }
    });

    document.querySelectorAll('[data-video-embed]').forEach((button) => {
        button.addEventListener('click', () => {
            const iframe = document.createElement('iframe');

            iframe.src = `${button.dataset.videoEmbed}?autoplay=1&rel=0`;
            iframe.title = button.dataset.videoTitle || 'Video';
            iframe.allow = 'autoplay; encrypted-media; picture-in-picture; fullscreen';
            iframe.allowFullscreen = true;

            frame.replaceChildren(iframe);
            dialog.showModal();
        });
    });
});
