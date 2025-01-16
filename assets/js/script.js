// Theme Mode
userColorPreference();
function userColorPreference() {
    var colorPreference = $.cookie('colorPreference');
    if (colorPreference) {
        if (colorPreference === 'dark') {
            $('body:not(.dark)').addClass('dark');
            $('#btn-mode i:not(.las.la-sun)').toggleClass('las la-sun las la-moon');
            $('.modal .btn-close').addClass('btn-close-white');
        } else if (colorPreference === 'light') {
            $('body').removeClass('dark');
            $('#btn-mode i:not(.las.la-moon)').toggleClass('las la-sun las la-moon');
            $('.modal .btn-close').removeClass('btn-close-white');
        }
    } else {
        var userColorSchema = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
        $.cookie('colorPreference', userColorSchema, {path: '/'});
        userColorPreference();
    }
}

// Button Mode
$('#btn-mode').on('click', function() {
    $('body').toggleClass('dark');
    $('#btn-mode i').toggleClass('las la-sun las la-moon');
    var colorPreference = $.cookie('colorPreference') == 'dark'? 'light':'dark';
    $.cookie('colorPreference', colorPreference, {path: '/'});
    userColorPreference();
});


// Sidebar Maximize Minimize
function sidebarSize() {
    var sidebarSize = $.cookie('sidebarSize');
    if (sidebarSize) {
        if (sidebarSize == 'maximize') {
            $('aside').hasClass('minimize') && $('aside').toggleClass('minimize maximize');
        } else if (sidebarSize == 'minimize') {
            $('aside').hasClass('maximize') && $('aside').toggleClass('minimize maximize');
        }
    } else {
        $.cookie('sidebarSize', 'maximize', {path: '/'});
    }
}
sidebarSize();
$('#btn-menu').on('click', function() {
    $('aside').toggleClass('minimize maximize');
    var sidebarSize = $.cookie('sidebarSize') == 'minimize'? 'maximize':'minimize';
    $.cookie('sidebarSize', sidebarSize, {path: '/'});
    floatingMenuHandler()
});


// Floating Menu Scroll
$(window).on('scroll resize', floatingMenuHandler);
floatingMenuHandler();

function floatingMenuHandler() {
    const isScrolled = $(window).scrollTop() > 10;
    const isWideScreen = $(window).width() >= 992;
    const isMinimized = $('aside').hasClass('minimize');
    const isMaximized = $('aside').hasClass('maximize');

    if (isScrolled) {
        $('.floating-btn').css('opacity', 0.5).addClass('flex-column');
    } else {
        $('.floating-btn').css('opacity', 1);

        if (isWideScreen || isMinimized) {
            $('.floating-btn').removeClass('flex-column');
        } else if (isMaximized) {
            $('.floating-btn').addClass('flex-column');
        }
    }
}


// QR Scanner
var scanner;
var cameraStream;

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
            if (atob($('#adminRole').data('admin-role')) === 'admin') {
                $('#qrForm').submit();
            } else if (atob($('#adminRole').data('admin-role')) === 'hospital') {
                $('#qrHospitalForm').submit();
            } else if (atob($('#adminRole').data('admin-role')) === 'company') {
                $('#qrCompanyForm').submit();
            }
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

$('#qrHospitalForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: baseUrl + 'hospitals/getPatientByNIK',
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
                    $('#scanResultModal #imgPreview').attr('src', photo ? `${baseUrl}uploads/profiles/${photo}` : `${baseUrl}assets/images/user-placeholder.png`);
                    $('#scanResultModal [name="nik"]').val(data.employeeNIK ? data.employeeNIK : data.familyNIK);
                    $('#scanResultModal [name="name"]').val(data.employeeName ? data.employeeName : data.familyName);
                    $('#scanResultModal [name="role"]').val(data.familyRole ? data.familyRole : 'Employee');
                    $('#scanResultModal [name="birth"]').val(data.employeeBirth ? data.employeeBirth : data.familyBirth);
                    $('#scanResultModal [name="gender"]').val(capitalizeWords(data.employeeGender ? data.employeeGender : data.familyGender));
                    $('#scanResultModal [name="companyName"]').val(data.companyName);
                    $('#scanResultModal [name="email"]').val(data.employeeEmail ? data.employeeEmail : data.familyEmail);
                    $('#scanResultModal [name="phone"]').val(data.employeePhone ? data.employeePhone : data.familyPhone);
                    $('#scanResultModal [name="address"]').val(data.employeeAddress ? data.employeeAddress : data.familyAddress);
                    $('#scanResultModal [name="status"]').val(capitalizeWords(data.employeeStatus ? data.employeeStatus : data.familyStatus));
                    displayAlert('scan qr success');
                    getHPatientHistoryHealth(data.employeeNIK ? data.employeeNIK : data.familyNIK);
                });
            } else if (res.status === 'failed') {
                displayAlert(res.failedMsg);
            }
        }
    });
});

$('#qrCompanyForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: baseUrl + 'company/getPatientByNIK',
        method: 'POST',
        data: $(this).serialize(),
        success: function (response) {
            var res = JSON.parse(response);
            if (res.status === 'success') {
                // var resultModal = new bootstrap.Modal(document.getElementById('scanResultModal'));
                // resultModal.show();
                $('#scanResultModal').modal('show');
                $('#scannerModal').modal('hide');
                const data = res.data;
                $('#scanResultModal').on('shown.bs.modal', function() {
                    var photo = data.employeePhoto || data.familyPhoto;
                    $('#scanResultModal #imgPreview').attr('src', photo ? `${baseUrl}uploads/profiles/${photo}` : `${baseUrl}assets/images/user-placeholder.png`);
                    $('#scanResultModal [name="nik"]').val(data.employeeNIK ? data.employeeNIK : data.familyNIK);
                    $('#scanResultModal [name="name"]').val(data.employeeName ? data.employeeName : data.familyName);
                    $('#scanResultModal [name="role"]').val(data.familyRole ? data.familyRole : 'Employee');
                    $('#scanResultModal [name="birth"]').val(data.employeeBirth ? data.employeeBirth : data.familyBirth);
                    $('#scanResultModal [name="gender"]').val(capitalizeWords(data.employeeGender ? data.employeeGender : data.familyGender));
                    $('#scanResultModal [name="companyName"]').val(data.companyName);
                    $('#scanResultModal [name="email"]').val(data.employeeEmail ? data.employeeEmail : data.familyEmail);
                    $('#scanResultModal [name="phone"]').val(data.employeePhone ? data.employeePhone : data.familyPhone);
                    $('#scanResultModal [name="address"]').val(data.employeeAddress ? data.employeeAddress : data.familyAddress);
                    $('#scanResultModal [name="status"]').val(capitalizeWords(data.employeeStatus ? data.employeeStatus : data.familyStatus));
                    displayAlert('scan qr success');
                    getCPatientHistoryHealth(data.employeeNIK ? data.employeeNIK : data.familyNIK);
                });
            } else if (res.status === 'failed') {
                displayAlert(res.failedMsg);
            }
        }
    });
});

$('#qrForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: baseUrl + 'dashboard/getPatientByNIK',
        method: 'POST',
        data: $(this).serialize(),
        success: function (response) {
            var res = JSON.parse(response);
            if (res.status === 'success') {
                // var resultModal = new bootstrap.Modal(document.getElementById('scanResultModal'));
                // resultModal.show();
                $('#scanResultModal').modal('show');
                $('#scannerModal').modal('hide');
                const data = res.data;
                $('#scanResultModal').on('shown.bs.modal', function() {
                    var photo = data.employeePhoto || data.familyPhoto;
                    $('#scanResultModal #imgPreview').attr('src', photo ? `${baseUrl}uploads/profiles/${photo}` : `${baseUrl}assets/images/user-placeholder.png`);
                    $('#scanResultModal [name="nik"]').val(data.employeeNIK ? data.employeeNIK : data.familyNIK);
                    $('#scanResultModal [name="name"]').val(data.employeeName ? data.employeeName : data.familyName);
                    $('#scanResultModal [name="role"]').val(data.familyRole ? data.familyRole : 'Employee');
                    $('#scanResultModal [name="birth"]').val(data.employeeBirth ? data.employeeBirth : data.familyBirth);
                    $('#scanResultModal [name="gender"]').val(capitalizeWords(data.employeeGender ? data.employeeGender : data.familyGender));
                    $('#scanResultModal [name="companyName"]').val(data.companyName);
                    $('#scanResultModal [name="email"]').val(data.employeeEmail ? data.employeeEmail : data.familyEmail);
                    $('#scanResultModal [name="phone"]').val(data.employeePhone ? data.employeePhone : data.familyPhone);
                    $('#scanResultModal [name="address"]').val(data.employeeAddress ? data.employeeAddress : data.familyAddress);
                    $('#scanResultModal [name="status"]').val(capitalizeWords(data.employeeStatus ? data.employeeStatus : data.familyStatus));
                    displayAlert('scan qr success');
                    getPatientHistoryHealth(data.employeeNIK ? data.employeeNIK : data.familyNIK);
                });
            } else if (res.status === 'failed') {
                displayAlert(res.failedMsg);
            }
        }
    });
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


// Show Password
$('.input-group #btnShowPassword').on('click', function(event) {
    event.preventDefault();
    const passwordInput = $(this).closest('.input-group').find('input[type="password"], input[type="text"]');
    passwordInput.attr('type', passwordInput.attr('type') === 'password' ? 'text' : 'password');
    $(this).find('i').toggleClass('la-eye la-eye-slash');
});


// Number Only
function isNumberKey(evt) {
	var kodeASCII = evt.which ? evt.which : evt.keyCode;
	if (kodeASCII > 31 && (kodeASCII < 48 || kodeASCII > 57)) {
		return false;
	}
	return true;
}

// Text Only
function isLetterSpaceKey(evt) {
	var charCode = evt.which ? evt.which : evt.keyCode;
	if (
		(charCode < 65 || charCode > 90) &&
		(charCode < 97 || charCode > 122) &&
		charCode != 32
	) {
		return false;
	}
	return true;
}

// Capitalize Words
function capitalizeWords(string) {
    string = string.toLowerCase();
    return string.replace(/\b[a-z]/g, function(char) {
        return char.toUpperCase();
    });
}

// Rupiah Format
function formatToRupiah(amount) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
    }).format(amount);
}

// Bootstrap Tooltips
$('[data-bs-toggle="tooltip"]').each(function() {
    new bootstrap.Tooltip($(this));
});

// Image Upload Preview
$('.imgFile').on('change', function(e) {
    var file = e.target.files[0];
    if (file) {
        $(e.target).closest('.col-12').find('.imgContainer img').attr('src', URL.createObjectURL(file));
    }
});