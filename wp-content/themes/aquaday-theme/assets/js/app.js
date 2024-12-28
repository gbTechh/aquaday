document.addEventListener('DOMContentLoaded', function () {
  const header = document.querySelector('.main-header');
  const mobileMenu = document.querySelector('.mobile-menu');
  const mobileMenuButton = document.querySelector('.js-btn-burguer');
  const closeMenuButton = document.querySelector('#close-mobile-menu');
  let lastScroll = 0;
  console.log(mobileMenu)
  // Función para manejar el scroll del header
  window.addEventListener('scroll', () => {
    const currentScroll = window.pageYOffset;

    if (currentScroll > 50) {
      header.classList.add('fixed', 'top-0', 'left-0', 'w-full', 'rounded-none');
      header.classList.remove('w-[95%]', 'absolute', 'left-[50%]', '-translate-x-[50%]', 'top-4', 'rounded-full');
      header.querySelector('.logo-container').classList.add('scale-90');
    } else {
      header.classList.remove('fixed', 'top-0', 'left-0', 'w-full', 'rounded-none');
      header.classList.add('w-[95%]', 'absolute', 'left-[50%]', '-translate-x-[50%]', 'top-4', 'rounded-full');
      header.querySelector('.logo-container').classList.remove('scale-90');
    }

    lastScroll = currentScroll;
  });

  // Funciones para el menú móvil
  const toggleMobileMenu = (open = false) => {
    mobileMenu.classList.toggle('hidden', !open);
  };

  // Event listeners para abrir/cerrar menú
  mobileMenuButton.addEventListener('click', () => toggleMobileMenu(true));
  closeMenuButton.addEventListener('click', () => {
    toggleMobileMenu(false)
  });

  // Cerrar menú móvil al hacer clic en un enlace
  const mobileMenuLinks = mobileMenu.getElementsByTagName('a');
  Array.from(mobileMenuLinks).forEach(link => {
    link.addEventListener('click', () => toggleMobileMenu(false));
  });
});