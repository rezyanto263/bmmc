document.addEventListener('DOMContentLoaded', () => {
    const slides = document.querySelector('.sec6 .slides');
    const slideElements = document.querySelectorAll('.sec6 .slide');
    const totalSlides = slideElements.length;
    const slideWidth = slideElements[0].clientWidth;
    let currentIndex = 0;

    // Fungsi untuk menggeser slide
    function slide(direction) {
        currentIndex += direction;

        // Reset ke slide pertama jika di akhir
        if (currentIndex < 0) {
            currentIndex = totalSlides - 1;
        } else if (currentIndex >= totalSlides) {
            currentIndex = 0;
        }

        slides.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
    }

    // Tombol navigasi
    document.querySelector('.btn.prev').addEventListener('click', () => slide(-1));
    document.querySelector('.btn.next').addEventListener('click', () => slide(1));

    // Auto-play (opsional)
    setInterval(() => {
        slide(1);
    }, 5000);
});
