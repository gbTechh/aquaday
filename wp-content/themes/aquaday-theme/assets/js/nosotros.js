document.addEventListener("DOMContentLoaded", function () {
  const swiper = new Swiper('.slider-nosotros', {
    slidesPerView: 1,
    spaceBetween: 0,
    loop: true,
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    breakpoints: {
      640: {
        slidesPerView: 1,
      },
      740: {
        slidesPerView: 2,
      },
      1024: {
        slidesPerView: 3,
      },
      1224: {
        slidesPerView: 3,
      },
    },
    autoplay: {
      delay: 5500,
      disableOnInteraction: false,
    },
  });
});
