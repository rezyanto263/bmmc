// Queues DataTable
var queuesTable = $('#queuesTable').DataTable($.extend(true, {}, DataTableSettings, {
  ajax: baseUrl + 'hospital/getHospitalQueueDatas', 
  columns: [
      {
        data: 'companyLogo',
        className: "align-middle user-select-none no-export",
        orderable: false,
        render: function (data, type, row) {
          let logo = data
            ? `${baseUrl}uploads/logos/${data}`
            : `${baseUrl}assets/images/company-placeholder.jpg`;
          return `
              <div class="rounded overflow-hidden border border-secondary-subtl d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                  <img class="img-fluid" src="${logo}">
              </div>
          `;
        },
      },
      {data: 'companyName'},
      {
        data: 'companyStatus',
        render: function (data, type, row) {
          if (type === 'display' || type === 'filter') {
            return generateStatusData([data]).find((d) => d.id === data).text;
          }
          return data;
        }
      },
      {
        data: 'patientNIK',
        className: 'text-start'
      },
      {data: 'patientName'},
      {
          data: 'patientRelationship',
          className: 'text-center',
          render: function (data, type, row) {
            return capitalizeWords(data);
          }
      },
      {
				data: "createdAt",
        className: 'text-start',
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
          className: 'text-end user-select-none no-export no-visibility',
          orderable: false,
          defaultContent: `
              <button 
                  type="button" 
                  class="btn-view btn-primary rounded-2" 
                  data-bs-toggle="modal" 
                  data-bs-target="#viewPatientDetailsModal"
                  title="View Patient Details">
                    <i class="fa-regular fa-eye"></i>
              </button>
              <button 
                  type="button" 
                  class="btn-add btn-secondary rounded-2" 
                  data-bs-toggle="modal" 
                  data-bs-target="#addHealthHistoryModal"
                  title="Proceed Treatment">
                      <i class="fa-solid fa-file-waveform"></i>
              </button>
              <button 
                  type="button" 
                  class="btn-delete btn-danger rounded-2" 
                  data-bs-toggle="modal" 
                  data-bs-target="#deleteQueueModal" 
                  title="Remove from Queue">
                      <i class="fa-solid fa-trash-can"></i>
              </button>
          `
      }
  ],
  columnDefs: [
      {width: '120px', targets: 6}
  ]
}));

$('#addTreatmentButton, #addReferralButton, #deleteQueueButton').on('click', function() {
  reloadTableData(queuesTable);
});


// Proceed Treatment
$('#queuesTable').on('click', '.btn-add', function() {
  let data = queuesTable.row($(this).parents('tr')).data();
  var totalBillingRemaining;
  
  $('#addHealthHistoryModal').on('shown.bs.modal', function() {
    let companyImg = data.companyLogo ? `${baseUrl}/uploads/logos/${data.companyLogo}` : `${baseUrl}/assets/images/company-placeholder.jpg`;
    $('#addHealthHistoryForm #companyId').html(`
      <span class="d-flex align-items-center gap-1">
      <img src="${companyImg}" class="rounded object-fit-contain" style="width: 28px; height: 28px;">
      <div>
      ${data.companyName} | 
      ${generateStatusData([data.companyStatus]).find((d) => d.id === data.companyStatus).text}
      </div>
      </span>
      `);
    $('#addHealthHistoryForm [name="companyId"]').val(data.companyId);


    $.ajax({
      url: `${baseUrl}hospital/getQueuedPatientByNIK?nik=${data.patientNIK}&role=${data.patientRole}`,
      method: 'GET',
      success: function(response) {
        let res = JSON.parse(response).data;
        totalBillingRemaining = res.totalBillingRemaining;
        $('#addHealthHistoryForm #patientNIK').html(`
          <span>
            ${res.patientNIK} - ${res.patientName} | 
            ${capitalizeWords(res.patientRole)} | 
            ${generateStatusData([res.patientStatus]).find((d) => d.id === res.patientStatus).text} |
            ${formatToRupiah(res.totalBillingRemaining, true, false)}
          </span>
        `);
        $('#addHealthHistoryForm [name="patientNIK"]').val(res.patientNIK);
        $('#addHealthHistoryForm [name="patientRole"]').val(res.patientRole);
      },
      error: function(xhr, textStatus, errorThrown) {
        console.log(xhr.responseText);
      }
    })
  
  
    let hospitalImg = data.hospitalLogo ? `${baseUrl}/uploads/logos/${data.hospitalLogo}` : `${baseUrl}/assets/images/hospital-placeholder.jpg`;
    $('#addHealthHistoryForm #hospitalId').html(`
      <span class="d-flex align-items-center gap-1">
        <img src="${hospitalImg}" class="rounded object-fit-contain" style="width: 28px; height: 28px;">
        <div>
          ${data.hospitalName} | 
          ${generateStatusData([data.hospitalStatus]).find((d) => d.id === data.hospitalStatus).text}
        </div>
      </span>
    `);
    $('#addHealthHistoryForm [name="hospitalId"]').val(data.hospitalId);
  
  
    $('#addHealthHistoryForm [name="diseaseIds[]"]').empty().select2({
      width: '1%',
      placeholder: 'Choose Disease',
      disabled: false,
      ajax: {
        url: baseUrl + "hospital/getCompanyDiseases?id=" + data.companyId,
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
              let disabled = d.diseaseStatus == 1 ? false : true;
              let coverage = disabled ? 'Not Covered' : 'Covered'
              return {
                id: d.diseaseId,
                text: `${d.diseaseName} | ${coverage}`,
                disabled: disabled
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
  
  
    $('#addHealthHistoryForm [name="doctorId"]').select2({
        placeholder: 'Choose Doctor - Optional',
        disabled: false,
        ajax: {
            url: baseUrl + "hospital/getAllDoctorsByHospitalId?id=" + data.hospitalId,
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
  
  
    $('#addHealthHistoryForm #referredCheck').on('change', function() {
      if ($(this).is(':checked')) {
        $('#addHealthHistoryForm .referredInput').show();
        $('#addHealthHistoryForm [name="healthhistoryReferredTo"]').select2({
          placeholder: 'Choose Referred Hospital',
          ajax: {
            url: baseUrl + "hospital/getAllHospitalsDatas",
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
      } else {
        $('#addHealthHistoryForm [name="healthhistoryReferredTo"]').select2('destroy');
        $('#addHealthHistoryForm [name="healthhistoryReferredTo"]').val(null).trigger('change');
        $('#addHealthHistoryForm .referredInput').hide();
      }
      $('.error-message').remove();
      $('.is-invalid').removeClass('is-invalid');
    });
  });


  $('#addHealthHistoryForm').on('input', '[name="healthhistoryDoctorFee"], [name="healthhistoryMedicineFee"], [name="healthhistoryLabFee"], [name="healthhistoryActionFee"], [name="healthhistoryDiscount"]', function() {
    let form = $(this).closest('form');
    let subtotal = 0;
  
    form.find('[name="healthhistoryDoctorFee"], [name="healthhistoryMedicineFee"], [name="healthhistoryLabFee"], [name="healthhistoryActionFee"]').each(function() {
        let value = $(this).data('cleave') ? $(this).data('cleave').getRawValue() : $(this).val();
        subtotal += value && !isNaN(value) ? parseFloat(value) : 0;
    });

    if (subtotal > totalBillingRemaining) {
      let lastInput = $(this);
      let lastValue = lastInput.data('cleave') ? lastInput.data('cleave').getRawValue() : lastInput.val();
      let excessAmount = subtotal - totalBillingRemaining;
      let adjustedValue = Math.max(parseFloat(lastValue) - excessAmount, 0);
      
      if (lastInput.data('cleave')) {
          lastInput.data('cleave').setRawValue(adjustedValue);
      }
      lastInput.val(formatToRupiah(adjustedValue, true, false));

      subtotal = totalBillingRemaining; // Set subtotal agar tetap dalam batas
    }
  
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
});

$('#addHealthHistoryForm').on('submit', function(e) {
  e.preventDefault();
  removeCleaveFormat();
  $.ajax({
      url: baseUrl + 'hospital/healthhistories/addHealthHistory',
      method: 'POST',
      data: $(this).serialize(),
      success: function(response) {
          var res = JSON.parse(response);
          res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
          if (res.status === 'success') {
              reloadTableData(queuesTable);
              displayAlert('add success');
          } else if (res.status === 'failed') {
              $('.error-message').remove();
              $('.is-invalid').removeClass('is-invalid');
              displayAlert(res.failedMsg);
          } else if (res.status === 'invalid') {
              displayFormValidation('#addHealthHistoryForm', res.errors);
          }
      }
  });
});



// View Data
$('#queuesTable').on('click', '.btn-view', function() {
  let data = queuesTable.row($(this).parents('tr')).data();

  $.ajax({
    url: `${baseUrl}hospital/getQueuedPatientDetails?nik=${data.patientNIK}&role=${data.patientRole}`,
    method: 'GET',
    success: function (response) {
      let res = JSON.parse(response);
      const pro = res.data.profile;
      const ins = res.data.insurance;

      var photo = pro.employeePhoto || pro.familyPhoto;
      var status = pro.employeeStatus || pro.familyStatus;
      $('#viewPatientDetailsModal #imgPreview').attr('src', photo ? `${baseUrl}uploads/profiles/${photo}` : `${baseUrl}assets/images/user-placeholder.png`);

      var totalBillingRemaining = pro.insuranceAmount - ins.totalBillingUsedThisMonth;
      const fields = [
          { id: 'nik', value: pro.familyNIK || pro.employeeNIK },
          { id: 'name', value: pro.employeeName || pro.familyName },
          { id: 'role', value: pro.familyNIK ? 'family' : 'employee' },
          { id: 'relationship', value: capitalizeWords(pro.familyRelationship) },
          { id: 'department', value: pro.employeeDepartment },
          { id: 'band', value: pro.employeeBand },
          { id: 'birth', value: moment(pro.employeeBirth || pro.familyBirth).format('dddd, D MMMM YYYY') },
          { id: 'gender', value: capitalizeWords(pro.employeeGender || pro.familyGender) },
          { id: 'companyName', value: pro.companyName },
          { id: 'email', value: pro.employeeEmail || pro.familyEmail },
          { id: 'phone', value: pro.employeePhone || pro.familyPhone },
          { id: 'address', value: pro.employeeAddress || pro.familyAddress },
          { id: 'status', value: generateStatusData([status]).find((d) => d.id === status).text },
          { id: 'companyStatus', value: generateStatusData([pro.companyStatus]).find((d) => d.id === pro.companyStatus).text },
          { id: 'totalTreatmentsThisMonth', value: ins.totalTreatmentsThisMonth },
          { id: 'totalBilledTreatmentsThisMonth', value: ins.totalBilledTreatmentsThisMonth },
          { id: 'totalReferredTreatmentsThisMonth', value: ins.totalReferredTreatmentsThisMonth },
          { id: 'totalFreeTreatmentsThisMonth', value: ins.totalFreeTreatmentsThisMonth },
          { id: 'totalTreatments', value: ins.totalTreatments },
          { id: 'totalBilledTreatments', value: ins.totalBilledTreatments },
          { id: 'totalReferredTreatments', value: ins.totalReferredTreatments },
          { id: 'totalFreeTreatments', value: ins.totalFreeTreatments },
          { id: 'totalBillingRemaining', value: formatToRupiah(totalBillingRemaining) },
          { id: 'insuranceTier', value: pro.insuranceTier },
          { id: 'totalBillingUsed', value: formatToRupiah(ins.totalBillingUsedThisMonth, false, false) },
          { id: 'totalBillingAmount', value: formatToRupiah(pro.insuranceAmount, false, false) },
      ];

      fields.forEach(field => {
          $(`#viewPatientDetailsModal #${field.id}`).html(field.value);
      });

      getPatientHealthHistory(pro.employeeNIK || pro.familyNIK, pro.familyNIK ? 'family' : 'employee');
    },
    error: function(xhr, status, error) {
        console.error('AJAX Error!');
        console.error('Status:', status);
        console.error('Error:', error);
        console.error('Response:', xhr.responseText);
    }
  });
});

var queuedPatientHealthHistoriesTable;
function getPatientHealthHistory(patientNIK, patientRole) {
    if ($.fn.DataTable.isDataTable('#queuedPatientHealthHistoriesTable')) {
        $('#queuedPatientHealthHistoriesTable').DataTable().ajax.url(baseUrl + 'hospital/getPatientHealthHistoryDetailsByNIK?nik=' + patientNIK + '&role=' + patientRole).load();
        return;
    }
    queuedPatientHealthHistoriesTable = $('#queuedPatientHealthHistoriesTable').DataTable($.extend(true, {}, DataTableSettings, {
        ajax: baseUrl + 'hospital/getPatientHealthHistoryDetailsByNIK?nik=' + patientNIK + '&role=' + patientRole,
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
                className:"text-end user-select-none no-export no-visibility text-center",
                orderable: false,
                defaultContent: `
                    <button 
                        type="button"
                        class="btn-view btn-primary rounded-2">
                        <i class="fa-regular fa-eye"></i>
                    </button>
                `
            },
        ],
        order: [[0, 'desc']],
        columnDefs: [{ width: "40px", target: 16 }],
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
                    createDropdownInModal(node, list, 'year', 'YYYY');
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
                        createDropdownInModal(node, list, 'month', 'MM');
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
}

function createDropdownInModal(node, list, type, format) {
    var id = `${type}Dropdown`;

    // Hapus dropdown lain sebelum menampilkan yang baru
    $('.dropdown-menu.show').fadeOut(300, function () {
        $(this).remove();
    });

    var selectedValue = type === 'year' ? selectedYear : selectedMonth;

    var html = `
        <div id="${id}" class="dropdown-menu show user-select-none" style="position: fixed; z-index: 1050; min-width: 200px; opacity: 0;">
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
    queuedPatientHealthHistoriesTable.columns(0).search(selectedYear ? `^${selectedYear}` : '', true, false);
    queuedPatientHealthHistoriesTable.columns(0).search(selectedMonth ? `-${selectedMonth}-` : '', true, false);
    queuedPatientHealthHistoriesTable.draw();
}

var viewQueuedPatientHealthHistoriesDetailsModal = new bootstrap.Modal(document.getElementById('viewQueuedPatientHealthHistoriesDetailsModal'));
$('#queuedPatientHealthHistoriesTable').on('click', '.btn-view', function() {
    viewQueuedPatientHealthHistoriesDetailsModal.show();
    const $backdrops = $('.modal-backdrop.show');
    if ($backdrops.length >= 2) {
        $backdrops.eq(1).css('z-index', '1055');
        $('#viewQueuedPatientHealthHistoriesDetailsModal').css('z-index', '1056');
    }
    let data = queuedPatientHealthHistoriesTable.row($(this).parents('tr')).data();

    $('#viewQueuedPatientHealthHistoriesDetailsModal #createdAt').html(moment(data.createdAt).format('dddd, DD MMMM YYYY HH:mm') + ' WITA');
    $('#viewQueuedPatientHealthHistoriesDetailsModal #updatedAt').html(moment(data.updatedAt).format('dddd, DD MMMM YYYY HH:mm') + ' WITA');

    data.patientPhoto && $('#viewQueuedPatientHealthHistoriesDetailsModal #patientPhoto').attr('src', `${baseUrl}uploads/profiles/${data.patientPhoto}`);

    $('#viewQueuedPatientHealthHistoriesDetailsModal #patientNIK').html(data.patientNIK);
    $('#viewQueuedPatientHealthHistoriesDetailsModal #patientName').html(data.patientName);
    $('#viewQueuedPatientHealthHistoriesDetailsModal #patientDepartment').html(data.patientDepartment);
    $('#viewQueuedPatientHealthHistoriesDetailsModal #patientGender').html(capitalizeWords(data.patientGender));
    $('#viewQueuedPatientHealthHistoriesDetailsModal #patientBand').html(data.patientBand);
    $('#viewQueuedPatientHealthHistoriesDetailsModal #patientRelationship').html(capitalizeWords(data.patientRelationship));

    let hospitalLogo = `${data.hospitalLogo ? baseUrl + "uploads/logos/" + data.hospitalLogo : baseUrl + "assets/images/hospital-placeholder.jpg"}`;
    $('#viewQueuedPatientHealthHistoriesDetailsModal #hospitalName').html(`
        <span class="d-flex align-items-center gap-1">
        <img src="${hospitalLogo}" class="rounded object-fit-contain" style="width: 28px; height: 28px;">
        <div>
            ${data.hospitalName}
        </div>
        </span>
    `);

    $('#viewQueuedPatientHealthHistoriesDetailsModal #healthhistoryStatus').html(generateStatusData([data.status]).find((d) => d.id === data.status).text);
    $('#viewQueuedPatientHealthHistoriesDetailsModal #invoiceStatus').html(generateStatusData([data.invoiceStatus]).find((d) => d.id === data.invoiceStatus).text);
    if (data.healthhistoryReferredTo) {
        $('#viewQueuedPatientHealthHistoriesDetailsModal .referredInput').show();

        let referredHospitalLogo = `${data.referredHospitalLogo ? baseUrl + "uploads/logos/" + data.referredHospitalLogo : baseUrl + "assets/images/hospital-placeholder.jpg"}`;
        $('#viewQueuedPatientHealthHistoriesDetailsModal #healthhistoryReferredTo').html(`
        <span class="d-flex align-items-center gap-1">
            <img src="${referredHospitalLogo}" class="rounded object-fit-contain" style="width: 28px; height: 28px;">
            <div>
            ${data.referredHospitalName}
            </div>
        </span>
        `);
    }

    $('#viewQueuedPatientHealthHistoriesDetailsModal #healthhistoryDate').html(moment(data.healthhistoryDate).format('ddd, DD MMMM YYYY'));
    $('#viewQueuedPatientHealthHistoriesDetailsModal #doctorName').html(data.doctorName);
    $('#viewQueuedPatientHealthHistoriesDetailsModal #diseaseNames').html(data.diseaseNames);
    $('#viewQueuedPatientHealthHistoriesDetailsModal #healthhistoryDescription').val(data.healthhistoryDescription);
    $('#viewQueuedPatientHealthHistoriesDetailsModal #healthhistoryDoctorFee').html(formatToRupiah(data.healthhistoryDoctorFee, true, false));
    $('#viewQueuedPatientHealthHistoriesDetailsModal #healthhistoryMedicineFee').html(formatToRupiah(data.healthhistoryMedicineFee, true, false));
    $('#viewQueuedPatientHealthHistoriesDetailsModal #healthhistoryLabFee').html(formatToRupiah(data.healthhistoryLabFee, true, false));
    $('#viewQueuedPatientHealthHistoriesDetailsModal #healthhistoryActionFee').html(formatToRupiah(data.healthhistoryActionFee, true, false));
    $('#viewQueuedPatientHealthHistoriesDetailsModal #healthhistoryDiscount').html(formatToRupiah(data.healthhistoryDiscount, true, false));
    $('#viewQueuedPatientHealthHistoriesDetailsModal #healthhistoryTotalBill').html(formatToRupiah(data.healthhistoryTotalBill, true, false));
});



// Delete Data
$('#queuesTable').on('click', '.btn-delete', function() {
  let data = queuesTable.row($(this).parents('tr')).data();
  $('#deleteQueueForm #patientName').text(data.patientName);
  $('#deleteQueueForm #patientNIK').val(data.patientNIK);
})

$('#deleteQueueForm').on('submit', function(e) {
  e.preventDefault();
  var patientNIK = $('#deleteQueueForm #patientNIK').val();
  $.ajax({
      url: baseUrl + 'hospital/queues/deleteQueue',
      method: 'POST',
      data: $(this).serialize(),
      success: function(response) {
          var res = JSON.parse(response);
          res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
          if (res.status === 'success') {
              reloadTableData(queuesTable);
              displayAlert('delete success');
          }
      }
  });
});