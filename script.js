const menuToggle = document.querySelector(".menu-toggle");
const navLinks = document.querySelector(".nav-links");

menuToggle?.addEventListener("click", () => navLinks.classList.toggle("open"));
document.querySelectorAll(".nav-links a").forEach(link => {
  link.addEventListener("click", () => navLinks.classList.remove("open"));
});

const search = document.getElementById("resourceSearch");
const filter = document.getElementById("resourceFilter");
const cards = [...document.querySelectorAll(".resource-card")];

function filterResources() {
  const term = search.value.toLowerCase().trim();
  const course = filter.value;
  cards.forEach(card => {
    const matchesText = card.dataset.search.includes(term);
    const matchesCourse = course === "all" || card.dataset.course === course;
    card.style.display = matchesText && matchesCourse ? "" : "none";
  });
}
search?.addEventListener("input", filterResources);
filter?.addEventListener("change", filterResources);

const form = document.getElementById("contactForm");
const formMessage = document.getElementById("formMessage");
form?.addEventListener("submit", () => {
  formMessage.textContent = "Sending your message…";
});

const topBtn = document.getElementById("topBtn");
window.addEventListener("scroll", () => {
  topBtn.style.display = window.scrollY > 500 ? "grid" : "none";
});
topBtn?.addEventListener("click", () => window.scrollTo({top:0, behavior:"smooth"}));
