/* ─────────────────────────────────────────
   NINA – Main Scripts
   main.js
───────────────────────────────────────── */

// ─── SLIDER ───────────────────────────────
(function () {
  const track = document.getElementById('sliderTrack');
  if (!track) return;

  const dots = document.querySelectorAll('.dot');
  let current = 0;
  const total = track.children.length;

  function goToSlide(n) {
    current = (n + total) % total;
    track.style.transform = `translateX(-${current * 100}%)`;
    dots.forEach((d, i) => d.classList.toggle('active', i === current));
  }

  // Expose globally so inline onclick handlers still work
  window.goToSlide = goToSlide;

  // Auto-advance every 4 seconds
  let autoplay = setInterval(() => goToSlide(current + 1), 4000);

  // Pause on hover
  track.addEventListener('mouseenter', () => clearInterval(autoplay));
  track.addEventListener('mouseleave', () => {
    autoplay = setInterval(() => goToSlide(current + 1), 4000);
  });

  // Touch/swipe support
  let startX = 0;
  track.addEventListener('touchstart', e => { startX = e.touches[0].clientX; }, { passive: true });
  track.addEventListener('touchend', e => {
    const diff = startX - e.changedTouches[0].clientX;
    if (Math.abs(diff) > 40) goToSlide(diff > 0 ? current + 1 : current - 1);
  });
})();
