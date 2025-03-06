// Configuration
var DataTableSettings = {
    processing: true,
    deferRender: true,
    buttons: [
        {
            extend: 'copyHtml5',
            text: 'Copy',
            exportOptions: {
                columns: ':visible:not(.no-export)'
            }
        },
        {
            extend: 'excelHtml5',
            text: 'Excel',
            exportOptions: {
                columns: ':visible:not(.no-export)'
            }
        },
        {
            extend: "colvis",
            columns: ':not(.no-visibility)',
            collectionLayout: "dropdown",
            text: "Visibility",
        },
        {
            text: '<i class="fa-solid fa-arrows-rotate fs-5 pt-1 px-0 px-md-1"></i>',
            className: 'reload',
            action: function (e, dt, node, config) {
                dt.ajax.reload(null, false);
            }
        },
    ],
    layout: {
        topStart: 'buttons',
        topEnd: {
            pageLength: {
                menu: [10, 20, 50, 100]
            },
            search:{
                placeholder: 'Search'
            },
        },
        bottomStart: 'info',
        bottomEnd: 'paging',
    },
    fixedHeader: true,
    colReorder: true,
    paging: true,
    searching: true,
    ordering: true,
    autoWidth: true,
    scrollX: true,
    fixedColumns: {
        rightColumns: 1,
        leftColumns: 0
    }
}

function reloadTableData(table) {
    table.ajax.reload(null, false);
}

function displayFormValidation(formSelector, errors) {
    $(formSelector + ' .error-message').remove();
    $(formSelector + ' .is-invalid').removeClass('is-invalid');

    $.each(errors, function(key, message) {
        var inputField = $(formSelector + ' [name="' + key + '"]');
        inputField.addClass('is-invalid');
        inputField.parent().after('<small class="error-message text-danger px-0 lh-1">' + message + '</small>');
    });
}

var htmlContent;
var submitBtn;
$.ajaxSetup({
    beforeSend: function (jqXHR, settings) {
        if (settings.type.toUpperCase() === "POST") {
            submitBtn = $('[type="submit"]:focus');
            htmlContent = submitBtn.html();
            submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Processing...');
            $('[data-bs-dismiss="modal"]').prop('disabled', true);
        }
    },
    complete: function (jqXHR, settings) {
        if (submitBtn) {
            var response = JSON.parse(jqXHR.responseText);
            if (response.status) {
                submitBtn.prop('disabled', false).html(htmlContent);
                $('[data-bs-dismiss="modal"]').prop('disabled', false);
                if (response.status === 'success' || response.status === 'failed') {
                    $('.modal').modal('hide');
                }
            }
        }
    },
    error: function(xhr, status, error) {
        console.error('AJAX Error!');
        console.error('Status:', status);
        console.error('Error:', error);
        console.error('Response:', xhr.responseText);
        if (xhr.status === 403) {
            location.reload(true);
        }
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


$('.modal').on('hidden.bs.modal', function(e) {
    $(this).find('#imgPreview').attr('src', $(this).find('#imgPreview').data('originalsrc'));
    $(this).find('#imgPreview2').attr('src', $(this).find('#imgPreview2').data('originalsrc'));
    $(this).find('select.select2').select2('destroy');
    $(e.target).find('form').trigger('reset');
    $('.error-message').remove();
    $('.warning-message').hide();
    $('.is-invalid').removeClass('is-invalid');
    $('.changeEmailInput, .changePasswordInput, #changeCoordinateInput, #changeBillingAmountInput, #newEmployeeNIKInput, .referredInput').hide();
});

// Change Email or Password Visibility Checkbox
$('.changeEmailInput, .changePasswordInput').hide();
$('#newEmailCheck, #newPasswordCheck').on('change', function() {
    const targetClass = $(this).is('#newEmailCheck')? '.changeEmailInput' : '.changePasswordInput';
    $(targetClass).toggle();
    $(targetClass).find('input').val('');
    $(targetClass).find('.error-message').remove();
    $(targetClass).find('.is-invalid').removeClass('is-invalid');

    const isEmailChecked = $('#newEmailCheck').is(':checked');
    const isPasswordChecked = $('#newPasswordCheck').is(':checked');

    if (isEmailChecked) {
        $('#newPasswordCheck').prop('disabled', true);
    } else if (isPasswordChecked) {
        $('#newEmailCheck').prop('disabled', true);
    } else {
        $('#newEmailCheck, #newPasswordCheck').prop('disabled', false);
    }
});

$('#changeCoordinateInput').hide();
$('#newCoordinateCheck').change(function() {
    $('#changeCoordinateInput').toggle();
    $('#changeCoordinateInput').find('input').val('');
    $('.error-message').remove();
    $('.is-invalid').removeClass('is-invalid');
});