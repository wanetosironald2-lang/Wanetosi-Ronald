// Slider
document.addEventListener('DOMContentLoaded', () => {
  const slides = document.querySelectorAll('.slide');
  if (slides.length > 1) {
    let idx = 0;
    const show = i => {
      slides.forEach(s => s.classList.remove('active'));
      slides[i].classList.add('active');
      idx = i;
    };
    document.querySelector('.slider-next')?.addEventListener('click', () => show((idx+1) % slides.length));
    document.querySelector('.slider-prev')?.addEventListener('click', () => show((idx-1+slides.length) % slides.length));
    setInterval(() => show((idx+1) % slides.length), 6000);
  }
});