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

$('#hospitalsTables').on('click', '.btn-view', function () {
    var rowData = hospitalsTables.row($(this).closest('tr')).data();
    var hospitalCoordinate = rowData.hospitalCoordinate; // Mendapatkan koordinat
    var hospitalName = rowData.hospitalName; // Mendapatkan nama rumah sakit

    if (hospitalCoordinate) {
        var coordsArray = hospitalCoordinate.split(',');
        var latitude = parseFloat(coordsArray[0].trim());
        var longitude = parseFloat(coordsArray[1].trim());

        if (!isNaN(latitude) && !isNaN(longitude)) {
            // Peta di dalam modal
            var map = L.map('hospitalMap').setView([latitude, longitude], 13); // Inisialisasi peta
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Tambahkan marker
            var marker = L.marker([latitude, longitude]).addTo(map)
                .bindPopup('Hospital: ' + hospitalName)
                .openPopup();
        } else {
            console.error('Koordinat tidak valid: ' + hospitalCoordinate);
        }
    } else {
        console.error('Koordinat tidak ditemukan.');
    }
});

// Menampilkan peta ketika modal dibuka
$('#viewMapHospitalModal').on('shown.bs.modal', function () {
    // Ambil data dari tabel yang terkait dengan tombol yang diklik
    var rowData = hospitalsTables.row($(this).closest('tr')).data();  // Ambil data baris yang sedang dipilih
    var hospitalCoordinate = rowData.hospitalCoordinate;  // Koordinat rumah sakit
    var hospitalName = rowData.hospitalName;  // Nama rumah sakit

    // Periksa apakah koordinat ada
    if (hospitalCoordinate) {
        var coordsArray = hospitalCoordinate.split(',');  // Pisahkan koordinat
        var latitude = parseFloat(coordsArray[0].trim());  // Latitude
        var longitude = parseFloat(coordsArray[1].trim());  // Longitude

        if (!isNaN(latitude) && !isNaN(longitude)) {
            // Inisialisasi peta dengan koordinat
            var map = L.map('hospitalMap').setView([latitude, longitude], 13);  // Set posisi peta dan zoom level
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Tambahkan marker pada peta
            var marker = L.marker([latitude, longitude]).addTo(map)
                .bindPopup('Hospital: ' + hospitalName)  // Tampilkan nama rumah sakit di popup
                .openPopup();

            // Perbarui ukuran peta setelah modal ditampilkan
            map.invalidateSize();
        } else {
            console.error('Koordinat tidak valid: ' + hospitalCoordinate);
        }
    } else {
        console.error('Koordinat tidak ditemukan.');
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
                displayAlert('delete success');
            }
        }
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
                displayAlert('delete success');
            }
        }
    });
});

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
        {data: 'policyholderNIN'},
        {data: 'policyholderName'},
        {data: 'policyholderEmail'},
        {data: 'policyholderAddress'},
        {data: 'policyholderBirth'},
        {data: 'policyholderGender'},
        {data: 'policyholderStatus'},
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
    var policyholderNIN = rowData.policyholderNIN;

    // Simpan policyholderNIN ke dalam session melalui AJAX
    $.post(baseUrl + 'company/Family/savePolicyholderNIN', { policyholderNIN: policyholderNIN }, function(response) {
        if (response.success) {
            // Buka halaman baru untuk melihat data keluarga
            window.open(baseUrl + 'company/Family', '_blank');
        } else {
            alert("Gagal menyimpan Policyholder NIN.");
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
    $.ajax({
        url: baseUrl + 'company/Employee/addEmployee', // base URL diubah
        method: 'POST',
        data: $(this).serialize(),
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

// Edit Data Employee
$('#employeesTable').on('click', '.btn-edit', function() {
    var data = employeesTable.row($(this).parents('tr')).data();
    $('#editEmployeeForm [name="policyholderNIN"]').val(data.policyholderNIN);
    $('#editEmployeeForm [name="policyholderName"]').val(data.policyholderName);
    $('#editEmployeeForm [name="policyholderEmail"]').val(data.policyholderEmail);
    $('#editEmployeeForm [name="policyholderPassword"]').val(data.policyholderEmail);
    $('#editEmployeeForm [name="policyholderAddress"]').val(data.policyholderAddress);
    $('#editEmployeeForm [name="policyholderBirth"]').val(data.policyholderBirth);
    $('#editEmployeeForm [name="policyholderGender"]').val(data.policyholderGender);
    $('#editEmployeeForm [name="policyholderStatus"]').val(data.policyholderStatus);
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
    $('#deleteEmployeeForm #employeeName').html(data.policyholderName);
    $('#deleteEmployeeForm #policyholderNIN').val(data.policyholderNIN);
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
        {data: 'familyNIN'},
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
    $('#editFamilyForm2 [name="familyNIN"]').val(data.familyNIN);
    $('#editFamilyForm2 [name="policyholderNIN"]').val(data.policyholderNIN);
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
    $('#deleteFamilyForm2 #familyNIN').val(data.familyNIN);
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
        url: baseUrl + 'company/Family/getFamiliesByPolicyholderNIN',
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
        {data: 'familyNIN'},
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
    $('#editFamilyForm [name="familyNIN"]').val(data.familyNIN);
    $('#editFamilyForm [name="policyholderNIN"]').val(data.policyholderNIN);
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
    $('#deleteFamilyForm #familyNIN').val(data.familyNIN);
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
