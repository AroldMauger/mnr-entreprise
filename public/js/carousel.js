let slideIndex = 0;

function showSlide(index) {
    const slides = document.querySelectorAll('.carousel-slide');
    const totalSlides = slides.length;

    if (index >= totalSlides) {
        slideIndex = 0;
    } else if (index < 0) {
        slideIndex = totalSlides - 1;
    } else {
        slideIndex = index;
    }

    const offset = -slideIndex * 100;
    const carouselSlides = document.querySelector('.carousel-slides');

    // Ajoute la classe pour la transition instantanée lorsque nécessaire
    if (slideIndex === 0 && index === totalSlides - 1) {
        carouselSlides.classList.add('no-transition');
        carouselSlides.style.transform = `translateX(${offset}%)`;
        setTimeout(() => carouselSlides.classList.remove('no-transition'), 0);
    } else if (slideIndex === totalSlides - 1 && index === 0) {
        carouselSlides.classList.add('no-transition');
        carouselSlides.style.transform = `translateX(${offset}%)`;
        setTimeout(() => carouselSlides.classList.remove('no-transition'), 0);
    } else {
        carouselSlides.style.transform = `translateX(${offset}%)`;
    }
}

function moveSlide(step) {
    showSlide(slideIndex + step);
}

// Initial display
showSlide(slideIndex);
