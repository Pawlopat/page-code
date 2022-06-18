particlesJS.load('background', './assets/js/particle-js/particles.json', function() {
    console.log('particles.js loaded - callback');
});

const myCarouselElement = document.querySelector('#carouselExampleCaptions')
const carousel = new bootstrap.Carousel(myCarouselElement, {
  interval: 3000,
  wrap: true,
  ride: true,
})