// QR Scanner
var scanner;
var cameraStream;
var role = atob($('#adminRole').data('admin-role'));

$('#scannerModal').on('show.bs.modal', function() {
    $('#scannerModal .btn-close').hide();
    $('aside').hasClass('maximize') && $('aside').toggleClass('minimize maximize');
    try {
        cameraStream = navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
            cameraStream = stream;
        });
        scanner = new Instascan.Scanner({ video: $('#qrScanner').get(0) });
        scanner.addListener('scan', function (content) {
            $('[name="qrData"]').val(content);
            $('#qrForm').submit();
            console.log(content);
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

var viewHistoryHealthDetailsModal = new bootstrap.Modal(document.getElementById('viewHistoryHealthDetailsModal'));

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
                const ins = res.data.insurance[0];
                $('#scanResultModal').on('shown.bs.modal', function() {
                    var photo = pro.employeePhoto || pro.familyPhoto;
                    var status = pro.employeeStatus || pro.familyStatus;
                    $('#scanResultModal #imgPreview').attr('src', photo ? `${baseUrl}uploads/profiles/${photo}` : `${baseUrl}assets/images/user-placeholder.png`);

                    var totalBillingRemaining = ins.totalBillingUsed - pro.insuranceAmount;
                    const fields = [
                        { id: 'nik', value: pro.familyNIK || pro.employeeNIK },
                        { id: 'name', value: pro.employeeName || pro.familyName },
                        { id: 'role', value: pro.familyNIK ? 'Family' : 'Employee' },
                        { id: 'birth', value: moment(pro.employeeBirth || pro.familyBirth).format('dddd, D MMMM YYYY') },
                        { id: 'gender', value: capitalizeWords(pro.employeeGender || pro.familyGender) },
                        { id: 'companyName', value: pro.companyName },
                        { id: 'email', value: pro.employeeEmail || pro.familyEmail },
                        { id: 'phone', value: pro.employeePhone || pro.familyPhone },
                        { id: 'address', value: pro.employeeAddress || pro.familyAddress },
                        { id: 'status', value: generateStatusData([status]).find((d) => d.id === status).text },
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
                        { id: 'totalBillingUsed', value: formatToRupiah(ins.totalBillingUsed, false, false) },
                        { id: 'totalBillingAmount', value: formatToRupiah(pro.insuranceAmount, false, false) },
                    ];

                    fields.forEach(field => {
                        $(`#scanResultModal #${field.id}`).html(field.value);
                    });

                    displayAlert('scan qr success');
                    getPatientHistoryHealth(pro.employeeNIK || pro.familyNIK);
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

var patientTable;
function getPatientHistoryHealth(patientNIK) {
    if ($.fn.DataTable.isDataTable('#patientTable')) {
        $('#patientTable').DataTable().ajax.url(baseUrl + (role == 'admin' ? 'dashboard' : role)  + '/getPatientHistoryHealthDetailsByNIK/' + patientNIK).load();
        return;
    }
    patientTable = $('#patientTable').DataTable($.extend(true, {}, DataTableSettings, {
        ajax: baseUrl + (role == 'admin' ? 'dashboard' : role)  + '/getPatientHistoryHealthDetailsByNIK/' + patientNIK,
        columns: [
            {
                data: null,
                className: 'text-start align-middle',
                render: function (data, type, row, meta) {
                    return meta.row + 1;
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
                data: 'diseaseNames',
                className: 'align-middle',
                render: function(data, type, row) {
                    return data ? data.split('|').join(', ') : 'No Disease';
                }
            },
            {
                data: 'historyhealthDate',
                className: 'align-middle',
                render: function(data, type, row) {
                    return moment(data).format('ddd, D MMMM YYYY HH:mm') + ' WITA';
                }
            },
            {
                data: 'historyhealthTotalBill',
                className: 'align-middle',
                render: function(data, type, row) {
                    return formatToRupiah(data);
                }
            },
            {
                data: 'status',
                className: 'align-middle',
                render: function(data, type, row) {
                    console.log(data);
                    return generateStatusData([data]).find((d) => d.id === data)?.text;
                }
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
            {width: '80px', target: 7}
        ]
    }));
}

$('#patientTable').on('click', '.btn-view', function() {
    viewHistoryHealthDetailsModal.show();
    const $backdrops = $('.modal-backdrop.show');
    if ($backdrops.length >= 2) {
        $backdrops.eq(1).css('z-index', '1055');
        $('#viewHistoryHealthDetailsModal').css('z-index', '1056');
    }
    var data = patientTable.row($(this).parents('tr')).data();

    $('#viewHistoryHealthDetailsModal [name="historyhealthComplaint"]').val(data.historyhealthComplaint);
    $('#viewHistoryHealthDetailsModal [name="historyhealthDetails"]').val(data.historyhealthDetails);
    $('#viewHistoryHealthDetailsModal [name="historyhealthDoctorFee"]').val(data.historyhealthDoctorFee);
    $('#viewHistoryHealthDetailsModal [name="historyhealthMedicineFee"]').val(data.historyhealthMedicineFee);
    $('#viewHistoryHealthDetailsModal [name="historyhealthLabFee"]').val(data.historyhealthLabFee);
    $('#viewHistoryHealthDetailsModal [name="historyhealthActionFee"]').val(data.historyhealthActionFee);
    $('#viewHistoryHealthDetailsModal [name="historyhealthDiscount"]').val(data.historyhealthDiscount);
    $('#viewHistoryHealthDetailsModal [name="historyhealthTotalBill"]').val(data.historyhealthTotalBill);
});

var addQueueModal = new bootstrap.Modal(document.getElementById('addQueueModal'));

// Add Data Queue
$('#scanResultModal').on('click', '.add-queue', function() {
    addQueueModal.show();
    const backdrops = document.querySelectorAll('.modal-backdrop.show');
    // if (backdrops.length >= 2) {
    //     backdrops[0].style.zIndex = "1040";
    //     backdrops[1].style.zIndex = "1055";
    // }
    const patientNIK = $('#scanResultModal #nik').html();
    $('#addQueueForm #patientNIK').val(patientNIK);
    $('#addQueueForm #patientName').html($(`#scanResultModal #name`).html());
});

$('#addQueueForm').on('submit', function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        url: baseUrl + 'hospital/queue/addQueue',
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            var res = JSON.parse(response);
            res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
            if (res.status === 'success') {
                $('#addQueueModal').modal('hide');
                reloadTableData(doctorTable);
                displayAlert('add success');
            } else if (res.status === 'failed') {
                $('.error-message').remove();
                $('.is-invalid').removeClass('is-invalid');
                displayAlert(res.failedMsg, res.errorMsg ?? null);
            } else if (res.status === 'invalid') {
                displayFormValidation('#addQueueModal', res.errors);
            }
        }
    });
});