// Theme Mode
userColorPreference();
function userColorPreference() {
    var colorPreference = $.cookie('colorPreference');
    if (colorPreference) {
        if (colorPreference === 'dark') {
            $('body:not(.dark)').addClass('dark');
            $('#btn-mode i:not(.las.la-sun)').toggleClass('las la-sun las la-moon');
            $('.modal .btn-close:not(.btn-close-white)').each(function() {
                $(this).addClass('btn-close-white');
            });
            toggleFlatpickrTheme(true);
        } else if (colorPreference === 'light') {
            $('body').removeClass('dark');
            $('#btn-mode i:not(.las.la-moon)').toggleClass('las la-sun las la-moon');
            $('.modal .btn-close').each(function() {
                $(this).removeClass('btn-close-white');
            });
            toggleFlatpickrTheme(false);
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
function formatToRupiah(amount, Rp = true, showDecimals = true) {
    return new Intl.NumberFormat('id-ID', {
        style: Rp ? 'currency' : 'decimal',
        currency: Rp ? 'IDR' : undefined,
        useGrouping: true,
        minimumFractionDigits: showDecimals ? 2 : 0,
        maximumFractionDigits: showDecimals ? 2 : 0
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

// Flatpickr
$('input[type="date"]').each(function() {
    $(this).flatpickr({
        dateFormat: 'Y-m-d',
        altInput: true,
        altFormat: 'j F Y',
        minDate: $(this).attr('min') || null,
        maxDate: $(this).attr('max') || null,
        disableMobile: true,
    });
});

function toggleFlatpickrTheme(isDarkMode) {
    if (isDarkMode) {
        $('#flatpickr-theme').prop('disabled', false)
    } else {
        $('#flatpickr-theme').prop('disabled', true)
    }
}

// Cleave (Input Rupiah Format)
function formatCurrencyInput() {
    $('.currency-input').each(function() {
        const cleaveInstance = new Cleave(this, {
            numeral: true,
            numeralDecimalMark: ',',
            delimiter: '.',
            prefix: 'Rp ',
            noImmediatePrefix: true,
            rawValueTrimPrefix: true,
        });
    
        $(this).data('cleave', cleaveInstance);
    
        $(this).on('blur', function() {
            const rawValue = cleaveInstance.getRawValue();
            if (rawValue === '') {
                cleaveInstance.setRawValue('');
                $(this).val('');
            }
        });
    });
}
formatCurrencyInput();

// Cleave (Input Indonesia Phone Number)
function formatPhoneInput() {
    $('.phone-input').each(function() {
        const cleaveInstance = new Cleave(this, {
            phone: true,
            phoneRegionCode: 'ID',
            prefix: '08',
            delimiter: ' ',
            noImmediatePrefix: true,
        });
    
        $(this).data('cleave', cleaveInstance);
    
        $(this).on('blur', function() {
            const rawValue = cleaveInstance.getRawValue();
            if (rawValue === '08') {
                cleaveInstance.setRawValue('');
                $(this).val('');
            }
        });
    });
}
formatPhoneInput();

function removeCleaveFormat() {
    $('.currency-input, .phone-input').each(function() {
        const cleaveInstance = $(this).data('cleave');
        if (cleaveInstance) {
            const rawValue = cleaveInstance.getRawValue();
            $(this).val(rawValue);
        }
    });    
}

// Status Color
function statusColor(data) {
    switch (data) {
        case 'active':
        case 'current':
        case 'in use':
        case 'published':
        case 'paid':
            return 'bg-success';

        case 'free':
        case 'unverified':
        case 'draft':
            return 'bg-secondary-subtle';

        case 'on hold':
            return 'bg-warning';

        case 'discontinued':
        case 'archived':
        case 'finished':
            return 'bg-secondary';

        case 'unpaid':
        case 'stopped':
            return 'bg-danger';

        default:
            return 'border-2 border-dashed border-secondary'
    }
}