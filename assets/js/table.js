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
    $(this).find('select').select2('destroy');
    $(e.target).find('form').trigger('reset');
    $('.error-message').remove();
    $('.is-invalid').removeClass('is-invalid');
    $('.changeEmailInput, .changePasswordInput, #changeCoordinateInput').hide();
});

$('#addAdminButton, #editAdminButton, #deleteAdminButton').on('click', function() {
    reloadTableData(adminsTable);
});

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



// // Hospitals CRUD
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

var hospitalsTables = $('#hospitalsTables').DataTable($.extend(true, {}, DataTableSettings, {
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
        {data: 'hospitalCoordinate'},
        {
            data: null, // Mengambil data koordinat
            className: 'text-end user-select-none no-export',
            orderable: false,
            defaultContent: `
                <button 
                    type="button" 
                    class="btn-view btn-primary rounded-2 ms-1 mx-0 px-4 d-inline-block my-1" 
                    data-bs-toggle="modal" 
                    data-bs-target="#viewMapHospitalModal">
                    <i class="fa-regular fa-eye"></i>
                </button>
            `
        }
    ],
    columnDefs: [
        {width: '240px', target: 4}
    ]
}));

var hospitalMap; // Variabel untuk instance peta
var hospitalMarker; // Variabel untuk marker peta

// Fungsi inisialisasi atau pembaruan peta
function initializeOrUpdateMap(mapContainerId, latitude, longitude, popupContent) {
    if (!hospitalMap) {
        // Inisialisasi peta hanya jika belum ada instance
        hospitalMap = L.map(mapContainerId).setView([latitude, longitude], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(hospitalMap);

        // Tambahkan marker awal
        hospitalMarker = L.marker([latitude, longitude]).addTo(hospitalMap)
            .bindPopup(popupContent).openPopup();
    } else {
        // Perbarui peta dan marker jika instance sudah ada
        hospitalMap.setView([latitude, longitude], 13);
        hospitalMarker.setLatLng([latitude, longitude]).bindPopup(popupContent).openPopup();
    }

    // Pastikan ukuran peta diperbarui saat modal ditampilkan
    hospitalMap.invalidateSize();
}

// Event listener untuk tombol "View"
$('#hospitalsTables').on('click', '.btn-view', function () {
    var rowData = hospitalsTables.row($(this).closest('tr')).data(); // Data baris yang diklik
    var hospitalCoordinate = rowData.hospitalCoordinate; // Koordinat rumah sakit
    var hospitalName = rowData.hospitalName; // Nama rumah sakit

    if (hospitalCoordinate) {
        var coordsArray = hospitalCoordinate.split(','); // Pisahkan koordinat
        var latitude = parseFloat(coordsArray[0].trim());
        var longitude = parseFloat(coordsArray[1].trim());

        if (!isNaN(latitude) && !isNaN(longitude)) {
            // Simpan data ke modal sebelum dibuka
            $('#viewMapHospitalModal').data('latitude', latitude)
                .data('longitude', longitude)
                .data('hospitalName', hospitalName);
            
            // Tampilkan modal
            $('#viewMapHospitalModal').modal('show');
        } else {
            console.error('Koordinat tidak valid: ' + hospitalCoordinate);
        }
    } else {
        console.error('Koordinat tidak ditemukan.');
    }
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
            }
        }
    });
});

// Scan QR Patient For Company
var cPatientTable;
function getCPatientHistoryHealth(patientNIK) {
    if ($.fn.DataTable.isDataTable('#cPatientTable')) {
        $('#cPatientTable').DataTable().ajax.url(baseUrl + 'company/getPatientHistoryHealthDetailsByNIK/' + patientNIK).load();
        return;
    }
    cPatientTable = $('#cPatientTable').DataTable($.extend(true, {}, DataTableSettings, {
        ajax: baseUrl + 'company/getPatientHistoryHealthDetailsByNIK/' + patientNIK,
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
$('#cPatientTable').on('click', '.btn-view', function() {
    viewHistoryHealthDetailsModal.show();
    const backdrops = document.querySelectorAll('.modal-backdrop.show');
    if (backdrops.length >= 2) {
        backdrops[1].style.zIndex = "1055";
    }
    var data = cPatientTable.row($(this).parents('tr')).data();
    console.log(data);
    $('#viewHistoryHealthDetailsModal [name="historyhealthComplaint"]').val(data.historyhealthComplaint);
    $('#viewHistoryHealthDetailsModal [name="historyhealthDetails"]').val(data.historyhealthDetails);
});

// CRUD Data Doctors
var doctorTable = $('#doctorTable').DataTable($.extend(true, {}, DataTableSettings, {
    ajax: baseUrl + 'hospital/getHospitalDoctorDatas', 
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
            className: 'text-end user-select-none no-export',
            orderable: false,
            defaultContent: `
                <button 
                    type="button" 
                    class="btn-edit btn-warning rounded-2 ms-1 mx-0 px-4 d-inline-block my-1" 
                    data-bs-toggle="modal" 
                    data-bs-target="#editDoctorModal" title="Edit Doctor">
                        <i class="fa-regular fa-pen-to-square"></i>
                </button>
                <button 
                    type="button" 
                    class="btn-delete btn-danger rounded-2 ms-1 mx-0 px-4 d-inline-block my-1" 
                    data-bs-toggle="modal" 
                    data-bs-target="#deleteDoctorModal" title="Delete Doctor">
                        <i class="fa-solid fa-trash-can"></i>
                </button>
            `
        }
    ],
    columnDefs: [
        {width: '180px', target: 4}
    ]
}));

$('#addDoctorButton, #editDoctorButton, #deleteDoctorButton').on('click', function() {
    reloadTableData(doctorTable);
});

$('#addDoctorModal').on('hidden.bs.modal', function(e) {
    console.log('addDoctorModal closed and reset');
    $(e.target).find('form').trigger('reset');
});

// Add Data Doctor
$('#addDoctorForm').on('submit', function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        url: baseUrl + 'hospital/doctor/addDoctor',
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            var res = JSON.parse(response);
            res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
            if (res.status === 'success') {
                $('#addDoctorModal').modal('hide');
                reloadTableData(doctorTable);
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
$('#doctorTable').on('click', '.btn-edit', function() {
    var data = doctorTable.row($(this).parents('tr')).data();
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
        url: baseUrl + 'hospital/doctor/editDoctor',
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            var res = JSON.parse(response);
            res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
            if (res.status === 'success') {
                $('#editDoctorModal').modal('hide');
                displayAlert('edit success');
                reloadTableData(doctorTable);
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
$('#doctorTable').on('click', '.btn-delete', function() {
    var data = doctorTable.row($(this).parents('tr')).data();
    $('#deleteDoctorForm #doctorName').html(data.doctorName);
    $('#deleteDoctorForm #doctorId').val(data.doctorId);
})

$('#deleteDoctorForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: baseUrl + 'hospital/doctor/deleteDoctor',
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            var res = JSON.parse(response);
            res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
            if (res.status === 'success') {
                $('#deleteDoctorModal').modal('hide');
                displayAlert('delete success');
                reloadTableData(doctorTable);
            } else if (res.status === 'failed') {
                displayAlert(res.failedMsg);
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
        {
            data: 'doctorName',
            name: 'doctorName',
            render: function (data, type, row) {
                if (row.historyhealthTotalBill == 0 && row.historyhealthDiscount == 0) {
                    return 'Referred';
                } else {
                    return data;
                }
            }
        },
        {
            data: 'historyhealthDate',
            name: 'historyhealthDate',
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
            name: 'historyhealthTotalBill',
            render: function (data) {
                return 'Rp ' + parseFloat(data).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            }
        },
        {
            data: null,
            className: 'text-end user-select-none no-export',
            orderable: false,
            render: function(data, type, row, meta) {
                if (data.historyhealthTotalBill == 0 && data.historyhealthDiscount == 0) {
                    return `
                    <button 
                        type="button" 
                        class="btn-view btn-primary rounded-2 ms-1 mx-0 px-4 d-inline-block my-1" 
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
                            class="btn-view btn-primary rounded-2 ms-1 mx-0 px-4 d-inline-block my-1" 
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
        {width: '180px', target: 4}
    ],
    footerCallback: function (row, data, start, end, display) {
        var api = this.api();
        var columnIndex = api.column('historyhealthTotalBill:name').index();
        var pageTotal = api.column(columnIndex, { page: 'current' }).data().reduce((a, b) => parseFloat(a) + parseFloat(b), 0);
        $(api.column(columnIndex).footer()).html(`Rp ${pageTotal.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`);
    },
    buttons: [...DataTableSettings.buttons.slice(0, 4),
        {
            text: "Year",
            className: "btn btn-primary dropdown-toggle",
            action: function (e, dt, node, config) {
                var columnIndex = dt.column('historyhealthDate:name').index();
                var list = [];
                dt.column(columnIndex).data().unique().each(function (value) {
                    if (value) {
                        var item = moment(value, 'YYYY-MM-DD').format('YYYY');
                        if (!list.includes(item)) list.push(item);
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
                var columnIndex = dt.column('historyhealthDate:name').index();
                var list = [];
                dt.column(columnIndex).data().unique().each(function (value) {
                    if (value) {
                        var item = moment(value, 'YYYY-MM-DD').format('MMMM');
                        if (!list.includes(item)) list.push(item);
                    }
                });
                list.sort();
                createDropdown(node, list, 'month', 'MMMM');
            }
        },
        {
            text: '<i class="fa-solid fa-arrows-rotate fs-5 pt-1 px-0 px-md-1"></i>',
            className: '',
            action: function (e, dt, node, config) {
                dt.ajax.reload(null, false);
            }
        },
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
    var dateColumnIndex = dt.column('historyhealthDate:name').index();
    dt.column(dateColumnIndex).search('');

    dt.column(dateColumnIndex).search((selectedYear && selectedMonth) ? 
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
    $('#detailContent #diseaseName').text(data.diseaseName ? data.diseaseName : 'Referred');
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

// Scan QR Patient For Hospital
var hPatientTable;
function getHPatientHistoryHealth(patientNIK) {
    if ($.fn.DataTable.isDataTable('#hPatientTable')) {
        $('#hPatientTable').DataTable().ajax.url(baseUrl + 'hospital/getPatientHistoryHealthDetailsByNIK/' + patientNIK).load();
        return;
    }
    hPatientTable = $('#hPatientTable').DataTable($.extend(true, {}, DataTableSettings, {
        ajax: baseUrl + 'hospital/getPatientHistoryHealthDetailsByNIK/' + patientNIK,
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

$('#hPatientTable').on('click', '.btn-view', function() {
    viewHistoryHealthDetailsModal.show();
    const backdrops = document.querySelectorAll('.modal-backdrop.show');
    if (backdrops.length >= 2) {
        backdrops[1].style.zIndex = "1055";
    }
    var data = hPatientTable.row($(this).parents('tr')).data();
    console.log(data);
    $('#viewHistoryHealthDetailsModal [name="historyhealthComplaint"]').val(data.historyhealthComplaint);
    $('#viewHistoryHealthDetailsModal [name="historyhealthDetails"]').val(data.historyhealthDetails);
});

// CRUD hospital queue
var hQueueTable = $('#hQueueTable').DataTable($.extend(true, {}, DataTableSettings, {
    ajax: baseUrl + 'hospital/getHospitalQueueDatas', 
    columns: [
        {
            data: null,
            className: 'text-start',
            render: function (data, type, row, meta) {
                return meta.row + 1;
            }
        },
        {
            data: null,
            render: function (data, type, row) {
                return row.familyName ? row.familyName : row.employeeName;
            }
        },
        {
            data: null,
            render: function (data, type, row) {
                return row.familyName ? 'Family' : 'Employee';
            }
        },
        {data: 'companyName'},
        {data: 'createdAt'},
        {
            data: null,
            className: 'text-end user-select-none no-export',
            orderable: false,
            defaultContent: `
                <button 
                    type="button" 
                    class="btn-add btn-primary rounded-2 ms-1 mx-0 px-4 d-inline-block my-1" 
                    data-bs-toggle="modal" 
                    data-bs-target="#addTreatmentModal" title="Process for Treatment">
                        <i class="fa-regular fa-pen-to-square"></i>
                </button>
                <button 
                    type="button" 
                    class="btn-add btn-warning rounded-2 ms-1 mx-0 px-4 d-inline-block my-1" 
                    data-bs-toggle="modal" 
                    data-bs-target="#addReferralModal" title="Assign As Referral">
                        <i class="fa-regular fa-share-from-square"></i>
                </button>
                <button 
                    type="button" 
                    class="btn-delete btn-danger rounded-2 ms-1 mx-0 px-4 d-inline-block my-1" 
                    data-bs-toggle="modal" 
                    data-bs-target="#deleteQueueModal" title="Remove from Queue">
                        <i class="fa-solid fa-trash-can"></i>
                </button>
            `
        }
    ],
    columnDefs: [
        {width: '180px', target: 1}
    ]
}));

$('#addTreatmentButton, #addReferralButton, #deleteQueueButton').on('click', function() {
    reloadTableData(hQueueTable);
});

// Add Data Referral and Data Treatment From Queue
$('#hQueueTable').on('click', '.btn-add', function() {
    var data = hQueueTable.row($(this).parents('tr')).data();
    if ($(this).attr('data-bs-target') === '#addReferralModal') {
        $('#addReferralForm [name="historyhealthDescription"]').val('');
        $('#addReferralForm [name="historyhealthReferredTo"]').val('');
        $('#patientName').text(data.familyName ? data.familyName : data.employeeName);
        $('#patientRole').text(data.familyName ? 'Family' : 'Employee');
        $('#employeeName').text(data.employeeName);
        $('#companyName').text(data.companyName);
    } else if ($(this).attr('data-bs-target') === '#addTreatmentModal') {
        $('#addTreatmentForm [name="treatmentType"]').val('');
        $('#addTreatmentForm [name="treatmentDescription"]').val('');
        $('#treatmentPatientName').text(data.familyName ? data.familyName : data.employeeName);
        $('#treatmentPatientRole').text(data.familyName ? 'Family' : 'Employee');
        $('#treatmentEmployeeName').text(data.employeeName);
        $('#treatmentCompanyName').text(data.companyName);
    }
});


$('#addReferralForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: baseUrl + 'hospital/history/addReferral',
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            var res = JSON.parse(response);
            if (res.status === 'success') {
                $('#addReferralModal').modal('hide');
                reloadTableData(hQueueTable);
                displayAlert('add success');
            } else if (res.status === 'failed') {
                $('.error-message').remove();
                $('.is-invalid').removeClass('is-invalid');
                displayAlert(res.failedMsg);
            } else if (res.status === 'invalid') {
                displayFormValidation('#addReferralForm', res.errors);
            }
        }
    });
});

// Delete Data Queue
$('#hQueueTable').on('click', '.btn-delete', function() {
    var data = hQueueTable.row($(this).parents('tr')).data();
    $('#deleteQueueForm #patientName').html(data.familyName ? data.familyName : data.employeeName);
    $('#deleteQueueForm #patientNIK').val(data.patientNIK);
    $('#deleteQueueForm #hospitalId').val(data.hospitalId);
})

$('#deleteQueueForm').on('submit', function(e) {
    e.preventDefault();
    var patientNIK = $('#deleteQueueForm #patientNIK').val();
    var hospitalId = $('#deleteQueueForm #hospitalId').val();
    $.ajax({
        url: baseUrl + '/queue/deleteQueue',
        method: 'POST',
        data: {patientNIK: patientNIK, hospitalId: hospitalId},
        success: function(response) {
            var res = JSON.parse(response);
            if (res.status === 'success') {
                $('#deleteQueueModal').modal('hide');
                reloadTableData(hQueueTable);
                displayAlert('delete success');
            }
        }
    });
});

// hospital disease
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
    ajax: baseUrl + 'company/Employee/getAllEmployeesDatas', // base URL diubah
    columns: [
        {
            data: null,
            className: 'text-start',
            render: function (data, type, row, meta) {
                return meta.row + 1;
            }
        },
        {data: 'employeeNIK'},
        {data: 'employeeName'},
        {data: 'employeeEmail'},
        {data: 'employeeAddress'},
        {data: 'employeePhone'},
        {data: 'employeeBirth'},
        {data: 'employeeGender'},
        {
            data: null,
            className: 'text-end user-select-none no-export',
            orderable: false,
            defaultContent: `
                <button 
                    type="button" 
                    class="btn-view btn-primary rounded-2 ms-1 mx-0 px-4 d-inline-block my-1" 
                    onclick="viewEmployeeInNewTab(this)">
                    <i class="fa-regular fa-eye"></i>
                </button>
                <button 
                    type="button" 
                    class="btn-edit btn-warning rounded-2 ms-1 mx-0 px-4 d-inline-block my-1" 
                    data-bs-toggle="modal" 
                    data-bs-target="#editEmployeeModal">
                    <i class="fa-regular fa-pen-to-square"></i>
                </button>
                <button 
                    type="button" 
                    class="btn-delete btn-danger rounded-2 ms-1 mx-0 px-4 d-inline-block my-1" 
                    data-bs-toggle="modal" 
                    data-bs-target="#deleteEmployeeModal">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            `
        }
    ],
    columnDefs: [
        {width: '240px', target: 8}
    ]
}));

function viewEmployeeInNewTab(button) {
    // Dapatkan data baris dari tombol yang diklik
    var rowData = employeesTable.row($(button).closest('tr')).data();
    var employeeNIK = rowData.employeeNIK;

    // Simpan policyholderNIK ke dalam session melalui AJAX
    $.post(baseUrl + 'company/Family/saveemployeeNIK', { employeeNIK: employeeNIK }, function(response) {
        if (response.success) {
            // Buka halaman baru untuk melihat data keluarga
            window.open(baseUrl + 'company/Family', '_blank');
        } else {
            alert("Gagal menyimpan Employee NIK.");
        }
    }, 'json');
}

$('#addEmployeeModal').on('shown.bs.modal', function() {
    // Tambahkan kode jika memerlukan dropdown atau elemen interaktif lainnya
});

$('#addEmployeeButton, #editEmployeeButton, #deleteEmployeeButton').on('click', function() {
    reloadTableData(employeesTable);
});

// Add Data Employee
$('#addEmployeeForm').on('submit', function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        url: baseUrl + 'company/Employee/addEmployee',
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            var res = JSON.parse(response);
            if (res.status === 'success') {
                $('#addEmployeeModal').modal('hide');
                reloadTableData(employeesTable);
                displayAlert('add success');
            } else if (res.status === 'failed') {
                $('.error-message').remove();
                $('.is-invalid').removeClass('is-invalid');
                displayAlert(res.failedMsg, res.errorMsg ?? null);
            } else if (res.status === 'invalid') {
                displayFormValidation('#addEmployeeForm', res.errors);
            }
        }
    });
});

$('#addEmployeeModal').on('shown.bs.modal', function() {
    $(this).find('select#employeeGender').select2({
        placeholder: 'Choose Gender',
        dropdownParent: $('#addEmployeeModal .modal-body')
    });
    $(this).find('select#insuranceId').select2({
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
                            text: data.insuranceTier + ' | ' + data.insuranceAmount
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

// Edit Data Employee
$('#employeesTable').on('click', '.btn-edit', function() {
    var data = employeesTable.row($(this).parents('tr')).data();
    if (data.employeePhoto) {
        $('#editEmployeeForm #imgPreview').attr('src', baseUrl+'uploads/logos/'+data.employeePhoto);
    }
    $('#editEmployeeForm [name="employeeNIK"]').val(data.employeeNIK);
    $('#editEmployeeForm [name="employeeName"]').val(data.employeeName);
    $('#editEmployeeForm [name="employeeEmail"]').val(data.employeeEmail);
    $('#editEmployeeForm [name="employeePhone"]').val(data.employeePhone);
    $('#editEmployeeForm [name="employeePassword"]').val(data.employeePassword);
    $('#editEmployeeForm [name="employeeAddress"]').val(data.employeeAddress);
    $('#editEmployeeForm [name="employeeBirth"]').val(data.employeeBirth);
    $('#editEmployeeForm [name="employeeGender"]').val(data.employeeGender);
    $('#editEmployeeForm [name="employeeStatus"]').val(data.employeeStatus);
    var insuranceId = data.insuranceId;
    if (insuranceId) {
        var selectedInsurance = '<option value="'+insuranceId+'">'+data.insuranceTier+' | '+data.insuranceAmount+'</option>';
    }
    $('#editEmployeeForm select#insuranceId').html(selectedInsurance);
    $('#editEmployeeForm select#insuranceId').select2({
        placeholder: 'Choose Insurance',
        allowClear: true,
        dropdownParent: $('#editEmployeeModal .modal-body'),
    });

    $.ajax({
        url: baseUrl + 'company/Insurance/getAllInsuranceByCompanyId',
        method: 'GET',
        success: function(response) {
            var res = JSON.parse(response);

            let optionList = [selectedInsurance];
            $.each(res.data, function(index, data) {
                optionList += '<option value="'+data.insuranceId+'">'+data.insuranceTier+' | '+data.insuranceAmount+'</option>';
            });

            $('#editEmployeeForm select#insuranceId').html(optionList);
            $('#editEmployeeForm select#insuranceId').val(insuranceId).trigger('change');
        }
    });
});

$('#editEmployeeForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: baseUrl + 'company/Employee/editEmployee', // base URL diubah
        method: 'POST',
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function(response) {
            var res = JSON.parse(response);
            if (res.status === 'success') {
                $('#editEmployeeModal').modal('hide');
                reloadTableData(employeesTable);
                displayAlert('edit success');
            } else if (res.status === 'failed') {
                $('.error-message').remove();
                $('.is-invalid').removeClass('is-invalid');
                displayAlert(res.failedMsg, res.errorMsg ?? null);
            } else if (res.status === 'invalid') {
                displayFormValidation('#editEmployeeForm', res.errors);
            }
        }
    });
});

// Delete Employee
$('#employeesTable').on('click', '.btn-delete', function() {
    var data = employeesTable.row($(this).parents('tr')).data();
    $('#deleteEmployeeForm #employeeName').html(data.employeeName);
    $('#deleteEmployeeForm #employeeNIK').val(data.employeeNIK);
});

$('#deleteEmployeeForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: baseUrl + 'company/Employee/deleteEmployee', // base URL diubah
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            var res = JSON.parse(response);
            if (res.status === 'success') {
                $('#deleteEmployeeModal').modal('hide');
                reloadTableData(employeesTable);
                displayAlert('delete success');
            }
        }
    });
});

var insurancesTable = $('#insurancesTable').DataTable($.extend(true, {}, DataTableSettings, {
    ajax: baseUrl + 'company/Insurance/getAllInsuranceByCompanyId',
    columns: [
        {
            data: null,
            className: 'text-start',
            render: function (data, type, row, meta) {
                return meta.row + 1;
            }
        },
        {
            data: 'insuranceTier',
            className: 'text-start'
        },
        {
            data: 'insuranceAmount',
            className: 'text-end'
        },
        {
            data: 'insuranceDescription',
            className: 'text-start'
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
                    data-bs-target="#editInsuranceModal">
                    <i class="fa-regular fa-pen-to-square"></i>
                </button>
                <button 
                    type="button" 
                    class="btn-delete btn-danger rounded-2 ms-1 mx-0 px-4 d-inline-block my-1" 
                    data-bs-toggle="modal" 
                    data-bs-target="#deleteInsuranceModal">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            `
        }
    ]
}));

$('#addInsuranceModal').on('shown.bs.modal', function() {
});

$('#addInsuranceButton, #editInsuranceButton, #deleteInsuranceButton').on('click', function() {
    reloadTableData(insurancesTable);
});

// Add Data Company
$('#addInsuranceForm').on('submit', function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        url: baseUrl + 'company/insurance/addInsurance',
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            var res = JSON.parse(response);
            if (res.status === 'success') {
                $('#addInsuranceModal').modal('hide');
                reloadTableData(companiesTable);
                displayAlert('add success');
            } else if (res.status === 'failed') {
                $('.error-message').remove();
                $('.is-invalid').removeClass('is-invalid');
                displayAlert(res.failedMsg, res.errorMsg ?? null);
            } else if (res.status === 'invalid') {
                displayFormValidation('#addInsuranceForm', res.errors);
            }
        }
    });
});


var allfamiliesTable = $('#allfamiliesTable').DataTable($.extend(true, {}, DataTableSettings, {
    ajax: {
        url: baseUrl + 'company/Family/getAllFamilyDatas',
        dataSrc: 'data', 
        error: function (xhr, error, thrown) {
            console.error("AJAX Error:", error);
            console.error("XHR:", xhr);
            alert("Error loading data: " + thrown);
        }
    },
    columns: [
        {
            data: null,
            className: 'text-start',
            render: function (data, type, row, meta) {
                return meta.row + 1;
            }
        },
        {data: 'familyNIK'},
        {data: 'familyName'},
        {data: 'familyEmail'},
        {data: 'familyAddress'},
        {data: 'familyBirth'},
        {data: 'familyGender'},
        {data: 'familyRole'},
        {data: 'familyStatus'},
        {
            data: null,
            className: 'text-end user-select-none no-export',
            orderable: false,
            defaultContent: `
                <button 
                    type="button" 
                    class="btn-edit btn-warning rounded-2 ms-1 mx-0 px-4 d-inline-block my-1" 
                    data-bs-toggle="modal" 
                    data-bs-target="#editFamilyModal2">
                    <i class="fa-regular fa-pen-to-square"></i>
                </button>
                <button 
                    type="button" 
                    class="btn-delete btn-danger rounded-2 ms-1 mx-0 px-4 d-inline-block my-1" 
                    data-bs-toggle="modal" 
                    data-bs-target="#deleteFamilyModal2">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            `
        }
    ],
    columnDefs: [
        {width: '240px', target: 9}
    ]
}));

$('#addFamilyModal2').on('shown.bs.modal', function() {
    // Tambahkan kode jika memerlukan dropdown atau elemen interaktif lainnya
});

$('#addFamilyButton2, #editFamilyButton2, #deleteFamilyButton2').on('click', function() {
    reloadTableData(allfamiliesTable);
});

// Add Data Family
$('#addFamilyForm2').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: baseUrl + 'company/Family/addFamily', // URL untuk menambahkan data
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            var res = JSON.parse(response);
            if (res.status === 'success') {
                $('#addFamilyModal2').modal('hide');
                reloadTableData(allfamiliesTable);
                displayAlert('add success');
            } else if (res.status === 'failed') {
                $('.error-message').remove();
                $('.is-invalid').removeClass('is-invalid');
                displayAlert(res.failedMsg, res.errorMsg ?? null);
            } else if (res.status === 'invalid') {
                displayFormValidation('#addFamilyForm2', res.errors);
            }
        }
    });
});

// Edit Data Family
$('#allfamiliesTable').on('click', '.btn-edit', function() {
    var data = allfamiliesTable.row($(this).parents('tr')).data();
    $('#editFamilyForm2 [name="familyNIK"]').val(data.familyNIK);
    $('#editFamilyForm2 [name="employeeNIK"]').val(data.employeeNIK);
    $('#editFamilyForm2 [name="familyName"]').val(data.familyName);
    $('#editFamilyForm2 [name="familyEmail"]').val(data.familyEmail);
    $('#editFamilyForm2 [name="familyAddress"]').val(data.familyAddress);
    $('#editFamilyForm2 [name="familyBirth"]').val(data.familyBirth);
    $('#editFamilyForm2 [name="familyGender"]').val(data.familyGender);
    $('#editFamilyForm2 [name="familyRole"]').val(data.familyRole);
    $('#editFamilyForm2 [name="familyStatus"]').val(data.familyStatus);
});

$('#editFamilyForm2').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: baseUrl + 'company/Family/editFamily', // URL untuk mengedit data
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            var res = JSON.parse(response);
            if (res.status === 'success') {
                $('#editFamilyModal2').modal('hide');
                reloadTableData(allfamiliesTable);
                displayAlert('edit success');
            } else if (res.status === 'failed') {
                $('.error-message').remove();
                $('.is-invalid').removeClass('is-invalid');
                displayAlert(res.failedMsg, res.errorMsg ?? null);
            } else if (res.status === 'invalid') {
                displayFormValidation('#editFamilyForm2', res.errors);
            }
        }
    });
});

// Delete Family
$('#allfamiliesTable').on('click', '.btn-delete', function() {
    var data = allfamiliesTable.row($(this).parents('tr')).data();
    $('#deleteFamilyForm2 #familyName').html(data.familyName);
    $('#deleteFamilyForm2 #familyNIK').val(data.familyNIK);
});

$('#deleteFamilyForm2').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: baseUrl + 'company/Family/deleteFamily', // URL untuk menghapus data
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            var res = JSON.parse(response);
            if (res.status === 'success') {
                $('#deleteFamilyModal2').modal('hide');
                reloadTableData(allfamiliesTable);
                displayAlert('delete success');
            }
        }
    });
});

var familiesTable = $('#familiesTable').DataTable($.extend(true, {}, DataTableSettings, {
    ajax: {
        url: baseUrl + 'company/Family/getFamiliesByemployeeNIK',
        dataSrc: 'data', 
        error: function (xhr, error, thrown) {
            console.error("AJAX Error:", error);
            console.error("XHR:", xhr);
            alert("Error loading data: " + thrown);
        }
    },
    columns: [
        {
            data: null,
            className: 'text-start',
            render: function (data, type, row, meta) {
                return meta.row + 1;
            }
        },
        {data: 'familyNIK'},
        {data: 'familyName'},
        {data: 'familyEmail'},
        {data: 'familyAddress'},
        {data: 'familyBirth'},
        {data: 'familyGender'},
        {data: 'familyRole'},
        {data: 'familyStatus'},
        {
            data: null,
            className: 'text-end user-select-none no-export',
            orderable: false,
            defaultContent: `
                <button 
                    type="button" 
                    class="btn-edit btn-warning rounded-2 ms-1 mx-0 px-4 d-inline-block my-1" 
                    data-bs-toggle="modal" 
                    data-bs-target="#editFamilyModal">
                    <i class="fa-regular fa-pen-to-square"></i>
                </button>
                <button 
                    type="button" 
                    class="btn-delete btn-danger rounded-2 ms-1 mx-0 px-4 d-inline-block my-1" 
                    data-bs-toggle="modal" 
                    data-bs-target="#deleteFamilyModal">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            `
        }
    ],
    columnDefs: [
        {width: '240px', target: 9}
    ]
}));

$('#addFamilyModal').on('shown.bs.modal', function() {
    // Tambahkan kode jika memerlukan dropdown atau elemen interaktif lainnya
});

$('#addFamilyButton, #editFamilyButton, #deleteFamilyButton').on('click', function() {
    reloadTableData(familiesTable);
});

// Add Data Family
$('#addFamilyForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: baseUrl + 'company/Family/addFamily', // URL untuk menambahkan data
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            var res = JSON.parse(response);
            if (res.status === 'success') {
                $('#addFamilyModal').modal('hide');
                reloadTableData(familiesTable);
                displayAlert('add success');
            } else if (res.status === 'failed') {
                $('.error-message').remove();
                $('.is-invalid').removeClass('is-invalid');
                displayAlert(res.failedMsg, res.errorMsg ?? null);
            } else if (res.status === 'invalid') {
                displayFormValidation('#addFamilyForm', res.errors);
            }
        }
    });
});

// Edit Data Family
$('#familiesTable').on('click', '.btn-edit', function() {
    var data = familiesTable.row($(this).parents('tr')).data();
    $('#editFamilyForm [name="familyNIK"]').val(data.familyNIK);
    $('#editFamilyForm [name="employeeNIK"]').val(data.employeeNIK);
    $('#editFamilyForm [name="familyName"]').val(data.familyName);
    $('#editFamilyForm [name="familyEmail"]').val(data.familyEmail);
    $('#editFamilyForm [name="familyAddress"]').val(data.familyAddress);
    $('#editFamilyForm [name="familyBirth"]').val(data.familyBirth);
    $('#editFamilyForm [name="familyGender"]').val(data.familyGender);
    $('#editFamilyForm [name="familyRole"]').val(data.familyRole);
    $('#editFamilyForm [name="familyStatus"]').val(data.familyStatus);
});

$('#editFamilyForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: baseUrl + 'company/Family/editFamily', // URL untuk mengedit data
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            var res = JSON.parse(response);
            if (res.status === 'success') {
                $('#editFamilyModal').modal('hide');
                reloadTableData(familiesTable);
                displayAlert('edit success');
            } else if (res.status === 'failed') {
                $('.error-message').remove();
                $('.is-invalid').removeClass('is-invalid');
                displayAlert(res.failedMsg, res.errorMsg ?? null);
            } else if (res.status === 'invalid') {
                displayFormValidation('#editFamilyForm', res.errors);
            }
        }
    });
});

// Delete Family
$('#familiesTable').on('click', '.btn-delete', function() {
    var data = familiesTable.row($(this).parents('tr')).data();
    $('#deleteFamilyForm #familyName').html(data.familyName);
    $('#deleteFamilyForm #familyNIK').val(data.familyNIK);
});

$('#deleteFamilyForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: baseUrl + 'company/Family/deleteFamily', // URL untuk menghapus data
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            var res = JSON.parse(response);
            if (res.status === 'success') {
                $('#deleteFamilyModal').modal('hide');
                reloadTableData(familiesTable);
                displayAlert('delete success');
            }
        }
    });
});


//Maps
