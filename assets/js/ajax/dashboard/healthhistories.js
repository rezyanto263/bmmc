// HealthHistories DataTable
var healthhistoriesTable = $("#healthhistoriesTable").DataTable($.extend(true, {}, DataTableSettings, {
  ajax: baseUrl + "dashboard/getAllHealthHistoriesDatas", 
  columns: [  
    {
      data: "healthhistoryDate",
      className: 'text-start',
      render: function(data, type, row) {
        if (type === 'display' || type === 'filter') {
          return `<span data-order="${data}">${moment(data).format('ddd, D MMMM YYYY')}</span>`;
        }
        return data;
      }
    },
    {data: "companyName"},
    {
      data: "patientNIK",
      className: 'text-start'
    },
    {data: "patientName"},
    {data: "patientDepartment"},
    {data: "patientBand"},
    {
      data: "patientRelationship",
      render: function(data) {
        return capitalizeWords(data);
      }
    },
    {
      data: "patientGender",
      className: 'text-center',
      render: function(data) {
        return data === 'male'? 'M' : 'F';
      }
    },
    {
      data: "status",
      render: function(data) {
        return generateStatusData([data]).find((d) => d.id === data).text
      }
    },
    {
      data: "invoiceStatus",
      render: function(data) {
        return generateStatusData([data]).find((d) => d.id === data).text
      }
    },
    {
      data: "healthhistoryDoctorFee",
      className: 'text-end',
      render: function(data = 0, type, row) {
        if (type === 'display' || type === 'filter') {
          return formatToRupiah(data, true, true);
        }
        return data;
      }
    },
    {
      data: "healthhistoryMedicineFee",
      className: 'text-end',
      render: function(data = 0, type, row) {
        if (type === 'display' || type === 'filter') {
          return formatToRupiah(data, true, true);
        }
        return data;
      }
    },
    {
      data: "healthhistoryLabFee",
      className: 'text-end',
      render: function(data = 0, type, row) {
        if (type === 'display' || type === 'filter') {
          return formatToRupiah(data, true, true);
        }
        return data;
      }
    },
    {
      data: "healthhistoryActionFee",
      className: 'text-end',
      render: function(data = 0, type, row) {
        if (type === 'display' || type === 'filter') {
          return formatToRupiah(data, true, true);
        }
        return data;
      }
    },
    {
      data: "healthhistoryDiscount",
      className: 'text-end',
      render: function(data = 0, type, row) {
        if (type === 'display' || type === 'filter') {
          return `<span class="text-danger">${formatToRupiah(data, true, true)}</span>`;
        }
        return data;
      }
    },
    {
      data: "healthhistoryTotalBill",
      className: 'text-end',
      render: function(data = 0, type, row) {
        if (type === 'display' || type === 'filter') {
          return `<span class="text-info">${formatToRupiah(data, true, true)}</span>`;
        }
        return data;
      }
    },
    {data: 'hospitalName'},
    {data: 'doctorName'},
    {
      data: "createdAt",
      className: "align-middle",
      render: function(data, type, row) {
          let timestamp = moment(data).valueOf();
          let formattedDate = moment(data).format('ddd, D MMMM YYYY HH:mm') + ' WITA';
          
          if (type === 'display' || type === 'filter') {
            return `<span data-order="${timestamp}">${formattedDate}</span>`;
          }

          return timestamp;
      }
    },
    {
      data: "updatedAt",
      className: "align-middle",
      render: function(data, type, row) {
          let timestamp = moment(data).valueOf();
          let formattedDate = moment(data).format('ddd, D MMMM YYYY HH:mm') + ' WITA';
          
          if (type === 'display' || type === 'filter') {
            return `<span data-order="${timestamp}">${formattedDate}</span>`;
          }

          return timestamp;
      }
    },
    {
      data: null,
      className:"text-end user-select-none no-export no-visibility",
      orderable: false,
      render: function(data, type, row, meta) {
        let editDisabled = ['finished'].includes(row.billingStatus);
        let deleteDisabled = ['paid', 'unpaid', 'free'].includes(row.invoiceStatus);
        return `
          <button 
              type="button"
              class="btn-view btn-primary rounded-2" 
              data-bs-toggle="modal" 
              data-bs-target="#viewHealthHistoryModal">
              <i class="fa-regular fa-eye"></i>
          </button>
          <button 
              type="button" 
              class="btn-edit btn-warning rounded-2 ${editDisabled && 'opacity-50'}" 
              ${editDisabled ? 'disabled style="cursor: default;"' : 'data-bs-toggle="modal" data-bs-target="#editHealthHistoryModal"'}>
              <i class="fa-regular fa-pen-to-square"></i>
          </button>
          <button 
              type="button" 
              class="btn-delete btn-danger rounded-2 ${deleteDisabled && 'opacity-50'}" 
              ${deleteDisabled ? 'disabled style="cursor: default;"' : 'data-bs-toggle="modal" data-bs-target="#deleteHealthHistoryModal"'}>
                  <i class="fa-solid fa-trash-can"></i>
          </button>
        `;
      },
    },
  ],
  order: [[0, 'desc']],
  columnDefs: [{ width: "120px", target: 17 }],
  buttons: [
    ...DataTableSettings.buttons
    .filter(button => button.className !== 'reload')
    .map((button) => {
      if (button.extend === 'colvis') {
        return $.extend(true, {}, button, {
          collectionLayout: "fixed two-column",
        });
      }
    }),
    {
      text: "Year",
      className: "btn btn-primary dropdown-toggle",
      action: function (e, dt, node, config) {
        if ($('#yearDropdown').length === 0) {
          var columnIndex = dt.column('healthhistoryDate:name').index();
          var list = [];
          dt.column(columnIndex).data().unique().each(function (value) {
              if (value) {
                  var item = moment(value, 'YYYY-MM-DD').format('YYYY');
                  if (!list.includes(item)) list.push(item);
              }
          });
          list.sort();
          createDropdown(node, list, 'year', 'YYYY');
        } else {
          $('#yearDropdown').fadeOut(300, function () {
            $('#yearDropdown').remove();
          });
        }
      }
    },
    {
      text: "Month",
      className: "btn btn-primary dropdown-toggle",
      action: function (e, dt, node, config) {
        if ($('#monthDropdown').length === 0) {
          var columnIndex = dt.column('healthhistoryDate:name').index();
          var list = [];
          dt.column(columnIndex).data().unique().each(function (value) {
            if (value) {
              var item = moment(value, 'YYYY-MM-DD').format('MM');
                  if (!list.includes(item)) list.push(item);
              }
          });
          list.sort();
          createDropdown(node, list, 'month', 'MM');
        } else {
          $('#monthDropdown').fadeOut(300, function () {
            $('#monthDropdown').remove();
          });
        }
      }
    },
    {
      text: '<i class="fa-solid fa-arrows-rotate fs-5 pt-1 px-0 px-md-1"></i>',
      className: '',
      action: function (e, dt, node, config) {
          dt.ajax.reload(null, false);
      }
    },
  ]
}));

// Year And Month Filter Dropdown
function createDropdown(node, list, type, format) {
  var id = `${type}Dropdown`;

  // Hapus dropdown lain sebelum menampilkan yang baru
  $('.dropdown-menu.show').fadeOut(300, function () {
      $(this).remove();
  });

  var selectedValue = type === 'year' ? selectedYear : selectedMonth;

  var html = `
      <div id="${id}" class="dropdown-menu show user-select-none" style="position: absolute; z-index: 1050; min-width: 200px; opacity: 0;">
          <a class="dropdown-item d-flex justify-content-between" data-value="" style="cursor: pointer;">
              <span>All ${type.charAt(0).toUpperCase() + type.slice(1)}</span>
              <span>${selectedValue === '' ? '✔' : ''}</span>
          </a>
          ${list.map(item => {
              let label = type === 'year' ? item : moment(item, 'MM').format('MMMM');
              return `
                  <a class="dropdown-item d-flex justify-content-between" data-value="${item}" style="cursor: pointer;">
                      <span>${label}</span>
                      <span>${selectedValue == item ? '✔' : ''}</span>
                  </a>
              `;
          }).join('')}
      </div>
  `;

  $(node).after(html);
  var $dropdown = $(`#${id}`);

  $dropdown.css({
      top: $(node).offset().top + $(node).outerHeight(),
      left: $(node).offset().left
  });

  setTimeout(() => {
    $dropdown.css({ 
        opacity: 1, 
        visibility: 'visible',
        transition: 'opacity 0.3s ease, visibility 0s linear'
    });
  }, 10);

  // Event klik pada item dropdown
  $dropdown.find('.dropdown-item').on('click', function () {
      var value = $(this).data('value');
      if (type === 'year') {
          selectedYear = value;
      } else {
          selectedMonth = value;
      }

      $dropdown.find('.dropdown-item span:last-child').text('');
      $(this).find('span:last-child').text('✔');

      applyDateFilter();
  });

  $(document).off('click.closeDropdown').on('click.closeDropdown', function (event) {
    if (!$(event.target).closest('.dropdown-menu.show, .btn-primary').length) {
      $dropdown.fadeOut(300, function () {
        $(this).remove();
      });
      $(document).off('click.closeDropdown');
    }
  });
}

function applyDateFilter() {
  healthhistoriesTable.columns(0).search(selectedYear ? `^${selectedYear}` : '', true, false);
  healthhistoriesTable.columns(0).search(selectedMonth ? `-${selectedMonth}-` : '', true, false);
  healthhistoriesTable.draw();
}


$('#addHealthHistoryForm, #editHealthHistoryForm').on('input', '[name="healthhistoryDoctorFee"], [name="healthhistoryMedicineFee"], [name="healthhistoryLabFee"], [name="healthhistoryActionFee"], [name="healthhistoryDiscount"]', function() {
  let form = $(this).closest('form');
  let subtotal = 0;

  form.find('[name="healthhistoryDoctorFee"], [name="healthhistoryMedicineFee"], [name="healthhistoryLabFee"], [name="healthhistoryActionFee"]').each(function() {
      let value = $(this).data('cleave') ? $(this).data('cleave').getRawValue() : $(this).val();
      subtotal += value && !isNaN(value) ? parseFloat(value) : 0;
  });

  let discountInput = form.find('[name="healthhistoryDiscount"]');
  let discountValue = discountInput.data('cleave') ? discountInput.data('cleave').getRawValue() : discountInput.val();
  discountValue = discountValue && !isNaN(discountValue) ? parseFloat(discountValue) : 0;

  if (discountValue >= subtotal) {
      discountValue = subtotal;
      if (discountInput.data('cleave')) {
          discountInput.data('cleave').setRawValue(discountValue);
      }
      discountInput.val(formatToRupiah(discountValue, true, false));
  }

  discountInput.attr('max', subtotal);

  let total = Math.max(subtotal - discountValue, 0);

  let totalBillInput = form.find('[name="healthhistoryTotalBill"]');

  if (totalBillInput.data('cleave')) {
      totalBillInput.data('cleave').setRawValue(total);
  }
  totalBillInput.val(formatToRupiah(total, true, false));
});




// Add Data
$('#addHealthHistoryModal').on('show.bs.modal', function() {
  $('#addHealthHistoryForm [name="companyId"]').select2({
    width: '1%',
    placeholder: 'Choose Company',
    ajax: {
      url: baseUrl + "dashboard/getAllCompaniesDatas",
      type: 'GET',
      dataType: 'json',
      delay: 250,
      processResults: function(response, params) {
        const searchTerm = params.term ? params.term.toLowerCase() : "";
        return {
          results: response.data
            .filter(d => {
              const companyName = d.companyName.toLowerCase().includes(searchTerm);
              const companyStatus = d.companyStatus.toLowerCase().includes(searchTerm);
              return companyName || companyStatus;
            })
            .map(d => {
              let companyImg = `${d.companyLogo ? baseUrl + "uploads/logos/" + d.companyLogo : baseUrl + "assets/images/company-placeholder.jpg"}`;
              let disabled = ['unverified', 'discontinued'].includes(d.companyStatus);
              return {
                id: d.companyId,
                text: `
                  <span class="d-flex align-items-center gap-1 ${disabled && 'opacity-50'}">
                    <img src="${companyImg}" class="rounded object-fit-contain" style="width: 28px; height: 28px;">
                    <div>
                      ${d.companyName} | 
                      ${generateStatusData([d.companyStatus]).find((data) => data.id === d.companyStatus).text}
                    </div>
                  </span>
                `,
                disabled: disabled,
              };
            }),
        };
      },
    },
    dropdownParent: $("#addHealthHistoryModal .modal-body"),
    escapeMarkup: function(markup) {
      return markup;
    }
  });

  let patientSelect = $('#addHealthHistoryForm [name="patientNIK"]');
  patientSelect.select2({
      placeholder: 'Choose Patient NIK',
      dropdownParent: $("#addHealthHistoryModal .modal-body"),
      disabled: true
  });

  let diseaseSelect = $('#addHealthHistoryForm [name="diseaseIds[]"]');
  diseaseSelect.select2({
    width: '1%',
    placeholder: 'Choose Disease',
    dropdownParent: $("#addHealthHistoryModal .modal-body"),
    disabled: true
  });
  setTimeout(() => {
    $('.select2-selection--multiple textarea').scrollTop(3.5);
  }, 200);

  $('#addHealthHistoryForm [name="companyId"]').on('change', function() {
    let companyId = $(this).val();

    if (companyId) {
      patientSelect.empty().select2({
        width: '1%',
        placeholder: 'Choose Patient NIK',
        disabled: false,
        ajax: {
          url: baseUrl + "dashboard/getAllPatientsData",
          type: 'GET',
          dataType: 'json',
          delay: 250,
          processResults: function(response, params) {
            const searchTerm = params.term ? params.term.toLowerCase() : "";
            return {
              results: response.data
              .filter(function(d) {
                if (d.companyId === companyId) {
                  const patientNIK = d.patientNIK.toLowerCase().includes(searchTerm);
                  const patientName = d.patientName.toLowerCase().includes(searchTerm);
                  const patientRole = d.patientRole.toLowerCase().includes(searchTerm);
                  const patientStatus = d.patientStatus.toLowerCase().includes(searchTerm);
                  const totalBillingRemaining = d.totalBillingRemaining.toLowerCase().includes(searchTerm);
                  return patientNIK || patientName || patientRole || patientStatus || totalBillingRemaining;
                }
              })
              .map((d) => {
                let disabled = ['unverified', 'discontinued', 'archived'].includes(d.patientStatus);
                return {
                  id: d.patientNIK,
                  text: `
                    <span class="${disabled && 'opacity-50'}">
                      ${d.patientNIK} - ${d.patientName} | 
                      ${capitalizeWords(d.patientRole)} | 
                      ${generateStatusData([d.patientStatus]).find((data) => data.id === d.patientStatus).text} |
                      ${formatToRupiah(d.totalBillingRemaining, true, false)}
                    </span>
                  `,
                  disabled: disabled,
                  patientRole: d.patientRole
                };
              }),
            };
          },
        },
        dropdownParent: $("#addHealthHistoryModal .modal-body"),
        escapeMarkup: function(markup) {
          return markup;
        }
      });

      diseaseSelect.empty().select2({
        width: '1%',
        placeholder: 'Choose Disease',
        disabled: false,
        ajax: {
          url: baseUrl + "dashboard/getCompanyDiseases?id=" + companyId,
          type: 'GET',
          dataType: 'json',
          delay: 250,
          processResults: function(response, params) {
            const searchTerm = params.term ? params.term.toLowerCase() : "";
            return {
              results: response.data
              .filter(d => {
                let coverage = d.diseaseStatus == 1 ? 'Covered' : 'Not Covered';
                let diseaseName = d.diseaseName.toLowerCase().includes(searchTerm);
                let dropdownDiseaseName = (`${d.diseaseName} | ${coverage}`).toLowerCase().includes(searchTerm);
                return diseaseName || dropdownDiseaseName;
              })
              .map(d => {
                let coverage = d.diseaseStatus == 1 ? 'Covered' : 'Not Covered';
                return {
                  id: d.diseaseId,
                  text: `${d.diseaseName} | ${coverage}`,
                }
              })
            };
          },
        },
        dropdownParent: $("#addHealthHistoryModal .modal-body"),
        escapeMarkup: function(markup) {
          return markup;
        }
      });
      setTimeout(() => {
        $('.select2-selection--multiple textarea').scrollTop(3.5);
      }, 200);
    } else {
      patientSelect.prop('disabled', true);
      diseaseSelect.prop('disabled', true);
    }
  });

  $('#addHealthHistoryForm [name="patientNIK"]').on('select2:select', function(e) {
    let selectedData = e.params.data;
    $('#addHealthHistoryForm [name="patientRole"]').val(selectedData.patientRole);
  });

  $('#addHealthHistoryForm [name="hospitalId"]').select2({
    placeholder: 'Choose Hospital',
    ajax: {
      url: baseUrl + "dashboard/getAllHospitalsDatas",
      type: 'GET',
      dataType: 'json',
      delay: 250,
      processResults: function (response, params) {
        const searchTerm = params.term ? params.term.toLowerCase() : "";
        return {
          results: response.data
            .filter(d => {
              const hospitalName = d.hospitalName.toLowerCase().includes(searchTerm);
              const hospitalStatus = d.hospitalStatus.toLowerCase().includes(searchTerm);
              return hospitalName || hospitalStatus;
            })
            .map(d => {
              let hospitalImg = `${d.hospitalLogo ? baseUrl + "uploads/logos/" + d.hospitalLogo : baseUrl + "assets/images/hospital-placeholder.jpg"}`;
              return {
                id: d.hospitalId,
                text: `
                  <span class="d-flex align-items-center gap-1">
                    <img src="${hospitalImg}" class="rounded object-fit-contain" style="width: 28px; height: 28px;">
                    <div>
                      ${d.hospitalName} | 
                      ${generateStatusData([d.hospitalStatus]).find((data) => data.id === d.hospitalStatus).text}
                    </div>
                  </span>
                `,
              };
            }),
        };
      },
    },
    dropdownParent: $("#addHealthHistoryModal .modal-body"),
    escapeMarkup: function (markup) {
        return markup;
    }
  });

  $('#addHealthHistoryForm #referredCheck').prop('disabled', true);
  $('#addHealthHistoryForm [name="hospitalId"]').on('change', function() {
    if ($('#addHealthHistoryForm [name="hospitalId"]').val() == '') {
      $('#addHealthHistoryForm #referredCheck').prop('disabled', true);
    } else {
      $('#addHealthHistoryForm #referredCheck').prop('disabled', false);
    }
  });

  let doctorSelect = $('#addHealthHistoryForm [name="doctorId"]');
  doctorSelect.select2({
      placeholder: 'Choose Doctor - Optional',
      dropdownParent: $("#addHealthHistoryModal .modal-body"),
      disabled: true
  });

  $('#addHealthHistoryForm [name="hospitalId"]').on('change', function() {
      doctorSelect.val(null).trigger('change');
      let hospitalId = $(this).val();
      
      if (hospitalId) {
          doctorSelect.select2({
              placeholder: 'Choose Doctor - Optional',
              disabled: false,
              ajax: {
                  url: baseUrl + "dashboard/getAllDoctorsByHospitalId?id=" + hospitalId,
                  type: 'GET',
                  dataType: 'json',
                  delay: 250,
                  processResults: function (response, params) {
                      const searchTerm = params.term ? params.term.toLowerCase() : "";
                      return {
                          results: response.data
                              .filter(d => {
                                const doctorName = d.doctorName.toLowerCase().includes(searchTerm);
                                const doctorSpecialization = d.doctorSpecialization.toLowerCase().includes(searchTerm);
                                return doctorName || doctorSpecialization;
                              })
                              .map(d => ({
                                  id: d.doctorId,
                                  text: `${d.doctorName} | ${d.doctorSpecialization}`,
                              }))
                      };
                  },
              },
              dropdownParent: $("#addHealthHistoryModal .modal-body")
          });
      } else {
          doctorSelect.prop('disabled', true).val(null).trigger('change');
      }
  });

  $('#addHealthHistoryForm #referredCheck').on('change', function() {
    if ($(this).is(':checked')) {
      $('#addHealthHistoryForm .referredInput').show();
      $('#addHealthHistoryForm [name="healthhistoryReferredTo"]').select2({
        placeholder: 'Choose Referred Hospital',
        ajax: {
          url: baseUrl + "dashboard/getAllHospitalsDatas",
          type: 'GET',
          dataType: 'json',
          delay: 250,
          processResults: function(response, params) {
            const searchTerm = params.term ? params.term.toLowerCase() : "";
            return {
              results: response.data
              .filter(d => {
                if (!(d.hospitalId == $('#addHealthHistoryForm [name="hospitalId"]').val())) {
                  return d.hospitalName.toLowerCase().includes(searchTerm)
                }
              })
              .map(d => {
                let hospitalImg = `${d.hospitalLogo ? baseUrl + "uploads/logos/" + d.hospitalLogo : baseUrl + "assets/images/hospital-placeholder.jpg"}`;
                return {
                  id: d.hospitalId,
                  text: `
                    <span class="d-flex align-items-center gap-1">
                    <img src="${hospitalImg}" class="rounded object-fit-contain" style="width: 28px; height: 28px;">
                    <div>
                      ${d.hospitalName} | 
                      ${generateStatusData([d.hospitalStatus]).find((data) => data.id === d.hospitalStatus).text}
                    </div>
                  </span>
                  `,
                };
              }),
            };
          }
        },
        dropdownParent: $("#addHealthHistoryModal .modal-body"),
        escapeMarkup: function(markup) {
          return markup;
        }
      });
      $('#addHealthHistoryForm [name="hospitalId"]').on('change', function() {
        if ($(this).val() === $('#addHealthHistoryForm [name="healthhistoryReferredTo"]').val()) {
          $('#addHealthHistoryForm [name="healthhistoryReferredTo"]').val(null).trigger('change');
        }
      });
    } else {
      $('#addHealthHistoryForm [name="healthhistoryReferredTo"]').select2('destroy');
      $('#addHealthHistoryForm [name="healthhistoryReferredTo"]').val(null).trigger('change');
      $('#addHealthHistoryForm .referredInput').hide();
    }
    $('.error-message').remove();
    $('.is-invalid').removeClass('is-invalid');
  }); 
});

$('#addHealthHistoryForm').on('submit', function(e) {
  e.preventDefault();
  removeCleaveFormat();
  $.ajax({
    url: baseUrl + 'dashboard/healthhistories/addHealthHistory',
    method: 'POST',
    data: $(this).serialize(),
    success: function(response) {
      let res = JSON.parse(response);
      res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
      if (res.status === 'success') {
        reloadTableData(healthhistoriesTable);
        displayAlert('add success');
      } else if (res.status === 'failed') {
        $('.error-message').remove();
        $('.is-invalid').removeClass('is-invalid');
        displayAlert(res.failedMsg, res.errorMsg ?? null);
        formatCurrencyInput();
      } else if (res.status === 'invalid') {
        displayFormValidation('#addHealthHistoryForm', res.errors);
        formatCurrencyInput();
      }
    }
  });
});



// View Data
$('#healthhistoriesTable').on('click', '.btn-view', function() {
  let data = healthhistoriesTable.row($(this).parents('tr')).data();
  $('#viewHealthHistoryModal #createdAt').html(moment(data.createdAt).format('dddd, DD MMMM YYYY HH:mm') + ' WITA');
  $('#viewHealthHistoryModal #updatedAt').html(moment(data.updatedAt).format('dddd, DD MMMM YYYY HH:mm') + ' WITA');

  data.patientPhoto && $('#viewHealthHistoryModal #patientPhoto').attr('src', `${baseUrl}uploads/profiles/${data.patientPhoto}`);
  data.companyLogo && $('#viewHealthHistoryModal #companyLogo').attr('src', `${baseUrl}uploads/logos/${data.companyLogo}`);
  
  let companyLogo = `${data.companyLogo ? baseUrl + "uploads/logos/" + data.companyLogo : baseUrl + "assets/images/company-placeholder.jpg"}`;
  $('#viewHealthHistoryModal #companyName').html(`
    <span class="d-flex align-items-center gap-1">
      <img src="${companyLogo}" class="rounded object-fit-contain" style="width: 28px; height: 28px;">
      <div>
        ${data.companyName}
      </div>
    </span>
  `);
  $('#viewHealthHistoryModal #patientNIK').html(data.patientNIK);
  $('#viewHealthHistoryModal #patientName').html(data.patientName);
  $('#viewHealthHistoryModal #patientDepartment').html(data.patientDepartment);
  $('#viewHealthHistoryModal #patientGender').html(capitalizeWords(data.patientGender));
  $('#viewHealthHistoryModal #patientBand').html(data.patientBand);
  $('#viewHealthHistoryModal #patientRelationship').html(capitalizeWords(data.patientRelationship));

  let hospitalLogo = `${data.hospitalLogo ? baseUrl + "uploads/logos/" + data.hospitalLogo : baseUrl + "assets/images/hospital-placeholder.jpg"}`;
  $('#viewHealthHistoryModal #hospitalName').html(`
    <span class="d-flex align-items-center gap-1">
      <img src="${hospitalLogo}" class="rounded object-fit-contain" style="width: 28px; height: 28px;">
      <div>
        ${data.hospitalName}
      </div>
    </span>
  `);

  $('#viewHealthHistoryModal #healthhistoryStatus').html(generateStatusData([data.status]).find((d) => d.id === data.status).text);
  $('#viewHealthHistoryModal #invoiceStatus').html(generateStatusData([data.invoiceStatus]).find((d) => d.id === data.invoiceStatus).text);
  if (data.healthhistoryReferredTo) {
    $('#viewHealthHistoryModal .referredInput').show();

    let referredHospitalLogo = `${data.referredHospitalLogo ? baseUrl + "uploads/logos/" + data.referredHospitalLogo : baseUrl + "assets/images/hospital-placeholder.jpg"}`;
    $('#viewHealthHistoryModal #healthhistoryReferredTo').html(`
      <span class="d-flex align-items-center gap-1">
        <img src="${referredHospitalLogo}" class="rounded object-fit-contain" style="width: 28px; height: 28px;">
        <div>
          ${data.referredHospitalName}
        </div>
      </span>
    `);
  }

  $('#viewHealthHistoryModal #healthhistoryDate').html(moment(data.healthhistoryDate).format('ddd, DD MMMM YYYY'));
  $('#viewHealthHistoryModal #doctorName').html(data.doctorName);
  $('#viewHealthHistoryModal #diseaseNames').html(data.diseaseNames);
  $('#viewHealthHistoryModal [name="healthhistoryDescription"]').val(data.healthhistoryDescription);
  $('#viewHealthHistoryModal #healthhistoryDoctorFee').html(formatToRupiah(data.healthhistoryDoctorFee, true, false));
  $('#viewHealthHistoryModal #healthhistoryMedicineFee').html(formatToRupiah(data.healthhistoryMedicineFee, true, false));
  $('#viewHealthHistoryModal #healthhistoryLabFee').html(formatToRupiah(data.healthhistoryLabFee, true, false));
  $('#viewHealthHistoryModal #healthhistoryActionFee').html(formatToRupiah(data.healthhistoryActionFee, true, false));
  $('#viewHealthHistoryModal #healthhistoryDiscount').html(formatToRupiah(data.healthhistoryDiscount, true, false));
  $('#viewHealthHistoryModal #healthhistoryTotalBill').html(formatToRupiah(data.healthhistoryTotalBill, true, false));
});

$('#viewHealthHistoryModal').on('hidden.bs.modal', function() {
  $('#viewHealthHistoryModal .referredInput').hide();
  $(this).find('#patientPhoto').prop('src', $(this).find('#patientPhoto').data('originalsrc'));
  $(this).find('#companyLogo').prop('src', $(this).find('#companyLogo').data('originalsrc'));
});



// Edit Data
$('#healthhistoriesTable').on('click', '.btn-edit', function() {
  let data = healthhistoriesTable.row($(this).parents('tr')).data();
  $('#editHealthHistoryForm [name="healthhistoryId"]').val(data.healthhistoryId);
  $('#editHealthHistoryForm [name="healthhistoryDate"]')[0]._flatpickr.setDate(data.healthhistoryDate);
  $('#editHealthHistoryForm [name="healthhistoryDescription"]').val(data.healthhistoryDescription);
  $('#editHealthHistoryForm [name="healthhistoryDoctorFee"]').val(formatToRupiah(data.healthhistoryDoctorFee, true, false));
  $('#editHealthHistoryForm [name="healthhistoryMedicineFee"]').val(formatToRupiah(data.healthhistoryMedicineFee, true, false));
  $('#editHealthHistoryForm [name="healthhistoryLabFee"]').val(formatToRupiah(data.healthhistoryLabFee, true, false));
  $('#editHealthHistoryForm [name="healthhistoryActionFee"]').val(formatToRupiah(data.healthhistoryActionFee, true, false));
  $('#editHealthHistoryForm [name="healthhistoryDiscount"]').val(formatToRupiah(data.healthhistoryDiscount, true, false));
  $('#editHealthHistoryForm [name="healthhistoryTotalBill"]').val(formatToRupiah(data.healthhistoryTotalBill, true, false));
  formatCurrencyInput();

  $('#editHealthHistoryForm [name="companyId"]').select2({
    width: '1%',
    placeholder: 'Choose Company',
    disabled: ['unverified', 'discontinued'].includes(data.companyStatus),
    ajax: {
      url: baseUrl + "dashboard/getAllCompaniesDatas",
      type: 'GET',
      dataType: 'json',
      delay: 250,
      processResults: function(response, params) {
        const searchTerm = params.term ? params.term.toLowerCase() : "";
        return {
          results: response.data
            .filter(d => {
              const companyName = d.companyName.toLowerCase().includes(searchTerm);
              const companyStatus = d.companyStatus.toLowerCase().includes(searchTerm);
              return companyName || companyStatus;
            })
            .map(d => {
              let companyImg = `${d.companyLogo ? baseUrl + "uploads/logos/" + d.companyLogo : baseUrl + "assets/images/company-placeholder.jpg"}`;
              let disabled = ['unverified', 'discontinued'].includes(d.companyStatus);
              return {
                id: d.companyId,
                text: `
                  <span class="d-flex align-items-center gap-1 ${disabled && 'opacity-50'}">
                    <img src="${companyImg}" class="rounded object-fit-contain" style="width: 28px; height: 28px;">
                    <div>
                      ${d.companyName} | 
                      ${generateStatusData([d.companyStatus]).find((data) => data.id === d.companyStatus).text}
                    </div>
                  </span>
                `,
                disabled: disabled
              };
            }),
        };
      },
    },
    dropdownParent: $("#editHealthHistoryModal .modal-body"),
    escapeMarkup: function(markup) {
      return markup;
    }
  })

  let companyImg = `${data.companyLogo ? baseUrl + "uploads/logos/" + data.companyLogo : baseUrl + "assets/images/company-placeholder.jpg"}`;
  let selectedCompanyOption = new Option(`
      <span class="d-flex align-items-center gap-1 ${['unverified', 'discontinued'].includes(data.companyStatus) && 'opacity-50'}">
        <img src="${companyImg}" class="rounded object-fit-contain" style="width: 28px; height: 28px;">
        <div>
          ${data.companyName} | 
          ${generateStatusData([data.companyStatus]).find((d) => d.id === data.companyStatus).text}
        </div>
      </span>
    `, data.companyId, true, true);
  $('#editHealthHistoryForm [name="companyId"]').append(selectedCompanyOption).trigger('change');

  $('#editHealthHistoryForm [name="companyId"]').on('change', function() {
    patientSelect.val(null).trigger('change');
    let companyId = $(this).val();
    selectPatientByCompanyId(companyId);
    selectDiseaseByCompanyId(companyId);
  });


  var patientSelect = $('#editHealthHistoryForm [name="patientNIK"]');
  function selectPatientByCompanyId(companyId) {
    patientSelect.select2({
      width: '1%',
      placeholder: 'Choose Patient NIK',
      disabled: false,
      ajax: {
        url: baseUrl + "dashboard/getAllPatientsData",
        type: 'GET',
        dataType: 'json',
        delay: 250,
        processResults: function(response, params) {
          const searchTerm = params.term ? params.term.toLowerCase() : "";
          return {
            results: response.data
            .filter(function(d) {
              if (d.companyId === companyId) {
                const patientNIK = d.patientNIK.toLowerCase().includes(searchTerm);
                const patientName = d.patientName.toLowerCase().includes(searchTerm);
                const patientRole = d.patientRole.toLowerCase().includes(searchTerm);
                const patientStatus = d.patientStatus.toLowerCase().includes(searchTerm);
                const totalBillingRemaining = d.totalBillingRemaining.toLowerCase().includes(searchTerm);
                return patientNIK || patientName || patientRole || patientStatus || totalBillingRemaining;
              }
            })
            .map((d) => {
              let disabled = ['unverified', 'discontinued', 'archived'].includes(d.patientStatus);
              return {
                id: d.patientNIK,
                text: `
                    ${d.patientNIK} - ${d.patientName} | 
                    ${capitalizeWords(d.patientRole)} | 
                    ${generateStatusData([d.patientStatus]).find((dt) => dt.id === d.patientStatus).text} |
                    ${formatToRupiah(d.totalBillingRemaining, true, false)}
                `,
                disabled: disabled,
                patientRole: d.patientRole
              };
            }),
          };
        },
      },
      dropdownParent: $("#editHealthHistoryModal .modal-body"),
      escapeMarkup: function(markup) {
        return markup;
      }
    });
  }

  selectPatientByCompanyId(data.companyId);
  $.ajax({
    url: baseUrl + 'dashboard/getAllPatientsData',
    type: 'GET',
    success: function(response) {
      response.data.forEach(function(d) {
        if(d.patientNIK === data.patientNIK) {
          let selectedPatientOption = new Option(`
            <span class="${['unverified', 'discontinued', 'archived'].includes(d.patientStatus) && 'opacity-50'}">
              ${data.patientNIK} - ${data.patientName} | 
              ${capitalizeWords(data.patientRole)} | 
              ${generateStatusData([d.patientStatus]).find((dt) => dt.id === d.patientStatus).text} |
              ${formatToRupiah(d.totalBillingRemaining, true, false)}
            </span>
            `, data.patientNIK, true, true);
          patientSelect.append(selectedPatientOption).trigger('change');
          $('#editHealthHistoryForm [name="patientRole"]').val(data.patientRole);
        }
      });
    }
  });

  $('#editHealthHistoryForm [name="patientNIK"]').on('select2:select', function(e) {
    let selectedData = e.params.data;
    $('#editHealthHistoryForm [name="patientRole"]').val(selectedData.patientRole);
  });


  var diseaseSelect = $('#editHealthHistoryForm [name="diseaseIds[]"]');
  function selectDiseaseByCompanyId(companyId) {
    diseaseSelect.empty().select2({
      width: '1%',
      placeholder: 'Choose Disease',
      ajax: {
        url: baseUrl + "dashboard/getCompanyDiseases?id=" + companyId,
        type: 'GET',
        dataType: 'json',
        delay: 250,
        processResults: function(response, params) {
          const searchTerm = params.term ? params.term.toLowerCase() : "";
          return {
            results: response.data
            .filter(d => {
              let coverage = d.diseaseStatus == 1 ? 'Covered' : 'Not Covered';
              let diseaseName = d.diseaseName.toLowerCase().includes(searchTerm);
              let dropdownDiseaseName = (`${d.diseaseName} | ${coverage}`).toLowerCase().includes(searchTerm);
              return diseaseName || dropdownDiseaseName;
            })
            .map(d => {
              let coverage = d.diseaseStatus == 1 ? 'Covered' : 'Not Covered';
              return {
                id: d.diseaseId,
                text: `${d.diseaseName} | ${coverage}`,
              }
            })
          };
        },
      },
      dropdownParent: $("#editHealthHistoryModal .modal-body"),
      escapeMarkup: function(markup) {
        return markup;
      }
    });
  }

  selectDiseaseByCompanyId(data.companyId);
  $.ajax({
    url: baseUrl + 'dashboard/getCompanyDiseases?id=' + data.companyId,
    type: 'GET',
    success: function(response) {
      let res = JSON.parse(response);
      res.data.forEach(function(d) {
        if(data.diseaseNames.split(', ').includes(d.diseaseName.toString())) {
          let coverage = data.diseaseStatus == 1 ? 'Covered' : 'Not Covered';
          let selectedDiseaseOption = new Option(`${d.diseaseName} | ${coverage}`, d.diseaseId, true, true);
          $('#editHealthHistoryForm [name="diseaseIds[]"]').append(selectedDiseaseOption).trigger('change');
        }
      });
    }
  });

  $('#editHealthHistoryModal').on('shown.bs.modal', function() {
    setTimeout(() => {
      $('.select2-selection--multiple textarea').scrollTop(3.5);
    }, 200);
  });


  $('#editHealthHistoryForm [name="hospitalId"]').select2({
    width: '1%',
    placeholder: 'Choose Hospital',
    ajax: {
      url: baseUrl + "dashboard/getAllHospitalsDatas",
      type: 'GET',
      dataType: 'json',
      delay: 250,
      processResults: function(response, params) {
        const searchTerm = params.term ? params.term.toLowerCase() : "";
        return {
          results: response.data
            .filter(d => {
              const hospitalName = d.hospitalName.toLowerCase().includes(searchTerm);
              const hospitalStatus = d.hospitalStatus.toLowerCase().includes(searchTerm);
              return hospitalName || hospitalStatus;
            })  
            .map(d => {
              let hospitalImg = `${d.hospitalLogo ? baseUrl + "uploads/logos/" + d.hospitalLogo : baseUrl + "assets/images/hospital-placeholder.jpg"}`;
              let disabled = ['unverified', 'discontinued'].includes(d.hospitalStatus);
              return {
                id: d.hospitalId,
                text: `
                  <span class="d-flex align-items-center gap-1 ${disabled && 'opacity-50'}">
                    <img src="${hospitalImg}" class="rounded object-fit-contain" style="width: 28px; height: 28px;">
                    <div>
                      ${d.hospitalName} | 
                      ${generateStatusData([d.hospitalStatus]).find((data) => data.id === d.hospitalStatus).text}
                    </div>
                  </span>
                `,
                disabled: disabled
              };
            }),
        }
      },
    },
    dropdownParent: $("#editHealthHistoryModal .modal-body"),
    escapeMarkup: function(markup) {
      return markup;
    }
  });

  $.ajax({
    url: baseUrl + 'dashboard/getAllHospitalsDatas',
    type: 'GET',
    success: function(response) {
      let res = JSON.parse(response);
      res.data.forEach(function(d) {
        if(d.hospitalId === data.hospitalId) {
          let hospitalImg = `${d.hospitalLogo ? baseUrl + "uploads/logos/" + d.hospitalLogo : baseUrl + "assets/images/hospital-placeholder.jpg"}`;
          let selectedHospitalOption = new Option(`
            <span class="d-flex align-items-center gap-1 ${['unverified', 'discontinued'].includes(d.hospitalStatus) && 'opacity-50'}">
              <img src="${hospitalImg}" class="rounded object-fit-contain" style="width: 28px; height: 28px;">
              <div>
                ${d.hospitalName} | 
                ${generateStatusData([d.hospitalStatus]).find((dt) => dt.id === d.hospitalStatus).text}
              </div>
            </span>
            `, d.hospitalId, true, true);
          $('#editHealthHistoryForm [name="hospitalId"]').append(selectedHospitalOption).trigger('change');
        }
      });
    }
  });


  function selectDoctorByHospitalId(hospitalId) {
    $('#editHealthHistoryForm [name="doctorId"]').select2({
      width: '1%',
      placeholder: 'Choose Doctor - Optional',
      ajax: {
        url: baseUrl + "dashboard/getAllDoctorsByHospitalId?id=" + hospitalId,
        type: 'GET',
        dataType: 'json',
        delay: 250,
        processResults: function(response, params) {
          const searchTerm = params.term ? params.term.toLowerCase() : "";
          return {
            results: response.data
              .filter(d => {
                const doctorName = d.doctorName.toLowerCase().includes(searchTerm);
                const doctorStatus = d.doctorStatus.toLowerCase().includes(searchTerm);
                return doctorName || doctorStatus;
              })  
              .map(d => {
                let disabled = ['unverified', 'discontinued'].includes(d.doctorStatus);
                return {
                  id: d.doctorId,
                  text: `
                    <span class="d-flex align-items-center gap-1 ${disabled && 'opacity-50'}">
                      ${d.doctorName} | 
                      ${generateStatusData([d.doctorStatus]).find((dt) => dt.id === d.doctorStatus).text}
                    </span>
                  `,
                  disabled: disabled
                };
              }),
          }
        }
      },
      dropdownParent: $("#editHealthHistoryModal .modal-body"),
      escapeMarkup: function(markup) {
        return markup;
      }
    });

    $.ajax({
      url: baseUrl + 'dashboard/getAllDoctorsByHospitalId?id=' + data.hospitalId,
      type: 'GET',
      success: function(response) {
        response.data.forEach(function(d) {
          if(d.doctorId === data.doctorId && d.hospitalId === data.hospitalId) {
            let selectedDoctorOption = new Option(`
              <span class="d-flex align-items-center gap-1 ${['unverified', 'discontinued'].includes(d.doctorStatus) && 'opacity-50'}">
                ${d.doctorName} | 
                ${generateStatusData([d.doctorStatus]).find((dt) => dt.id === d.doctorStatus).text}
              </span>
              `, d.doctorId, true, true);
            $('#editHealthHistoryForm [name="doctorId"]').append(selectedDoctorOption).trigger('change');
          }
        });
      }
    });
  }

  $('#editHealthHistoryForm [name="hospitalId"]').off('change').on('change', function() {
    $('#editHealthHistoryForm [name="doctorId"]').val(null).trigger('change');
    let hospitalId = $(this).val();
    selectDoctorByHospitalId(hospitalId);
  });

  selectDoctorByHospitalId(data.hospitalId);

  function selectReferredHospital() {
    $('#editHealthHistoryForm [name="healthhistoryReferredTo"]').empty().select2({
      placeholder: 'Choose Referred Hospital',
      ajax: {
        url: baseUrl + "dashboard/getAllHospitalsDatas",
        type: 'GET',
        dataType: 'json',
        delay: 250,
        processResults: function(response, params) {
          const searchTerm = params.term ? params.term.toLowerCase() : "";
          return {
            results: response.data
            .filter(d => d.hospitalId !== $('#editHealthHistoryForm [name="hospitalId"]').val() && d.hospitalName.toLowerCase().includes(searchTerm))
            .map(d => {
              let hospitalImg = `${d.hospitalLogo ? baseUrl + "uploads/logos/" + d.hospitalLogo : baseUrl + "assets/images/hospital-placeholder.jpg"}`;
              return {
                id: d.hospitalId,
                text: `
                  <span class="d-flex align-items-center gap-1">
                  <img src="${hospitalImg}" class="rounded object-fit-contain" style="width: 28px; height: 28px;">
                  <div>
                    ${d.hospitalName} | 
                    ${generateStatusData([d.hospitalStatus]).find((data) => data.id === d.hospitalStatus).text}
                  </div>
                </span>
                `,
              };
            }),
          };
        }
      },
      dropdownParent: $("#editHealthHistoryModal .modal-body"),
      escapeMarkup: function(markup) {
        return markup;
      }
    });

    $.ajax({
      url: baseUrl + 'dashboard/getAllHospitalsDatas',
      type: 'GET',
      success: function(response) {
        let res = JSON.parse(response);
        res.data.forEach(function(d) {
          if(d.hospitalId === data.healthhistoryReferredTo) {
            if ($('#editHealthHistoryForm [name="hospitalId"]').val() == data.healthhistoryReferredTo) {
              $('#editHealthHistoryForm [name="healthhistoryReferredTo"]').val(null).trigger('change');
            } else {
              let selectedReferredHospitalOption = new Option(`
                <span class="d-flex align-items-center gap-1">
                  <img src="${d.hospitalLogo ? baseUrl + 'uploads/logos/' + d.hospitalLogo : baseUrl + 'assets/images/hospital-placeholder.jpg'}" class="rounded object-fit-contain" style="width: 28px; height: 28px;">
                  <div>
                    ${d.hospitalName} |
                    ${generateStatusData([d.hospitalStatus]).find((dt) => dt.id === d.hospitalStatus).text}
                  </div>
                </span>
                `, d.hospitalId, true, true);
              $('#editHealthHistoryForm [name="healthhistoryReferredTo"]').append(selectedReferredHospitalOption).trigger('change');
            }
          }
        });
      }
    });
  }

  if (data.healthhistoryReferredTo !== null) {
    $('#editHealthHistoryForm #referredCheck').prop('checked', true);
    $('#editHealthHistoryForm .referredInput').show();
    selectReferredHospital();
  }
  
  $('#editHealthHistoryForm #referredCheck').off('change').on('change', function() {
    if ($(this).is(':checked')) {
      $('#editHealthHistoryForm .referredInput').show();
      selectReferredHospital();
      $('#editHealthHistoryForm [name="hospitalId"]').on('change', function() {
        if ($(this).val() === $('#editHealthHistoryForm [name="healthhistoryReferredTo"]').val()) {
          $('#editHealthHistoryForm [name="healthhistoryReferredTo"]').val(null).trigger('change');
        }
      });
    } else {
      $('#editHealthHistoryForm [name="healthhistoryReferredTo"]').select2('destroy');
      $('#editHealthHistoryForm [name="healthhistoryReferredTo"]').val(null).trigger('change');
      $('#editHealthHistoryForm .referredInput').hide();
    }
    $('.error-message').remove();
    $('.is-invalid').removeClass('is-invalid');
  });
});

$('#editHealthHistoryForm').on('submit', function(e) {
  e.preventDefault();
  removeCleaveFormat();
  console.log($(this).serialize());
  $.ajax({
    url: baseUrl + 'dashboard/healthhistories/editHealthHistory',
    method: 'POST',
    data: $(this).serialize(),
    success: function(response) {
      console.log(response);
      let res = JSON.parse(response);
      res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
      if (res.status === 'success') {
        reloadTableData(healthhistoriesTable);
        displayAlert('edit success');
      } else if (res.status === 'failed') {
        $('.error-message').remove();
        $('.is-invalid').removeClass('is-invalid');
        displayAlert(res.failedMsg, res.errorMsg ?? null);
        formatCurrencyInput();
      } else if (res.status === 'invalid') {
        displayFormValidation('#editHealthHistoryForm', res.errors);
        formatCurrencyInput();
      }
    }
  });
});




// Delete Data

$('#healthhistoriesTable').on('click', '.btn-delete', function() {
  let data = healthhistoriesTable.row($(this).parents('tr')).data();
  $('#deleteHealthHistoryForm [name="healthhistoryId"]').val(data.healthhistoryId);
  $('#deleteHealthHistoryForm #patientName').html(data.patientName);
  $('#deleteHealthHistoryForm #healthhistoryDate').html(moment(data.healthhistoryDate).format('ddd, D MMMM YYYY'));
});


$('#deleteHealthHistoryForm').on('submit', function(e) {
  e.preventDefault();
  $.ajax({
    url: baseUrl + 'dashboard/healthhistories/deleteHealthHistory',
    method: 'POST',
    data: $(this).serialize(),
    success: function(response) {
      let res = JSON.parse(response);
      res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
      if (res.status === 'success') {
        reloadTableData(healthhistoriesTable);
        displayAlert('delete success');
      } else if (res.status === 'failed') {
        displayAlert(res.failedMsg, res.errorMsg ?? null);
      }
    }
  });
});