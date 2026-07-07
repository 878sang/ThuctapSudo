if (document.querySelector('.thumbSwiper') && document.querySelector('.mainSwiper')) {
    const thumbSwiper = new Swiper('.thumbSwiper', {
        spaceBetween: 10,
        slidesPerView: 4,
        watchSlidesProgress: true,
    });
    const mainSwiper = new Swiper('.mainSwiper', {
        spaceBetween: 10,
        thumbs: {
            swiper: thumbSwiper,
        },
    });
}