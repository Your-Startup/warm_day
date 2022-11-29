import Swiper from 'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.esm.browser.min.js';

window.addEventListener('DOMContentLoaded', () => {
    const swiper = new Swiper('.swiper', {
        direction: 'horizontal',
        loop: true,
        speed: 600,
        navigation: {
          nextEl: '.swiper-next',
          prevEl: '.swiper-prev',
        },
    });
});