(function () {
  const car = document.querySelector('[data-carousel="moments"]');
  if (!car) return;

  const track = car.querySelector('.carousel-track');
  const left = car.querySelector('.carousel-arrow.left');
  const right = car.querySelector('.carousel-arrow.right');

  const GAP = 26;
  const AUTOPLAY_MS = 3500;

  let originalCards = [];
  let clones = [];
  let loopWidth = 0;
  let timer = null;
  let restoringBehavior = false;

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
    originalCards = Array.from(track.querySelectorAll('.carousel-card'))
      .filter(el => !el.dataset.clone);

    clearClones();

    const n = originalCards.length;
    for (let i = n - 1; i >= 0; i--) {
      const before = originalCards[i].cloneNode(true);
      before.dataset.clone = "1";
      track.insertBefore(before, track.firstChild);
      clones.push(before);
    }
    for (let i = 0; i < n; i++) {
      const after = originalCards[i].cloneNode(true);
      after.dataset.clone = "1";
      track.appendChild(after);
      clones.push(after);
    }

    const firstOriginal = originalCards[0];
    const lastOriginal = originalCards[originalCards.length - 1];
    if (firstOriginal && lastOriginal) {
      loopWidth = (lastOriginal.offsetLeft + lastOriginal.offsetWidth) - firstOriginal.offsetLeft;
    } else {
      loopWidth = 0;
    }
  }

  function fixIfOnClones() {
    if (!loopWidth) return;

    if (track.scrollLeft >= loopWidth * 2) {
      jumpWithoutSmooth(-loopWidth);
    } else if (track.scrollLeft <= 0) {
      jumpWithoutSmooth(loopWidth);
    }
  }

  function jumpWithoutSmooth(delta) {
    if (!delta) return;
    const prev = track.style.scrollBehavior;
    track.style.scrollBehavior = "auto";
    track.scrollLeft += delta;
    if (!restoringBehavior) {
      restoringBehavior = true;
      requestAnimationFrame(() => {
        track.style.scrollBehavior = prev;
        restoringBehavior = false;
      });
    }
  }

  function next() {
    const step = stepPx();
    if (!step) return;

    if (track.scrollLeft >= loopWidth * 2 - step - 2) {
      jumpWithoutSmooth(-loopWidth);
    }

    track.scrollBy({ left: step, behavior: "smooth" });
  }

  function prev() {
    const step = stepPx();
    if (!step) return;

    if (track.scrollLeft <= step + 2) {
      jumpWithoutSmooth(loopWidth);
    }

    track.scrollBy({ left: -step, behavior: "smooth" });
  }

  function start() {
    stop();
    // Autoplay image par image, vers la droite.
    timer = setInterval(() => {
      const step = stepPx();
      if (!step) return;

      if (track.scrollLeft >= loopWidth * 2 - step - 2) {
        jumpWithoutSmooth(-loopWidth);
      }

      track.scrollBy({ left: step, behavior: "smooth" });
    }, AUTOPLAY_MS);
  }
  function stop() {
    if (timer) clearInterval(timer);
    timer = null;
  }

  // Init
  rebuildClones();
  track.scrollTo({ left: loopWidth, behavior: "auto" });
  start();

  right?.addEventListener("click", next);
  left?.addEventListener("click", prev);

  car.addEventListener("mouseenter", stop);
  car.addEventListener("mouseleave", start);

  track.addEventListener("scroll", () => {
    requestAnimationFrame(fixIfOnClones);
  });

  window.addEventListener("resize", () => {
    rebuildClones();
    track.scrollTo({ left: loopWidth, behavior: "auto" });
  });
})();

(function () {
  const toggleButtons = document.querySelectorAll("[data-toggle-password]");
  toggleButtons.forEach((button) => {
    button.addEventListener("click", () => {
      const wrapper = button.closest(".auth-input-wrap");
      const input = wrapper ? wrapper.querySelector("input") : null;
      if (!input) return;

      const isHidden = input.type === "password";
      input.type = isHidden ? "text" : "password";
      button.textContent = isHidden ? "Masquer" : "Afficher";
      button.setAttribute("aria-pressed", isHidden ? "true" : "false");
    });
  });

  const signupForm = document.querySelector('[data-auth-form="signup"]');
  if (!signupForm) return;

  const passwordInput = signupForm.querySelector('input[name="password"]');
  const confirmInput = signupForm.querySelector('input[name="confirm"]');
  const termsInput = signupForm.querySelector('input[name="terms"]');
  const matchError = signupForm.querySelector('[data-error="password-match"]');
  const termsError = signupForm.querySelector('[data-error="terms"]');

  function setError(el, show) {
    if (!el) return;
    el.hidden = !show;
  }

  signupForm.addEventListener("submit", (event) => {
    let hasError = false;

    if (passwordInput && confirmInput && passwordInput.value !== confirmInput.value) {
      setError(matchError, true);
      hasError = true;
    } else {
      setError(matchError, false);
    }

    if (termsInput && !termsInput.checked) {
      setError(termsError, true);
      hasError = true;
    } else {
      setError(termsError, false);
    }

    if (hasError) {
      event.preventDefault();
    }
  });
})();

(function () {
  const menus = document.querySelectorAll(".user-menu");
  menus.forEach((menu) => {
    const toggle = menu.querySelector(".user-menu-toggle");
    if (!toggle) return;

    function closeMenu() {
      menu.classList.remove("open");
      toggle.setAttribute("aria-expanded", "false");
    }

    function openMenu() {
      menu.classList.add("open");
      toggle.setAttribute("aria-expanded", "true");
    }

    toggle.addEventListener("click", (event) => {
      event.preventDefault();
      event.stopPropagation();
      if (menu.classList.contains("open")) {
        closeMenu();
      } else {
        openMenu();
      }
    });

    document.addEventListener("click", (event) => {
      if (!menu.contains(event.target)) {
        closeMenu();
      }
    });

    document.addEventListener("keydown", (event) => {
      if (event.key === "Escape") {
        closeMenu();
      }
    });
  });
})();

(function () {
  const cartLink = document.querySelector(".cart-link");
  const panel = document.querySelector(".cart-panel");
  const backdrop = document.querySelector("[data-cart-backdrop]");
  const closeBtn = document.querySelector("[data-cart-close]");

  if (!cartLink || !panel || !backdrop) return;

  function openPanel() {
    document.body.classList.add("cart-panel-open");
    cartLink.setAttribute("aria-expanded", "true");
  }

  function closePanel() {
    document.body.classList.remove("cart-panel-open");
    cartLink.setAttribute("aria-expanded", "false");
  }

  cartLink.addEventListener("click", (event) => {
    event.preventDefault();
    if (document.body.classList.contains("cart-panel-open")) {
      closePanel();
    } else {
      openPanel();
    }
  });

  backdrop.addEventListener("click", closePanel);
  closeBtn?.addEventListener("click", closePanel);

  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape") {
      closePanel();
    }
  });
})();
