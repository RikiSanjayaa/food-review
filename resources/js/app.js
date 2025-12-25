import './bootstrap';

// document.addEventListener('DOMContentLoaded', () => {
//     const track = document.getElementById('recipeCarousel');
//     if (!track) return;

//     const slideWidth = 300;
//     const prev = document.querySelector('.carousel-nav.prev');
//     const next = document.querySelector('.carousel-nav.next');

//     prev?.addEventListener('click', () => {
//         track.scrollBy({ left: -slideWidth, behavior: 'smooth' });
//     });

//     next?.addEventListener('click', () => {
//         track.scrollBy({ left: slideWidth, behavior: 'smooth' });
//     });

//     // AUTO SCROLL
//     setInterval(() => {
//         track.scrollBy({ left: slideWidth, behavior: 'smooth' });

//         if (track.scrollLeft + track.clientWidth >= track.scrollWidth - 10) {
//             track.scrollTo({ left: 0, behavior: 'smooth' });
//         }
//     }, 4000);
// });
