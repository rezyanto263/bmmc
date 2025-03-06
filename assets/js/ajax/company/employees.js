// Employees CRUD
var employeesTable = $('#employeesTable').DataTable($.extend(true, {}, DataTableSettings, {
    ajax: baseUrl + 'company/getAllEmployeesByCompanyId',
    columns: [
        {
            data: 'employeeNIK',
            className: 'text-start'
        },
        {data: 'employeeName'},
        {
            data: 'employeeStatus',
            render: function(data, type) {
                if (type === 'display' || type === 'filter') {
                    return generateStatusData([data]).find((d) => d.id == data).text;
                }
                return data;
            }
        },
        {
            data: 'employeeGender',
            render: function(data) {
                return capitalizeWords(data);
            }
        },
        {data: 'employeeDepartment'},
        {data: 'employeeBand'},
        {data: 'employeeEmail'},
        {data: 'employeePhone'},
        {
            data: 'employeeBirth',
            render: function(data, type) {
                if (type === 'display' || type === 'filter') {
                    return moment(data).format('D MMMM YYYY')
                }
                return data;
            }
        },
        {
            data: 'employeeAddress',
            className: 'text-wrap',
            render: function(data, type) {
                if (type === 'display' || type === 'filter') {
                    return `<div class="text-2-row" style="width: 250px;">${data}</div>`;
                }
                return data;
            }
        },
        {
            data: 'createdAt',
            className: 'text-start',
            render: function(data, type) {
                if (type === 'display' || type === 'filter') {
                    return moment(data).format('ddd, D MMMM YYYY HH:mm') + ' WITA';
                }
                return data;
            }
        },
        {
            data: 'updatedAt',
            className: 'text-start',
            render: function(data, type) {
                if (type === 'display' || type === 'filter') {
                    return moment(data).format('ddd, D MMMM YYYY HH:mm') + ' WITA';
                }
                return data;
            }
        },
        {
            data: null,
            className: 'text-end user-select-none no-export no-visibility',
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
        {width: '180px', target: 12}
    ]
}));

$('#addEmployeeButton, #editEmployeeButton, #deleteEmployeeButton').on('click', function() {
reloadTableData(employeesTable);
});



// Add Data Employee
$('#addEmployeeForm').on('submit', function(e) {
    e.preventDefault();
    removeCleaveFormat();
    $.ajax({
        url: baseUrl + 'company/Employees/addEmployee',
        method: 'POST',
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function(response) {
            console.log(response);
            var res = JSON.parse(response);
            res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
            if (res.status === 'success') {
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
        }
    });
});

$('#addEmployeeModal').on('show.bs.modal', function() {
    $('#addEmployeeForm #employeeStatus').html(generateStatusData(['unverified']).find((d) => d.id === 'unverified').text);

    $(this).find('#addEmployeeForm [name="employeeGender"]').select2({
        placeholder: 'Choose Gender',
        dropdownParent: $('#addEmployeeModal .modal-body')
    });

    $(this).find('#addEmployeeForm [name="employeeDepartment"]').select2({
        tags: true,
        ajax: {
            url: baseUrl + 'company/getAllDepartmentByCompanyId',
            type: 'GET',
            dataType: 'json',
            delay: 250,
            processResults: function (response, params) {
                const searchTerm = params.term ? params.term.toLowerCase() : '';
                return {
                    results: response.data 
                        .filter(data => data.departmentName.toLowerCase().includes(searchTerm))
                        .map(function (data) {
                        return {
                            id: data.departmentName,
                            text: data.departmentName
                        };
                    })
                };
            },
            cache: true
        },
        minimumInputLength: 0,
        placeholder: 'Choose or Create Department',
        dropdownParent: $('#addEmployeeModal .modal-body')
    });

    $(this).find('#addEmployeeForm [name="employeeBand"]').select2({
        tags: true,
        ajax: {
            url: baseUrl + 'company/getAllBandByCompanyId',
            type: 'GET',
            dataType: 'json',
            delay: 250,
            processResults: function (response, params) {
                const searchTerm = params.term ? params.term.toLowerCase() : '';
                return {
                    results: response.data 
                        .filter(data => data.bandName.toLowerCase().includes(searchTerm))
                        .map(function (data) {
                        return {
                            id: data.bandName,
                            text: data.bandName
                        };
                    })
                };
            },
            cache: true
        },
        minimumInputLength: 0,
        placeholder: 'Choose or Create Band',
        dropdownParent: $('#addEmployeeModal .modal-body')
    });

    $(this).find('#addEmployeeForm [name="insuranceId"]').select2({
        ajax: {
            url: baseUrl + 'company/getAllInsuranceByCompanyId',
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
                            text: data.insuranceTier + ' | ' + formatToRupiah(data.insuranceAmount, true, false)
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
    $('#viewEmployeeModal #employeeDepartment').html(data.employeeDepartment);
    $('#viewEmployeeModal #employeeBand').html(data.employeeBand);
    $('#viewEmployeeModal #employeePhone').html(data.employeePhone);
    $('#viewEmployeeModal #insuranceTier').html(capitalizeWords(data.insuranceTier));
    $('#viewEmployeeModal #totalBillingAmount').html(formatToRupiah(data.insuranceAmount, false, false));
    $('#viewEmployeeModal #createdAt').html(moment(data.createdAt).format('ddd, D MMMM YYYY HH:mm') + ' WITA');
    $('#viewEmployeeModal #updatedAt').html(moment(data.updatedAt).format('ddd, D MMMM YYYY HH:mm') + ' WITA');

    $.ajax({
        url: baseUrl + 'company/getInsuranceDetailsByEmployeeNIK?nik=' + data.employeeNIK,
        method: 'GET',
        success: function(response) {
            var res = JSON.parse(response).data;
            let billingRemaining = data.insuranceAmount - res.totalBillingUsedThisMonth;
            $('#viewEmployeeModal #totalBillingUsed').html(formatToRupiah(res.totalBillingUsedThisMonth, false, false));
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
                data: 'familyNIK',
                className: 'text-start'
            },
            {data: 'familyName'},
            {
                data: 'familyStatus',
                render: function(data, type) {
                    if (type === 'display' || type === 'filter') {
                        return generateStatusData([data]).find((d) => d.id == data).text;
                    }
                    return data;
                }
            },
            {
                data: 'familyGender',
                render: function(data) {
                    return capitalizeWords(data);
                }
            },
            {data: 'familyEmail'},
            {data: 'familyPhone'},
            {
                data: 'familyBirth',
                render: function(data, type) {
                    if (type === 'display' || type === 'filter') {
                        return moment(data).format('D MMMM YYYY')
                    }
                    return data;
                }
            },
            {data: 'familyAddress'},
            {
                data: null,
                className: 'text-end user-select-none no-export no-visibility text-center',
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
            {width: '80px', target: 8}
        ],
        buttons: [
            ...DataTableSettings.buttons
            .filter(button => button.className !== 'reload')
            .map((button) => {
                if (button.extend === 'colvis') {
                    return $.extend(true, {}, button, {
                        collectionLayout: "fixed two-column",
                    });
                }
            }),
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

    $('#editEmployeeForm [name="employeeDepartment"]').val(data.employeeDepartment).select2({
        tags: true,
        ajax: {
            url: baseUrl + 'company/getAllDepartmentByCompanyId',
            type: 'GET',
            dataType: 'json',
            delay: 250,
            processResults: function (response, params) {
                const searchTerm = params.term ? params.term.toLowerCase() : '';
                return {
                    results: response.data 
                        .filter(data => data.departmentName.toLowerCase().includes(searchTerm))
                        .map(function (data) {
                        return {
                            id: data.departmentName,
                            text: data.departmentName
                        };
                    })
                };
            },
            cache: true
        },
        minimumInputLength: 0,
        placeholder: 'Choose or Create Department',
        dropdownParent: $('#editEmployeeModal .modal-body')
    });
    $('#editEmployeeForm [name="employeeDepartment"]').append(
        new Option(data.employeeDepartment, data.employeeDepartment, true, true)
    ).trigger('change');

    $('#editEmployeeForm [name="employeeBand"]').select2({
        tags: true,
        ajax: {
            url: baseUrl + 'company/getAllBandByCompanyId',
            type: 'GET',
            dataType: 'json',
            delay: 250,
            processResults: function (response, params) {
                const searchTerm = params.term ? params.term.toLowerCase() : '';
                return {
                    results: response.data 
                        .filter(data => data.bandName.toLowerCase().includes(searchTerm))
                        .map(function (data) {
                        return {
                            id: data.bandName,
                            text: data.bandName
                        };
                    })
                };
            },
            cache: true
        },
        minimumInputLength: 0,
        placeholder: 'Choose or Create Band',
        dropdownParent: $('#editEmployeeModal .modal-body')
    });
    $('#editEmployeeForm [name="employeeBand"]').append(
        new Option(data.employeeBand, data.employeeBand, true, true)
    ).trigger('change');

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
                                text: `${d.insuranceTier} | ${formatToRupiah(d.insuranceAmount, true, false)}`,
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
            reloadTableData(employeesTable);
            displayAlert('delete success');
        }
    }
});
});