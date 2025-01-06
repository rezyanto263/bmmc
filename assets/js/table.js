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

$('.modal').on('hidden.bs.modal', function(e) {
    $('#imgPreview').attr('src', $('#imgPreview').data('originalsrc'));
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
            data: 'adminStatus',
            render: function(data, type, row) {
                return capitalizeWords(data);
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
        {width: '180px', target: 4}
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

$('#addAdminModal').on('shown.bs.modal', function () {
    $(this).find('select#adminRole').select2({
        placeholder: 'Choose Role',
        dropdownParent: $('#addAdminModal .modal-body')
    });
    $(this).find('select#adminStatus').select2({
        placeholder: 'Choose Status',
        dropdownParent: $('#addAdminModal .modal-body')
    });
});

// Edit Data Admin
$('#adminsTable').on('click', '.btn-edit', function() {
    var data = adminsTable.row($(this).parents('tr')).data();
    $('#editAdminForm [name="adminId"]').val(data.adminId);
    $('#editAdminForm [name="adminName"]').val(data.adminName);
    $('#editAdminForm [name="adminRole"]').val(data.adminRole);
    $('#editAdminForm [name="adminStatus"]').val(data.adminStatus);
});

$('#editAdminModal').on('shown.bs.modal', function () {
    $(this).find('select#adminRole').select2({
        placeholder: 'Choose',
        dropdownParent: $('#editAdminModal .modal-body')
    });
    $(this).find('select#adminStatus').select2({
        placeholder: 'Choose',
        dropdownParent: $('#editAdminModal .modal-body')
    });
});


$('#editAdminForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: baseUrl + 'dashboard/admins/editAdmin',
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            var res = JSON.parse(response);
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
    $('#deleteAdminForm #adminId').val(data.adminId);
})

$('#deleteAdminForm').on('submit', function(e) {
    e.preventDefault();
    var adminId = $('#deleteAdminForm #adminId').val();
    $.ajax({
        url: baseUrl + 'dashboard/admins/deleteAdmin',
        method: 'POST',
        data: {adminId: adminId},
        success: function(response) {
            var res = JSON.parse(response);
            if (res.status === 'success') {
                $('#deleteAdminModal').modal('hide');
                displayAlert('delete success');
                reloadTableData(adminsTable);
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
        {width: '240px', target: 5}
    ]
}));

$('#addHospitalModal').on('shown.bs.modal', function() {
    $(this).find('select#adminId').select2({
        ajax: {
            url: baseUrl + 'dashboard/getAllUnconnectedHospitalAdminsDatas',
            type: 'GET',
            dataType: 'json',
            delay: 250,
            processResults: function (response) {
                return {
                    results: $.map(response.data, function (data) {
                        return {
                            id: data.adminId,
                            text: data.adminEmail + ' | ' + data.adminName
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
    });
});

$('#addHospitalButton, #editHospitalButton, #deleteHospitalButton').on('click', function() {
    reloadTableData(hospitalsTable);
});

// Add Data Hospital
$('#addHospitalForm').on('submit', function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        url: baseUrl + 'dashboard/hospitals/addHospital',
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            var res = JSON.parse(response);
            if (res.status === 'success') {
                $('#addHospitalModal').modal('hide');
                reloadTableData(hospitalsTable);
                displayAlert('add success');
            } else if (res.status === 'failed') {
                $('.error-message').remove();
                $('.is-invalid').removeClass('is-invalid');
                displayAlert(res.failedMsg, res.errorMsg ?? null);
            } else if (res.status === 'invalid') {
                displayFormValidation('#addHospitalForm', res.errors);
            }
        }
    });
});


// View Data Hospital
$('#hospitalsTable').on('click', '.btn-view', function() {
    var data = hospitalsTable.row($(this).parents('tr')).data();
    let imageFilePath = baseUrl + 'assets/images/hospital-placeholder.jpg';
    if (data.hospitalLogo) {
        imageFilePath = baseUrl + 'uploads/logos/' + data.hospitalLogo;
        $('#viewHospitalModal #imgPreview').attr('src', baseUrl+'uploads/logos/'+data.hospitalLogo);
    }
    $('#viewHospitalModal [name="hospitalId"]').val(data.hospitalId);
    $('#viewHospitalModal [name="hospitalName"]').val(data.hospitalName);
    $('#viewHospitalModal [name="hospitalPhone"]').val(data.hospitalPhone);
    $('#viewHospitalModal [name="hospitalAddress"]').val(data.hospitalAddress);
    $('#viewHospitalModal [name="hospitalCoordinate"]').val(data.hospitalCoordinate);

    if (data.adminId) {
        $('#viewHospitalModal [name="adminId"]').val(data.adminName + ' | ' + data.adminEmail);
    } else {
        $('#viewHospitalModal [name="adminId"]').val('No Admin');
    }

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
    var data = hospitalsTable.row($(this).parents('tr')).data();
    if (data.hospitalLogo) {
        $('#editHospitalForm #imgPreview').attr('src', baseUrl+'uploads/logos/'+data.hospitalLogo);
    }
    $('#editHospitalForm [name="hospitalId"]').val(data.hospitalId);
    $('#editHospitalForm [name="hospitalName"]').val(data.hospitalName);
    $('#editHospitalForm [name="hospitalPhone"]').val(data.hospitalPhone);
    $('#editHospitalForm [name="hospitalAddress"]').val(data.hospitalAddress);

    var adminId = data.adminId;
    if (adminId) {
        var selectedAdmin = '<option value="'+adminId+'">'+data.adminName+' | '+data.adminEmail+'</option>';
    }
    $('#editHospitalForm select#adminId').html(selectedAdmin);
    $('#editHospitalForm select#adminId').select2({
        placeholder: 'Choose Admin',
        allowClear: true,
        dropdownParent: $('#editHospitalModal .modal-body'),
    });

    $.ajax({
        url: baseUrl + 'dashboard/getAllUnconnectedHospitalAdminsDatas',
        method: 'GET',
        success: function(response) {
            var res = JSON.parse(response);

            let optionList = [selectedAdmin];
            $.each(res.data, function(index, data) {
                optionList += '<option value="'+data.adminId+'">'+data.adminName+' | '+data.adminEmail+'</option>';
            });

            $('#editHospitalForm select#adminId').html(optionList);
            $('#editHospitalForm select#adminId').val(adminId).trigger('change');
        }
    });
});

$('#editHospitalForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: baseUrl + 'dashboard/hospitals/editHospital',
        method: 'POST',
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function(response) {
            var res = JSON.parse(response);
            if (res.status === 'success') {
                $('#editHospitalModal').modal('hide');
                reloadTableData(hospitalsTable);
                displayAlert('edit success');
            } else if (res.status === 'failed') {
                $('.error-message').remove();
                $('.is-invalid').removeClass('is-invalid');
                displayAlert(res.failedMsg, res.errorMsg ?? null);
            } else if (res.status === 'invalid') {
                displayFormValidation('#editHospitalForm', res.errors);
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
    $('#deleteHospitalForm #hospitalId').val(data.hospitalId);
});

$('#deleteHospitalForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: baseUrl + 'dashboard/hospitals/deleteHospital',
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            var res = JSON.parse(response);
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
        {
            data: 'adminEmail',
            render: function(data, type, row) {
                return data ? data : 'No Admin';
            }
        },
        {data: 'companyAddress'},
        {data: 'companyPhone'},
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
        {width: '240px', target: 5}
    ]
}));

$('#addCompanyModal').on('shown.bs.modal', function() {
    $(this).find('select#adminId').select2({
        ajax: {
            url: baseUrl + 'dashboard/getAllUnconnectedCompanyAdminsDatas',
            type: 'GET',
            dataType: 'json',
            delay: 250,
            processResults: function (response) {
                return {
                    results: $.map(response.data, function (data) {
                        return {
                            id: data.adminId,
                            text: data.adminEmail + ' | ' + data.adminName
                        };
                    })
                };
            },
            cache: true
        },
        minimumInputLength: 0,
        placeholder: 'Choose Admin',
        allowClear: true,
        dropdownParent: $('#addCompanyModal .modal-body')
    });
});

$('#addCompanyButton, #editCompanyButton, #deleteCompanyButton').on('click', function() {
    reloadTableData(companiesTable);
});

// Add Data Company
$('#addCompanyForm').on('submit', function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        url: baseUrl + 'dashboard/companies/addCompany',
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            var res = JSON.parse(response);
            if (res.status === 'success') {
                $('#addCompanyModal').modal('hide');
                reloadTableData(companiesTable);
                displayAlert('add success');
            } else if (res.status === 'failed') {
                $('.error-message').remove();
                $('.is-invalid').removeClass('is-invalid');
                displayAlert(res.failedMsg, res.errorMsg ?? null);
            } else if (res.status === 'invalid') {
                displayFormValidation('#addCompanyForm', res.errors);
            }
        }
    });
});

// View Data Company
$('#companiesTable').on('click', '.btn-view', function() {
    var data = companiesTable.row($(this).parents('tr')).data();
    let imageFilePath = baseUrl + 'assets/images/company-placeholder.jpg';
    if (data.companyLogo) {
        imageFilePath = baseUrl + 'uploads/logos/' + data.companyLogo;
        $('#viewCompanyModal #imgPreview').attr('src', baseUrl+'uploads/logos/'+data.companyLogo);
    }
    $('#viewCompanyModal [name="companyName"]').val(data.companyName);
    $('#viewCompanyModal [name="companyPhone"]').val(data.companyPhone);
    $('#viewCompanyModal [name="companyAddress"]').val(data.companyAddress);
    $('#viewCompanyModal [name="companyCoordinate"]').val(data.companyCoordinate);

    if (data.adminId) {
        $('#viewCompanyModal [name="adminId"]').val(data.adminName + ' | ' + data.adminEmail);
    } else {
        $('#viewCompanyModal [name="adminId"]').val('No Admin');
    }

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
    var data = companiesTable.row($(this).parents('tr')).data();
    if (data.companyLogo) {
        $('#editCompanyForm #imgPreview').attr('src', baseUrl+'uploads/logos/'+data.companyLogo);
    }
    $('#editCompanyForm [name="companyId"]').val(data.companyId);
    $('#editCompanyForm [name="companyName"]').val(data.companyName);
    $('#editCompanyForm [name="companyPhone"]').val(data.companyPhone);
    $('#editCompanyForm [name="companyAddress"]').val(data.companyAddress);

    var adminId = data.adminId;
    if (adminId) {
        var selectedAdmin = '<option value="'+adminId+'">'+data.adminName+' | '+data.adminEmail+'</option>';
    }
    $('#editCompanyForm select#adminId').html(selectedAdmin);
    $('#editCompanyForm select#adminId').select2({
        placeholder: 'Choose Admin',
        allowClear: true,
        dropdownParent: $('#editCompanyModal .modal-body'),
    });

    $.ajax({
        url: baseUrl + 'dashboard/getAllUnconnectedCompanyAdminsDatas',
        method: 'GET',
        success: function(response) {
            var res = JSON.parse(response);

            let optionList = [selectedAdmin];
            $.each(res.data, function(index, data) {
                optionList += '<option value="'+data.adminId+'">'+data.adminName+' | '+data.adminEmail+'</option>';
            });

            $('#editCompanyForm select#adminId').html(optionList);
            $('#editCompanyForm select#adminId').val(adminId).trigger('change');
        }
    });
});

$('#editCompanyForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: baseUrl + 'dashboard/companies/editCompany',
        method: 'POST',
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function(response) {
            var res = JSON.parse(response);
            if (res.status === 'success') {
                $('#editCompanyModal').modal('hide');
                reloadTableData(companiesTable);
                displayAlert('edit success');
            } else if (res.status === 'failed') {
                $('.error-message').remove();
                $('.is-invalid').removeClass('is-invalid');
                displayAlert(res.failedMsg, res.errorMsg ?? null);
            } else if (res.status === 'invalid') {
                displayFormValidation('#editCompanyForm', res.errors);
            }
        }
    });
});

// Delete Company
$('#companiesTable').on('click', '.btn-delete', function() {
    var data = companiesTable.row($(this).parents('tr')).data();
    $('#deleteCompanyForm #companyName').html(data.companyName);
    $('#deleteCompanyForm #companyId').val(data.companyId);
});

$('#deleteCompanyForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: baseUrl + 'dashboard/companies/deleteCompany',
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            var res = JSON.parse(response);
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
            render: function(data, type, row) {
                var statusColor;
                if (data === 'active') {
                    statusColor = 'bg-success';
                } else if (data === 'finished') {
                    statusColor = 'bg-secondary';
                } else if (data === 'stopped') {
                    statusColor = 'bg-danger';
                }
                return `<div class="rounded-circle ${statusColor} d-inline-block" style="width: 12px;height: 12px;"></div>  ` + capitalizeWords(data);
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

// Add Billing
$('#addBillingModal').on('shown.bs.modal', function () {
    $(this).find('select#billingStatus').select2({
        placeholder: 'Choose Status',
        dropdownParent: $('#addBillingModal .modal-body')
    });

    $(this).find('select#companyId').select2({
        ajax: {
            url: baseUrl + 'dashboard/getAllCompaniesDatas',
            type: 'GET',
            dataType: 'json',
            delay: 250,
            processResults: function (response) {
                return {
                    results: $.map(response.data, function (data) {
                        return {
                            id: data.companyId,
                            text: data.companyName + ' | ' + capitalizeWords(data.companyStatus)
                        };
                    })
                };
            },
            cache: true
        },
        minimumInputLength: 0,
        placeholder: 'Choose Company',
        allowClear: true,
        dropdownParent: $('#addBillingModal .modal-body')
    });
})


// Scan QR Details Table
var patientTable;
function getPatientHistoryHealth(patientNIK) {
    if ($.fn.DataTable.isDataTable('#patientTable')) {
        $('#patientTable').DataTable().ajax.url(baseUrl + 'dashboard/getPatientHistoryHealthDetailsByNIK/' + patientNIK).load();
        return;
    }
    patientTable = $('#patientTable').DataTable($.extend(true, {}, DataTableSettings, {
        ajax: baseUrl + 'dashboard/getPatientHistoryHealthDetailsByNIK/' + patientNIK,
        columns: [
            {
                data: null,
                className: 'text-start',
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            {data: 'hospitalName'},
            {data: 'doctorName'},
            {
                data: 'diseaseNames',
                render: function(data, type, row) {
                    return data.split('|').join(', ');
                }
            },
            {
                data: 'historyhealthDate',
                render: function(data, type, row) {
                    return moment(data).format('ddd, D MMMM YYYY HH:mm') + ' WITA';
                }
            },
            {
                data: 'historyhealthBill',
                render: function(data, type, row) {
                    return formatToRupiah(data);
                }
            },
            {
                data: 'historyhealthStatus',
                render: function(data, type, row) {
                    var statusColor;
                    if (data === 'not paid') {
                        statusColor = 'bg-danger';
                    } else if (data === 'paid') {
                        statusColor = 'bg-success';
                    } else if (data === 'free') {
                        statusColor = 'bg-info';
                    }
                    return `<div class="rounded-circle ${statusColor} d-inline-block" style="width: 12px;height: 12px;"></div>  ` + capitalizeWords(data);
                }
            },
            {
                data: null,
                className: 'text-end user-select-none no-export',
                orderable: false,
                defaultContent: `
                    <button 
                        type="button" 
                        class="btn-view btn-primary rounded-2 ms-1 mx-0 px-4 d-inline-block my-1">
                        <i class="fa-regular fa-eye"></i>
                    </button>
                `
            }
        ],
        columnDefs: [
            {width: '80px', target: 7}
        ]
    }));
}

var viewHistoryHealthDetailsModal = new bootstrap.Modal(document.getElementById('viewHistoryHealthDetailsModal'));
$('#patientTable').on('click', '.btn-view', function() {
    viewHistoryHealthDetailsModal.show();
    const backdrops = document.querySelectorAll('.modal-backdrop.show');
    if (backdrops.length >= 2) {
        backdrops[1].style.zIndex = "1055";
    }
    var data = patientTable.row($(this).parents('tr')).data();

    console.log(data);

    $('#viewHistoryHealthDetailsModal [name="historyhealthComplaint"]').val(data.historyhealthComplaint);
    $('#viewHistoryHealthDetailsModal [name="historyhealthDetails"]').val(data.historyhealthDetails);
});