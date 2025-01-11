document.addEventListener("DOMContentLoaded", function () {
    $.ajax({
        url: baseUrl + 'landing/getActiveHospitalDatas',
        method: 'GET',
        success: function(response) {
            var res = JSON.parse(response);
            if (res.status === 'success') {
                var hospitals = res.data;
                var htmlNormal = '';
                var htmlReverse = '';

                $.each(hospitals, function(index, hospital) {
                    var logo = hospital.hospitalLogo ? baseUrl + 'uploads/logos/' + hospital.hospitalLogo : baseUrl + 'assets/images/user-placeholder.png';

                    htmlNormal += '<div class="splide__slide d-flex align-items-center">';
                    htmlNormal += '<img src="' + logo + '" alt="" class="img-mitra" loading="lazy">';
                    htmlNormal += '</div>';

                    htmlReverse += '<div class="splide__slide d-flex align-items-center">';
                    htmlReverse += '<img src="' + logo + '" alt="" class="img-mitra" loading="lazy">';
                    htmlReverse += '</div>';
                });

                $('.splide.normal .splide__list.partner-normal').html(htmlNormal);
                $('.splide.reverse .splide__list.partner-reverse').html(htmlReverse);

                new Splide(".normal", {
                    type: "loop",
                    drag: "free",
                    focus: "center",
                    pagination: false,
                    arrows: false,
                    perPage: 5,
                    autoScroll: {
                        speed: 0.5,
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

                new Splide(".reverse", {
                    type: "loop",
                    drag: "free",
                    focus: "center",
                    pagination: false,
                    arrows: false,
                    perPage: 5,
                    autoScroll: {
                        speed: -0.5,
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
            } else if (res.status === 'failed') {
                displayAlert(res.failedMsg);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
            displayAlert('Failed to load hospital data.');
        }
    });
});