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

if (flashdata == 'wrong password') {
    Swal.fire({
        title: 'Failed!',
        text: 'Wrong password',
        icon: 'error',
        confirmButtonText: 'Try again'
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
}

flashdata = $('#forgotPassAlert').data('flashdata');
var errorflashdata = $('#forgotPassAlert').data('errorflashdata');

if (flashdata == 'send email failed') {
    Swal.fire({
        title: 'Failed!',
        text: 'Email not send. ' + errorflashdata,
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
    }
}

