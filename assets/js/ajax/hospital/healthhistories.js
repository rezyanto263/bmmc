// HealthHistories DataTable
var healthhistoriesTable = $("#healthhistoriesTable").DataTable($.extend(true, {}, DataTableSettings, {
  ajax: baseUrl + "hospital/getAllHealthHistoriesByHospitalId", 
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
      className:"text-end user-select-none no-export no-visibility text-center",
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