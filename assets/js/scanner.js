// QR Scanner
var scanner;
var cameraStream;
var role = atob($('#adminRole').data('admin-role'));

$('#scannerModal').on('show.bs.modal', function() {
    $('#scannerModal .btn-close').hide();
    $('aside').hasClass('maximize') && $('aside').toggleClass('minimize maximize');
    $.cookie('sidebarSize', 'minimize', {path: '/'});
    try {
        cameraStream = navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
            cameraStream = stream;
        });
        scanner = new Instascan.Scanner({ video: $('#qrScanner').get(0) });
        scanner.addListener('scan', function (content) {
            $('[name="qrData"]').val(content);
            $('#qrForm').submit();
        });
        Instascan.Camera.getCameras().then(function (cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
                $('#scannerModal .btn-close').show();
            } else {
                alert('No cameras found.');
            }
        }).catch(function (e) {
            $('#scannerModal .btn-close').show();
            alert(e);
        });
    } catch (error) {
        console.error('Instascan initialization error:', error);
    }
});

$('#scannerModal').on('hidden.bs.modal', function () {
    if (cameraStream) {
        cameraStream.getTracks().forEach(function(track) {
            track.stop();
        });
        cameraStream = null;
    }
    scanner ? scanner.stop() : null;
    if (scanner) {
        scanner.stop()
    }
    scanner = null;
});	

// Scan QR Details Table
$('#qrForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: baseUrl + (role == 'admin' ? 'dashboard' : role)  + '/getPatientByNIK',
        method: 'POST',
        data: $(this).serialize(),
        success: function (response) {
            var res = JSON.parse(response);
            res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
            if (res.status === 'success') {
                $('#scanResultModal').modal('show');
                $('#scannerModal').modal('hide');
                const pro = res.data.profile;
                const ins = res.data.insurance;
                $('#scanResultModal').on('shown.bs.modal', function() {
                    $('#scanResultModal .add-queue').prop('disabled', false);
                    $('#scanResultModal .add-queue').removeClass('opacity-50 pe-none user-select-none');
                    if (['on hold', 'discontinued', 'unverified'].includes(pro.companyStatus)) {
                        $('#scanResultModal .add-queue').prop('disabled', true);
                        $('#scanResultModal .add-queue').addClass('opacity-50 pe-none user-select-none');
                    }

                    var photo = pro.employeePhoto || pro.familyPhoto;
                    var status = pro.employeeStatus || pro.familyStatus;
                    $('#scanResultModal #imgPreview').attr('src', photo ? `${baseUrl}uploads/profiles/${photo}` : `${baseUrl}assets/images/user-placeholder.png`);

                    var totalBillingRemaining = pro.insuranceAmount - ins.totalBillingUsedThisMonth;
                    const fields = [
                        { id: 'nik', value: pro.familyNIK || pro.employeeNIK },
                        { id: 'name', value: pro.employeeName || pro.familyName },
                        { id: 'role', value: pro.familyNIK ? 'family' : 'employee' },
                        { id: 'relationship', value: capitalizeWords(pro.familyRelationship) },
                        { id: 'department', value: pro.employeeDepartment },
                        { id: 'band', value: pro.employeeBand },
                        { id: 'birth', value: moment(pro.employeeBirth || pro.familyBirth).format('dddd, D MMMM YYYY') },
                        { id: 'gender', value: capitalizeWords(pro.employeeGender || pro.familyGender) },
                        { id: 'companyName', value: pro.companyName },
                        { id: 'email', value: pro.employeeEmail || pro.familyEmail },
                        { id: 'phone', value: pro.employeePhone || pro.familyPhone },
                        { id: 'address', value: pro.employeeAddress || pro.familyAddress },
                        { id: 'status', value: generateStatusData([status]).find((d) => d.id === status).text },
                        { id: 'companyStatus', value: generateStatusData([pro.companyStatus]).find((d) => d.id === pro.companyStatus).text },
                        { id: 'totalTreatmentsThisMonth', value: ins.totalTreatmentsThisMonth },
                        { id: 'totalBilledTreatmentsThisMonth', value: ins.totalBilledTreatmentsThisMonth },
                        { id: 'totalReferredTreatmentsThisMonth', value: ins.totalReferredTreatmentsThisMonth },
                        { id: 'totalFreeTreatmentsThisMonth', value: ins.totalFreeTreatmentsThisMonth },
                        { id: 'totalTreatments', value: ins.totalTreatments },
                        { id: 'totalBilledTreatments', value: ins.totalBilledTreatments },
                        { id: 'totalReferredTreatments', value: ins.totalReferredTreatments },
                        { id: 'totalFreeTreatments', value: ins.totalFreeTreatments },
                        { id: 'totalBillingRemaining', value: formatToRupiah(totalBillingRemaining) },
                        { id: 'insuranceTier', value: pro.insuranceTier },
                        { id: 'totalBillingUsed', value: formatToRupiah(ins.totalBillingUsedThisMonth, false, false) },
                        { id: 'totalBillingAmount', value: formatToRupiah(pro.insuranceAmount, false, false) },
                    ];

                    fields.forEach(field => {
                        $(`#scanResultModal #${field.id}`).html(field.value);
                    });

                    displayAlert('scan qr success');
                    getPatientHealthHistory(pro.employeeNIK || pro.familyNIK, pro.familyNIK ? 'family' : 'employee');
                });
            } else if (res.status === 'failed') {
                displayAlert(res.failedMsg);
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

var patientHealthHistoriesTable;
function getPatientHealthHistory(patientNIK, patientRole) {
    if ($.fn.DataTable.isDataTable('#patientHealthHistoriesTable')) {
        $('#patientHealthHistoriesTable').DataTable().ajax.url(baseUrl + (role == 'admin' ? 'dashboard' : role)  + '/getPatientHealthHistoryDetailsByNIK?nik=' + patientNIK + '&role=' + patientRole).load();
        return;
    }
    patientHealthHistoriesTable = $('#patientHealthHistoriesTable').DataTable($.extend(true, {}, DataTableSettings, {
        ajax: baseUrl + (role == 'admin' ? 'dashboard' : role)  + '/getPatientHealthHistoryDetailsByNIK?nik=' + patientNIK + '&role=' + patientRole,
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
                        class="btn-view btn-primary rounded-2">
                        <i class="fa-regular fa-eye"></i>
                    </button>
                `
            },
        ],
        order: [[0, 'desc']],
        columnDefs: [{ width: "40px", target: 16 }],
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
                    createDropdownInModal(node, list, 'year', 'YYYY');
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
                        createDropdownInModal(node, list, 'month', 'MM');
                    } else {
                        $('#monthDropdown').fadeOut(300, function () {
                        $('#monthDropdown').remove();
                        });
                    }
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
}

function createDropdownInModal(node, list, type, format) {
    var id = `${type}Dropdown`;

    // Hapus dropdown lain sebelum menampilkan yang baru
    $('.dropdown-menu.show').fadeOut(300, function () {
        $(this).remove();
    });

    var selectedValue = type === 'year' ? selectedYear : selectedMonth;

    var html = `
        <div id="${id}" class="dropdown-menu show user-select-none" style="position: fixed; z-index: 1050; min-width: 200px; opacity: 0;">
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
    patientHealthHistoriesTable.columns(0).search(selectedYear ? `^${selectedYear}` : '', true, false);
    patientHealthHistoriesTable.columns(0).search(selectedMonth ? `-${selectedMonth}-` : '', true, false);
    patientHealthHistoriesTable.draw();
}

var viewHealthHistoryDetailsModal = new bootstrap.Modal(document.getElementById('viewHealthHistoryDetailsModal'));
$('#patientHealthHistoriesTable').on('click', '.btn-view', function() {
    viewHealthHistoryDetailsModal.show();
    const $backdrops = $('.modal-backdrop.show');
    if ($backdrops.length >= 2) {
        $backdrops.eq(1).css('z-index', '1055');
        $('#viewHealthHistoryDetailsModal').css('z-index', '1056');
    }
    let data = patientHealthHistoriesTable.row($(this).parents('tr')).data();

    $('#viewHealthHistoryDetailsModal #createdAt').html(moment(data.createdAt).format('dddd, DD MMMM YYYY HH:mm') + ' WITA');
    $('#viewHealthHistoryDetailsModal #updatedAt').html(moment(data.updatedAt).format('dddd, DD MMMM YYYY HH:mm') + ' WITA');

    data.patientPhoto && $('#viewHealthHistoryDetailsModal #patientPhoto').attr('src', `${baseUrl}uploads/profiles/${data.patientPhoto}`);

    $('#viewHealthHistoryDetailsModal #patientNIK').html(data.patientNIK);
    $('#viewHealthHistoryDetailsModal #patientName').html(data.patientName);
    $('#viewHealthHistoryDetailsModal #patientDepartment').html(data.patientDepartment);
    $('#viewHealthHistoryDetailsModal #patientGender').html(capitalizeWords(data.patientGender));
    $('#viewHealthHistoryDetailsModal #patientBand').html(data.patientBand);
    $('#viewHealthHistoryDetailsModal #patientRelationship').html(capitalizeWords(data.patientRelationship));

    let hospitalLogo = `${data.hospitalLogo ? baseUrl + "uploads/logos/" + data.hospitalLogo : baseUrl + "assets/images/hospital-placeholder.jpg"}`;
    $('#viewHealthHistoryDetailsModal #hospitalName').html(`
        <span class="d-flex align-items-center gap-1">
        <img src="${hospitalLogo}" class="rounded object-fit-contain" style="width: 28px; height: 28px;">
        <div>
            ${data.hospitalName}
        </div>
        </span>
    `);

    $('#viewHealthHistoryDetailsModal #healthhistoryStatus').html(generateStatusData([data.status]).find((d) => d.id === data.status).text);
    $('#viewHealthHistoryDetailsModal #invoiceStatus').html(generateStatusData([data.invoiceStatus]).find((d) => d.id === data.invoiceStatus).text);
    if (data.healthhistoryReferredTo) {
        $('#viewHealthHistoryDetailsModal .referredInput').show();

        let referredHospitalLogo = `${data.referredHospitalLogo ? baseUrl + "uploads/logos/" + data.referredHospitalLogo : baseUrl + "assets/images/hospital-placeholder.jpg"}`;
        $('#viewHealthHistoryDetailsModal #healthhistoryReferredTo').html(`
        <span class="d-flex align-items-center gap-1">
            <img src="${referredHospitalLogo}" class="rounded object-fit-contain" style="width: 28px; height: 28px;">
            <div>
            ${data.referredHospitalName}
            </div>
        </span>
        `);
    }

    $('#viewHealthHistoryDetailsModal #healthhistoryDate').html(moment(data.healthhistoryDate).format('ddd, DD MMMM YYYY'));
    $('#viewHealthHistoryDetailsModal #doctorName').html(data.doctorName);
    $('#viewHealthHistoryDetailsModal #diseaseNames').html(data.diseaseNames);
    $('#viewHealthHistoryDetailsModal #healthhistoryDescription').val(data.healthhistoryDescription);
    $('#viewHealthHistoryDetailsModal #healthhistoryDoctorFee').html(formatToRupiah(data.healthhistoryDoctorFee, true, false));
    $('#viewHealthHistoryDetailsModal #healthhistoryMedicineFee').html(formatToRupiah(data.healthhistoryMedicineFee, true, false));
    $('#viewHealthHistoryDetailsModal #healthhistoryLabFee').html(formatToRupiah(data.healthhistoryLabFee, true, false));
    $('#viewHealthHistoryDetailsModal #healthhistoryActionFee').html(formatToRupiah(data.healthhistoryActionFee, true, false));
    $('#viewHealthHistoryDetailsModal #healthhistoryDiscount').html(formatToRupiah(data.healthhistoryDiscount, true, false));
    $('#viewHealthHistoryDetailsModal #healthhistoryTotalBill').html(formatToRupiah(data.healthhistoryTotalBill, true, false));
});



// Add Data Queue
var addQueueModal = new bootstrap.Modal(document.getElementById('addQueueModal'));
$('#scanResultModal').off('click').on('click', '.add-queue', function() {
    addQueueModal.show();
    const $backdrops = $('.modal-backdrop.show');
    if ($backdrops.length >= 2) {
        $backdrops.eq(1).css('z-index', '1055');
        $('#addQueueModal').css('z-index', '1056');
    }

    let patientName = $(`#scanResultModal #name`).text();
    let patientNIK = $('#scanResultModal #nik').text();
    let patientRole = $('#scanResultModal #role').text();

    $('#addQueueForm #patientName').text(patientName);
    $('#addQueueForm [name="patientNIK"]').val(patientNIK);
    $('#addQueueForm [name="patientRole"]').val(patientRole);
});

$('#addQueueForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: baseUrl + 'hospital/queues/addQueue',
        method: 'POST',
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function(response) {
            let res = JSON.parse(response);
            res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
            if (res.status === 'success') {
                displayAlert('add success');
                window.location.href = baseUrl + 'hospital/queues';
            } else if (res.status === 'failed') {
                $('.error-message').remove();
                $('.is-invalid').removeClass('is-invalid');
                displayAlert(res.failedMsg, res.errorMsg ?? null);
            }
        }
    });
});