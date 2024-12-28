document.addEventListener("DOMContentLoaded", function () {
  const swiper = new Swiper('.slider-header', {
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
        slidesPerView: 1,
      },
      1024: {
        slidesPerView: 1,
      },
      1224: {
        slidesPerView: 1,
      },
    },
    autoplay: {
      delay: 5500,
      disableOnInteraction: false,
    },
  });
  console.log({swiper})
});
