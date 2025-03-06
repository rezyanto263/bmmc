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
            $('#offcanvasActivityLog').addClass('text-bg-dark');
            $('#offcanvasActivityLog .btn-close').addClass('btn-close-white');
            toggleFlatpickrTheme(true);
        } else if (colorPreference === 'light') {
            $('body').removeClass('dark');
            $('#btn-mode i:not(.las.la-moon)').toggleClass('las la-sun las la-moon');
            $('.modal .btn-close').each(function() {
                $(this).removeClass('btn-close-white');
            });
            $('#offcanvasActivityLog').removeClass('text-bg-dark');
            $('#offcanvasActivityLog .btn-close').removeClass('btn-close-white');
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
            $('#btn-menu i').removeClass('la-chevron-circle-right');
            $('#btn-menu i').addClass('la-chevron-circle-left');
        } else if (sidebarSize == 'minimize') {
            $('aside').hasClass('maximize') && $('aside').toggleClass('minimize maximize');
            $('#btn-menu i').removeClass('la-chevron-circle-left');
            $('#btn-menu i').addClass('la-chevron-circle-right');
        }
    } else {
        $.cookie('sidebarSize', 'maximize', {path: '/'});
        $('#btn-menu i').removeClass('la-chevron-circle-right');
        !$('#btn-menu i').hasClass('la-chevron-circle-left') && $('#btn-menu i').addClass('la-chevron-circle-left');
    }
}
sidebarSize();


$('#btn-menu').on('click', function() {
    $('aside').toggleClass('minimize maximize');
    var sidebarSize = $.cookie('sidebarSize') === 'minimize'? 'maximize':'minimize';
    $('#btn-menu i').toggleClass('la-chevron-circle-right la-chevron-circle-left');
    $.cookie('sidebarSize', sidebarSize, {path: '/'});
    floatingMenuHandler()
});

let resizeFrame;
$('aside').on('transitionend', function() {
    if (resizeFrame) cancelAnimationFrame(resizeFrame);
    resizeFrame = requestAnimationFrame(() => {
        $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
    });
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
        $('.floating-btn').addClass('flex-column');
        $('.floating-btn button').css('opacity', 0.5);
    } else {
        $('.floating-btn button').css('opacity', 1);

        if (isWideScreen || isMinimized) {
            $('.floating-btn').removeClass('flex-column');
        } else if (isMaximized) {
            $('.floating-btn').addClass('flex-column');
        }
    }
}

// Flatpickr
$('input[type="date"]').each(function() {
    $(this).flatpickr({
        dateFormat: 'Y-m-d',
        altInput: true,
        altFormat: 'j F Y',
        minDate: $(this).attr('min') || null,
        maxDate: $(this).attr('max') || null,
        disableMobile: true,
        plugins: [new confirmDatePlugin({
            confirmText: '',
            showAlways: true
        })],
        onOpen: function(selectedDates, dateStr, instance) {
            $('.flatpickr-confirm').html('<span class="fw-bold"><i class="las la-calendar-day"></i> TODAY</span>')
            $('.flatpickr-confirm').on('click', function() {
                instance.setDate(moment().tz('Asia/Makassar').format('YYYY-MM-DD'));
            });
        }
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
    $('.currency-input')?.each(function() {
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

        $(this).on('input', function() {
            const rawValue = cleaveInstance.getRawValue();
            const minValue = parseFloat($(this).attr('min'));
            const maxValue = parseFloat($(this).attr('max'));
            if (rawValue < minValue) {
                cleaveInstance.setRawValue(minValue.toString());
                $(this).val(cleaveInstance.getFormattedValue());
            } else if (rawValue > maxValue) {
                cleaveInstance.setRawValue(maxValue.toString());
                $(this).val(cleaveInstance.getFormattedValue());    
            } else if (rawValue === '-' || rawValue === '') {
                cleaveInstance.setRawValue('');
                $(this).val('Rp ');
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

        $(this).on('focus', function() {
            $(this).on('input', function() {
                const rawValue = cleaveInstance.getRawValue();
                if (rawValue === '') {
                    cleaveInstance.setRawValue('');
                    $(this).val('08');
                }
            });
        });
    
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
    $('.currency-input, .phone-input')?.each(function() {
        const cleaveInstance = $(this).data('cleave');
        if (cleaveInstance) {
            const rawValue = cleaveInstance.getRawValue();
            $(this).val(rawValue);
        }
    });    
}