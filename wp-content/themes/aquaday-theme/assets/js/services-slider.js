document.addEventListener('DOMContentLoaded', function () {
  const servicesSwiper = new Swiper('.services-slider', {
    slidesPerView: 1,
    spaceBetween: 30,
    loop: true,
    navigation: {
      nextEl: '.services-slider .swiper-button-next',
      prevEl: '.services-slider .swiper-button-prev',
    },
    breakpoints: {
      1024: {
        slidesPerView: 1,
        spaceBetween: 30
      }
    },
    autoplay: {
      delay:3500,
      disableOnInteraction: false,
    },
  });
});