//LANDING PAGE
document.addEventListener("DOMContentLoaded", function () {
    new Splide(".normal", {
        type: "loop",
        drag: "free",
        focus: "center",
        pagination: false,
        arrows: false,
        perPage: 5,
        autoScroll: {
        speed: 2,
        },
        breakpoints: {
        768: {
            perPage: 3,
        },
        640: {
            perPage: 2,
        },
        },
    }).mount(window.splide.Extensions);
});

document.addEventListener("DOMContentLoaded", function () {
    new Splide(".reverse", {
        type: "loop",
        drag: "free",
        focus: "center",
        pagination: false,
        arrows: false,
        perPage: 5,
        autoScroll: {
        speed: -2,
        },
        breakpoints: {
        768: {
            perPage: 3,
        },
        640: {
            perPage: 2,
        },
        },
    }).mount(window.splide.Extensions);
});
