let swiperCards = new Swiper('.card_content', {
    loop: true,
    spaceBetween: 32,
    grabCursor: true,

    pagination: {
        el: '.swiper-pagination',
        clicable: true,
        dynamicBullets: true,
    },

    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },

    breakpoints:{
        600:{
            slidesPerView: 2,
        },
        968:{
            slidesPerView: 3,
        },
    },
});