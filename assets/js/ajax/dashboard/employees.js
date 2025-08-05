// Employees CRUD
var employeesTable = $('#employeesTable').DataTable($.extend(true, {}, DataTableSettings, {
    ajax: baseUrl + 'dashboard/getAllEmployees',
    columns: [
        {
            data: "companyLogo",
            className: "align-middle user-select-none no-export",
            orderable: false,
            render: function (data, type, row) {
                let logo = data
                    ? `${baseUrl}uploads/logos/${data}`
                    : `${baseUrl}assets/images/company-placeholder.jpg`;
                return `
                    <img class="object-fit-contain border border-secondary-subtle rounded" src="${logo}" style="width: 45px; height: 45px; object-position: center">
                `;
            },
        },
        {
            data: "companyName",
            className: "align-middle text-nowrap",
        },
        {
            data: 'employeeNIK',
            className: 'text-start'
        },
        {data: 'employeeName'},
        {
            data: 'employeehistoryStatus',
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
        {data: 'employeehistoryDepartment'},
        {data: 'employeehistoryBand'},
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
        url: baseUrl + 'dashboard/Employees/addEmployee',
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

    var NIKTimer;
    $('#addEmployeeForm #NIKAvailability').removeClass('text-success text-danger').hide();
    $('#addEmployeeForm #NIKAvailability i').removeClass('la-check-circle la-times-circle');
    $('#addEmployeeForm [name="employeeNIK"]').on('input', function() {
        let value = $(this).val();
        $('#addEmployeeForm #NIKAvailability').removeClass('text-success text-danger').hide();
        $('#addEmployeeForm #NIKAvailability i').removeClass('la-check-circle la-times-circle');
        if (value.length == 16) {
            clearTimeout(NIKTimer);
            NIKTimer = setTimeout(() => {
                $.ajax({
                    url: `${baseUrl}dashboard/checkUserNIKAvailability?nik=${value}`,
                    method: 'GET',
                    success: function(response) {
                        let res = JSON.parse(response);
                        let isAvailable = res.status === 'failed' ? false : true;

                        if (isAvailable) {
                            $('#addEmployeeForm #NIKAvailability').addClass('text-success').show();
                            $('#addEmployeeForm #NIKAvailability span').text('NIK is available');
                            $('#addEmployeeForm #NIKAvailability i').addClass('la-check-circle');
                        } else {
                            $('#addEmployeeForm #NIKAvailability').addClass('text-danger').show();
                            $('#addEmployeeForm #NIKAvailability span').text('NIK is already used');
                            $('#addEmployeeForm #NIKAvailability i').addClass('la-times-circle');
                        }
                    }
                });
            }, 500);
        }
    });

    $('#addEmployeeForm [name="companyId"]').select2({
        width: '1%',
        placeholder: 'Choose Company',
        ajax: {
            url: `${baseUrl}dashboard/getAllCompaniesDatas`,
            type: 'GET',
            dataType: 'json',
            delay: 250,
            processResults: function (response, params) {
                const searchTerm = params.term ? params.term.toLowerCase() : '';
                return {
                    results: response.data 
                        .filter(d => {
                            const companyName = d.companyName.toLowerCase().includes(searchTerm);
                            const companyStatus = d.companyStatus.toLowerCase().includes(searchTerm);
                            const render = `${companyName} | ${companyStatus}`.toLowerCase().includes(searchTerm);
                            return companyName || companyStatus || render;
                        })
                        .map(function (d) {
                            let companyImg = d.companyLogo 
                                ? baseUrl + "uploads/logos/" + d.companyLogo 
                                : baseUrl + "assets/images/company-placeholder.jpg";
                            return {
                                id: d.companyId,
                                text: `
                                <span class="d-flex align-items-center gap-1">
                                    <img src="${companyImg}" class="rounded object-fit-contain" style="width: 28px; height: 28px;">
                                    <div>
                                    ${d.companyName} | 
                                    ${generateStatusData([d.companyStatus]).find((data) => data.id === d.companyStatus).text}
                                    </div>
                                </span>
                                `,
                            };
                        }
                    )
                }
            }
        },
        dropdownParent: $('#addEmployeeModal .modal-body'),
        escapeMarkup: function(markup) {
            return markup;
        }
    });

    $('#addEmployeeForm [name="employeeDepartment"]').select2({
        placeholder: 'Choose or Create Department',
        disabled: true
    });

    $('#addEmployeeForm [name="employeeBand"]').select2({
        placeholder: 'Choose or Create Band',
        disabled: true
    });

    $('#addEmployeeForm [name="companyId"]').on('change', function() {
        let companyId = $(this).val();

        if (companyId) {
            $('#addEmployeeForm [name="employeeDepartment"]').empty().select2({
                tags: true,
                disabled: false,
                ajax: {
                    url: baseUrl + 'dashboard/getAllDepartmentByCompanyId?id=' + companyId,
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
        
            $('#addEmployeeForm [name="employeeBand"]').empty().select2({
                tags: true,
                disabled: false,
                ajax: {
                    url: baseUrl + 'dashboard/getAllBandByCompanyId?id=' + companyId,
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
        } else {
            $('#addEmployeeForm [name="employeeDepartment"]').empty().prop('disabled', true);
            $('#addEmployeeForm [name="employeeBand"]').empty().prop('disabled', true);
        }
    });

    $(this).find('#addEmployeeForm [name="employeeGender"]').select2({
        placeholder: 'Choose Gender',
        dropdownParent: $('#addEmployeeModal .modal-body')
    });

    $(this).find('#addEmployeeForm [name="insuranceId"]').select2({
        ajax: {
            url: baseUrl + 'dashboard/getAllInsurance',
            type: 'GET',
            dataType: 'json',
            delay: 250,
            processResults: function (response, params) {
                const searchTerm = params.term ? params.term.toLowerCase() : '';
                return {
                    results: response.data 
                        .filter(function(d) {
                            const insuranceTier = d.insuranceTier.toLowerCase().includes(searchTerm);
                            const insuranceAmount = d.insuranceAmount.toLowerCase().includes(searchTerm);
                            const render = `${d.insuranceTier} - ${formatToRupiah(d.insuranceAmount, true, false)}`.toLowerCase().includes(searchTerm);
                            return insuranceTier || insuranceAmount || render;
                        })
                        .map(function(d) {
                            return {
                                id: d.insuranceId,
                                text: `${d.insuranceTier} - ${formatToRupiah(d.insuranceAmount, true, false)}`,
                            }
                        })
                };
            },
            cache: true
        },
        minimumInputLength: 0,
        placeholder: 'Choose Insurance',
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
    $('#viewEmployeeModal #employeeStatus').html(generateStatusData([data.employeehistoryStatus]).find((d) => d.id == data.employeehistoryStatus).text);
    $('#viewEmployeeModal #employeeBirth').html(moment(data.employeeBirth).format('dddd, D MMMM YYYY'))
    $('#viewEmployeeModal #employeeGender').html(capitalizeWords(data.employeeGender))
    $('#viewEmployeeModal #employeeDepartment').html(data.employeehistoryDepartment);
    $('#viewEmployeeModal #employeeBand').html(data.employeehistoryBand);
    $('#viewEmployeeModal #employeePhone').html(data.employeePhone);
    $('#viewEmployeeModal #insuranceTier').html(capitalizeWords(data.insuranceTier));
    $('#viewEmployeeModal #totalBillingAmount').html(formatToRupiah(data.insuranceAmount, false, false));
    $('#viewEmployeeModal #createdAt').html(moment(data.createdAt).format('ddd, D MMMM YYYY HH:mm') + ' WITA');
    $('#viewEmployeeModal #updatedAt').html(moment(data.updatedAt).format('ddd, D MMMM YYYY HH:mm') + ' WITA');

    $.ajax({
        url: baseUrl + 'dashboard/getInsuranceDetailsByEmployeeNIK?nik=' + data.employeeNIK,
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
        $('#employeeFamiliesTable').DataTable().ajax.url(baseUrl + 'dashboard/getFamiliesByEmployeeNIK?nik=' + employeeNIK).load();
        return;
    }
    employeeFamiliesTable = $('#employeeFamiliesTable').DataTable($.extend(true, {}, DataTableSettings, {
        ajax: baseUrl + 'dashboard/getFamiliesByEmployeeNIK?nik=' + employeeNIK,
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
    $('#newPasswordCheck').prop('disabled', false);
    $('#newEmailCheck').prop('disabled', false);

    if (data.employeePhoto) {
        $('#editEmployeeForm #imgPreview').attr('src', baseUrl+'uploads/profiles/'+data.employeePhoto);
    }

    $('#editEmployeeForm [name="employeeNIK"]').val(data.employeeNIK);
    $('#editEmployeeForm [name="employeeName"]').val(data.employeeName);
    $('#editEmployeeForm [name="employeeEmail"]').val(data.employeeEmail);
    $('#editEmployeeForm [name="employeePassword"]').val(data.employeePassword);
    $('#editEmployeeForm [name="employeeAddress"]').val(data.employeeAddress);
    $('#editEmployeeForm [name="employeeBirth"]')[0]._flatpickr.setDate(data.employeeBirth);

    var isUnverified = data.employeehistoryStatus == 'unverified';
    $('#editEmployeeForm [name="employeeStatus"]').select2({
        minimumInputLength: 0,
        placeholder: 'Choose Status',
        data: isUnverified ? generateStatusData([data.employeehistoryStatus]) : generateStatusData(['Active', 'On Hold', 'Discontinued']),
        disabled: isUnverified,
        dropdownParent: $('#editEmployeeModal .modal-body'),
        escapeMarkup: function(markup) {
            return markup;
        }
    });
    $('#editEmployeeForm [name="employeeStatus"]').val(data.employeehistoryStatus).trigger('change');
    isUnverified && $('#editEmployeeForm [name="employeeStatus"]').parents('.col-12').find('.warning-message').show();

    $('#editEmployeeForm [name="employeePhone"]').val(data.employeePhone);
    formatPhoneInput();

    $('#editEmployeeForm [name="companyId"]').select2({
        width: '1%',
        placeholder: 'Choose Company',
        ajax: {
            url: `${baseUrl}dashboard/getAllCompaniesDatas`,
            type: 'GET',
            dataType: 'json',
            delay: 250,
            processResults: function (response, params) {
                const searchTerm = params.term ? params.term.toLowerCase() : '';
                return {
                    results: response.data 
                        .filter(d => {
                            const companyName = d.companyName.toLowerCase().includes(searchTerm);
                            const companyStatus = d.companyStatus.toLowerCase().includes(searchTerm);
                            const render = `${companyName} | ${companyStatus}`.toLowerCase().includes(searchTerm);
                            return companyName || companyStatus || render;
                        })
                        .map(function (d) {
                            let companyImg = d.companyLogo 
                                ? baseUrl + "uploads/logos/" + d.companyLogo 
                                : baseUrl + "assets/images/company-placeholder.jpg";
                            return {
                                id: d.companyId,
                                text: `
                                <span class="d-flex align-items-center gap-1">
                                    <img src="${companyImg}" class="rounded object-fit-contain" style="width: 28px; height: 28px;">
                                    <div>
                                    ${d.companyName} | 
                                    ${generateStatusData([d.companyStatus]).find((data) => data.id === d.companyStatus).text}
                                    </div>
                                </span>
                                `,
                            };
                        }
                    )
                }
            }
        },
        dropdownParent: $('#editEmployeeModal .modal-body'),
        escapeMarkup: function(markup) {
            return markup;
        }
    });
    let companyImg = data.companyLogo 
            ? baseUrl + "uploads/logos/" + data.companyLogo 
            : baseUrl + "assets/images/company-placeholder.jpg";
    let selectedCompany = new Option(`
            <span class="d-flex align-items-center gap-1">
                <img src="${companyImg}" class="rounded object-fit-contain" style="width: 28px; height: 28px;">
                <div>
                ${data.companyName} | 
                ${generateStatusData([data.companyStatus]).find((d) => d.id === data.companyStatus).text}
                </div>
            </span>
        `, 
        data.companyId, true, true)
    $('#editEmployeeForm [name="companyId"]').append(selectedCompany).trigger('change');

    function selectEmployeeDepartment(companyId) {
        $('#editEmployeeForm [name="employeeDepartment"]').empty().val(data.employeehistoryDepartment).select2({
            tags: true,
            ajax: {
                url: baseUrl + 'dashboard/getAllDepartmentByCompanyId?id=' + companyId,
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
    }

    function selectEmployeeBand(companyId) {
        $('#editEmployeeForm [name="employeeBand"]').empty().select2({
            tags: true,
            ajax: {
                url: baseUrl + 'dashboard/getAllBandByCompanyId?id=' + companyId,
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
    }

    selectEmployeeDepartment(data.companyId);
    $('#editEmployeeForm [name="employeeDepartment"]').append(
        new Option(data.employeehistoryDepartment, data.employeehistoryDepartment, true, true)
    ).trigger('change');

    selectEmployeeBand(data.companyId);
    $('#editEmployeeForm [name="employeeBand"]').append(
        new Option(data.employeehistoryBand, data.employeehistoryBand, true, true)
    ).trigger('change');

    $('#editEmployeeForm [name="companyId"]').on('change', function() {
        let companyId = $(this).val();

        if (companyId) {
            selectEmployeeDepartment(companyId);
            selectEmployeeBand(companyId);

            var isUnverified = data.employeehistoryStatus == 'unverified';
            $('#editEmployeeForm [name="employeeStatus"]').select2({
                minimumInputLength: 0,
                placeholder: 'Choose Status',
                data: isUnverified ? generateStatusData([data.employeehistoryStatus]) : generateStatusData(['Active', 'On Hold', 'Discontinued']),
                disabled: isUnverified,
                dropdownParent: $('#editEmployeeModal .modal-body'),
                escapeMarkup: function(markup) {
                    return markup;
                }
            });
            $('#editEmployeeForm [name="employeeStatus"]').val(isUnverified || (companyId === data.companyId) ? data.employeehistoryStatus : 'active').trigger('change');
            isUnverified && $('#editEmployeeForm [name="employeeStatus"]').parents('.col-12').find('.warning-message').show();

            if (companyId == data.companyId) {
                $('#editEmployeeForm [name="employeeDepartment"]').append(
                    new Option(data.employeehistoryDepartment, data.employeehistoryDepartment, true, true)
                ).trigger('change');
                $('#editEmployeeForm [name="employeeBand"]').append(
                    new Option(data.employeehistoryBand, data.employeehistoryBand, true, true)
                ).trigger('change');
            }
        } else {
            $('#editEmployeeForm [name="employeeDepartment"]').empty().prop('disabled', true);
            $('#editEmployeeForm [name="employeeBand"]').empty().prop('disabled', true);
        }
    });

    $.ajax({
        url: baseUrl + 'dashboard/getInsuranceDetailsByEmployeeNIK?nik=' + data.employeeNIK,
        method: 'GET',
        success: function(response) {
            let res = JSON.parse(response);
            let selectCompanyDisabled = res.data.totalTreatments != 0 ? true : false;
            $('#editEmployeeForm [name="companyId"]').prop('disabled', selectCompanyDisabled);
        }
    });


    $('#editEmployeeForm [name="employeeGender"]').select2({
        minimumInputLength: 0,
        placeholder: 'Choose Gender',
        dropdownParent: $('#editEmployeeModal .modal-body'),
    });
    $('#editEmployeeForm [name="employeeGender"]').val(data.employeeGender).trigger('change');

    $('#editEmployeeForm [name="insuranceId"]').select2({
        ajax: {
            url: baseUrl + 'dashboard/getAllInsurance',
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
                            const render = `${d.insuranceTier} - ${formatToRupiah(d.insuranceAmount, true, false)}`.includes(searchTerm);
                            return insuranceTier || insuranceAmount || render;
                        })
                        .map(function(d) {
                            return {
                                id: d.insuranceId,
                                text: `${d.insuranceTier} - ${formatToRupiah(d.insuranceAmount, true, false)}`,
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

    var NIKTimer;
    $('#editEmployeeForm [name="newEmployeeNIK"]').on('input', function() {
        let value = $(this).val();
        $('#editEmployeeForm #NIKAvailability').removeClass('text-success text-danger').hide();
        $('#editEmployeeForm #NIKAvailability i').removeClass('la-check-circle la-times-circle');
        if (value.length == 16) {
            clearTimeout(NIKTimer);
            NIKTimer = setTimeout(() => {
                $.ajax({
                    url: `${baseUrl}dashboard/checkUserNIKAvailability?nik=${value}`,
                    method: 'GET',
                    success: function(response) {
                        let res = JSON.parse(response);
                        let isAvailable = res.status === 'failed' ? false : true;

                        if (isAvailable) {
                            $('#editEmployeeForm #NIKAvailability').addClass('text-success').show();
                            $('#editEmployeeForm #NIKAvailability span').text('NIK is available');
                            $('#editEmployeeForm #NIKAvailability i').addClass('la-check-circle');
                        } else {
                            $('#editEmployeeForm #NIKAvailability').addClass('text-danger').show();
                            $('#editEmployeeForm #NIKAvailability span').text('NIK is already used');
                            $('#editEmployeeForm #NIKAvailability i').addClass('la-times-circle');
                        }
                    }
                });
            }, 500);
        }
    });
});

$('#editEmployeeForm #newEmployeeNIK').change(function() {
    $('#editEmployeeForm #newEmployeeNIKInput').toggle();
    $('#editEmployeeForm #newEmployeeNIKInput').find('input').val('');
    $('#editEmployeeForm #newEmployeeNIKInput').find('.error-message').remove();
    $('#editEmployeeForm #newEmployeeNIKInput').find('.is-invalid').removeClass('is-invalid');
    $('#editEmployeeForm #NIKAvailability').removeClass('text-success text-danger').hide();
    $('#editEmployeeForm #NIKAvailability i').removeClass('la-check-circle la-times-circle');
});

$('#editEmployeeForm').on('submit', function(e) {
    e.preventDefault();
    removeCleaveFormat();
    $.ajax({
        url: baseUrl + 'dashboard/Employees/editEmployee',
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
        url: baseUrl + 'dashboard/Employees/deleteEmployee',
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            console.log(response);
            var res = JSON.parse(response);
            res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
            if (res.status === 'success') {
                reloadTableData(employeesTable);
                displayAlert('delete success');
            } else if (res.status === 'failed') {
                displayAlert(res.failedMsg, res.errorMsg?? null);
            }
        }
    });
});