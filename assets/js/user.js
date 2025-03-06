$(window).on('scroll', function() {
    floatingNavbar();
    goTop();
});



// Navbar
function floatingNavbar() {
    var navbar = $('nav.navbar');
    if ($(window).scrollTop() === 0) {
        navbar.removeClass('floating-top');
    } else {
        navbar.addClass('floating-top');
    }
}
floatingNavbar();



// Go Top
function goTop () {
    var goTop = $('#goTop');
    if ($(window).scrollTop() > 500) {
        goTop.removeClass('d-none');
    } else {
        goTop.addClass('d-none');
    }
}
goTop();



// Partner Splider
if ($('.splide.normal').length) {
    const splideNormal = new Splide('.splide.normal', {
        type: "loop",
        drag: "free",
        focus: "center",
        pagination: false,
        arrows: false,
        perPage: 5,
        autoScroll: {
            speed: 0.5,
        },
        gap: '16px'
    });
    splideNormal.mount(window.splide.Extensions);
}

if ($('.splide.reverse').length) {
    const splideReverse = new Splide('.splide.reverse', {
        type: "loop",
        drag: "free",
        focus: "center",
        pagination: false,
        arrows: false,
        perPage: 5,
        autoScroll: {
            speed: -0.5,
        },
        gap: '16px'
    });
    splideReverse.mount(window.splide.Extensions);
}



// Partners Map
let map;
let markers = [];
function initializeMap(centerLat, centerLng) {
    if (!map) {
        // Inisialisasi peta hanya sekali
        map = L.map('map').setView([centerLat, centerLng], 10);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors',
            maxZoom: 20,
            minZoom: 8,
        }).addTo(map);
    }
}

function addMarkersFromAjax(url) {
    $.ajax({
        url: url,
        type: "GET",
        success: function (response) {
            let res = JSON.parse(response);

            // Hapus semua marker lama
            markers.forEach(marker => map.removeLayer(marker));
            markers = []; // Reset array marker

            res.data.forEach(item => {
                let dafaultPhoto = `${baseUrl}assets/images/${item.partnerRole == 'company' ? 'company-placeholder.jpg' : 'hospital-placeholder.jpg'}`;
                let dafaultLogo = `${baseUrl}assets/images/${item.partnerRole == 'company' ? 'company-placeholder.jpg' : 'hospital-placeholder.jpg'}`;
                let coordsArray = item.coordinate.split(",");
                item.latitude = parseFloat(coordsArray[0].trim());
                item.longitude = parseFloat(coordsArray[1].trim());
                let marker = L.marker([item.latitude, item.longitude]).addTo(map);
                marker.bindPopup(`
                    <div>
                        <div class="position-relative border rounded overflow-hidden" style="width: 210px; height: 130px">
                            <img src="${item.photo ? baseUrl + 'uploads/photos/' + item.photo :  dafaultPhoto}" class="object-fit-cover" style="width: 210px; height: 130px; object-position: center;">
                            <img src="${item.logo ? baseUrl + 'uploads/logos/' + item.logo :  dafaultLogo}" class="object-fit-contain position-absolute top-0 start-0" style="width: 35px; height: 35px;">
                        </div>
                        <h5 class="mb-0 fs-6">${item.partnerName}</h5>
                        <p class="my-0 text-secondary">${capitalizeWords(item.partnerRole)}</p>
                        <button class="btn-primary w-100 mt-3" type="button" onclick="routeFromCurrentLocation(${item.latitude}, ${item.longitude}, JSON.parse(decodeURIComponent('${encodeURIComponent(JSON.stringify(item))}')))">
                            <i class="las la-directions text-white"></i> GET DIRECTION
                        </button>
                    </div>
                `);
                markers.push(marker); // Simpan marker ke array
            });
        },
        error: function (xhr, status, error) {
            console.error("Error fetching markers:", error);
        }
    });
}

let currentMarker, destinationMarker, routingControl; // Simpan state global
function routeFromCurrentLocation(destLatitude, destLongitude, item) {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                var currentLocation = L.latLng(position.coords.latitude, position.coords.longitude);
                var destination = L.latLng(destLatitude, destLongitude);

                // 🔥 Hapus rute & marker sebelumnya jika ada
                if (routingControl) {
                    map.removeControl(routingControl);
                }
                if (currentMarker) {
                    map.removeLayer(currentMarker);
                }
                if (destinationMarker) {
                    map.removeLayer(destinationMarker);
                }

                // 🔹 Tambahkan ikon untuk lokasi user
                const yourLocationIcon = L.icon({
                    iconUrl: 'https://cdn-icons-png.flaticon.com/512/12207/12207498.png',
                    iconSize: [50, 50],
                    iconAnchor: [25, 50],
                    popupAnchor: [0, -50]
                });

                // 🔹 Tambahkan marker untuk lokasi pengguna
                currentMarker = L.marker(currentLocation, { icon: yourLocationIcon })
                    .addTo(map)
                    .bindPopup('Your Location')
                    .openPopup();

                let dafaultPhoto = `${baseUrl}assets/images/${item.partnerRole == 'company' ? 'company-placeholder.jpg' : 'hospital-placeholder.jpg'}`;
                let dafaultLogo = `${baseUrl}assets/images/${item.partnerRole == 'company' ? 'company-placeholder.jpg' : 'hospital-placeholder.jpg'}`;
                // 🔹 Tambahkan marker tujuan
                destinationMarker = L.marker(destination)
                    .addTo(map)
                    .bindPopup(`
                        <div>
                            <div class="position-relative border rounded overflow-hidden" style="width: 210px; height: 130px">
                                <img src="${item.photo ? baseUrl + 'uploads/photos/' + item.photo :  dafaultPhoto}" class="object-fit-cover" style="width: 210px; height: 130px; object-position: center;">
                                <img src="${item.logo ? baseUrl + 'uploads/logos/' + item.logo :  dafaultLogo}" class="object-fit-contain position-absolute top-0 start-0" style="width: 35px; height: 35px;">
                            </div>
                            <h5 class="mb-0 fs-6">${item.partnerName}</h5>
                            <p class="my-0 text-secondary">${capitalizeWords(item.partnerRole)}</p>
                            <button class="btn-danger w-100 mt-3" type="button" onclick="exitDirection()">
                                <i class="las la-directions text-white"></i> EXIT DIRECTION
                            </button>
                        </div>
                    `)
                    .openPopup();

                // 🔹 Tambahkan rute menggunakan Leaflet Routing Machine
                routingControl = L.Routing.control({
                    waypoints: [currentLocation, destination],
                    draggableWaypoints: false,
                    routeWhileDragging: false,
                    showAlternatives: false,
                    addWaypoints: false,
                    createMarker: () => null, // Hilangkan marker default dari routing
                    collapsible: true,
                }).addTo(map);

                // 🔹 Zoom agar rute terlihat jelas
                map.fitBounds([currentLocation, destination], {
                    padding: [100, 100],
                    maxZoom: 20,
                    minZoom: 8,
                    animate: true
                });

            },
            function (error) {
                console.error("Error mendapatkan lokasi: ", error);
                alert("Gagal mendapatkan lokasi. Pastikan GPS diaktifkan.");
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
    } else {
        alert("Geolocation tidak didukung di browser Anda.");
    }
}

function exitDirection() {
    if (routingControl) {
        map.removeControl(routingControl);
        routingControl = null;
    }
    if (currentMarker) {
        map.removeLayer(currentMarker);
        currentMarker = null;
    }
    if (destinationMarker) {
        map.removeLayer(destinationMarker);
        destinationMarker = null;
    }
}

if ($('#map').length) {
    initializeMap(-8.5000, 115.1889);
    addMarkersFromAjax(`${baseUrl}user/getAllActivePartnersMapData`);
}



// Load More News
$("#btnLoadMore").on('click', function () {
    let page = $(this).data("page");
    let searchKeyword = $('[name="search"]').val();
    let button = $(this);

    $.ajax({
        url: `${baseUrl}user/getAllPublishedNewsWithoutContent?search=${searchKeyword}`,
        type: "GET",
        data: { page: page },
        dataType: "json",
        beforeSend: function () {
            button.html('<span class="spinner-border spinner-border-sm text-white"></span> Loading...').prop("disabled", true);
        },
        success: function (response) {
            if (response.data.length > 0) {
                response.data.forEach(function (item) {
                    $("#newsList").append(`
                        <div class="col-12 col-md-4 col-lg-3">
                            <div class="card">
                            <img class="card-img-top mb-0 border-bottom" src="${baseUrl}uploads/news/${item.newsThumbnail}" alt="Latest News Image" draggable="false">
                            <div class="card-body py-3">
                                <h5 class="card-title my-0">${item.newsTitle}</h5>
                                <div class="text-nowrap overflow-hidden">
                                <span class="badge bg-success text-white">
                                    <i class="las la-history text-white"></i>
                                    ${moment(item.createdAt).format('ddd, D MMMM YYYY')}
                                </span>
                                <span class="badge bg-primary text-white">
                                    <i class="las la-newspaper text-white"></i>
                                    ${item.newsType}
                                </span>
                                </div>
                                <div class="tag-badges">
                                ${item.newsTags.split(',').map(tag => `<span class="badge fw-normal">#${tag}</span>`).join(' ')}
                                </div>
                            </div>
                            <a type="button" href="${baseUrl}news?id=${item.newsId}" class="btn-readmore align-bottom border-top py-3 ps-auto pe-5 text-end">
                                Read More
                                <i class="las la-arrow-right fs-5"></i>
                            </a>
                            </div>
                        </div>
                    `);
                });

                button.text('Load More').prop("disabled", false);
                button.data("page", page + 1);
            } else {
                button.text("No More News").prop("disabled", true);
                button.text("No More News").css("opacity", 0.5);
            }
        },
        error: function (xhr, status, error) {
            console.error("Error loading news:", error);
            button.text("Load More").prop("disabled", false);
        }
    });
});

let nik = $('#userNIK').val();
var healthhistoriesTable = $('#healthhistoriesProfilesTable').DataTable({
    processing: true,
    deferRender: true,
    buttons: [
        {
            extend: 'copyHtml5',
            text: 'Copy',
            exportOptions: {
                columns: ':visible:not(.no-export)'
            }
        },
        {
            extend: 'excelHtml5',
            text: 'Excel',
            exportOptions: {
                columns: ':visible:not(.no-export)'
            }
        },
        {
            extend: "colvis",
            columns: ':not(.no-visibility)',
            collectionLayout: "fixed two-column",
            text: "Visibility",
        },
        {
            text: "Year",
            className: "btn btn-primary dropdown-toggle",
            action: function (e, dt, node, config) {
            if ($('#yearDropdown').length === 0) {
                var columnIndex = dt.column('healthhistoryDate:name').index();
                var list = [];
                dt.column(columnIndex).data().unique().each(function (value) {
                    if (value) {
                        var item = moment(value, 'YYYY-MM-DD').format('YYYY');
                        if (!list.includes(item)) list.push(item);
                    }
                });
                list.sort();
                createDropdown(node, list, 'year', 'YYYY');
            } else {
                $('#yearDropdown').fadeOut(300, function () {
                $('#yearDropdown').remove();
                });
            }
            }
        },
        {
            text: "Month",
            className: "btn btn-primary dropdown-toggle",
            action: function (e, dt, node, config) {
            if ($('#monthDropdown').length === 0) {
                var columnIndex = dt.column('healthhistoryDate:name').index();
                var list = [];
                dt.column(columnIndex).data().unique().each(function (value) {
                if (value) {
                    var item = moment(value, 'YYYY-MM-DD').format('MM');
                        if (!list.includes(item)) list.push(item);
                    }
                });
                list.sort();
                createDropdown(node, list, 'month', 'MM');
            } else {
                $('#monthDropdown').fadeOut(300, function () {
                $('#monthDropdown').remove();
                });
            }
            }
        },
        {
            text: '<i class="fa-solid fa-arrows-rotate fs-5 text-white pt-1 px-0 px-md-1"></i>',
            className: '',
            action: function (e, dt, node, config) {
                dt.ajax.reload(null, false);
            }
        },
    ],
    layout: {
        topStart: 'buttons',
        topEnd: {
            pageLength: {
                menu: [10, 20, 50, 100]
            },
            search:{
                placeholder: 'Search'
            },
        },
        bottomStart: 'info',
        bottomEnd: 'paging',
    },
    fixedHeader: true,
    colReorder: true,
    paging: true,
    searching: true,
    ordering: true,
    autoWidth: true,
    scrollX: true,
    fixedColumns: {
        rightColumns: 1,
        leftColumns: 0
    },
    ajax: `${baseUrl}user/getAllInsuranceMembersHealhtHistoriesByUserNIK?nik=${nik}`,
    columns: [  
        {
            data: "healthhistoryDate",
            className: 'text-start',
            render: function(data, type, row) {
            if (type === 'display' || type === 'filter') {
                return `<span data-order="${data}">${moment(data).format('ddd, D MMMM YYYY')}</span>`;
            }
            return data;
            }
        },
        {
            data: "patientNIK",
            className: 'text-start'
        },
        {data: "patientName"},
        {data: "patientDepartment"},
        {data: "patientBand"},
        {
            data: "patientRelationship",
            render: function(data) {
            return capitalizeWords(data);
            }
        },
        {
            data: "patientGender",
            className: 'text-center',
            render: function(data) {
            return data === 'male'? 'M' : 'F';
            }
        },
        {
            data: "status",
            render: function(data) {
            return generateStatusData([data]).find((d) => d.id === data).text
            }
        },
        {
            data: "invoiceStatus",
            render: function(data) {
            return generateStatusData([data]).find((d) => d.id === data).text
            }
        },
        {
            data: "healthhistoryDoctorFee",
            className: 'text-end',
            render: function(data = 0, type, row) {
            if (type === 'display' || type === 'filter') {
                return formatToRupiah(data, true, true);
            }
            return data;
            }
        },
        {
            data: "healthhistoryMedicineFee",
            className: 'text-end',
            render: function(data = 0, type, row) {
            if (type === 'display' || type === 'filter') {
                return formatToRupiah(data, true, true);
            }
            return data;
            }
        },
        {
            data: "healthhistoryLabFee",
            className: 'text-end',
            render: function(data = 0, type, row) {
            if (type === 'display' || type === 'filter') {
                return formatToRupiah(data, true, true);
            }
            return data;
            }
        },
        {
            data: "healthhistoryActionFee",
            className: 'text-end',
            render: function(data = 0, type, row) {
            if (type === 'display' || type === 'filter') {
                return formatToRupiah(data, true, true);
            }
            return data;
            }
        },
        {
            data: "healthhistoryDiscount",
            className: 'text-end',
            render: function(data = 0, type, row) {
            if (type === 'display' || type === 'filter') {
                return `<span class="text-danger">${formatToRupiah(data, true, true)}</span>`;
            }
            return data;
            }
        },
        {
            data: "healthhistoryTotalBill",
            className: 'text-end',
            render: function(data = 0, type, row) {
            if (type === 'display' || type === 'filter') {
                return `<span class="text-info">${formatToRupiah(data, true, true)}</span>`;
            }
            return data;
            }
        },
        {data: 'hospitalName'},
        {data: 'doctorName'},
        {
            data: "createdAt",
            className: "align-middle",
            render: function(data, type, row) {
                let timestamp = moment(data).valueOf();
                let formattedDate = moment(data).format('ddd, D MMMM YYYY HH:mm') + ' WITA';
                
                if (type === 'display' || type === 'filter') {
                return `<span data-order="${timestamp}">${formattedDate}</span>`;
                }

                return timestamp;
            }
        },
        {
            data: "updatedAt",
            className: "align-middle",
            render: function(data, type, row) {
                let timestamp = moment(data).valueOf();
                let formattedDate = moment(data).format('ddd, D MMMM YYYY HH:mm') + ' WITA';
                
                if (type === 'display' || type === 'filter') {
                return `<span data-order="${timestamp}">${formattedDate}</span>`;
                }

                return timestamp;
            }
        },
        {
            data: null,
            className:"text-end user-select-none no-export no-visibility text-center",
            orderable: false,
            defaultContent: `
            <button 
                type="button"
                class="btn-view btn-primary rounded-2" 
                data-bs-toggle="modal" 
                data-bs-target="#viewHealthHistoryModal">
                <i class="fa-regular fa-eye"></i>
            </button>
            `
        },
    ],
    order: [[0, 'desc']],
    columnDefs: [{ width: "40px", target: 16 }],
});

var selectedYear;
var selectedMonth;
// Year And Month Filter Dropdown
function createDropdown(node, list, type, format) {
    var id = `${type}Dropdown`;

    // Hapus dropdown lain sebelum menampilkan yang baru
    $('.dropdown-menu.show').fadeOut(300, function () {
        $(this).remove();
    });

    var selectedValue = type === 'year' ? selectedYear : selectedMonth;

    var html = `
        <div id="${id}" class="dropdown-menu show user-select-none" style="position: absolute; z-index: 1050; min-width: 200px; opacity: 0;">
            <a class="dropdown-item d-flex justify-content-between" data-value="" style="cursor: pointer;">
                <span>All ${type.charAt(0).toUpperCase() + type.slice(1)}</span>
                <span>${selectedValue === '' ? '✔' : ''}</span>
            </a>
            ${list.map(item => {
                let label = type === 'year' ? item : moment(item, 'MM').format('MMMM');
                return `
                    <a class="dropdown-item d-flex justify-content-between" data-value="${item}" style="cursor: pointer;">
                        <span>${label}</span>
                        <span>${selectedValue == item ? '✔' : ''}</span>
                    </a>
                `;
            }).join('')}
        </div>
    `;

    $(node).after(html);
    var $dropdown = $(`#${id}`);

    $dropdown.css({
        top: $(node).offset().top + $(node).outerHeight(),
        left: $(node).offset().left
    });

    setTimeout(() => {
    $dropdown.css({ 
        opacity: 1, 
        visibility: 'visible',
        transition: 'opacity 0.3s ease, visibility 0s linear'
    });
    }, 10);

    // Event klik pada item dropdown
    $dropdown.find('.dropdown-item').on('click', function () {
        var value = $(this).data('value');
        if (type === 'year') {
            selectedYear = value;
        } else {
            selectedMonth = value;
        }

        $dropdown.find('.dropdown-item span:last-child').text('');
        $(this).find('span:last-child').text('✔');

        applyDateFilter();
    });

    $(document).off('click.closeDropdown').on('click.closeDropdown', function (event) {
    if (!$(event.target).closest('.dropdown-menu.show, .btn-primary').length) {
        $dropdown.fadeOut(300, function () {
        $(this).remove();
        });
        $(document).off('click.closeDropdown');
    }
    });
}

function applyDateFilter() {
    healthhistoriesTable.columns(0).search(selectedYear ? `^${selectedYear}` : '', true, false);
    healthhistoriesTable.columns(0).search(selectedMonth ? `-${selectedMonth}-` : '', true, false);
    healthhistoriesTable.draw();
}


$('#healthhistoriesProfilesTable').on('click', '.btn-view', function() {
    let data = healthhistoriesTable.row($(this).parents('tr')).data();
    $('#viewHealthHistoryModal #createdAt').html(moment(data.createdAt).format('dddd, DD MMMM YYYY HH:mm') + ' WITA');
    $('#viewHealthHistoryModal #updatedAt').html(moment(data.updatedAt).format('dddd, DD MMMM YYYY HH:mm') + ' WITA');

    data.patientPhoto && $('#viewHealthHistoryModal #patientPhoto').attr('src', `${baseUrl}uploads/profiles/${data.patientPhoto}`);

    $('#viewHealthHistoryModal #patientNIK').html(data.patientNIK);
    $('#viewHealthHistoryModal #patientName').html(data.patientName);
    $('#viewHealthHistoryModal #patientDepartment').html(data.patientDepartment);
    $('#viewHealthHistoryModal #patientGender').html(capitalizeWords(data.patientGender));
    $('#viewHealthHistoryModal #patientBand').html(data.patientBand);
    $('#viewHealthHistoryModal #patientRelationship').html(capitalizeWords(data.patientRelationship));

    let hospitalLogo = `${data.hospitalLogo ? baseUrl + "uploads/logos/" + data.hospitalLogo : baseUrl + "assets/images/hospital-placeholder.jpg"}`;
    $('#viewHealthHistoryModal #hospitalName').html(`
    <span class="d-flex align-items-center gap-1">
        <img src="${hospitalLogo}" class="rounded object-fit-contain" style="width: 28px; height: 28px;">
        <div>
        ${data.hospitalName}
        </div>
    </span>
    `);

    $('#viewHealthHistoryModal #healthhistoryStatus').html(generateStatusData([data.status]).find((d) => d.id === data.status).text);
    $('#viewHealthHistoryModal #invoiceStatus').html(generateStatusData([data.invoiceStatus]).find((d) => d.id === data.invoiceStatus).text);
    if (data.healthhistoryReferredTo) {
    $('#viewHealthHistoryModal .referredInput').show();

    let referredHospitalLogo = `${data.referredHospitalLogo ? baseUrl + "uploads/logos/" + data.referredHospitalLogo : baseUrl + "assets/images/hospital-placeholder.jpg"}`;
    $('#viewHealthHistoryModal #healthhistoryReferredTo').html(`
        <span class="d-flex align-items-center gap-1">
        <img src="${referredHospitalLogo}" class="rounded object-fit-contain" style="width: 28px; height: 28px;">
        <div>
            ${data.referredHospitalName}
        </div>
        </span>
    `);
    }

    $('#viewHealthHistoryModal #healthhistoryDate').html(moment(data.healthhistoryDate).format('ddd, DD MMMM YYYY'));
    $('#viewHealthHistoryModal #doctorName').html(data.doctorName);
    $('#viewHealthHistoryModal #diseaseNames').html(data.diseaseNames);
    $('#viewHealthHistoryModal #healthhistoryDescription').val(data.healthhistoryDescription);
    $('#viewHealthHistoryModal #healthhistoryDoctorFee').html(formatToRupiah(data.healthhistoryDoctorFee, true, false));
    $('#viewHealthHistoryModal #healthhistoryMedicineFee').html(formatToRupiah(data.healthhistoryMedicineFee, true, false));
    $('#viewHealthHistoryModal #healthhistoryLabFee').html(formatToRupiah(data.healthhistoryLabFee, true, false));
    $('#viewHealthHistoryModal #healthhistoryActionFee').html(formatToRupiah(data.healthhistoryActionFee, true, false));
    $('#viewHealthHistoryModal #healthhistoryDiscount').html(formatToRupiah(data.healthhistoryDiscount, true, false));
    $('#viewHealthHistoryModal #healthhistoryTotalBill').html(formatToRupiah(data.healthhistoryTotalBill, true, false));
});

$('#viewHealthHistoryModal').on('hidden.bs.modal', function() {
    $('#viewHealthHistoryModal .referredInput').hide();
    $(this).find('#patientPhoto').prop('src', $(this).find('#patientPhoto').data('originalsrc'));
});


$('.changePasswordInput').hide();
$('#newPasswordCheck').on('change', function() {
    const targetClass = '.changePasswordInput';
    $(targetClass).toggle();
    $(targetClass).find('input').val('');
    $(targetClass).find('.error-message').remove();
    $(targetClass).find('.is-invalid').removeClass('is-invalid');

    const isPasswordChecked = $('#newPasswordCheck').is(':checked');

    if (isPasswordChecked) {
        $('#newEmailCheck').prop('disabled', true);
    } else {
        $('#newPasswordCheck').prop('disabled', false);
    }
});

function displayFormValidation(formSelector, errors) {
    $(formSelector + ' .error-message').remove();
    $(formSelector + ' .is-invalid').removeClass('is-invalid');

    $.each(errors, function(key, message) {
        var inputField = $(formSelector + ' [name="' + key + '"]');
        inputField.addClass('is-invalid');
        inputField.parent().after('<small class="error-message text-danger px-0 lh-1">' + message + '</small>');
    });
}

$('#editProfileForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: `${baseUrl}user/profile/editProfile`,
        type: 'POST',
        data: new FormData(this),
        contentType: false,
        processData: false,
        beforeSend: function (jqXHR, settings) {
            if (settings.type.toUpperCase() === "POST") {
                submitBtn = $('[type="submit"]:focus');
                htmlContent = submitBtn.html();
                submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm text-white"></span> Processing...');
                $('[data-bs-dismiss="modal"]').prop('disabled', true);
            }
        },
        success: function(response) {
            console.log(response);
            let res = JSON.parse(response);
            res.csrfToken && $(`[name="${csrfName}"]`).val(res.csrfToken);
            if (res.status === 'success') {
                displayAlert('edit success');
                window.location.reload();
            } else if (res.status === 'failed') {
                $(".error-message").remove();
                $(".is-invalid").removeClass("is-invalid");
                displayAlert(res.failedMsg, res.errorMsg ?? null);
            } else if (res.status === 'invalid') {
                displayFormValidation('#editProfileForm', res.errors)
            }
        },
        complete: function (jqXHR, settings) {
            if (submitBtn) {
                var response = JSON.parse(jqXHR.responseText);
                if (response.status) {
                    submitBtn.prop('disabled', false).html(htmlContent);
                    $('[data-bs-dismiss="modal"]').prop('disabled', false);
                    if (response.status === 'success' || response.status === 'failed') {
                        $('.modal').modal('hide');
                    }
                }
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error!');
            console.error('Status:', status);
            console.error('Error:', error);
            console.error('Response:', xhr.responseText);
            if (xhr.status === 403) {
                location.reload(true);
            }
        }
    });
});