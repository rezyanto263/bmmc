// Insurances CRUD
var insurancesTable = $('#insurancesTable').DataTable($.extend(true, {}, DataTableSettings, {
  ajax: baseUrl + 'company/getAllInsuranceByCompanyId',
  columns: [
      {
          data: 'insuranceTier',
          className: 'text-start fw-bold'
      },
      {
          data: 'insuranceAmount',
          className: 'text-start',
          render: function(data) {
              return formatToRupiah(data);
          }
      },
      {
          data: 'insuranceDescription',
          className: 'text-start text-wrap'
      },
      {
        data: 'createdAt',
        render: function(data, type, row) {
          if (type === 'display' || type === 'filter') {
            return moment(data).format('ddd, D MMMM YYYY HH:mm') + ' WITA';
          }
          return data;
        }
      },
      {
        data: 'updatedAt',
        render: function(data, type, row) {
          if (type === 'display' || type === 'filter') {
            return moment(data).format('ddd, D MMMM YYYY HH:mm') + ' WITA';
          }
          return data;
        }
      },
      {
          data: null,
          className: 'text-end user-select-none no-export no-visibility',
          orderable: false,
          defaultContent: `
              <button 
                  type="button" 
                  class="btn-edit btn-warning rounded-2" 
                  data-bs-toggle="modal" 
                  data-bs-target="#editInsuranceModal">
                  <i class="fa-regular fa-pen-to-square"></i>
              </button>
              <button 
                  type="button" 
                  class="btn-delete btn-danger rounded-2" 
                  data-bs-toggle="modal" 
                  data-bs-target="#deleteInsuranceModal">
                  <i class="fa-solid fa-trash-can"></i>
              </button>
          `
      }
  ],
  columnDefs: [
      {width: '130px', target: 3}
  ]
}));

$('#addInsuranceButton, #editInsuranceButton, #deleteInsuranceButton').on('click', function() {
  reloadTableData(insurancesTable);
});

// Add Data Insurance
$('#addInsuranceForm').on('submit', function(e) {
  e.preventDefault();
  removeCleaveFormat();
  var formData = new FormData(this);
  $.ajax({
      url: baseUrl + 'company/insurance/addInsurance',
      method: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      success: function(response) {
          var res = JSON.parse(response);
          res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
          if (res.status === 'success') {
              reloadTableData(insurancesTable);
              displayAlert('add success');
          } else if (res.status === 'failed') {
              $('.error-message').remove();
              $('.is-invalid').removeClass('is-invalid');
              formatCurrencyInput();
              displayAlert(res.failedMsg, res.errorMsg ?? null);
          } else if (res.status === 'invalid') {
              formatCurrencyInput();
              displayFormValidation('#addInsuranceForm', res.errors);
          }
      }
  });
});

// Edit Data Insurance
$('#insurancesTable').on('click', '.btn-edit', function() {
  var data = insurancesTable.row($(this).parents('tr')).data();
  $('#editInsuranceForm [name="insuranceId"]').val(data.insuranceId);
  $('#editInsuranceForm [name="insuranceTier"]').val(data.insuranceTier);
  $('#editInsuranceForm [name="insuranceAmount"]').val(data.insuranceAmount);
  formatCurrencyInput();
  $('#editInsuranceForm [name="insuranceDescription"]').val(data.insuranceDescription);
});

$('#editInsuranceForm').on('submit', function(e) {
  e.preventDefault();
  removeCleaveFormat();
  $.ajax({
      url: baseUrl + 'company/insurance/editInsurance',
      method: 'POST',
      data: $(this).serialize(),
      success: function(response) {
          var res = JSON.parse(response);
          res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
          if (res.status === 'success') {
              reloadTableData(insurancesTable);
              displayAlert('edit success');
          } else if (res.status === 'failed') {
              $('.error-message').remove();
              $('.is-invalid').removeClass('is-invalid');
              formatCurrencyInput();
              displayAlert(res.failedMsg, res.errorMsg ?? null);
          } else if (res.status === 'invalid') {
              formatCurrencyInput();
              displayFormValidation('#editInsuranceForm', res.errors);
          }
      }
  });
});

// Delete Insurance
$('#insurancesTable').on('click', '.btn-delete', function() {
  var data = insurancesTable.row($(this).parents('tr')).data();
  $('#deleteInsuranceForm #insuranceTier').html(data.insuranceTier);
  $('#deleteInsuranceForm [name="insuranceId"]').val(data.insuranceId);
});

$('#deleteInsuranceForm').on('submit', function(e) {
  e.preventDefault();
  $.ajax({
      url: baseUrl + 'company/insurance/deleteInsurance', // base URL diubah
      method: 'POST',
      data: $(this).serialize(),
      success: function(response) {
          var res = JSON.parse(response);
          res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
          if (res.status === 'success') {
              reloadTableData(insurancesTable);
              displayAlert('delete success');
          }
      }
  });
});