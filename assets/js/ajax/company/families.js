// Families CRUD
var familiesTable = $('#familiesTable').DataTable($.extend(true, {}, DataTableSettings, {
  ajax: baseUrl + 'company/getAllFamilyDatas',
  columns: [
      {data: 'familyNIK'},
      {data: 'familyName'},
      {
          data: 'familyStatus',
          render: function(data, type) {
            if (type === 'display' || type === 'filter') {
              return generateStatusData([data]).find((d) => d.id === data).text;
            }
            return data;
          }
      },
      {
          data: 'familyGender',
          render: function(data) {
              return capitalizeWords(data);
          }
      },
      {
          data: 'familyRelationship',
          render: function(data) {
              return capitalizeWords(data);
          }
      },
      {data: 'employeeDepartment'},
      {data: 'employeeBand'},
      {data: 'familyEmail'},
      {data: 'familyPhone'},
      {
          data: 'familyBirth',
          render: function(data, type) {
            if (type === 'display' || type === 'filter') {
              return moment(data).format('D MMMM YYYY');
            }
            return data;
          }
      },
      {
          data: 'familyAddress',
          className: 'text-wrap',
          render: function(data, type) {
              if (type === 'display' || type === 'filter') {
                  return `<div class="text-2-row" style="width: 250px;">${data}</div>`;
              }
              return data;
          }
      },
      {
          data: 'createdAt',
          className: 'text-start',
          render: function(data, type) {
              if (type === 'display' || type === 'filter') {
                  return moment(data).format('ddd, D MMMM YYYY HH:mm') + ' WITA';
              }
              return data;
          }
      },
      {
          data: 'updatedAt',
          className: 'text-start',
          render: function(data, type) {
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
                  data-bs-target="#editFamilyModal">
                  <i class="fa-regular fa-pen-to-square"></i>
              </button>
              <button 
                  type="button" 
                  class="btn-delete btn-danger rounded-2" 
                  data-bs-toggle="modal" 
                  data-bs-target="#deleteFamilyModal">
                  <i class="fa-solid fa-trash-can"></i>
              </button>
          `
      }
  ],
  columnDefs: [
      {width: '80px', target: 12}
  ]
}));

$('#addFamilyButton, #editFamilyButton, #deleteFamilyButton').on('click', function() {
  reloadTableData(familiesTable);
});

// Add Data Family
$('#addFamilyModal').on('show.bs.modal', function() {
  $('#addFamilyForm [name="familyGender"]').select2({
      placeholder: 'Choose Gender',
      dropdownParent: $('#addFamilyModal .modal-body')
  });

  $('#addFamilyForm [name="familyRelationship"]').select2({
      placeholder: 'Choose Relationship',
      dropdownParent: $('#addFamilyModal .modal-body')
  });

  $('#addFamilyForm [name="employeeNIK"]').select2({
      width: '1%',
      ajax: {
          url: baseUrl + 'company/getAllEmployeesByCompanyId',
          type: 'GET',
          dataType: 'json',
          delay: 250,
          processResults: function (response, params) {
              const searchTerm = params.term ? params.term.toLowerCase() : '';
              return {
                  results: response.data
                      .filter(function (data) {
                          const nikMatch = data.employeeNIK.toLowerCase().includes(searchTerm);
                          const nameMatch = data.employeeName.toLowerCase().includes(searchTerm);
                          const statusMatch = data.employeeStatus.toLowerCase().includes(searchTerm);
                          return nikMatch || nameMatch || statusMatch;
                      })
                      .map(function (data) {
                          return {
                              id: data.employeeNIK,
                              text: `
                              ${data.employeeNIK} | 
                              ${data.employeeName} | 
                              ${generateStatusData([data.employeeStatus]).find((d) => d.id === data.employeeStatus).text}`
                          };
                      }) ?? []
              };
          },
          cache: true
      },
      minimumInputLength: 0,
      placeholder: 'Choose Employee',
      dropdownParent: $('#addFamilyModal .modal-body'),
      escapeMarkup: function (markup) { return markup; }
  });
});

$('#addFamilyForm').on('submit', function(e) {
  e.preventDefault();
  removeCleaveFormat();
  $.ajax({
      url: baseUrl + 'company/Families/addFamily',
      method: 'POST',
      data: new FormData(this),
      contentType: false,
      processData: false,
      success: function(response) {
          var res = JSON.parse(response);
          res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
          if (res.status === 'success') {
              reloadTableData(familiesTable);
              displayAlert('add success');
          } else if (res.status === 'failed') {
              $('.error-message').remove();
              $('.is-invalid').removeClass('is-invalid');
              formatPhoneInput()
              displayAlert(res.failedMsg, res.errorMsg ?? null);
          } else if (res.status === 'invalid') {
              formatPhoneInput()
              displayFormValidation('#addFamilyForm', res.errors);
          }
      }
  });
});


// Edit Data Family
$('#familiesTable').on('click', '.btn-edit', function() {
  var data = familiesTable.row($(this).parents('tr')).data();
  $('#editFamilyForm #newFamilyNIKInput').hide();

  data.familyPhoto && $('#editFamilyForm #imgPreview').attr('src', baseUrl+'uploads/profiles/'+data.familyPhoto);
  $('#editFamilyForm [name="familyNIK"]').val(data.familyNIK);
  $('#editFamilyForm [name="familyName"]').val(data.familyName);
  $('#editFamilyForm [name="familyEmail"]').val(data.familyEmail);
  $('#editFamilyForm [name="familyAddress"]').val(data.familyAddress);

  $('#editFamilyForm [name="familyPhone"]').val(data.familyPhone);
  formatPhoneInput();

  $('#editFamilyForm [name="familyBirth"]')[0]._flatpickr.setDate(data.familyBirth);
  
  $('#editFamilyForm [name="familyGender"]').select2({
      placeholder: 'Choose Gender',
      dropdownParent: $('#editFamilyModal .modal-body'),
  });
  $('#editFamilyForm [name="familyGender"]').val(data.familyGender).trigger('change');
  
  $('#editFamilyForm [name="familyRelationship"]').select2({
    placeholder: 'Choose Relationship',
    dropdownParent: $('#editFamilyModal .modal-body')
  });
  $('#editFamilyForm [name="familyRelationship"]').val(data.familyRelationship).trigger('change');

  var isUnverified = data.familyStatus == 'unverified';
  $('#editFamilyForm [name="familyStatus"]').select2({
      placeholder: 'Choose Status',
      data: isUnverified ? generateStatusData([data.familyStatus]) : generateStatusData(['Active', 'On Hold', 'Archived']),
      disabled: isUnverified,
      dropdownParent: $('#editFamilyModal .modal-body'),
      escapeMarkup: function(markup) {
          return markup;
      }
  });
  $('#editFamilyForm [name="familyStatus"]').val(data.familyStatus).trigger('change');
  isUnverified && $('#editFamilyForm [name="familyStatus"]').parents('.col-12').find('.warning-message').show();

  $('#editFamilyForm [name="employeeNIK"]').select2({
      ajax: {
          url: baseUrl + 'company/getAllEmployeesDatas',
          type: 'GET',
          dataType: 'json',
          delay: 250,
          processResults: function (response, params) {
              const searchTerm = params.term ? params.term.toLowerCase() : '';
              return {
                  results: response.data
                  .filter(function (d) {
                      const nikMatch = d.employeeNIK.toLowerCase().includes(searchTerm);
                      const nameMatch = d.employeeName.toLowerCase().includes(searchTerm);
                      const statusMatch = d.employeeStatus.toLowerCase().includes(searchTerm);
                      return nikMatch || nameMatch || statusMatch;
                  })
                  .map(function (d) {
                      if (d.employeeNIK != data.employeeNIK) {
                          return {
                              id: d.employeeNIK,
                              text: `
                              ${d.employeeNIK} | 
                              ${d.employeeName} | 
                              ${generateStatusData([d.employeeStatus]).find((a) => a.id === d.employeeStatus).text}`,
                          };
                      } else {
                          return {
                              id: d.employeeNIK,
                              text: `
                              ${d.employeeNIK} | 
                              ${d.employeeName} | 
                              ${generateStatusData(['current']).find((a) => a.id === 'current').text}`,
                              selected: true
                          };
                      }
                  }) ?? []
              };
          },
          cache: true
      },
      minimumInputLength: 0,
      placeholder: 'Choose Employee',
      dropdownParent: $('#editFamilyModal .modal-body'),
      escapeMarkup: function (markup) { return markup; },
  });
  $('#editFamilyForm [name="employeeNIK"]').val(data.employeeNIK).trigger('change');

  if (data.employeeNIK) {
      var preselectedOption = new Option(
          `${data.employeeNIK} | ${data.employeeName} | ${generateStatusData(['current']).find((d) => d.id === 'current').text}`,
          data.employeeNIK,
          true, 
          true  
      );
      $('#editFamilyForm [name="employeeNIK"]').append(preselectedOption).trigger('change');
  }
});

$('#editFamilyForm #newFamilyNIK').change(function() {
  $('#editFamilyForm #newFamilyNIKInput').toggle();
  $('#editFamilyForm #newFamilyNIKInput').find('input').val('');
  $('#editFamilyForm #newFamilyNIKInput').find('.error-message').remove();
  $('#editFamilyForm #newFamilyNIKInput').find('.is-invalid').removeClass('is-invalid');
});

$('#editFamilyForm').on('submit', function(e) {
  e.preventDefault();
  removeCleaveFormat();
  var formData = new FormData(this);
  $.ajax({
      url: baseUrl + 'company/Families/editFamily',
      method: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      success: function(response) {
          var res = JSON.parse(response);
          res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
          if (res.status === 'success') {
              reloadTableData(familiesTable);
              displayAlert('edit success');
          } else if (res.status === 'failed') {
              $('.error-message').remove();
              $('.is-invalid').removeClass('is-invalid');
              formatPhoneInput();
              displayAlert(res.failedMsg, res.errorMsg ?? null);
          } else if (res.status === 'invalid') {
              formatPhoneInput();
              displayFormValidation('#editFamilyForm', res.errors);
          }
      }
  });
});

// Delete Family
$('#familiesTable').on('click', '.btn-delete', function() {
  var data = familiesTable.row($(this).parents('tr')).data();
  $('#deleteFamilyForm #familyName').html(data.familyName);
  $('#deleteFamilyForm [name="familyNIK"]').val(data.familyNIK);
});

$('#deleteFamilyForm').on('submit', function(e) {
  e.preventDefault();
  $.ajax({
      url: baseUrl + 'company/Families/deleteFamily', // URL untuk menghapus data
      method: 'POST',
      data: $(this).serialize(),
      success: function(response) {
          var res = JSON.parse(response);
          res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
          if (res.status === 'success') {
              reloadTableData(familiesTable);
              displayAlert('delete success');
          } else if (res.status === 'failed') {
              displayAlert(res.failedMsg, res.errorMsg ?? null);
          }
      }
  });
});