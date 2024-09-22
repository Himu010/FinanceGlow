// Ensure the DOM is fully loaded before executing scripts
document.addEventListener("DOMContentLoaded", function () {

  // Smooth scroll for anchor links
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener("click", function (e) {
      e.preventDefault();
      document.querySelector(this.getAttribute("href")).scrollIntoView({
        behavior: "smooth"
      });
    });
  });

 // Mobile menu toggle functionality
const mobileMenuToggle = document.querySelector('.mobile-menu-toggle'); // Mobile toggle button
const mobileNavMenu = document.querySelector('.mobile-nav-menu'); // Mobile navigation menu
const mobileNavClose = document.querySelector('.mobile-nav-close'); // Close button in mobile menu
let isMenuOpen = false; // Track menu state

// Toggle mobile menu on button click
if (mobileMenuToggle) {
    mobileMenuToggle.addEventListener('click', function () {
        if (!isMenuOpen) {
            mobileNavMenu.style.transform = 'translateX(0)'; // Slide in the menu
            mobileNavMenu.style.display = 'block'; // Show the menu
            isMenuOpen = true;
        } else {
            mobileNavMenu.style.transform = 'translateX(-100%)'; // Slide out the menu
            // Hide the menu after transition
            setTimeout(() => {
                mobileNavMenu.style.display = 'none';
            }, 300); 
            isMenuOpen = false;
        }
    });
}

// Close mobile menu when close button is clicked
if (mobileNavClose) {
    mobileNavClose.addEventListener('click', function () {
        mobileNavMenu.style.transform = 'translateX(-100%)'; // Slide out the menu
        // Hide the menu after transition
        setTimeout(() => {
            mobileNavMenu.style.display = 'none';
        }, 300);
        isMenuOpen = false;
    });
}


  // Hero section script
  const seeMoreBtn = document.getElementById('see-more-btn');
  const popupContainer = document.getElementById('popup-container');
  const popupClose = document.getElementById('popup-close');

  // Show popup when "See more" button is clicked
  if (seeMoreBtn && popupContainer) {
    seeMoreBtn.addEventListener('click', function() {
      popupContainer.style.display = 'flex';
    });
  }

  // Hide popup when close button is clicked
  if (popupClose) {
    popupClose.addEventListener('click', function() {
      popupContainer.style.display = 'none';
    });
  }

  // Hide popup when clicking outside the popup content
  popupContainer.addEventListener('click', function(e) {
    if (e.target === popupContainer) {
      popupContainer.style.display = 'none';
    }
  });

  document.getElementById('jump-form').addEventListener('submit', function(e) {
    var pageNumber = document.getElementById('page-number').value;
    
    // maxPages should be declared in a PHP block in the HTML/PHP file
    if (typeof maxPages === 'undefined') {
      console.error("maxPages is not defined.");
      return;
    }

    // Validate page number
    if (pageNumber < 1 || pageNumber > maxPages) {
      e.preventDefault();
      alert("Please enter a valid page number between 1 and " + maxPages);
    }
  });

  // Back to top button
  window.addEventListener('scroll', function() {
    var backToTopButton = document.getElementById('back-to-top');
    if (window.scrollY > 200) { // Show button after scrolling down 200px
      backToTopButton.style.display = 'block';
    } else {
      backToTopButton.style.display = 'none';
    }
  });
  
  
  //mobile sub item
  jQuery(document).ready(function($) {
    // Mobile menu toggle (this part is for opening the mobile drawer)
    $('.mobile-menu-toggle').on('click', function () {
        $('.mobile-nav-menu').toggleClass('open'); // Toggle class to open/close the drawer
    });

    // Submenu toggle for mobile (expands the submenus)
    $('.mobile-menu-list .menu-item-has-children > a').on('click', function(e) {
        e.preventDefault(); // Prevent default behavior of anchor tags
        var $submenu = $(this).siblings('.sub-menu'); // Find the submenu

        // Toggle visibility of the submenu
        $submenu.slideToggle(); // Use slideToggle for smooth transition

        // If you want to close other open submenus when a new one is clicked
        $('.mobile-menu-list .sub-menu').not($submenu).slideUp(); // Close all other submenus
    });
});


  
});
