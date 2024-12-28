document.addEventListener('DOMContentLoaded', function () {
  const swiper = new Swiper('.categories-slider', {
    slidesPerView: 1,
    spaceBetween: 20,
    loop: true,
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    breakpoints: {
      640: {
        slidesPerView: 2,
      },
      740: {
        slidesPerView: 3,
      },
      1024: {
        slidesPerView: 4,
      },
      1224: {
        slidesPerView: 5,
      },
    }
  });
  
});