// Toast Settings
const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 5000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
});

// Authentication
var flashdata = $('#loginAlert').data('flashdata');

if (flashdata == 'wrong email or password') {
    Swal.fire({
        title: 'Failed!',
        text: 'Wrong email or password',
        icon: 'error',
        confirmButtonText: 'Try again'
    });
} else if (flashdata == 'account unverified') {
    Swal.fire({
        title: 'Failed!',
        text: 'Your account has not been verified yet. Please verify your account to proceed',
        icon: 'error',
        confirmButtonText: 'OK'
    });
} else if (flashdata == 'account discontinued') {
    Swal.fire({
        title: 'Failed!',
        text: 'Your account has been marked as discontinued and cannot be logged in.',
        icon: 'error',
        confirmButtonText: 'OK'
    });
} else if (flashdata == 'not found') {
    Swal.fire({
        title: 'Failed!',
        text: 'Account not found',
        icon: 'error',
        confirmButtonText: 'OK'
    });
} else if (flashdata == 'reset password success') {
    Swal.fire({
        title: 'Success!',
        text: 'Change password success. Please login!',
        icon: 'success',
        confirmButtonText: 'OK'
    });
} else if (flashdata == 'you are a robot') {
    Swal.fire({
        title: 'Failed!',
        text: "You're a Robot!",
        icon: 'error',
        confirmButtonText: 'OK'
    });
}

flashdata = $('#forgotPassAlert').data('flashdata');
var errorflashdata = $('#forgotPassAlert').data('errorflashdata');

if (flashdata == 'send email failed') {
    Swal.fire({
        title: 'Failed!',
        text: errorflashdata,
        icon: 'error',
        confirmButtonText: 'Try again'
    });
} else if (flashdata == 'forgot password') {
    Swal.fire({ 
        title: 'Succes!',
        text: 'Email has been sent. Please check you email.',
        icon: 'success',
        confirmButtonText: 'OK'
    });
} else if (flashdata == 'token expired') {
    Swal.fire({ 
        title: 'Failed!',
        text: 'Token is expired.',
        icon: 'error',
        confirmButtonText: 'OK'
    });
} else if (flashdata == 'cannot use token') {
    Swal.fire({ 
        title: 'Failed!',
        text: "Can't use the token.",
        icon: 'error',
        confirmButtonText: 'OK'
    });
}

// Dashboard CRUD
function displayAlert(flashdata, message = null) {
    if (flashdata == 'add success') {
        Toast.fire({ 
            title: 'The data has been added successfuly!',
            icon: 'success'
        });
    } else if (flashdata == 'edit success') {
        Toast.fire({
            title: 'The data has been edited successfuly!',
            icon: 'success'
        });
    } else if (flashdata == 'delete success') {
        Toast.fire({
            title: 'The data has been deleted successfuly!',
            icon: 'success'
        });
    } else if (flashdata == 'can not delete linked data') {
        Toast.fire({
            title: 'Sorry, you cannot delete this data because it is still linked to other data',
            icon: 'error'
        });
    } else if (flashdata == 'email used') {
        Toast.fire({
            title: 'The email already used!',
            icon: 'error'
        });
    } else if (flashdata == 'current password is incorrect') {
        Toast.fire({
            title: 'Current password is incorrect!',
            icon: 'error'
        });
    } else if (flashdata == 'delete failed') {
        Toast.fire({
            title: "Error! You can't delete this account.",
            icon: 'error'
        });
    } else if (flashdata == 'upload failed') {
        Toast.fire({
            title: "Upload error!",
            text: message,
            icon: 'error'
        });
    } else if (flashdata == 'coordinate used') {
        Toast.fire({
            title: "The coordinate already used!",
            icon: 'error'
        });
    } else if (flashdata == 'scan qr success') {
        Toast.fire({
            title: "QR Scanned Successfully!",
            icon: 'success'
        });
    } else if (flashdata == 'scan not found') {
        Toast.fire({
            title: "Data not found!",
            icon: 'error'
        });
    } else if (flashdata == 'billing not found') {
        Toast.fire({
            title: "Billing not found!",
            icon: 'error'
        });
    } else if (flashdata == 'invalid qr') {
        Toast.fire({
            title: "Invalid QR Code Data",
            icon: 'error'
        });
    } else if (flashdata == 'qr data missing') {
        Toast.fire({
            title: "QR data is missing",
            icon: 'error'
        });
    } else if (flashdata == 'incorrect format qr data') {
        Toast.fire({
            title: "QR data format is incorrect",
            icon: 'error'
        });
    } else if (flashdata == 'incomplete qr data') {
        Toast.fire({
            title: "QR data is incomplete",
            icon: 'error'
        });
    } else if (flashdata == 'add queue failed') {
        Toast.fire({
            title: `Sorry, you are not allowed to queue because company status is ${message}`,
            icon: 'error'
        });
    } else if (flashdata == 'billing date not valid') {
        Toast.fire({
            title: "Billing started date or ended date is not valid!",
            icon: 'error'
        });
    } else if (flashdata == 'billing date already used') {
        Toast.fire({
            title: "Billing started date or ended date already used!",
            icon: 'error'
        });
    } else if (flashdata == 'nik used') {
        Toast.fire({
            title: "The employee NIK already used!",
            icon: 'error'
        });
    } else if (flashdata == 'send email failed') {
        Toast.fire({
            title: "Oops! Something went wrong, and we couldn’t send your email. Give it another try in a bit.",
            icon: 'error'
        });
    } else if (flashdata == 'disease used') {
        Toast.fire({
            title: "The disease name already used!",
            icon: 'error'
        });
    } else if (flashdata == 'update healthhistory failed') {
        Toast.fire({
            title: "You can't update health history because billing has finished!",
            icon: 'error'
        });
    } else if (flashdata == 'invoice status not allowed') {
        Toast.fire({
            title: "You can't create invoice because billing not finished yet!",
            icon: 'error'
        });
    } else if (flashdata == 'no row selected') {
        Toast.fire({
            title: "Please select at least one row with invoice status 'Unpaid'!",
            icon: 'error'
        });
    } else if (flashdata == 'marked paid successfully') {
        Toast.fire({
            title: "Invoices marked as paid successfully!",
            icon: 'success'
        });
    } else if (flashdata == 'marked unpaid successfully') {
        Toast.fire({
            title: "Invoice marked as unpaid successfully!",
            icon: 'success'
        });
    } else if (flashdata == 'only unpaid invoice can be marked') {
        Toast.fire({
            title: "Only unpaid invoice can be marked!",
            icon: 'error'
        });
    } else if (flashdata == 'news already exists') {
        Toast.fire({
            title: "News Name already exists!",
            icon: 'error'
        });
    } else if (flashdata == 'unknown news status') {
        Toast.fire({
            title: "News Status is not recognized! Please try again.",
            icon: 'error'
        });
    } else if (flashdata == 'tagify max 100 chars') {
        Toast.fire({
            title: "News Tags cannot exceed 100 characters!",
            icon: 'error'
        });
    } else if (flashdata == 'tagify max 20 chars and only one value') {
        Toast.fire({
            title: "News Type must contain only one value and cannot exceed 20 characters!",
            icon: 'error'
        });
    } else if (flashdata == 'billing amount exceeded') {
        Toast.fire({
            title: "Sorry, the selected insurance amount exceeded the available balance!",
            icon: 'error'
        });
    } else if (flashdata == 'invalid billing amount') {
        Toast.fire({
            title: "Sorry, the input billing amount is less than the current billing usage, please input higher amount than the current usage",
            icon: 'error'
        });
    } else if (flashdata == 'insurance amount exceeded') {
        Toast.fire({
            title: "Sorry, the selected insurance amount is lower than the current coverage!",
            icon: 'error'
        });
    } else if (flashdata == 'news thumbnail required') {
        Toast.fire({
            title: "News thumbnail is required!",
            icon: 'error'
        });
    }
}

var profileFlashdata = $('#profileAlert').data('flashdata');
var profileFlashdataError = $('#profileAlert').data('flashdata-msg');
if (profileFlashdata) {
    displayAlert(profileFlashdata, profileFlashdataError ?? null);
}
