(function () {
  const car = document.querySelector('[data-carousel="moments"]');
  if (!car) return;

  const track = car.querySelector('.carousel-track');
  const left = car.querySelector('.carousel-arrow.left');
  const right = car.querySelector('.carousel-arrow.right');

  const GAP = 26;
  const AUTOPLAY_MS = 4500; // un tout petit peu plus long

  let originalCards = [];
  let clones = [];
  let timer = null;

  function visibleCount() {
    return window.innerWidth < 1100 ? 1 : 3;
  }

  function stepPx() {
    const first = track.querySelector('.carousel-card');
    if (!first) return 0;
    return first.getBoundingClientRect().width + GAP;
  }

  function clearClones() {
    clones.forEach(n => n.remove());
    clones = [];
  }

  function rebuildClones() {
    // Ne garde que les cartes non-clones comme “originales”
    originalCards = Array.from(track.querySelectorAll('.carousel-card'))
      .filter(el => !el.dataset.clone);

    clearClones();

    const n = Math.min(visibleCount(), originalCards.length);
    for (let i = 0; i < n; i++) {
      const c = originalCards[i].cloneNode(true);
      c.dataset.clone = "1";
      track.appendChild(c);
      clones.push(c);
    }
  }

  function thresholdPx() {
    // Largeur scrollable correspondant uniquement aux cartes originales
    const step = stepPx();
    return step ? step * originalCards.length : 0;
  }

  function fixIfOnClones() {
    const t = thresholdPx();
    if (!t) return;

    // Si on est passé dans la zone des clones, on “téléporte” au début
    if (track.scrollLeft >= t) {
      track.scrollTo({ left: track.scrollLeft - t, behavior: "auto" });
    }
  }

  function next() {
    const step = stepPx();
    if (!step) return;

    track.scrollBy({ left: step, behavior: "smooth" });
    // Après l’animation, on corrige si on est dans les clones
    setTimeout(fixIfOnClones, 700);
  }

  function prev() {
    const step = stepPx();
    if (!step) return;

    // Optionnel : prev propre, mais le sens autoplay reste toujours à droite
    if (track.scrollLeft <= 1) {
      const t = thresholdPx();
      track.scrollTo({ left: t, behavior: "auto" });
      requestAnimationFrame(() => {
        track.scrollBy({ left: -step, behavior: "smooth" });
      });
      return;
    }
    track.scrollBy({ left: -step, behavior: "smooth" });
  }

  function start() {
    stop();
    timer = setInterval(next, AUTOPLAY_MS);
  }
  function stop() {
    if (timer) clearInterval(timer);
    timer = null;
  }

  // Init
  rebuildClones();
  track.scrollTo({ left: 0, behavior: "auto" });
  start();

  right?.addEventListener("click", next);
  left?.addEventListener("click", prev);

  car.addEventListener("mouseenter", stop);
  car.addEventListener("mouseleave", start);

  // Si l’utilisateur scrolle à la main, on corrige aussi
  track.addEventListener("scroll", () => {
    requestAnimationFrame(fixIfOnClones);
  });

  window.addEventListener("resize", () => {
    const current = track.scrollLeft;
    rebuildClones();
    track.scrollTo({ left: current, behavior: "auto" });
  });
})();
