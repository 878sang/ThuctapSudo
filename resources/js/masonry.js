window.addEventListener('load', function () {
    const elem = document.querySelector('.grid-masonry');

    if (elem) {
        new Masonry(elem, {
            itemSelector: '.grid-item',
            columnWidth: '.grid-sizer',
            percentPosition: true,
            horizontalOrder: true
        });
    }
});