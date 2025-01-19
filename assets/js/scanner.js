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
            // console.error(e);
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
            if (res.status === 'success') {
                $('#scanResultModal').modal('show');
                $('#scannerModal').modal('hide');
                const data = res.data;
                $('#scanResultModal').on('shown.bs.modal', function() {
                    var photo = data.employeePhoto || data.familyPhoto;
                    var status = data.employeeStatus || data.familyStatus;
                    $('#scanResultModal #imgPreview').attr('src', photo ? `${baseUrl}uploads/profiles/${photo}` : `${baseUrl}assets/images/user-placeholder.png`);

                    const fields = [
                        { id: 'nik', value: data.employeeNIK || data.familyNIK },
                        { id: 'name', value: data.employeeName || data.familyName },
                        { id: 'role', value: data.familyRole || 'Employee' },
                        { id: 'birth', value: data.employeeBirth || data.familyBirth },
                        { id: 'gender', value: capitalizeWords(data.employeeGender || data.familyGender) },
                        { id: 'companyName', value: data.companyName },
                        { id: 'email', value: data.employeeEmail || data.familyEmail },
                        { id: 'phone', value: data.employeePhone || data.familyPhone },
                        { id: 'address', value: data.employeeAddress || data.familyAddress },
                        { id: 'status', value: generateStatusData([status]).find((d) => d.id === status).text }
                    ];

                    fields.forEach(field => {
                        console.log(field.value);
                        $(`#scanResultModal #${field.id}`).html(field.value);
                    });

                    displayAlert('scan qr success');
                    getPatientHistoryHealth(data.employeeNIK || data.familyNIK);
                });
            } else if (res.status === 'failed') {
                displayAlert(res.failedMsg);
            }
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
                data: 'historyhealthTotalBill',
                render: function(data, type, row) {
                    return formatToRupiah(data);
                }
            },
            {
                data: 'historyhealthStatus',
                render: function(data, type, row) {
                    console.log(data);
                    return generateStatusData([data]).find((d) => d.id === data)?.text;
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

$('#patientTable').on('click', '.btn-view', function() {
    viewHistoryHealthDetailsModal.show();
    const backdrops = document.querySelectorAll('.modal-backdrop.show');
    if (backdrops.length >= 2) {
        backdrops[1].style.zIndex = "1055";
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