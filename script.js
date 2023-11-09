document.addEventListener("DOMContentLoaded", function () {
  const menuToggle = document.getElementById("menu-toggle");
  const menu = document.querySelector(".menu");

  function closeMenu() {
    menuToggle.checked = false;
  }

  const menuItems = document.querySelectorAll(".menu ul li a");
  menuItems.forEach(function (item) {
    item.addEventListener("click", closeMenu);
  });
});

function scrollToCategory(categoryId) {
  var categoryElement = document.getElementById(categoryId);
  var categoryOffset = categoryElement.offsetTop;

  var navbarHeight = 70;

  window.scrollTo({
    top: categoryOffset - navbarHeight,
    behavior: "smooth",
  });
}

// overlay
function openOverlay(imageSrc, productName, productDescription) {
  var overlay = document.getElementById("overlay");
  var overlayContent = document.getElementById("overlay-content");
  var overlayImage = document.getElementById("overlay-image");
  var overlayProductName = document.getElementById("overlay-product-name");
  var overlayProductDescription = document.getElementById("overlay-product-description");

  overlayImage.innerHTML = '<img src="images/' + imageSrc + '" alt="Product Image">';
  overlayProductName.innerHTML = productName;
  overlayProductDescription.innerHTML = productDescription;

  overlay.style.display = "flex"; // Change to flex to center the content

}

function closeOverlay() {
  var overlay = document.getElementById("overlay");
  overlay.style.display = "none";
}

// Event listener to close overlay when clicking outside of it
document.addEventListener("click", function (event) {
  var overlay = document.getElementById("overlay");
  if (event.target == overlay) {
    closeOverlay();
  }
});


// Sayfanın tamamen yüklenmesini bekleyip minimum 1 saniye bekledikten sonra preloader'ı gizle
window.onload = function () {
  setTimeout(function() {
    const preloader = document.getElementById('preloader');
    preloader.style.display = 'none';
    
    // Preloader'ın olduğu div'i kaldır
    const contentWrapper = document.getElementById('content-wrapper');
    contentWrapper.style.display = 'block';
  }, 1000); // Minimum 1000 milisaniye (1 saniye)
};
