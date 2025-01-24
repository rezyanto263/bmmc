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
    paging: true,
    searching: true,
    ordering: true,
    autoWidth: true,
    scrollX: true,
    fixedColumns: {
        rightColumns: 1,
        leftColumns: 0
    }
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
        text: `<div class="${statusColor(status.toLowerCase())} status-circle"></div><span class="d-inline">${capitalizeWords(status)}</span>`
    }));
}

$('.modal').on('hidden.bs.modal', function(e) {
    $(this).find('#imgPreview').attr('src', $(this).find('#imgPreview').data('originalsrc'));
    $(this).find('#imgPreview2').attr('src', $(this).find('#imgPreview2').data('originalsrc'));
    $(this).find('select.form-control').select2('destroy');
    $(e.target).find('form').trigger('reset');
    $('.error-message').remove();
    $('.warning-message').hide();
    $('.is-invalid').removeClass('is-invalid');
    $('.changeEmailInput, .changePasswordInput, #changeCoordinateInput, #changeBillingAmountInput, #newEmployeeNIKInput').hide();
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
            className: 'text-nowrap',
            render: function(data, type, row) {
                if (!data) {
                    data = row.adminRole == 'admin' ? 'not partner' : 'not linked';
                }
                return `<div class="${statusColor(data)} status-circle"></div>  ` + capitalizeWords(data);
            }
        },
        {
            data: null,
            className: 'text-end user-select-none no-export text-nowrap align-middle',
            orderable: false,
            defaultContent: `
                <button 
                    type="button" 
                    class="btn-edit btn-warning rounded-2" 
                    data-bs-toggle="modal" 
                    data-bs-target="#editAdminModal">
                    <i class="fa-regular fa-pen-to-square"></i>
                </button>
                <button 
                    type="button" 
                    class="btn-delete btn-danger rounded-2" 
                    data-bs-toggle="modal" 
                    data-bs-target="#deleteAdminModal">
                        <i class="fa-solid fa-trash-can"></i>
                </button>
            `
        }
    ],
    columnDefs: [
        {width: '130px', target: 5}
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
    $('#deleteAdminForm #adminName').html(data.adminName);
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
            className: 'text-start align-middle',
            render: function (data, type, row, meta) {
                return meta.row + 1;
            }
        },
        {
            data: 'hospitalLogo',
            className: 'align-middle',
            orderable: false,
            render: function(data, type, row) {
                let logo = data ? `${baseUrl}uploads/logos/${data}` : `${baseUrl}assets/images/hospital-placeholder.jpg`;
                return `<img class="rounded border border-secondary-subtl" src="${logo}" width="45px" height="45px">`;
            }
        },
        {
            data: 'hospitalName',
            className: 'text-nowrap align-middle'
        },
        {
            data: 'adminEmail',
            className: 'align-middle',
            render: function(data, type, row) {
                return data ? data : 'No Admin';
            }
        },
        {
            data: 'hospitalAddress',
            className: 'align-middle'
        },
        {
            data: 'hospitalPhone',
            className: 'align-middle'
        },
        {
            data: 'hospitalStatus',
            className: 'text-nowrap align-middle',
            render: function(data, type, row) {
                return generateStatusData([data]).find((d) => d.id === data)?.text || '';
            }
        },
        {
            data: null,
            className: 'text-end user-select-none no-export text-nowrap align-middle',
            orderable: false,
            defaultContent: `
                <button 
                    type="button" 
                    class="btn-view btn-primary rounded-2" 
                    data-bs-toggle="modal" 
                    data-bs-target="#viewHospitalModal">
                    <i class="fa-regular fa-eye"></i>
                </button>
                <button 
                    type="button" 
                    class="btn-edit btn-warning rounded-2" 
                    data-bs-toggle="modal" 
                    data-bs-target="#editHospitalModal">
                    <i class="fa-regular fa-pen-to-square"></i>
                </button>
                <button 
                    type="button" 
                    class="btn-delete btn-danger rounded-2" 
                    data-bs-toggle="modal" 
                    data-bs-target="#deleteHospitalModal">
                        <i class="fa-solid fa-trash-can"></i>
                </button>
            `
        }
    ],
    columnDefs: [
        {width: '45px', target: 1},
        {width: '180px', target: 6}
    ]
}));

$('#addHospitalButton, #editHospitalButton, #deleteHospitalButton').on('click', function() {
    reloadTableData(hospitalsTable);
});

// Event listener untuk membuka modal dan memuat peta
$('#viewMapHospitalModal').on('shown.bs.modal', function () {
    var latitude = $(this).data('latitude');
    var longitude = $(this).data('longitude');
    var hospitalName = $(this).data('hospitalName');

    if (latitude !== undefined && longitude !== undefined) {
        // Inisialisasi atau perbarui peta
        initializeOrUpdateMap('hospitalMap', latitude, longitude, 'Hospital: ' + hospitalName);
    }
});

$('#addHospitalModal').on('shown.bs.modal', function() {
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
    adminData = data.adminName ? `${data.adminName} | ${data.adminEmail}` : 'No Admin';
    $('#viewHospitalModal [name="adminId"]').val(adminData);

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

    isRestrictedStatus = d.hospitalStatus === 'unverified' || d.hospitalStatus === 'independent';
    $('#editHospitalForm [name="hospitalStatus"]').select2({
        placeholder: 'Choose Status',
        data: isRestrictedStatus ? generateStatusData([d.hospitalStatus]) : generateStatusData(['Unverified', 'Active', 'On Hold', 'Discontinued']),
        disabled: isRestrictedStatus,
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
    isRestrictedStatus && $('#editHospitalForm [name="hospitalStatus"]').parents('.col-12').find('.warning-message').show();

    $('#editHospitalForm [name="adminId"]').empty().select2({
        placeholder: 'Choose Admin',
        ajax: {
            url: baseUrl + 'dashboard/getAllUnconnectedHospitalAdminsDatas',
            method: 'GET',
            dataType: 'json',
            delay: 250,
            processResults: function(response, params) {
                const searchTerm = params.term ? params.term.toLowerCase() : '';
                const selectedData = d && d.adminId
                    ? [{
                        id: d.adminId,
                        text: `${d.adminEmail} | ${d.adminName} | ${generateStatusData(['current']).find((a) => a.id === 'current').text}`,
                        selected: true
                    }]
                    : [];

                const allData = selectedData.concat(
                    response.data.map(function(data) {
                        return {
                            id: data.adminId,
                            text: `${data.adminEmail} | ${data.adminName} | ${generateStatusData(['not linked']).find((a) => a.id === 'not linked').text}`,
                        };
                    })
                );

                const filteredData = allData.filter(function(data) {
                    const searchText = data.text.toLowerCase();
                    return searchText.includes(searchTerm);
                });

                return {
                    results: filteredData
                };
            },
            error: function(err) {
                console.error('Error fetching admin data:', err);
            }
        },
        allowClear: true,
        dropdownParent: $('#editHospitalModal .modal-body'),
        escapeMarkup: function(markup) {
            return markup;
        }
    });

    if (d.adminId) {
        var preselectedOption = new Option(
            `${d.adminEmail} | ${d.adminName} | ${generateStatusData(['current']).find((d) => d.id === 'current').text}`,
            d.adminId,
            true, 
            true  
        );
        $('#editHospitalForm [name="adminId"]').append(preselectedOption).trigger('change');
    }
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
            className: 'text-start align-middle',
            render: function (data, type, row, meta) {
                return meta.row + 1;
            }
        },
        {
            data: 'companyLogo',
            className: 'align-middle',
            orderable: false,
            render: function(data, type, row) {
                let logo = data ? `${baseUrl}uploads/logos/${data}` : `${baseUrl}assets/images/company-placeholder.jpg`;
                return `<img class="rounded border border-secondary-subtl" src="${logo}" width="45px" height="45px">`;
            }
        },
        {
            data: 'companyName',
            className: 'align-middle text-nowrap'
        },
        {
            data: 'adminEmail',
            className: 'align-middle'
        },
        {
            data: 'companyAddress',
            className: 'align-middle'
        },
        {
            data: 'companyPhone',
            className: 'align-middle'
        },
        {
            data: 'billingUsed',
            className: 'align-middle',
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
            data: 'companyStatus',
            className: 'align-middle text-nowrap',
            render: function(data, type, row) {
                return generateStatusData([data]).find((d) => d.id === data)?.text || '';
            }
        },
        {
            data: null,
            className: 'text-end user-select-none no-export text-nowrap align-middle',
            orderable: false,
            defaultContent: `
                <button 
                    type="button" 
                    class="btn-view btn-primary rounded-2" 
                    data-bs-toggle="modal" 
                    data-bs-target="#viewCompanyModal">
                    <i class="fa-regular fa-eye"></i>
                </button>
                <button 
                    type="button" 
                    class="btn-edit btn-warning rounded-2" 
                    data-bs-toggle="modal" 
                    data-bs-target="#editCompanyModal">
                    <i class="fa-regular fa-pen-to-square"></i>
                </button>
                <button 
                    type="button" 
                    class="btn-delete btn-danger rounded-2" 
                    data-bs-toggle="modal" 
                    data-bs-target="#deleteCompanyModal">
                        <i class="fa-solid fa-trash-can"></i>
                </button>
            `
        }
    ],
    columnDefs: [
        {width: '180px', target: 8}
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
                        }) ?? []
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
                formatCurrencyInput();
            } else if (res.status === 'invalid') {
                displayFormValidation('#addCompanyForm', res.errors);
                formatPhoneInput();
                formatCurrencyInput();
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

    $.ajax({
        url: baseUrl + 'dashboard/getCompanyDetails?id=' + data.companyId,
        method: 'GET',
        success: function(response) {
            var res = JSON.parse(response).data;
            for (const key in res) {
                if (res.hasOwnProperty(key)) {
                    $(`#viewCompanyModal #${key}`).html(res[key]);
                }
            }
        }
    });

    let billingRemaining = data.billingAmount - data.billingUsed;
    var percentage = billingRemaining != 0 ? parseInt((billingRemaining / data.billingAmount) * 100) : 0;
    var textColor;
    if (percentage >= 50) {
        textColor = 'text-success';
    } else if (50 > percentage && percentage >= 20) {
        textColor = 'text-warning';
    } else {
        textColor = 'text-danger';
    }
    $('#viewCompanyModal #totalBillingAmount').html(formatToRupiah(data.billingAmount, false, false));
    $('#viewCompanyModal #totalBillingUsed').html(formatToRupiah(data.billingUsed, false, false));
    $('#viewCompanyModal #totalBillingRemaining').html(`<span class="${textColor}">${formatToRupiah(billingRemaining)}</span>`);
    $('#viewCompanyModal #billingDate').html(moment(data.billingStartedAt).format('D MMM YYYY') + ' - ' + moment(data.billingEndedAt).format('D MMM YYYY'));
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

    $('#editCompanyForm [name="billingId"]').val(d.billingId);  
    var isUnverified = d.companyStatus == 'unverified';
    $('#editCompanyForm [name="companyStatus"]').select2({
        placeholder: 'Choose Status',
        data: isUnverified ? generateStatusData([d.companyStatus]) : generateStatusData(['Active', 'On Hold', 'Discontinued']),
        dropdownParent: $('#editCompanyModal .modal-body'),
        disabled: isUnverified,
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
    isUnverified && $('#editCompanyForm [name="companyStatus"]').parents('.col-12').find('.warning-message').show();

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

$('#changeBillingAmountInput').hide();
$('#newBillingAmountCheck').change(function() {
    $('#changeBillingAmountInput').toggle();
    $('#changeBillingAmountInput').find('input').val('');
    $('.error-message').remove();
    $('.is-invalid').removeClass('is-invalid');
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
            responsivePriority: 3,
            orderable: false,
            render: function(data, type, row) {
                let logo = data ? `${baseUrl}uploads/logos/${data}` : `${baseUrl}assets/images/hospital-placeholder.jpg`;
                return `<img class="rounded border border-secondary-subtl" src="${logo}" width="45px" height="45px">`;
            }
        },
        {
            data: 'companyName',
            className: 'text-nowrap align-middle',
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
            data: 'billingUsed',
            className: 'align-middle',
            responsivePriority: 1,
            render: function(data, type, row) {
                console.log(row.billingUsed);
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
            className: 'text-nowrap align-middle',
            render: function(data, type, row) {
                return generateStatusData([data]).find((d) => d.id === data)?.text || '';
            }
        },
        {
            data: null,
            className: 'text-end user-select-none no-export text-nowrap align-middle',
            orderable: false,
            responsivePriority: 2,
            defaultContent: `
                <button 
                    type="button" 
                    class="btn-edit btn-warning rounded-2" 
                    data-bs-toggle="modal" 
                    data-bs-target="#editCompanyModal">
                    <i class="fa-regular fa-pen-to-square"></i>
                </button>
                <button 
                    type="button" 
                    class="btn-delete btn-danger rounded-2" 
                    data-bs-toggle="modal" 
                    data-bs-target="#deleteCompanyModal">
                        <i class="fa-solid fa-trash-can"></i>
                </button>
            `
        },
    ],
    columnDefs: [
        {width: '45px', target: 1},
        {width: '130px', target: 7},
    ],
    deferRended: true
}));

// Add Data Billing
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
                            if (data.companyStatus != ('active' || 'on hold' || 'discontinued')) {
                                return {
                                    id: data.companyId,
                                    text: `${data.companyName} | 
                                    ${generateStatusData([data.companyStatus]).find((d) => d.id == data.companyStatus).text}`
                                };
                            }
                        }) ?? []
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


// Edit Data Billing



// CRUD Data Doctors
var doctorsTable = $('#doctorsTable').DataTable($.extend(true, {}, DataTableSettings, {
    ajax: baseUrl + 'hospital/getHospitalDoctorsDatas', 
    columns: [
        {
            data: null,
            className: 'text-start',
            render: function (data, type, row, meta) {
                return meta.row + 1;
            }
        },
        {data: 'doctorName'},
        {data: 'doctorAddress'},
        {
            data: 'doctorDateOfBirth',
            render: function (data, type, row) {
                if (type === 'display' || type === 'filter') {
                    if (data) {
                        return moment(data).format('DD MMMM YYYY');
                    } else {
                        return '';
                    }
                }
                return data;
            }
        },
        {data: 'doctorSpecialization'},
        {
            data: 'doctorStatus',
            render: function(data, type, row) {
                return capitalizeWords(data);
            }
        },
        {
            data: null,
            className: 'text-end user-select-none no-export text-nowrap align-middle',
            orderable: false,
            defaultContent: `
                <button 
                    type="button" 
                    class="btn-edit btn-warning rounded-2" 
                    data-bs-toggle="modal" 
                    data-bs-target="#editDoctorModal" title="Edit Doctor">
                        <i class="fa-regular fa-pen-to-square"></i>
                </button>
                <button 
                    type="button" 
                    class="btn-delete btn-danger rounded-2" 
                    data-bs-toggle="modal" 
                    data-bs-target="#deleteDoctorModal" title="Delete Doctor">
                        <i class="fa-solid fa-trash-can"></i>
                </button>
            `
        }
    ],
    columnDefs: [
        {width: '180px', target: 6}
    ]
}));

$('#addDoctorButton, #editDoctorButton, #deleteDoctorButton').on('click', function() {
    reloadTableData(doctorsTable);
});

$('#addDoctorModal').on('hidden.bs.modal', function(e) {
    $(e.target).find('form').trigger('reset');
});

// Add Data Doctor
$('#addDoctorForm').on('submit', function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        url: baseUrl + 'hospital/doctors/addDoctor',
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            var res = JSON.parse(response);
            if (res.status === 'success') {
                $('#addDoctorModal').modal('hide');
                reloadTableData(doctorsTable);
                displayAlert('add success');
            } else if (res.status === 'failed') {
                $('.error-message').remove();
                $('.is-invalid').removeClass('is-invalid');
                displayAlert(res.failedMsg, res.errorMsg ?? null);
            } else if (res.status === 'invalid') {
                displayFormValidation('#addDoctorForm', res.errors);
            }
        }
    });
});

$('#addDoctorModal').on('shown.bs.modal', function () {
    $(this).find('select#doctorStatus').select2({
        placeholder: 'Choose Status',
        dropdownParent: $('#addDoctorModal .modal-body')
    });
});

// Edit Data Doctor
$('#doctorsTable').on('click', '.btn-edit', function() {
    var data = doctorsTable.row($(this).parents('tr')).data();
    $('#editDoctorForm [name="doctorId"]').val(data.doctorId);
    $('#editDoctorForm [name="doctorName"]').val(data.doctorName);
    $('#editDoctorForm [name="doctorAddress"]').val(data.doctorAddress);
    $('#editDoctorForm [name="doctorDateOfBirth"]').val(data.doctorDateOfBirth);
    $('#editDoctorForm [name="doctorSpecialization"]').val(data.doctorSpecialization);
    $('#editDoctorForm [name="doctorStatus"]').val(data.doctorStatus);  
});

$('#editDoctorModal').on('shown.bs.modal', function () {
    $(this).find('select#doctorStatus').select2({
        placeholder: 'Choose',
        dropdownParent: $('#editDoctorModal .modal-body')
    });
});


$('#editDoctorForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: baseUrl + 'hospital/doctors/editDoctor',
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            var res = JSON.parse(response);
            if (res.status === 'success') {
                $('#editDoctorModal').modal('hide');
                displayAlert('edit success');
                reloadTableData(doctorsTable);
            } else if (res.status === 'failed') {
                $('.error-message').remove();
                $('.is-invalid').removeClass('is-invalid');
                displayAlert(res.failedMsg);
            } else if (res.status === 'invalid') {
                displayFormValidation('#editDoctorForm', res.errors);
            }
        }
    });
});

// Delete Data Doctor
$('#doctorsTable').on('click', '.btn-delete', function() {
    var data = doctorsTable.row($(this).parents('tr')).data();
    $('#deleteDoctorForm #doctorName').html(data.doctorName);
    $('#deleteDoctorForm #doctorId').val(data.doctorId);
})

$('#deleteDoctorForm').on('submit', function(e) {
    e.preventDefault();
    var doctorId = $('#deleteDoctorForm #doctorId').val();
    $.ajax({
        url: baseUrl + 'hospital/doctors/deleteDoctor',
        method: 'POST',
        data: {doctorId: doctorId},
        success: function(response) {
            var res = JSON.parse(response);
            if (res.status === 'success') {
                $('#deleteDoctorModal').modal('hide');
                reloadTableData(doctorsTable);
                displayAlert('delete success');
            }
        }
    });
});

// CRUD History Health Hospital
var selectedYear = "";
var selectedMonth = "";
var hHistoriesTable = $('#hHistoriesTable').DataTable($.extend(true, {}, DataTableSettings, {
    ajax: baseUrl + 'hospital/getHospitalHistoriesDatas', 
    columns: [
        {
            data: null,
            className: 'text-start',
            render: function (data, type, row, meta) {
                return meta.row + 1;
            }
        },
        {
            data: 'historyhealthRole',
            render: function (data, type, row) {
                if (data === 'employee') {
                    return row.employeeName;
                } else {
                    return row.familyName;
                }
            }
        },
        {data: 'historyhealthRole'},
        {data: 'companyName'},
        {data: 'doctorName'},
        {
            data: 'historyhealthDate',
            render: function (data, type, row) {
                if (type === 'display' || type === 'filter') {
                    if (data) {
                        return moment(data).format('DD MMMM YYYY');
                    } else {
                        return '';
                    }
                }
                return data;
            }
        },
        {
            data: 'invoiceStatus',
                render: function(data, type, row) {
                    if (row.historyhealthTotalBill > 0) {
                        return data;
                    } else {
                        return 'free';
                    }
                }
        },
        {
            data: 'historyhealthTotalBill',
            render: function (data) {
                return 'Rp ' + parseFloat(data).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            }
        },
        {
            data: null,
            className: 'text-end user-select-none no-export text-nowrap align-middle',
            orderable: false,
            render: function(data, type, row, meta) {
                if (data.historyhealthTotalBill == 0 && data.historyhealthDiscount == 0) {
                    return `
                    <button 
                        type="button" 
                        class="btn-view btn-primary rounded-2" 
                        data-bs-toggle="modal" 
                        data-bs-target="#detailHistoryModal"
                        title="View History">
                        <i class="fa-regular fa-eye"></i>
                    </button>
                `;
                } else {
                    return `
                        <button 
                            type="button" 
                            class="btn-view btn-primary rounded-2" 
                            data-bs-toggle="modal" 
                            data-bs-target="#detailHistoryModal"
                            title="View History">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    `;
                }
            }
        },
        { 
            data: 'patientNIK',
            visible: false, 
            searchable: true
        },
    ],
    columnDefs: [
        {width: '180px', target: 8}
    ],
    footerCallback: function (row, data, start, end, display) {
        var api = this.api();
        var pageTotal = api.column(7, { page: 'current' }).data().reduce((a, b) => parseFloat(a) + parseFloat(b), 0);
        $(api.column(7).footer()).html(`Rp ${pageTotal.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`);
    },
    buttons: [
        {
            text: "Year",
            className: "btn btn-primary dropdown-toggle",
            action: function (e, dt, node, config) {
                var column = dt.column(5);
                var list = [];
    
                column.data().unique().each(function (value) {
                    if (value) {
                        var item = moment(value, 'YYYY-MM-DD').format('YYYY');
                        if (!list.includes(item)) {
                            list.push(item);
                        }
                    }
                });
    
                list.sort();
    
                createDropdown(node, list, 'year', 'YYYY');
            }
        },
        {
            text: "Month",
            className: "btn btn-primary dropdown-toggle",
            action: function (e, dt, node, config) {
                var column = dt.column(5);
                var list = [];
    
                column.data().unique().each(function (value) {
                    if (value) {
                        var item = moment(value, 'YYYY-MM-DD').format('MMMM');
                        if (!list.includes(item)) {
                            list.push(item);
                        }
                    }
                });
    
                list.sort();
    
                createDropdown(node, list, 'month', 'MMMM');
            }
        }
    ]
}));

function createDropdown(node, list, type, format) {
    var id = `${type}Dropdown`;
    var html = `
        <div id="${id}" class="dropdown-menu show" style="position: absolute; z-index: 1050;">
            <a class="dropdown-item" data-value="">All ${type.charAt(0).toUpperCase() + type.slice(1)}</a>
            ${list.map(item => `<a class="dropdown-item" data-value="${item}">${item}</a>`).join('')}
        </div>
    `;

    $(node).after(html);
    $(`#${id}`).css({
        top: $(node).offset().top + $(node).outerHeight(),
        left: $(node).offset().left
    });

    $(`#${id} .dropdown-item`).on('click', function () {
        var value = $(this).data('value');
        (type === 'year') ? selectedYear = value : selectedMonth = value;
        console.log(`Selected ${type.charAt(0).toUpperCase() + type.slice(1)}: `, value);
        applyFilters();
        $(`#${id}`).remove();
    });

    $(document).on(`click.close${type.charAt(0).toUpperCase() + type.slice(1)}Dropdown`, function (event) {
        if (!$(event.target).closest(`#${id}, .btn-primary`).length) {
            $(`#${id}`).remove();
            $(document).off(`click.close${type.charAt(0).toUpperCase() + type.slice(1)}Dropdown`);
        }
    });
}

function applyFilters() {
    var dt = hHistoriesTable;

    console.log("Applying Filters:", selectedYear, selectedMonth);

    dt.column(5).search('');

    dt.column(5).search((selectedYear && selectedMonth) ? 
        function(value) { return moment(value, 'DD MMMM YYYY').format('YYYY MMMM') === selectedYear + ' ' + selectedMonth; } 
        : selectedYear || selectedMonth, true, false).draw();
}

// Detail History Health Hospital
$('#hHistoriesTable').on('click', '.btn-view', function() {
    var data = hHistoriesTable.row($(this).parents('tr')).data();

    const formattedDate = moment(data.historyhealthDate).format('DD MMMM YYYY, HH:mm');
    const formattedCreateAt = moment(data.createdAt).format('DD MMMM YYYY, HH:mm');
    const formattedUpdateAt = moment(data.updatedAt).format('DD MMMM YYYY, HH:mm');
    const formattedBill = 'Rp ' + parseFloat(data.historyhealthTotalBill).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    const formattedDFee = 'Rp ' + parseFloat(data.historyhealthDoctorFee).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    const formattedMFee = 'Rp ' + parseFloat(data.historyhealthMedicineFee).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    const formattedLFee = 'Rp ' + parseFloat(data.historyhealthLabFee).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    const formattedAFee = 'Rp ' + parseFloat(data.historyhealthActionFee).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    const formattedDiscount = 'Rp ' + parseFloat(data.historyhealthDiscount).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

    if (data.historyhealthRole == "employee") {
        $('#detailContent #patientName').text(data.employeeName);
    } else {
        $('#detailContent #patientName').text(data.familyName);
    }

    $('#detailContent #detailDoctorName').text(data.doctorName);
    $('#detailContent #diseaseName').text(data.diseaseName ? data.diseaseName : 'Rujukan');
    $('#detailContent #historyhealthRole').text(data.historyhealthRole);
    $('#detailContent #employeeName').text(data.employeeName);
    $('#detailContent #companyName').text(data.companyName);
    $('#detailContent #historyhealthDate').text(formattedDate);
    $('#detailContent #invoiceStatus').text(data.historyhealthTotalBill > 0 ? data.invoiceStatus : 'free');
    $('#detailContent #createdAt').text(formattedCreateAt);
    $('#detailContent #updatedAt').text(formattedUpdateAt);
    $('#detailContent #historyhealthDoctorFee').text(formattedDFee);
    $('#detailContent #historyhealthMedicineFee').text(formattedMFee);
    $('#detailContent #historyhealthLabFee').text(formattedLFee);
    $('#detailContent #historyhealthActionFee').text(formattedAFee);
    $('#detailContent #historyhealthDiscount').text(formattedDiscount);
    $('#detailContent #historyhealthTotalBill').text(formattedBill);
});

var hDiseaseTable = $('#hDiseaseTable').DataTable($.extend(true, {}, DataTableSettings, {
    ajax: baseUrl + 'hospital/getHDiseaseDatas', 
    columns: [
        {
            data: null,
            className: 'text-start',
            render: function (data, type, row, meta) {
                return meta.row + 1;
            }
        },
        {data: 'diseaseName'},
        {data: 'diseaseInformation'},
    ],
    columnDefs: [
        {width: '180px', target: 0}
    ]
}));

// Employees CRUD
var employeesTable = $('#employeesTable').DataTable($.extend(true, {}, DataTableSettings, {
    ajax: baseUrl + 'company/getAllEmployeesDatas',
    columns: [
        {
            data: null,
            className: 'text-start align-middle',
            render: function (data, type, row, meta) {
                return meta.row + 1;
            }
        },
        {
            data: 'employeeNIK',
            className: 'text-nowrap align-middle'
        },
        {
            data: 'employeeName',
            className: 'text-nowrap align-middle'
        },
        {
            data: 'employeeStatus',
            className: 'text-nowrap align-middle',
            render: function(data) {
                return generateStatusData([data]).find((d) => d.id == data).text;
            }
        },
        {
            data: 'employeeGender',
            className: 'text-nowrap align-middle',
            render: function(data) {
                return capitalizeWords(data);
            }
        },
        {
            data: 'employeeEmail',
            className: 'text-nowrap align-middle'
        },
        {
            data: 'employeePhone',
            className: 'text-nowrap align-middle'
        },
        {
            data: 'employeeBirth',
            className: 'text-nowrap align-middle',
            render: function(data) {
                return moment(data).format('D MMMM YYYY')
            }
        },
        {
            data: 'employeeAddress',
            className: 'align-middle'
        },
        {
            data: null,
            className: 'text-end user-select-none no-export text-nowrap align-middle',
            orderable: false,
            defaultContent: `
                <button 
                    type="button" 
                    class="btn-view btn-primary rounded-2"
                    data-bs-toggle="modal"
                    data-bs-target="#viewEmployeeModal">
                    <i class="fa-regular fa-eye"></i>
                </button>
                <button 
                    type="button" 
                    class="btn-edit btn-warning rounded-2" 
                    data-bs-toggle="modal"
                    data-bs-target="#editEmployeeModal">
                    <i class="fa-regular fa-pen-to-square"></i>
                </button>
                <button 
                    type="button" 
                    class="btn-delete btn-danger rounded-2" 
                    data-bs-toggle="modal" 
                    data-bs-target="#deleteEmployeeModal">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            `
        }
    ],
    columnDefs: [
        {width: '180px', target: 8}
    ]
}));

$('#addEmployeeButton, #editEmployeeButton, #deleteEmployeeButton').on('click', function() {
    reloadTableData(employeesTable);
});

// Add Data Employee
$('#addEmployeeForm').on('submit', function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    removeCleaveFormat();
    $.ajax({
        url: baseUrl + 'company/Employees/addEmployee',
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            console.log(response);
            var res = JSON.parse(response);
            res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
            if (res.status === 'success') {
                $('#addEmployeeModal').modal('hide');
                reloadTableData(employeesTable);
                displayAlert('add success');
            } else if (res.status === 'failed') {
                $('.error-message').remove();
                $('.is-invalid').removeClass('is-invalid');
                formatPhoneInput()
                displayAlert(res.failedMsg, res.errorMsg ?? null);
            } else if (res.status === 'invalid') {
                formatPhoneInput()
                displayFormValidation('#addEmployeeForm', res.errors);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error!');
            console.error('Status:', status);
            console.error('Error:', error);
            console.error('Response:', xhr.responseText);
        }
    });
});

$('#addEmployeeModal').on('show.bs.modal', function() {
    $(this).find('#addEmployeeForm [name="employeeGender"]').select2({
        placeholder: 'Choose Gender',
        dropdownParent: $('#addEmployeeModal .modal-body')
    });

    $(this).find('#addEmployeeForm [name="insuranceId"]').select2({
        ajax: {
            url: baseUrl + 'company/Insurance/getAllInsuranceByCompanyId',
            type: 'GET',
            dataType: 'json',
            delay: 250,
            processResults: function (response, params) {
                const searchTerm = params.term ? params.term.toLowerCase() : '';
                return {
                    results: response.data 
                        .filter(function(data) {
                            const insuranceTier = data.insuranceTier.toLowerCase().includes(searchTerm);
                            const insuranceAmount = data.insuranceAmount.toLowerCase().includes(searchTerm);
                            return insuranceTier || insuranceAmount;
                        })
                        .map(function (data) {
                        return {
                            id: data.insuranceId,
                            text: data.insuranceTier + ' | ' + formatToRupiah(data.insuranceAmount)
                        };
                    })
                };
            },
            cache: true
        },
        minimumInputLength: 0,
        placeholder: 'Choose Insurance',
        allowClear: true,
        dropdownParent: $('#addEmployeeModal .modal-body')
    });
});

// View Data Employee
$('#employeesTable').on('click', '.btn-view', function() {
    var data = employeesTable.row($(this).parents('tr')).data();
    if (data.employeePhoto) {
        $('#viewEmployeeModal #imgPreview').attr('src', baseUrl+'uploads/profiles/'+data.employeePhoto);
    }

    $('#viewEmployeeModal #employeeNIK').html(data.employeeNIK);
    $('#viewEmployeeModal #employeeName').html(data.employeeName);
    $('#viewEmployeeModal #employeeEmail').html(data.employeeEmail);
    $('#viewEmployeeModal #employeePassword').html(data.employeePassword);
    $('#viewEmployeeModal #employeeAddress').html(data.employeeAddress);
    $('#viewEmployeeModal #employeeStatus').html(generateStatusData([data.employeeStatus]).find((d) => d.id == data.employeeStatus).text);
    $('#viewEmployeeModal #employeeBirth').html(moment(data.employeeBirth).format('dddd, D MMMM YYYY'))
    $('#viewEmployeeModal #employeeGender').html(capitalizeWords(data.employeeGender))
    $('#viewEmployeeModal #employeePhone').html(data.employeePhone);
    $('#viewEmployeeModal #insuranceTier').html(capitalizeWords(data.insuranceTier));
    $('#viewEmployeeModal #totalBillingAmount').html(formatToRupiah(data.insuranceAmount, false, false));

    $.ajax({
        url: baseUrl + 'company/getEmployeeDetails?nik=' + data.employeeNIK,
        method: 'GET',
        success: function(response) {
            var res = JSON.parse(response).data[0];
            let billingRemaining = data.insuranceAmount - res.totalBillingUsed;
            $('#viewEmployeeModal #totalBillingUsed').html(formatToRupiah(res.totalBillingUsed, false, false));
            $('#viewEmployeeModal #totalBillingRemaining').html(formatToRupiah(billingRemaining));
            $('#viewEmployeeModal #totalBilledTreatments').html(res.totalBilledTreatments);
            $('#viewEmployeeModal #totalReferredTreatments').html(res.totalReferredTreatments);
            $('#viewEmployeeModal #totalFreeTreatments').html(res.totalFreeTreatments);
            $('#viewEmployeeModal #totalTreatments').html(res.totalTreatments);
            $('#viewEmployeeModal #totalBilledTreatmentsThisMonth').html(res.totalBilledTreatmentsThisMonth);
            $('#viewEmployeeModal #totalReferredTreatmentsThisMonth').html(res.totalReferredTreatmentsThisMonth);
            $('#viewEmployeeModal #totalFreeTreatmentsThisMonth').html(res.totalFreeTreatmentsThisMonth);
            $('#viewEmployeeModal #totalTreatmentsThisMonth').html(res.totalTreatmentsThisMonth);
        }
    });
    
    getEmployeeFamilies(data.employeeNIK);
});

var employeeFamiliesTable;
function getEmployeeFamilies(employeeNIK) {
    if ($.fn.DataTable.isDataTable('#employeeFamiliesTable')) {
        $('#employeeFamiliesTable').DataTable().ajax.url(baseUrl + 'company/getFamiliesByEmployeeNIK?nik=' + employeeNIK).load();
        return;
    }
    employeeFamiliesTable = $('#employeeFamiliesTable').DataTable($.extend(true, {}, DataTableSettings, {
        ajax: baseUrl + 'company/getFamiliesByEmployeeNIK?nik=' + employeeNIK,
        columns: [
            {
                data: null,
                className: 'text-start align-middle',
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            {
                data: 'familyNIK',
                className: 'text-start text-nowrap align-middle'
            },
            {
                data: 'familyName',
                className: 'text-nowrap align-middle'
            },
            {
                data: 'familyStatus',
                className: 'text-nowrap align-middle',
                render: function(data) {
                    return generateStatusData([data]).find((d) => d.id == data).text;
                }
            },
            {
                data: 'familyGender',
                className: 'text-nowrap align-middle',
                render: function(data) {
                    return capitalizeWords(data);
                }
            },
            {
                data: 'familyEmail',
                className: 'text-nowrap align-middle'
            },
            {
                data: 'familyPhone',
                className: 'text-nowrap align-middle'
            },
            {
                data: 'familyBirth',
                className: 'text-nowrap align-middle',
                render: function(data) {
                    return moment(data).format('D MMMM YYYY')
                }
            },
            {
                data: 'familyAddress',
                className: 'align-middle'
            },
            {
                data: null,
                className: 'text-end user-select-none no-export text-nowrap align-middle',
                orderable: false,
                defaultContent: `
                    <button 
                        type="button" 
                        class="btn-view btn-primary rounded-2">
                        <i class="fa-regular fa-eye"></i>
                    </button>
                `
            }
        ],
        columnDefs: [
            {width: '80px', target: 9}
        ]
    }));
}

var viewFamilyTreatmentModal;
$('#employeeFamiliesTable').on('click', '.btn-view', function() {
    viewFamilyTreatmentModal = new bootstrap.Modal(document.getElementById('viewFamilyTreatmentModal'));
    viewFamilyTreatmentModal.show();
    const $backdrops = $('.modal-backdrop.show');
    if ($backdrops.length >= 2) {
        $backdrops.eq(1).css('z-index', '1055');
        $('#viewFamilyTreatmentModal').css('z-index', '1056');
    }
    var data = employeeFamiliesTable.row($(this).parents('tr')).data();

    $('#viewFamilyTreatmentModal #totalBilledTreatments').html(data.totalBilledTreatments);
    $('#viewFamilyTreatmentModal #totalReferredTreatments').html(data.totalReferredTreatments);
    $('#viewFamilyTreatmentModal #totalFreeTreatments').html(data.totalFreeTreatments);
    $('#viewFamilyTreatmentModal #totalTreatments').html(data.totalTreatments);
    $('#viewFamilyTreatmentModal #totalBilledTreatmentsThisMonth').html(data.totalBilledTreatmentsThisMonth);
    $('#viewFamilyTreatmentModal #totalReferredTreatmentsThisMonth').html(data.totalReferredTreatmentsThisMonth);
    $('#viewFamilyTreatmentModal #totalFreeTreatmentsThisMonth').html(data.totalFreeTreatmentsThisMonth);
    $('#viewFamilyTreatmentModal #totalTreatmentsThisMonth').html(data.totalTreatmentsThisMonth);
})

// Edit Data Employee
$('#employeesTable').on('click', '.btn-edit', function() {
    var data = employeesTable.row($(this).parents('tr')).data();

    if (data.employeePhoto) {
        $('#editEmployeeForm #imgPreview').attr('src', baseUrl+'uploads/profiles/'+data.employeePhoto);
    }

    $('#editEmployeeForm [name="employeeNIK"]').val(data.employeeNIK);
    $('#editEmployeeForm [name="employeeName"]').val(data.employeeName);
    $('#editEmployeeForm [name="employeeEmail"]').val(data.employeeEmail);
    $('#editEmployeeForm [name="employeePassword"]').val(data.employeePassword);
    $('#editEmployeeForm [name="employeeAddress"]').val(data.employeeAddress);
    $('#editEmployeeForm [name="employeeBirth"]')[0]._flatpickr.setDate(data.employeeBirth);

    var isUnverified = data.employeeStatus == 'unverified';
    $('#editEmployeeForm [name="employeeStatus"]').select2({
        minimumInputLength: 0,
        placeholder: 'Choose Status',
        data: isUnverified ? generateStatusData([data.employeeStatus]) : generateStatusData(['Active', 'On Hold', 'Discontinued']),
        disabled: isUnverified,
        dropdownParent: $('#editEmployeeModal .modal-body'),
        escapeMarkup: function(markup) {
            return markup;
        }
    });
    $('#editEmployeeForm [name="employeeStatus"]').val(data.employeeStatus).trigger('change');
    isUnverified && $('#editEmployeeForm [name="employeeStatus"]').parents('.col-12').find('.warning-message').show();

    $('#editEmployeeForm [name="employeePhone"]').val(data.employeePhone);
    formatPhoneInput()

    $('#editEmployeeForm [name="employeeGender"]').select2({
        minimumInputLength: 0,
        placeholder: 'Choose Gender',
        dropdownParent: $('#editEmployeeModal .modal-body'),
    });
    $('#editEmployeeForm [name="employeeGender"]').val(data.employeeGender).trigger('change');
    
    $('#editEmployeeForm [name="insuranceId"]').select2({
        ajax: {
            url: baseUrl + 'company/Insurance/getAllInsuranceByCompanyId',
            type: 'GET',
            dataType: 'json',
            delay: 250,
            processResults: function(response, params) {
                const searchTerm = params.term ? params.term.toLowerCase() : '';
                return {
                    results: response.data
                        .filter(function(d) {
                            const insuranceTier = d.insuranceTier.toLowerCase().includes(searchTerm);
                            const insuranceAmount = d.insuranceAmount.toLowerCase().includes(searchTerm);
                            return insuranceTier || insuranceAmount;
                        })
                        .map(function(d) {
                            return {
                                id: d.insuranceId,
                                text: `${d.insuranceTier} | ${d.insuranceAmount}`,
                                selected: d.insuranceId === data.insuranceId
                            }
                        })
                };
            }
        },
        minimumInputLength: 0,
        placeholder: 'Choose Insurance',
        dropdownParent: $('#editEmployeeModal .modal-body'),
    });

    var selectedOption = new Option(
        `${data.insuranceTier} - ${formatToRupiah(data.insuranceAmount, true, false)}`,
        data.insuranceId,
        true,
        true
    )
    $('#editEmployeeForm [name="insuranceId"]').append(selectedOption).trigger('change');
});

$('#editEmployeeForm #newEmployeeNIK').change(function() {
    $('#editEmployeeForm #newEmployeeNIKInput').toggle();
    $('#editEmployeeForm #newEmployeeNIKInput').find('input').val('');
    $('#editEmployeeForm #newEmployeeNIKInput').find('.error-message').remove();
    $('#editEmployeeForm #newEmployeeNIKInput').find('.is-invalid').removeClass('is-invalid');
});

$('#editEmployeeForm').on('submit', function(e) {
    e.preventDefault();
    removeCleaveFormat();
    $.ajax({
        url: baseUrl + 'company/Employees/editEmployee',
        method: 'POST',
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function(response) {
            console.log(response);
            var res = JSON.parse(response);
            res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
            if (res.status === 'success') {
                $('#editEmployeeModal').modal('hide');
                reloadTableData(employeesTable);
                displayAlert('edit success');
            } else if (res.status === 'failed') {
                $('.error-message').remove();
                $('.is-invalid').removeClass('is-invalid');
                formatPhoneInput();
                displayAlert(res.failedMsg, res.errorMsg ?? null);
            } else if (res.status === 'invalid') {
                formatPhoneInput();
                displayFormValidation('#editEmployeeForm', res.errors);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error!');
            console.error('Status:', status);
            console.error('Error:', error);
            console.error('Response:', xhr.responseText);
        }
    });
});

// Delete Data Employee
$('#employeesTable').on('click', '.btn-delete', function() {
    var data = employeesTable.row($(this).parents('tr')).data();
    $('#deleteEmployeeForm #employeeName').html(data.employeeName);
    $('#deleteEmployeeForm [name="employeeNIK"]').val(data.employeeNIK);
});

$('#deleteEmployeeForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: baseUrl + 'company/Employees/deleteEmployee',
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            var res = JSON.parse(response);
            res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
            if (res.status === 'success') {
                $('#deleteEmployeeModal').modal('hide');
                reloadTableData(employeesTable);
                displayAlert('delete success');
            }
        }
    });
});


// Insurances CRUD
var insurancesTable = $('#insurancesTable').DataTable($.extend(true, {}, DataTableSettings, {
    ajax: baseUrl + 'company/getAllInsuranceByCompanyId',
    columns: [
        {
            data: null,
            className: 'text-start align-middle',
            render: function (data, type, row, meta) {
                return meta.row + 1;
            }
        },
        {
            data: 'insuranceTier',
            className: 'text-start align-middle'
        },
        {
            data: 'insuranceAmount',
            className: 'text-end align-middle',
            render: function(data) {
                return formatToRupiah(data);
            }
        },
        {
            data: 'insuranceDescription',
            className: 'text-start align-middle'
        },
        {
            data: null,
            className: 'text-end user-select-none no-export text-nowrap align-middle',
            orderable: false,
            defaultContent: `
                <button 
                    type="button" 
                    class="btn-edit btn-warning rounded-2" 
                    data-bs-toggle="modal" 
                    data-bs-target="#editInsuranceModal">
                    <i class="fa-regular fa-pen-to-square"></i>
                </button>
                <button 
                    type="button" 
                    class="btn-delete btn-danger rounded-2" 
                    data-bs-toggle="modal" 
                    data-bs-target="#deleteInsuranceModal">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            `
        }
    ],
    columnDefs: [
        {width: '130px', target: 4}
    ]
}));

$('#addInsuranceButton, #editInsuranceButton, #deleteInsuranceButton').on('click', function() {
    reloadTableData(insurancesTable);
});

// Add Data Insurance
$('#addInsuranceForm').on('submit', function(e) {
    e.preventDefault();
    removeCleaveFormat();
    var formData = new FormData(this);
    $.ajax({
        url: baseUrl + 'company/insurance/addInsurance',
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            var res = JSON.parse(response);
            res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
            if (res.status === 'success') {
                $('#addInsuranceModal').modal('hide');
                reloadTableData(insurancesTable);
                displayAlert('add success');
            } else if (res.status === 'failed') {
                $('.error-message').remove();
                $('.is-invalid').removeClass('is-invalid');
                formatCurrencyInput();
                displayAlert(res.failedMsg, res.errorMsg ?? null);
            } else if (res.status === 'invalid') {
                formatCurrencyInput();
                displayFormValidation('#addInsuranceForm', res.errors);
            }
        }
    });
});

// Edit Data Insurance
$('#insurancesTable').on('click', '.btn-edit', function() {
    var data = insurancesTable.row($(this).parents('tr')).data();
    $('#editInsuranceForm [name="insuranceId"]').val(data.insuranceId);
    $('#editInsuranceForm [name="insuranceTier"]').val(data.insuranceTier);
    $('#editInsuranceForm [name="insuranceAmount"]').val(data.insuranceAmount);
    formatCurrencyInput();
    $('#editInsuranceForm [name="insuranceDescription"]').val(data.insuranceDescription);
});

$('#editInsuranceForm').on('submit', function(e) {
    e.preventDefault();
    removeCleaveFormat();
    $.ajax({
        url: baseUrl + 'company/insurance/editInsurance',
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            var res = JSON.parse(response);
            res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
            if (res.status === 'success') {
                $('#editInsuranceModal').modal('hide');
                reloadTableData(insurancesTable);
                displayAlert('edit success');
            } else if (res.status === 'failed') {
                $('.error-message').remove();
                $('.is-invalid').removeClass('is-invalid');
                formatCurrencyInput();
                displayAlert(res.failedMsg, res.errorMsg ?? null);
            } else if (res.status === 'invalid') {
                formatCurrencyInput();
                displayFormValidation('#editInsuranceForm', res.errors);
            }
        }
    });
});

// Delete Insurance
$('#insurancesTable').on('click', '.btn-delete', function() {
    var data = insurancesTable.row($(this).parents('tr')).data();
    $('#deleteInsuranceForm #insuranceTier').html(data.insuranceTier);
    $('#deleteInsuranceForm [name="insuranceId"]').val(data.insuranceId);
});

$('#deleteInsuranceForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: baseUrl + 'company/insurance/deleteInsurance', // base URL diubah
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            var res = JSON.parse(response);
            res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
            if (res.status === 'success') {
                $('#deleteInsuranceModal').modal('hide');
                reloadTableData(insurancesTable);
                displayAlert('delete success');
            }
        }
    });
});


// Families CRUD
var familiesTable = $('#familiesTable').DataTable($.extend(true, {}, DataTableSettings, {
    ajax: baseUrl + 'company/getAllFamilyDatas',
    columns: [
        {
            data: null,
            className: 'text-start align-middle',
            render: function (data, type, row, meta) {
                return meta.row + 1;
            }
        },
        {
            data: 'familyNIK',
            className: 'align-middle'
        },
        {
            data: 'familyName',
            className: 'align-middle'
        },
        {
            data: 'familyStatus',
            className: 'align-middle',
            render: function(data) {
                return generateStatusData([data]).find((d) => d.id === data).text;
            }
        },
        {
            data: 'familyGender',
            className: 'align-middle',
            render: function(data) {
                return capitalizeWords(data);
            }
        },
        {
            data: 'familyEmail',
            className: 'align-middle'
        },
        {
            data: 'familyPhone',
            className: 'align-middle'
        },
        {
            data: 'familyBirth',
            className: 'align-middle',
            render: function(data) {
                return moment(data).format('D MMMM YYYY');
            }
        },
        {
            data: 'familyAddress',
            className: 'align-middle'
        },
        {
            data: null,
            className: 'text-end user-select-none no-export text-nowrap align-middle',
            orderable: false,
            defaultContent: `
                <button 
                    type="button" 
                    class="btn-edit btn-warning rounded-2" 
                    data-bs-toggle="modal" 
                    data-bs-target="#editFamilyModal">
                    <i class="fa-regular fa-pen-to-square"></i>
                </button>
                <button 
                    type="button" 
                    class="btn-delete btn-danger rounded-2" 
                    data-bs-toggle="modal" 
                    data-bs-target="#deleteFamilyModal">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            `
        }
    ],
    columnDefs: [
        {width: '130px', target: 9}
    ]
}));

$('#addFamilyButton, #editFamilyButton, #deleteFamilyButton').on('click', function() {
    reloadTableData(familiesTable);
});

// Add Data Family
$('#addFamilyModal').on('show.bs.modal', function() {
    $('#addFamilyForm [name="familyGender"]').select2({
        placeholder: 'Choose Gender',
        dropdownParent: $('#addFamilyModal .modal-body')
    });

    $('#addFamilyForm [name="employeeNIK"]').select2({
        ajax: {
            url: baseUrl + 'company/getAllEmployeesDatas',
            type: 'GET',
            dataType: 'json',
            delay: 250,
            processResults: function (response, params) {
                const searchTerm = params.term ? params.term.toLowerCase() : '';
                return {
                    results: response.data
                        .filter(function (data) {
                            const nikMatch = data.employeeNIK.toLowerCase().includes(searchTerm);
                            const nameMatch = data.employeeName.toLowerCase().includes(searchTerm);
                            const statusMatch = data.employeeStatus.toLowerCase().includes(searchTerm);
                            return nikMatch || nameMatch || statusMatch;
                        })
                        .map(function (data) {
                            return {
                                id: data.employeeNIK,
                                text: `
                                ${data.employeeNIK} | 
                                ${data.employeeName} | 
                                ${generateStatusData([data.employeeStatus]).find((d) => d.id === data.employeeStatus).text}`
                            };
                        }) ?? []
                };
            },
            cache: true
        },
        minimumInputLength: 0,
        placeholder: 'Choose Employee',
        dropdownParent: $('#addFamilyModal .modal-body'),
        escapeMarkup: function (markup) { return markup; }
    });
});

$('#addFamilyForm').on('submit', function(e) {
    e.preventDefault();
    removeCleaveFormat();
    $.ajax({
        url: baseUrl + 'company/Families/addFamily',
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            var res = JSON.parse(response);
            res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
            if (res.status === 'success') {
                $('#addFamilyModal').modal('hide');
                reloadTableData(familiesTable);
                displayAlert('add success');
            } else if (res.status === 'failed') {
                $('.error-message').remove();
                $('.is-invalid').removeClass('is-invalid');
                formatPhoneInput()
                displayAlert(res.failedMsg, res.errorMsg ?? null);
            } else if (res.status === 'invalid') {
                formatPhoneInput()
                displayFormValidation('#addFamilyForm', res.errors);
            }
        }
    });
});


// Edit Data Family
$('#familiesTable').on('click', '.btn-edit', function() {
    var data = familiesTable.row($(this).parents('tr')).data();
    $('#editFamilyForm #newFamilyNIKInput').hide();

    $('#editFamilyForm [name="familyNIK"]').val(data.familyNIK);
    $('#editFamilyForm [name="familyName"]').val(data.familyName);
    $('#editFamilyForm [name="familyEmail"]').val(data.familyEmail);
    $('#editFamilyForm [name="familyAddress"]').val(data.familyAddress);

    $('#editFamilyForm [name="familyPhone"]').val(data.familyPhone);
    formatPhoneInput();

    $('#editFamilyForm [name="familyBirth"]')[0]._flatpickr.setDate(data.familyBirth);
    
    $('#editFamilyForm [name="familyGender"]').select2({
        placeholder: 'Choose Gender',
        dropdownParent: $('#editFamilyModal .modal-body'),
    });
    $('#editFamilyForm [name="familyGender"]').val(data.familyGender).trigger('change');

    var isUnverified = data.familyStatus == 'unverified';
    $('#editFamilyForm [name="familyStatus"]').select2({
        placeholder: 'Choose Status',
        data: isUnverified ? generateStatusData([data.familyStatus]) : generateStatusData(['Active', 'On Hold', 'Archived']),
        disabled: isUnverified,
        dropdownParent: $('#editFamilyModal .modal-body'),
        escapeMarkup: function(markup) {
            return markup;
        }
    });
    $('#editFamilyForm [name="familyStatus"]').val(data.familyStatus).trigger('change');
    isUnverified && $('#editFamilyForm [name="familyStatus"]').parents('.col-12').find('.warning-message').show();

    $('#editFamilyForm [name="employeeNIK"]').select2({
        ajax: {
            url: baseUrl + 'company/getAllEmployeesDatas',
            type: 'GET',
            dataType: 'json',
            delay: 250,
            processResults: function (response, params) {
                const searchTerm = params.term ? params.term.toLowerCase() : '';
                return {
                    results: response.data
                    .filter(function (d) {
                        const nikMatch = d.employeeNIK.toLowerCase().includes(searchTerm);
                        const nameMatch = d.employeeName.toLowerCase().includes(searchTerm);
                        const statusMatch = d.employeeStatus.toLowerCase().includes(searchTerm);
                        return nikMatch || nameMatch || statusMatch;
                    })
                    .map(function (d) {
                        if (d.employeeNIK != data.employeeNIK) {
                            return {
                                id: d.employeeNIK,
                                text: `
                                ${d.employeeNIK} | 
                                ${d.employeeName} | 
                                ${generateStatusData([d.employeeStatus]).find((a) => a.id === d.employeeStatus).text}`,
                            };
                        } else {
                            return {
                                id: d.employeeNIK,
                                text: `
                                ${d.employeeNIK} | 
                                ${d.employeeName} | 
                                ${generateStatusData(['current']).find((a) => a.id === 'current').text}`,
                                selected: true
                            };
                        }
                    }) ?? []
                };
            },
            cache: true
        },
        minimumInputLength: 0,
        placeholder: 'Choose Employee',
        dropdownParent: $('#editFamilyModal .modal-body'),
        escapeMarkup: function (markup) { return markup; },
    });
    $('#editFamilyForm [name="employeeNIK"]').val(data.employeeNIK).trigger('change');

    if (data.employeeNIK) {
        var preselectedOption = new Option(
            `${data.employeeNIK} | ${data.employeeName} | ${generateStatusData(['current']).find((d) => d.id === 'current').text}`,
            data.employeeNIK,
            true, 
            true  
        );
        $('#editFamilyForm [name="employeeNIK"]').append(preselectedOption).trigger('change');
    }
});

$('#editFamilyForm #newFamilyNIK').change(function() {
    $('#editFamilyForm #newFamilyNIKInput').toggle();
    $('#editFamilyForm #newFamilyNIKInput').find('input').val('');
    $('#editFamilyForm #newFamilyNIKInput').find('.error-message').remove();
    $('#editFamilyForm #newFamilyNIKInput').find('.is-invalid').removeClass('is-invalid');
});

$('#editFamilyForm').on('submit', function(e) {
    e.preventDefault();
    removeCleaveFormat();
    $.ajax({
        url: baseUrl + 'company/Families/editFamily',
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            var res = JSON.parse(response);
            res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
            if (res.status === 'success') {
                $('#editFamilyModal').modal('hide');
                reloadTableData(familiesTable);
                displayAlert('edit success');
            } else if (res.status === 'failed') {
                $('.error-message').remove();
                $('.is-invalid').removeClass('is-invalid');
                formatPhoneInput();
                displayAlert(res.failedMsg, res.errorMsg ?? null);
            } else if (res.status === 'invalid') {
                formatPhoneInput();
                displayFormValidation('#editFamilyForm', res.errors);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error!');
            console.error('Status:', status);
            console.error('Error:', error);
            console.error('Response:', xhr.responseText);
        }
    });
});

// Delete Family
$('#familiesTable').on('click', '.btn-delete', function() {
    var data = familiesTable.row($(this).parents('tr')).data();
    $('#deleteFamilyForm #familyName').html(data.familyName);
    $('#deleteFamilyForm [name="familyNIK"]').val(data.familyNIK);
});

$('#deleteFamilyForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: baseUrl + 'company/Families/deleteFamily', // URL untuk menghapus data
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            var res = JSON.parse(response);
            res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
            if (res.status === 'success') {
                $('#deleteFamilyModal').modal('hide');
                reloadTableData(familiesTable);
                displayAlert('delete success');
            } else if (res.status === 'failed') {
                $('#deleteFamilyModal').modal('hide');
                displayAlert(res.failedMsg, res.errorMsg ?? null);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error!');
            console.error('Status:', status);
            console.error('Error:', error);
            console.error('Response:', xhr.responseText);
        }
    });
});



// Treatment History CRUD
var treatmentHistoryTable = $('#treatmentHistoryTable').DataTable($.extend(true, {}, DataTableSettings, {
    ajax: baseUrl + 'company/getHistoryHealthByCompanyId',
    columns: [
        {
            data: null,
            className: 'text-start align-middle',
            render: function (data, type, row, meta) {
                return meta.row + 1;
            }
        },
        {
            data: 'patientNIK',
            className: 'align-middle'
        },
        {
            data: 'patientName',
            className: 'align-middle'
        },
        {
            data: 'historyhealthRole',
            className: 'align-middle'
        },
        {
            data: 'historyhealthDate',
            className: 'align-middle',
            render: function(data) {
                return moment(data).format('D MMMM YYYY');
            }
        },
        {
            data: 'historyhealthDoctorFee',
            className: 'align-middle',
            render: function(data) {
                return formatToRupiah(data);
            }
        },
        {
            data: 'historyhealthMedicineFee',
            className: 'align-middle',
            render: function(data) {
                return formatToRupiah(data);
            }
        },
        {
            data: 'historyhealthLabFee',
            className: 'align-middle',
            render: function(data) {
                return formatToRupiah(data);
            }
        },
        {
            data: 'historyhealthActionFee',
            className: 'align-middle',
            render: function(data) {
                return formatToRupiah(data);
            }
        },
        {
            data: 'historyhealthDiscount',
            className: 'align-middle',
            render: function(data) {
                return '- ' + formatToRupiah(data);
            }
        },
        {
            data: 'historyhealthTotalBill',
            className: 'align-middle',
            render: function(data) {
                return formatToRupiah(data);
            }
        },
        {
            data: 'hospitalName',
            className: 'align-middle'
        },
        {
            data: 'doctorName',
            className: 'align-middle'
        },
        {
            data: 'status',
            className: 'align-middle',
            render: function(data) {
                return generateStatusData([data]).find((d) => d.id = data).text;
            }
        },
    ],
    columnDefs: [
        {width: '250px', target: 13}
    ]
}));