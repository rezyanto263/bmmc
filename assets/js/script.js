// Theme Mode
userColorPreference();
function userColorPreference() {
    var colorPreference = $.cookie('colorPreference');
    if (colorPreference) {
        if (colorPreference === 'dark') {
            $('body:not(.dark)').addClass('dark');
            $('#btn-mode i:not(.las.la-sun)').toggleClass('las la-sun las la-moon');
        } else if (colorPreference === 'light') {
            $('body').removeClass('dark');
            $('#btn-mode i:not(.las.la-moon)').toggleClass('las la-sun las la-moon');
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
$('#btn-menu').on('click', function() {
    $('aside').toggleClass('minimize maximize');
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
$('#scannerModal').on('shown.bs.modal', function() {
    $('aside').hasClass('maximize') && $('aside').toggleClass('minimize maximize');
    try {
        cameraStream = navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
            cameraStream = stream;
        });
        scanner = new Instascan.Scanner({ video: $('#qrScanner').get(0) });
        scanner.addListener('scan', function (content) {
            $('#qrData').val(content);
            $('#qrForm').submit();
            console.log(content);
        });
        Instascan.Camera.getCameras().then(function (cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                alert('No cameras found.');
            }
        }).catch(function (e) {
            // console.error(e);
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
    scanner.stop();
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
    return string.replace(/\b[a-z]/g, function(char) {
        return char.toUpperCase();
    });
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