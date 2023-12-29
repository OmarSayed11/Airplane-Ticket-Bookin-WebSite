document.addEventListener("DOMContentLoaded", function () {
  const sliderWrapper = document.getElementById("sliderWrapper");
  const sliderNav = document.getElementById("sliderNav");
  let currentIndex = 0;

  function goToSlide(index) {
    currentIndex = index;
    updateSlider();
    updateNav();
  }

  function nextSlide() {
    currentIndex = (currentIndex + 1) % 3; // Assuming 3 slides
    updateSlider();
    updateNav();
  }

  function updateSlider() {
    const offset = -currentIndex * 100;
    sliderWrapper.style.transform = `translateX(${offset}%)`;
  }

  function updateNav() {
    const navButtons = Array.from(sliderNav.children);
    navButtons.forEach((button, index) => {
      button.classList.toggle("active", index === currentIndex);
    });
  }

  function startAutoplay() {
    setInterval(nextSlide, 3200); // Change slide every 3.2 seconds
  }

  startAutoplay();
});
function toggleMsgCont() {
  msgCont = document.getElementById("msgForm");
  msgContt = document.getElementById("msgForm2");
  msgContt.style.display = "none";
  if (msgCont.style.display === "none") {
    msgCont.style.display = "flex"; // or "block" depending on your layout requirements
  } else {
    msgCont.style.display = "none";
  }
}
function toggleMsgCont2() {
  msgCont = document.getElementById("msgForm2");
  msgContt = document.getElementById("msgForm");
  msgContt.style.display = "none";
  if (msgCont.style.display === "none") {
    msgCont.style.display = "flex"; // or "block" depending on your layout requirements
  } else {
    msgCont.style.display = "none";
  }
}
