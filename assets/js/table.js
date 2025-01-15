// Configuration
var DataTableSettings = {
    processing: true,
    columnDefs: [
        {width: '70px', target: 0},
    ],
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
            extend: 'pdfHtml5',
            text: 'PDF',
            orientation: 'portrait',
            pageSize: 'A4',
            exportOptions: {
                columns: ':visible:not(.no-export)'
            },
            customize: function (doc) {
                doc.content[1].table.widths = 
                    Array(doc.content[1].table.body[0].length + 1).join('*').split('');
            }
        },
        {
            extend: "colvis",
            collectionLayout: "dropdown",
            text: "Visibility",
        },
        {
            text: '<i class="fa-solid fa-arrows-rotate fs-5 pt-1 px-0 px-md-1"></i>',
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
    colReorder: true,
    responsive: true,
    paging: true,
    searching: true,
    ordering: true,
    autoWidth: true,
}

function displayFormValidation(formSelector, errors) {
    $(formSelector + ' .error-message').remove();
    $(formSelector + ' .is-invalid').removeClass('is-invalid');

    $.each(errors, function(key, message) {
        var inputField = $(formSelector + ' [name="' + key + '"]');
        inputField.addClass('is-invalid');
        inputField.parent().after('<small class="error-message text-danger px-0 lh-1">' + message + '</small>');
    });
}

function reloadTableData(table) {
    table.ajax.reload(null, false);
}

function generateStatusData(statuses) {
    return statuses.map(status => ({
        id: status.toLowerCase(),
        text: `<div class="${statusColor(status.toLowerCase())} status-circle"></div><span class="d-inline-block">${capitalizeWords(status)}</span>`
    }));
}

$('.modal').on('hidden.bs.modal', function(e) {
    $(this).find('#imgPreview').attr('src', $(this).find('#imgPreview').data('originalsrc'));
    $(this).find('#imgPreview2').attr('src', $(this).find('#imgPreview2').data('originalsrc'));
    $(this).find('select.form-control').select2('destroy');
    $(e.target).find('form').trigger('reset');
    $('.error-message').remove();
    $('.is-invalid').removeClass('is-invalid');
    $('.changeEmailInput, .changePasswordInput, #changeCoordinateInput').hide();
});

$('#addAdminButton, #editAdminButton, #deleteAdminButton').on('click', function() {
    reloadTableData(adminsTable);
});

// Initialize OSM
var map;
var marker;
var currentMarker;
var destinationMarker;
var routingControl;
var address;

function initializeMap(latitude, longitude, imageFile) {
    if (!map) {
        // Inisialisasi peta hanya sekali
        map = L.map('map').setView([latitude, longitude], 17);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors',
            maxZoom: 20,
            minZoom: 8,
        }).addTo(map);

        // Tambahkan marker awal
        marker = L.marker([latitude, longitude]).addTo(map);

        marker.setLatLng([latitude, longitude]).bindPopup(
            `
            <img src="${imageFile}" width="150px" height="150px"><br>
            <button class="btn-primary w-100 mt-3" type="button" onclick="routeFromCurrentLocation(${latitude}, ${longitude}, '${imageFile}')"><i class="las la-directions"></i> GET DIRECTION</button>
            `
        ).openPopup();
    } else {
        // Update koordinat jika peta sudah diinisialisasi
        updateMap(latitude, longitude, imageFile);
    }
}

function updateMap(latitude, longitude, imageFile) {
    if (map && marker) {
        // Pindahkan peta ke lokasi baru
        map.setView([latitude, longitude], 17);

        if (routingControl) {
            map.removeControl(routingControl);
        }

        currentMarker ? currentMarker.remove() : null;
        destinationMarker ? destinationMarker.remove() : null;

        // Pindahkan marker ke lokasi baru
        marker.setLatLng([latitude, longitude]).bindPopup(
            `
            <img src="${imageFile}" width="150px" height="150px"><br>
            <button class="btn-primary w-100 mt-3" type="button" onclick="routeFromCurrentLocation(${latitude}, ${longitude}, '${imageFile}')"><i class="las la-directions"></i> GET DIRECTION</button>
            `
        ).openPopup();
    } else {
        console.error('Peta atau marker belum diinisialisasi.');
    }
}

function routeFromCurrentLocation(destLatitude, destLongitude, imageFile) {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                var currentLocation = L.latLng(position.coords.latitude, position.coords.longitude);
                var destination = L.latLng(destLatitude, destLongitude);

                const yourLocationIcon = L.icon({
                    iconUrl: 'https://cdn-icons-png.flaticon.com/512/12207/12207498.png',
                    iconSize: [50, 50],
                    iconAnchor: [25, 50],
                    popupAnchor: [0, -50]
                });

                currentMarker = L.marker(currentLocation, { icon: yourLocationIcon }).addTo(map).bindPopup('Your Location').openPopup();

                destinationMarker = L.marker(destination).addTo(map).bindPopup(
                    `
                    <img src="${imageFile}" width="150px" height="150px"><br>
                    <button class="btn-danger w-100 mt-3" type="button" onclick="initializeMap(${destLatitude}, ${destLongitude}, '${imageFile}')"><i class="las la-close"></i> EXIT DIRECTION</button>
                    `
                ).openPopup();

                routingControl = L.Routing.control({
                    waypoints: [
                        currentLocation,
                        destination
                    ],
                    draggableWaypoints: false,
                    routeWhileDragging: false,
                    showAlternatives: false,
                    addWaypoints: false,
                    deleteWaypoints: false,
                    createMarker: function() {
                        return null;
                    }
                }).addTo(map);

                map.fitBounds([
                    [currentLocation.lat, currentLocation.lng],
                    [destination.lat, destination.lng]
                ]);
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

// Admins CRUD
var adminsTable = $('#adminsTable').DataTable($.extend(true, {}, DataTableSettings, {
    ajax: baseUrl + 'dashboard/getAllAdminsDatas', 
    columns: [
        {
            data: null,
            className: 'text-start',
            render: function (data, type, row, meta) {
                return meta.row + 1;
            }
        },
        {data: 'adminName'},
        {data: 'adminEmail'},
        {
            data: 'adminRole',
            render: function(data, type, row) {
                return capitalizeWords(data);
            }
        },
        {
            data: 'status',
            render: function(data, type, row) {
                if (!data) {
                    data = row.adminRole == 'admin' ? 'not partner' : 'not linked';
                }
                return `<div class="${statusColor(data)} status-circle"></div>  ` + capitalizeWords(data);
            }
        },
        {
            data: null,
            className: 'text-end user-select-none no-export',
            orderable: false,
            defaultContent: `
                <button 
                    type="button" 
                    class="btn-edit btn-warning rounded-2 ms-1 mx-0 px-4 d-inline-block my-1" 
                    data-bs-toggle="modal" 
                    data-bs-target="#editAdminModal">
                    <i class="fa-regular fa-pen-to-square"></i>
                </button>
                <button 
                    type="button" 
                    class="btn-delete btn-danger rounded-2 ms-1 mx-0 px-4 d-inline-block my-1" 
                    data-bs-toggle="modal" 
                    data-bs-target="#deleteAdminModal">
                        <i class="fa-solid fa-trash-can"></i>
                </button>
            `
        }
    ],
    columnDefs: [
        {width: '180px', target: 5}
    ]
}));

// Add Data Admin
$('#addAdminForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: baseUrl + 'dashboard/admins/addAdmin',
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            var res = JSON.parse(response);
            res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
            if (res.status === 'success') {
                $('#addAdminModal').modal('hide');
                reloadTableData(adminsTable);
                displayAlert('add success');
            } else if (res.status === 'failed') {
                $('.error-message').remove();
                $('.is-invalid').removeClass('is-invalid');
                displayAlert(res.failedMsg);
            } else if (res.status === 'invalid') {
                displayFormValidation('#addAdminForm', res.errors);
            }
        }
    });
});

$('#addAdminModal').on('show.bs.modal', function () {
    $(this).find('select[name="adminRole"]').select2({
        placeholder: 'Choose Role',
        dropdownParent: $('#addAdminModal .modal-body'),
    });
});

// Edit Data Admin
$('#adminsTable').on('click', '.btn-edit', function() {
    var data = adminsTable.row($(this).parents('tr')).data();
    $('#editAdminForm [name="adminId"]').val(data.adminId);
    $('#editAdminForm [name="adminName"]').val(data.adminName);
    $('#editAdminForm [name="adminRole"]').select2({
        placeholder: 'Choose Role',
        dropdownParent: $('#editAdminModal .modal-body'),
        disabled: data.status ? true : false
    });
    $('#editAdminForm [name="adminRole"]').val(data.adminRole).trigger('change');
    if (data.status) {
        $('#editAdminForm [name="adminRole"]').closest('.col-12').hide();
    }
});


$('#editAdminForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: baseUrl + 'dashboard/admins/editAdmin',
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            var res = JSON.parse(response);
            res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
            if (res.status === 'success') {
                $('#editAdminModal').modal('hide');
                displayAlert('edit success');
                reloadTableData(adminsTable);
            } else if (res.status === 'failed') {
                $('.error-message').remove();
                $('.is-invalid').removeClass('is-invalid');
                displayAlert(res.failedMsg);
            } else if (res.status === 'invalid') {
                displayFormValidation('#editAdminForm', res.errors);
            }
        }
    });
});

// Change Email or Password Visibility Checkbox
$('.changeEmailInput, .changePasswordInput').hide();
$('#newEmailCheck, #newPasswordCheck').change(function() {
        const targetClass = $(this).is('#newEmailCheck')? '.changeEmailInput' : '.changePasswordInput';
        $(targetClass).toggle();
        $(targetClass).find('input').val('');
        $(targetClass).find('.error-message').remove();
        $(targetClass).find('.is-invalid').removeClass('is-invalid');
});

// Delete Data Admin
$('#adminsTable').on('click', '.btn-delete', function() {
    var data = adminsTable.row($(this).parents('tr')).data();
    $('#deleteAdminForm [name="adminName"]').html(data.adminName);
    $('#deleteAdminForm [name="adminId"]').val(data.adminId);
})

$('#deleteAdminForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: baseUrl + 'dashboard/admins/deleteAdmin',
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            var res = JSON.parse(response);
            res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
            if (res.status === 'success') {
                $('#deleteAdminModal').modal('hide');
                displayAlert('delete success');
                reloadTableData(adminsTable);
            } else if (res.status === 'failed') {
                displayAlert(res.failedMsg);
            }
        }
    });
});



// Hospitals CRUD
var hospitalsTable = $('#hospitalsTable').DataTable($.extend(true, {}, DataTableSettings, {
    ajax: baseUrl + 'dashboard/getAllHospitalsDatas',
    columns: [
        {
            data: null,
            className: 'text-start',
            render: function (data, type, row, meta) {
                return meta.row + 1;
            }
        },
        {data: 'hospitalName'},
        {
            data: 'adminEmail',
            render: function(data, type, row) {
                return data ? data : 'No Admin';
            }
        },
        {data: 'hospitalAddress'},
        {data: 'hospitalPhone'},
        {
            data: 'hospitalStatus',
            render: function(data, type, row) {
                return generateStatusData([data]).find((d) => d.id === data)?.text || '';
            }
        },
        {
            data: null,
            className: 'text-end user-select-none no-export',
            orderable: false,
            defaultContent: `
                <button 
                    type="button" 
                    class="btn-view btn-primary rounded-2 ms-1 mx-0 px-4 d-inline-block my-1" 
                    data-bs-toggle="modal" 
                    data-bs-target="#viewHospitalModal">
                    <i class="fa-regular fa-eye"></i>
                </button>
                <button 
                    type="button" 
                    class="btn-edit btn-warning rounded-2 ms-1 mx-0 px-4 d-inline-block my-1" 
                    data-bs-toggle="modal" 
                    data-bs-target="#editHospitalModal">
                    <i class="fa-regular fa-pen-to-square"></i>
                </button>
                <button 
                    type="button" 
                    class="btn-delete btn-danger rounded-2 ms-1 mx-0 px-4 d-inline-block my-1" 
                    data-bs-toggle="modal" 
                    data-bs-target="#deleteHospitalModal">
                        <i class="fa-solid fa-trash-can"></i>
                </button>
            `
        }
    ],
    columnDefs: [
        {width: '240px', target: 6}
    ]
}));

$('#addHospitalButton, #editHospitalButton, #deleteHospitalButton').on('click', function() {
    reloadTableData(hospitalsTable);
});

$('#addHospitalModal').on('shown.bs.modal', function() {
    $(this).find('select[name="hospitalStatus"]').select2({
        placeholder: 'Choose Status',
        data: generateStatusData(['Unverified', 'Active', 'On Hold', 'Discontinued']),
        dropdownParent: $('#addHospitalModal .modal-body'),
        escapeMarkup: function (markup) { return markup; }
    });

    $(this).find('select[name="adminId"]').select2({
        ajax: {
            url: baseUrl + 'dashboard/getAllUnconnectedHospitalAdminsDatas',
            type: 'GET',
            dataType: 'json',
            delay: 250,
            processResults: function (response, params) {
                const searchTerm = params.term ? params.term.toLowerCase() : '';
                return {
                    results: response.data
                        .filter(function (data) {
                            const emailMatch = data.adminEmail.toLowerCase().includes(searchTerm);
                            const nameMatch = data.adminName.toLowerCase().includes(searchTerm);
                            return emailMatch || nameMatch;
                        })
                        .map(function (data) {
                            return {
                                id: data.adminId,
                                text: `
                                ${data.adminEmail} | 
                                ${data.adminName} | 
                                ${generateStatusData(['not linked']).find((d) => d.id === 'not linked').text}`
                            };
                        })
                };
            },
            cache: true
        },
        minimumInputLength: 0,
        placeholder: 'Choose Admin',
        allowClear: true,
        dropdownParent: $('#addHospitalModal .modal-body'),
        escapeMarkup: function (markup) { return markup; }
    });
});

// Add Data Hospital
$('#addHospitalForm').on('submit', function(e) {
    e.preventDefault();
    removeCleaveFormat();
    var formData = new FormData(this);
    $.ajax({
        url: baseUrl + 'dashboard/hospitals/addHospital',
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            var res = JSON.parse(response);
            res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
            if (res.status === 'success') {
                $('#addHospitalModal').modal('hide');
                reloadTableData(hospitalsTable);
                displayAlert('add success');
            } else if (res.status === 'failed') {
                $('.error-message').remove();
                $('.is-invalid').removeClass('is-invalid');
                displayAlert(res.failedMsg, res.errorMsg ?? null);
                formatPhoneInput();
            } else if (res.status === 'invalid') {
                displayFormValidation('#addHospitalForm', res.errors);
                formatPhoneInput();
            }
        }
    });
});


// View Data Hospital
$('#hospitalsTable').on('click', '.btn-view', function() {
    var data = hospitalsTable.row($(this).parents('tr')).data();
    let imageFilePath = `${baseUrl}assets/images/hospital-placeholder.jpg`;

    data.hospitalPhoto ? (imageFilePath = `${baseUrl}uploads/photos/${data.hospitalPhoto}`) : data.hospitalLogo ? (imageFilePath = `${baseUrl}uploads/logos/${data.hospitalLogo}`) : '';
    data.hospitalLogo && $('#viewHospitalModal #imgPreview').attr('src', `${baseUrl}uploads/logos/${data.hospitalLogo}`);
    $('#viewHospitalModal [name="hospitalId"]').val(data.hospitalId);
    $('#viewHospitalModal [name="hospitalName"]').val(data.hospitalName);
    $('#viewHospitalModal [name="hospitalAddress"]').val(data.hospitalAddress);
    $('#viewHospitalModal [name="hospitalCoordinate"]').val(data.hospitalCoordinate);
    $('#viewHospitalModal [name="hospitalPhone"]').val(data.hospitalPhone);
    $('#viewHospitalModal [name="adminId"]').val(`${data.adminName} | ${data.adminEmail}`);

    formatPhoneInput();

    $('#viewHospitalModal div#hospitalStatus').html(generateStatusData([data.hospitalStatus]).find((d) => d.id === data.hospitalStatus)?.text || '');

    $('#viewHospitalModal').on('shown.bs.modal', function() {
        var coordsArray = data.hospitalCoordinate.split(',');
        var latitude = parseFloat(coordsArray[0].trim());
        var longitude = parseFloat(coordsArray[1].trim());

        address = data.hospitalAddress;

        initializeMap(latitude, longitude, imageFilePath);
    });
});


// Edit Data Hospital
$('#hospitalsTable').on('click', '.btn-edit', function() {
    var d = hospitalsTable.row($(this).parents('tr')).data();

    d.hospitalLogo && $('#editHospitalForm #imgPreview').attr('src', baseUrl+'uploads/logos/'+d.hospitalLogo);
    d.hospitalPhoto && $('#editHospitalForm #imgPreview2').attr('src', baseUrl+'uploads/photos/'+d.hospitalPhoto);
    $('#editHospitalForm [name="hospitalId"]').val(d.hospitalId);
    $('#editHospitalForm [name="hospitalName"]').val(d.hospitalName);
    $('#editHospitalForm [name="hospitalAddress"]').val(d.hospitalAddress);
    $('#editHospitalForm [name="hospitalPhone"]').val(d.hospitalPhone);

    formatPhoneInput();

    $('#editHospitalForm [name="hospitalStatus"]').select2({
        placeholder: 'Choose Status',
        data: generateStatusData(['Unverified', 'Active', 'On Hold', 'Discontinued']),
        dropdownParent: $('#editHospitalModal .modal-body'),
        escapeMarkup: function (markup) {
            return markup;
        },
        templateResult: function (data) {
            return data.text ? $(data.text) : data.text;
        },
        templateSelection: function (data) {
            return data.text ? $(data.text) : data.text;
        }
    });
    $('#editHospitalForm [name="hospitalStatus"]').val(d.hospitalStatus).trigger('change');

    $('#editHospitalForm [name="adminId"]').empty();
    $('#editHospitalForm [name="adminId"]').select2({
        placeholder: 'Choose Admin',
        allowClear: true,
        dropdownParent: $('#editHospitalModal .modal-body'),
        escapeMarkup: function(markup) {
            return markup;
        },
        templateResult: function(data) {
            return data.text;
        },
        templateSelection: function(data) {
            return data.text || 'Choose Admin';
        }
    });

    var preselectedOption = new Option(
        `${d.adminEmail} | ${d.adminName} | ${generateStatusData(['current']).find((d) => d.id === 'current').text}`,
        d.adminId,
        true, 
        true  
    );
    $('#editHospitalForm [name="adminId"]').append(preselectedOption).trigger('change');

    $.ajax({
        url: baseUrl + 'dashboard/getAllUnconnectedHospitalAdminsDatas',
        method: 'GET',
        success: function(response) {
            var res = JSON.parse(response);
            res.data.forEach(function(data) {
                var option = new Option(
                    `${data.adminEmail} | ${data.adminName} | ${generateStatusData(['not linked']).find((d) => d.id === 'not linked').text}`,
                    data.adminId
                );
                $('#editHospitalForm [name="adminId"]').append(option);
            });
        },
        error: function(err) {
            console.error('Error fetching admin data:', err);
        }
    });
});

$('#editHospitalForm').on('submit', function(e) {
    e.preventDefault();
    removeCleaveFormat();
    $.ajax({
        url: baseUrl + 'dashboard/hospitals/editHospital',
        method: 'POST',
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function(response) {
            var res = JSON.parse(response);
            res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
            if (res.status === 'success') {
                $('#editHospitalModal').modal('hide');
                reloadTableData(hospitalsTable);
                displayAlert('edit success');
            } else if (res.status === 'failed') {
                $('.error-message').remove();
                $('.is-invalid').removeClass('is-invalid');
                displayAlert(res.failedMsg, res.errorMsg ?? null);
                formatPhoneInput();
            } else if (res.status === 'invalid') {
                displayFormValidation('#editHospitalForm', res.errors);
                formatPhoneInput();
            }
        }
    });
});

$('#changeCoordinateInput').hide();
$('#newCoordinateCheck').change(function() {
    $('#changeCoordinateInput').toggle();
    $('#changeCoordinateInput').find('input').val('');
    $('.error-message').remove();
    $('.is-invalid').removeClass('is-invalid');
});

// Delete Hospital
$('#hospitalsTable').on('click', '.btn-delete', function() {
    var data = hospitalsTable.row($(this).parents('tr')).data();
    $('#deleteHospitalForm #hospitalName').html(data.hospitalName);
    $('#deleteHospitalForm [name="hospitalId"]').val(data.hospitalId);
});

$('#deleteHospitalForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: baseUrl + 'dashboard/hospitals/deleteHospital',
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            var res = JSON.parse(response);
            res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
            if (res.status === 'success') {
                $('#deleteHospitalModal').modal('hide');
                reloadTableData(hospitalsTable)
                displayAlert('delete success');
            } else if (res.status === 'failed') {
                $('#deleteHospitalModal').modal('hide');
                displayAlert(res.failedMsg);
            }
        },
    });
});



// Companies CRUD
var companiesTable = $('#companiesTable').DataTable($.extend(true, {}, DataTableSettings, {
    ajax: baseUrl + 'dashboard/getAllCompaniesDatas',
    columns: [
        {
            data: null,
            className: 'text-start',
            render: function (data, type, row, meta) {
                return meta.row + 1;
            }
        },
        {data: 'companyName'},
        {data: 'adminEmail'},
        {data: 'companyAddress'},
        {data: 'companyPhone'},
        {
            data: 'companyStatus',
            render: function(data, type, row) {
                return generateStatusData([data]).find((d) => d.id === data)?.text || '';
            }
        },
        {
            data: null,
            className: 'text-end user-select-none no-export',
            orderable: false,
            defaultContent: `
                <button 
                    type="button" 
                    class="btn-view btn-primary rounded-2 ms-1 mx-0 px-4 d-inline-block my-1" 
                    data-bs-toggle="modal" 
                    data-bs-target="#viewCompanyModal">
                    <i class="fa-regular fa-eye"></i>
                </button>
                <button 
                    type="button" 
                    class="btn-edit btn-warning rounded-2 ms-1 mx-0 px-4 d-inline-block my-1" 
                    data-bs-toggle="modal" 
                    data-bs-target="#editCompanyModal">
                    <i class="fa-regular fa-pen-to-square"></i>
                </button>
                <button 
                    type="button" 
                    class="btn-delete btn-danger rounded-2 ms-1 mx-0 px-4 d-inline-block my-1" 
                    data-bs-toggle="modal" 
                    data-bs-target="#deleteCompanyModal">
                        <i class="fa-solid fa-trash-can"></i>
                </button>
            `
        }
    ],
    columnDefs: [
        {width: '240px', target: 6}
    ]
}));

$('#addCompanyButton, #editCompanyButton, #deleteCompanyButton').on('click', function() {
    reloadTableData(companiesTable);
});

$('#addCompanyModal').on('show.bs.modal', function() {
    $(this).find('select[name="adminId"]').select2({
        ajax: {
            url: baseUrl + 'dashboard/getAllUnconnectedCompanyAdminsDatas',
            type: 'GET',
            dataType: 'json',
            delay: 250,
            processResults: function (response, params) {
                const searchTerm = params.term ? params.term.toLowerCase() : '';
                return {
                    results: response.data
                        .filter(function (data) {
                            const emailMatch = data.adminEmail.toLowerCase().includes(searchTerm);
                            const nameMatch = data.adminName.toLowerCase().includes(searchTerm);
                            return emailMatch || nameMatch;
                        })
                        .map(function (data) {
                            return {
                                id: data.adminId,
                                text: `
                                ${data.adminEmail} | 
                                ${data.adminName} | 
                                ${generateStatusData(['not linked']).find((d) => d.id === 'not linked').text}`
                            };
                        })
                };
            },
            cache: true
        },
        minimumInputLength: 0,
        placeholder: 'Choose Admin',
        allowClear: true,
        dropdownParent: $('#addCompanyModal .modal-body'),
        escapeMarkup: function (markup) { return markup; }
    });

    $(this).find('select[name="companyStatus"]').select2({
        placeholder: 'Choose Status',
        data: generateStatusData(['Unverified', 'Active', 'On Hold', 'Discontinued']),
        dropdownParent: $('#addCompanyModal .modal-body'),
        escapeMarkup: function (markup) { return markup; }
    });
});

// Add Data Company
$('#addCompanyForm').on('submit', function(e) {
    e.preventDefault();
    removeCleaveFormat();
    var formData = new FormData(this);
    $.ajax({
        url: baseUrl + 'dashboard/companies/addCompany',
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            var res = JSON.parse(response);
            res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
            if (res.status === 'success') {
                $('#addCompanyModal').modal('hide');
                reloadTableData(companiesTable);
                displayAlert('add success');
            } else if (res.status === 'failed') {
                $('.error-message').remove();
                $('.is-invalid').removeClass('is-invalid');
                displayAlert(res.failedMsg, res.errorMsg ?? null);
                formatPhoneInput();
            } else if (res.status === 'invalid') {
                displayFormValidation('#addCompanyForm', res.errors);
                formatPhoneInput();
            }
        }
    });
});

// View Data Company
$('#companiesTable').on('click', '.btn-view', function() {
    var data = companiesTable.row($(this).parents('tr')).data();
    let imageFilePath = baseUrl + 'assets/images/company-placeholder.jpg';

    data.companyPhoto ? imageFilePath = baseUrl + 'uploads/photos/' + data.companyPhoto : data.companyLogo ? imageFilePath = baseUrl + 'uploads/logos/' + data.companyLogo : imageFilePath;
    data.companyLogo && $('#viewCompanyModal #imgPreview').attr('src', baseUrl+'uploads/logos/'+data.companyLogo);
    $('#viewCompanyModal [name="companyName"]').val(data.companyName);
    $('#viewCompanyModal [name="companyAddress"]').val(data.companyAddress);
    $('#viewCompanyModal [name="companyCoordinate"]').val(data.companyCoordinate);
    $('#viewCompanyModal [name="companyPhone"]').val(data.companyPhone);
    $('#viewCompanyModal [name="adminId"]').val(`${data.adminName} | ${data.adminEmail}`);

    formatPhoneInput();

    $('#viewCompanyModal div#companyStatus').html(generateStatusData([data.companyStatus]).find((d) => d.id === data.companyStatus)?.text || '');

    $('#viewCompanyModal').on('shown.bs.modal', function() {
        var coordsArray = data.companyCoordinate.split(',');
        var latitude = parseFloat(coordsArray[0].trim());
        var longitude = parseFloat(coordsArray[1].trim());

        address = data.companyAddress;

        initializeMap(latitude, longitude, imageFilePath);
    });
});

// Edit Data Company
$('#companiesTable').on('click', '.btn-edit', function() {
    var d = companiesTable.row($(this).parents('tr')).data();

    d.companyLogo && $('#editCompanyForm #imgPreview').attr('src', baseUrl+'uploads/logos/'+d.companyLogo);
    d.companyPhoto && $('#editCompanyForm #imgPreview2').attr('src', baseUrl+'uploads/photos/'+d.companyPhoto);
    $('#editCompanyForm [name="companyId"]').val(d.companyId);
    $('#editCompanyForm [name="companyName"]').val(d.companyName);
    $('#editCompanyForm [name="companyAddress"]').val(d.companyAddress);
    $('#editCompanyForm [name="companyPhone"]').val(d.companyPhone);

    formatPhoneInput();

    $('#editCompanyForm [name="companyStatus"]').select2({
        placeholder: 'Choose Status',
        data: generateStatusData(['Unverified', 'Active', 'On Hold', 'Discontinued']),
        dropdownParent: $('#editCompanyModal .modal-body'),
        escapeMarkup: function (markup) {
            return markup;
        },
        templateResult: function (data) {
            return data.text ? $(data.text) : data.text;
        },
        templateSelection: function (data) {
            return data.text ? $(data.text) : data.text;
        }
    });
    $('#editCompanyForm [name="companyStatus"]').val(d.companyStatus).trigger('change');

    $('#editCompanyForm [name="adminId"]').empty();
    $('#editCompanyForm [name="adminId"]').select2({
        placeholder: 'Choose Admin',
        allowClear: true,
        dropdownParent: $('#editCompanyModal .modal-body'),
        escapeMarkup: function(markup) {
            return markup;
        },
        templateResult: function(data) {
            return data.text;
        },
        templateSelection: function(data) {
            return data.text || 'Choose Admin';
        }
    });

    var preselectedOption = new Option(
        `${d.adminEmail} | ${d.adminName} | ${generateStatusData(['current']).find((d) => d.id === 'current').text}`,
        d.adminId,
        true, 
        true  
    );
    $('#editCompanyForm [name="adminId"]').append(preselectedOption).trigger('change');

    $.ajax({
        url: baseUrl + 'dashboard/getAllUnconnectedCompanyAdminsDatas',
        method: 'GET',
        success: function(response) {
            var res = JSON.parse(response);
            res.data.forEach(function(data) {
                var option = new Option(
                    `${data.adminEmail} | ${data.adminName} | ${generateStatusData(['not linked']).find((d) => d.id === 'not linked').text}`,
                    data.adminId
                );
                $('#editCompanyForm [name="adminId"]').append(option);
            });
        },
        error: function(err) {
            console.error('Error fetching admin data:', err);
        }
    });
});

$('#editCompanyForm').on('submit', function(e) {
    e.preventDefault();
    removeCleaveFormat();
    $.ajax({
        url: baseUrl + 'dashboard/companies/editCompany',
        method: 'POST',
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function(response) {
            var res = JSON.parse(response);
            res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
            if (res.status === 'success') {
                $('#editCompanyModal').modal('hide');
                reloadTableData(companiesTable);
                displayAlert('edit success');
            } else if (res.status === 'failed') {
                $('.error-message').remove();
                $('.is-invalid').removeClass('is-invalid');
                displayAlert(res.failedMsg, res.errorMsg ?? null);
                formatPhoneInput();
            } else if (res.status === 'invalid') {
                displayFormValidation('#editCompanyForm', res.errors);
                formatPhoneInput();
            }
        }
    });
});

// Delete Company
$('#companiesTable').on('click', '.btn-delete', function() {
    var data = companiesTable.row($(this).parents('tr')).data();
    $('#deleteCompanyForm #companyName').html(data.companyName);
    $('#deleteCompanyForm [name="companyId"]').val(data.companyId);
});

$('#deleteCompanyForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: baseUrl + 'dashboard/companies/deleteCompany',
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            var res = JSON.parse(response);
            res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
            if (res.status === 'success') {
                $('#deleteCompanyModal').modal('hide');
                reloadTableData(companiesTable);
                displayAlert('delete success');
            } else if (res.status === 'failed') {
                $('#deleteCompanyModal').modal('hide'); 
                displayAlert(res.failedMsg);
            }
        }
    });
});

// Billings CRUD
var billingsTable = $('#billingsTable').DataTable($.extend(true, {}, DataTableSettings, {
    ajax: baseUrl + 'dashboard/getAllCompanyBillingDatas',
    columns: [
        {
            data: null,
            className: 'text-start align-middle',
            responsivePriority: 1,
            render: function(data, type, row, meta) {
                return meta.row + 1;
            }
        },
        {
            data: 'companyLogo',
            className: 'align-middle',
            responsivePriority: 100,
            orderable: false,
            render: function(data, type, row) {
                return `<img src="${baseUrl}uploads/logos/${data}" width="45px" height="45px">`;
            }
        },
        {
            data: 'companyName',
            className: 'align-middle',
        },
        {
            data: 'billingStartedAt',
            className: 'align-middle',
            responsivePriority: 1,
            render: function(data, type, row) {
                return moment(data).format('ddd, D MMMM YYYY');
            }
        },
        {
            data: 'billingEndedAt',
            className: 'align-middle',
            responsivePriority: 1,
            render: function(data, type, row) {
                return moment(data).format('ddd, D MMMM YYYY');
            }
        },

        {
            data: null,
            className: 'align-middle',
            responsivePriority: 1,
            render: function(data, type, row) {
                var current = row.billingAmount - row.billingUsed;
                var percentage = current != 0 ? parseInt((current / row.billingAmount) * 100) : 0;
                var barColor;
                if (percentage >= 50) {
                    barColor = 'bg-success';
                } else if (50 > percentage && percentage >= 20) {
                    barColor = 'bg-warning';
                } else {
                    barColor = 'bg-danger';
                }
                return `
                <div class="progress bg-secondary border" role="progressbar" aria-valuenow="${percentage}" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar overflow-visible ${barColor} progress-bar-striped progress-bar-animated fw-bold" style="width: ${percentage}%">${formatToRupiah(current)} / ${formatToRupiah(row.billingAmount)}</div>
                </div>
                `
            }
        },
        {
            data: 'billingStatus',
            className: 'align-middle',
            render: function(data, type, row) {
                return generateStatusData([data]).find((d) => d.id === data)?.text || '';
            }
        },
        {
            data: null,
            className: 'text-end user-select-none no-export',
            orderable: false,
            responsivePriority: 2,
            defaultContent: `
                <button 
                    type="button" 
                    class="btn-edit btn-warning rounded-2 ms-1 mx-0 px-4 d-inline-block my-1" 
                    data-bs-toggle="modal" 
                    data-bs-target="#editCompanyModal">
                    <i class="fa-regular fa-pen-to-square"></i>
                </button>
                <button 
                    type="button" 
                    class="btn-delete btn-danger rounded-2 ms-1 mx-0 px-4 d-inline-block my-1" 
                    data-bs-toggle="modal" 
                    data-bs-target="#deleteCompanyModal">
                        <i class="fa-solid fa-trash-can"></i>
                </button>
            `
        },
    ],
    columnDefs: [
        {width: '45px', target: 1},
        {
            targets: 5,
            orderData: function(data, type, row) {
                return row.billingUsed;
            }
        },
        {width: '160px', target: 7},
    ]
}));

// Add Data Modal
$('#addBillingForm').on('submit', function(e) {
    e.preventDefault();
    removeCleaveFormat();
    $.ajax({
        url: baseUrl + 'dashboard/billings/addBilling',
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            var res = JSON.parse(response);
            res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
            if (res.status === 'success') {
                $('#addBillingModal').modal('hide');
                reloadTableData(billingsTable);
                displayAlert('add success');
            } else if (res.status === 'failed') {
                $('.error-message').remove();
                $('.is-invalid').removeClass('is-invalid');
                displayAlert(res.failedMsg);
                formatCurrencyInput();
            } else if (res.status === 'invalid') {
                displayFormValidation('#addBillingForm', res.errors);
                formatCurrencyInput();
            }
        }
    });
});

$('#addBillingModal').on('shown.bs.modal', function () {
    $(this).find('select[name="billingStatus"]').select2({
        placeholder: 'Choose Status',
        data: generateStatusData(['Unverified', 'In Use', 'Stopped', 'Finished']),
        dropdownParent: $('#addBillingModal .modal-body'),
        escapeMarkup: function (markup) { return markup; },
    });

    $(this).find('select[name="companyId"]').select2({
        ajax: {
            url: baseUrl + 'dashboard/getAllCompaniesDatas',
            type: 'GET',
            dataType: 'json',
            delay: 250,
            processResults: function (response, params) {
                const searchTerm = params.term ? params.term.toLowerCase() : '';

                return {
                    results: response.data
                        .filter(function(data) {
                            const companyName = data.companyName.toLowerCase().includes(searchTerm);
                            const companyStatus = data.companyStatus.toLowerCase().includes(searchTerm);
                            return companyName || companyStatus;
                        })
                        .map(function (data) {
                            return {
                                id: data.companyId,
                                text: `${data.companyName} | 
                                ${generateStatusData([data.companyStatus]).find((d) => d.id == data.companyStatus).text}`
                            };
                        })
                };
            },
            cache: true
        },
        minimumInputLength: 0,
        placeholder: 'Choose Company',
        allowClear: true,
        dropdownParent: $('#addBillingModal .modal-body'),
        escapeMarkup: function (markup) { return markup; }
    });
});