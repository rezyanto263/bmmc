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

// Status Color
function statusColor(data) {
    switch (data) {
        case 'active':
        case 'current':
        case 'in use':
        case 'published':
        case 'billed':
        case 'paid':
            return 'bg-success';

        case 'free':
        case 'unverified':
            return 'bg-secondary-subtle';

        case 'on hold':
        case 'pending':
            return 'bg-warning';

        case 'referred':
            return 'bg-info';

        case 'discontinued':
        case 'disabled':
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

function generateStatusData(statuses) {
    return statuses.map(status => ({
        id: status.toLowerCase(),
        text: `<div class="${statusColor(status.toLowerCase())} status-circle"></div><span class="d-inline">${capitalizeWords(status)}</span>`
    }));
}