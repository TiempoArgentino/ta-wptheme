const dots = document.getElementById("dots");
const moreText = document.getElementById("more");

const readMore = document.getElementById("myBtn");
const readMoreContent =
  "ver más<span class='ml-3'><img src='../../assets/images/right-arrow.png'alt=''/></span>";

readMore.addEventListener("click", () => {
  if (dots.style.display === "none") {
    dots.style.display = "inline";
    readMore.innerHTML = readMoreContent;
    moreText.style.display = "none";
  } else {
    dots.style.display = "none";
    readMore.innerHTML = "ver menos";
    moreText.style.display = "inline";
  }
});
