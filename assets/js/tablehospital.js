// CRUD Data Doctors
var doctorsTable = $('#doctorsTable').DataTable($.extend(true, {}, DataTableSettings, {
    ajax: baseUrl + 'hospitals/getHospitalDoctorsDatas', 
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
        {data: 'doctorDateOfBirth'},
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
                    data-bs-target="#editDoctorModal">
                    <i class="fa-regular fa-pen-to-square"></i>
                </button>
                <button 
                    type="button" 
                    class="btn-delete btn-danger rounded-2 ms-1 mx-0 px-4 d-inline-block my-1" 
                    data-bs-toggle="modal" 
                    data-bs-target="#deleteDoctorModal">
                        <i class="fa-solid fa-trash-can"></i>
                </button>
            `
        }
    ],
    columnDefs: [
        {width: '180px', target: 4}
    ]
}));

// Add Data Doctor
$('#addDoctorForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: baseUrl + 'hospitals/doctors/addDoctor',
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            var res = JSON.parse(response);
            if (res.status === 'success') {
                $('#addDoctorModal').modal('hide');
                reloadTableData(adminsTable);
                displayAlert('add success');
            } else if (res.status === 'failed') {
                $('.error-message').remove();
                $('.is-invalid').removeClass('is-invalid');
                displayAlert(res.failedMsg);
            } else if (res.status === 'invalid') {
                displayFormValidation('#addDoctorForm', res.errors);
            }
        }
    });
});

// Edit Data Doctor
$('#doctorsTable').on('click', '.btn-edit', function() {
    var data = doctorsTable.row($(this).parents('tr')).data();
    $('#editDoctorForm [name="doctorEIN"]').val(data.doctorEIN);
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
        url: baseUrl + 'hospitals/doctors/editDoctor',
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
    $('#deleteDoctorForm #doctorEIN').val(data.doctorEIN);
})

$('#deleteDoctorForm').on('submit', function(e) {
    e.preventDefault();
    var doctorEIN = $('#deleteDoctorForm #doctorEIN').val();
    $.ajax({
        url: baseUrl + 'hospitals/doctors/deleteDoctor',
        method: 'POST',
        data: {doctorEIN: doctorEIN},
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
var hHistoriesTable = $('#hHistoriesTable').DataTable($.extend(true, {}, DataTableSettings, {
    ajax: baseUrl + 'hospitals/getHospitalHistoriesDatas', 
    columns: [
        {
            data: null,
            className: 'text-start',
            render: function (data, type, row, meta) {
                return meta.row + 1;
            }
        },
        {data: 'policyholderName'},
        {data: 'companyName'},
        {data: 'historyhealthDate'},
        {data: 'historyhealthStatus'},
        {
            data: null,
            className: 'text-end user-select-none no-export',
            orderable: false,
            defaultContent: `
                <button 
                    type="button" 
                    class="btn-edit btn-warning rounded-2 ms-1 mx-0 px-4 d-inline-block my-1" 
                    data-bs-toggle="modal" 
                    data-bs-target="#editDoctorModal">
                    <i class="fa-regular fa-pen-to-square"></i>
                </button>
                <button 
                    type="button" 
                    class="btn-delete btn-danger rounded-2 ms-1 mx-0 px-4 d-inline-block my-1" 
                    data-bs-toggle="modal" 
                    data-bs-target="#deleteDoctorModal">
                        <i class="fa-solid fa-trash-can"></i>
                </button>
            `
        }
    ],
    columnDefs: [
        {width: '180px', target: 4}
    ]
}));
