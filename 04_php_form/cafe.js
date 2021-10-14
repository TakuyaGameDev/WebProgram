const navel = document.querySelector("#top nav");

const footer = document.querySelector("footer");

const jumpBtn = document.querySelector(".hidden");

const header = document.querySelector(".header");

const corona = document.querySelector("#corona");

const addJumpBtn = function (entries) {
  const [entry] = entries;

  if (!entry.isIntersecting) {
    jumpBtn.classList.remove("hidden");
    jumpBtn.classList.add("jump");
  } else {
    jumpBtn.classList.add("hidden");
    jumpBtn.classList.remove("jump");
  }
};

const headerObserver = new IntersectionObserver(addJumpBtn, {
  root: null,
  threshold: 0,
  rootMargin: "-180px",
});

const stickyNav = function (entries) {
  const [entry] = entries;

  if (!entry.isIntersecting) {
    navel.classList.add("black_out");
  } else {
    navel.classList.remove("black_out");
  }
};

const coronaObserver = new IntersectionObserver(stickyNav, {
  root: null,
  threshold: 0,
});

headerObserver.observe(header);
coronaObserver.observe(corona);
