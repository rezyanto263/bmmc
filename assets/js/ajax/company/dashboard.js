var imageFilePath = $('#temporaryData').data('photo');
var coordinate = $('#temporaryData').data('coordinate');
var latitude = coordinate.split(',')[0];
var longitude = coordinate.split(',')[1];

initializeMap(latitude, longitude, imageFilePath);

$('#editProfileForm').on('submit', function (e) {
  e.preventDefault();
  removeCleaveFormat();
  $.ajax({
    url: baseUrl + 'company/dashboard/editProfile',
    method: 'POST',
    data: new FormData(this),
    contentType: false,
    processData: false,
    success: function (response) {
      let res = JSON.parse(response);
      res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
      if (res.status ==='success') {
        displayAlert('edit success');
        window.location.reload();
      } else if (res.status === 'failed') {
        displayAlert(res.failedMsg, res.errorMsg?? null);
        formatPhoneInput();
      } else if (res.status === 'invalid') {
        displayFormValidation('#editProfileForm', res.errors);
        displayAlert(res.failedMsg, res.errorMsg?? null);
        formatPhoneInput();
      }
    }
  });
});