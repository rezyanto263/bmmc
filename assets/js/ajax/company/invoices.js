var invoicesTable = $("#invoicesTable").DataTable(
	$.extend(true, {}, DataTableSettings, {
		ajax: baseUrl + "company/getAllInvoicesByCompanyId",
		columns: [
			{
				data: "invoiceNumber",
				render: function(data, type, row) {
					return data ? data : "Upcoming";
				}
			},
			{
				data: "invoiceDate",
				className: 'text-start',
				render: function (data, type, row) {
					if (type === "display") {
						return data ? moment(data).format("DD MMMM YYYY") : "Upcoming";
					}
					return data;
				}
			},
			{
				data: "invoiceStatus",
				name: "invoiceStatus",
				render: function (data, type, row) {
					if (type === "display" || type === "filter") {
						return generateStatusData([data]).find((d) => d.id === data).text;
					}
					return data;
				}
			},
			{
				data: "invoiceSubtotal",
				render: function (data = 0, type, row) {
					return formatToRupiah(data);
				}
			},
			{
				data: "invoiceDiscount",
				render: function (data = 0, type, row) {
					return `<span class="text-danger">${formatToRupiah(data)}</span>`;
				}
			},
			{
				data: "invoiceTotalBill",
				render: function (data = 0, type, row) {
					return `<span class="text-info">${formatToRupiah(data)}</span>`;
				}
			},
			{
				data: "billingUsed",
				render: function (data, type, row) {
					var current = row.billingAmount - row.billingUsed;
					var percentage =
						current != 0 ? parseInt((current / row.billingAmount) * 100) : 0;
					var barColor;
					if (percentage >= 50) {
						barColor = "bg-success";
					} else if (50 > percentage && percentage >= 20) {
						barColor = "bg-warning";
					} else {
						barColor = "bg-danger";
					}
					return `
							<div class="progress bg-secondary border position-relative" role="progressbar" aria-valuenow="${percentage}" aria-valuemin="0" aria-valuemax="100">
									<div class="progress-bar ${barColor} progress-bar-striped progress-bar-animated" style="width: ${percentage}%">
											<span class="position-absolute top-50 start-50 translate-middle text-white fw-bold">
													${formatToRupiah(current, true, false)} / ${formatToRupiah(row.billingAmount, true, false)}
											</span>
									</div>
							</div>
					`;
				},
			},
			{
				data: "billingStatus",
				render: function (data, type, row) {
					return (
						generateStatusData([data]).find((d) => d.id === data)?.text || ""
					);
				},
			},
			{
				data: "billingStartedAt",
				render: function (data, type, row) {
					return moment(data).format("ddd, D MMMM YYYY");
				},
			},
			{
				data: "billingEndedAt",
				render: function (data, type, row) {
					return moment(data).format("ddd, D MMMM YYYY");
				},
			},
			{
				data: null,
				className:"text-center user-select-none no-export no-visibility",
				orderable: false,
				render: function (data, type, row) {
					let isInvoiceCreated = ['paid', 'unpaid', 'free'].includes(row.invoiceStatus);
					return `
						<button 
								type="button" 
								class="btn-view btn-primary rounded-2" 
								data-bs-toggle="modal" 
								data-bs-target="#viewInvoiceModal">
								<i class="fa-regular fa-eye"></i>
						</button>
				`;
				}
			},
		],
		columnDefs: [
			{ width: "40px", target: 10 },
		],
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
				text: "Invoice Status",
				className: "btn btn-primary dropdown-toggle",
				action: function (e, dt, node, config) {
					if ($('#invoiceStatusDropdown').length === 0) {
						var columnIndex = dt.column('invoiceStatus:name').index();
						var list = [];
						dt.column(columnIndex).data().unique().each(function (value) {
							if (value) {
								list.push(value);
							}
						});
						list.sort();
						createInvoiceStatusDropdown(node, list, columnIndex);
					} else {
						$('#invoiceStatusDropdown').fadeOut(300, function () {
							$('#invoiceStatusDropdown').remove();
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
	})
);

function createInvoiceStatusDropdown(node, list, columnIndex) {
	$('.dropdown-menu.show').fadeOut(300, function () {
			$(this).remove();
	});

	let selectedInvoiceStatus = $(node).data('value');

	let dropdownId = "invoiceStatusDropdown";
	let html = `
			<div id="${dropdownId}" class="dropdown-menu show user-select-none" style="position: absolute; z-index: 1050; min-width: 200px; opacity: 0;">
					<a class="dropdown-item d-flex justify-content-between" data-value="" style="cursor: pointer;">
							<span>All Invoice Status</span>
							<span class="check-mark">${selectedInvoiceStatus === '' ? '✔' : ''}</span>
					</a>
					${list.map(item => `
							<a class="dropdown-item d-flex justify-content-between" data-value="${item}" style="cursor: pointer;">
									<div>
										${generateStatusData([item]).find((d) => d.id === item).text}
									</div>
									<span class="check-mark">${selectedInvoiceStatus === item ? '✔' : ''}</span>
							</a>
					`).join('')}
			</div>
	`;

	$(node).after(html);
	let $dropdown = $(`#${dropdownId}`);

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

	// Event klik pada item dropdown untuk filter status invoice
	$dropdown.find('.dropdown-item').on('click', function () {
			let value = $(this).data('value');
			selectedInvoiceStatus = value;

		// Perbarui tanda centang
		$dropdown.find('.check-mark').text('');
		$(this).find('.check-mark').text('✔');

		// Terapkan filter ke DataTables
		invoicesTable.column(columnIndex).search(value).draw();
	});

	// Tutup dropdown jika klik di luar area
	$(document).off('click.closeDropdown').on('click.closeDropdown', function (event) {
    if (!$(event.target).closest('.dropdown-menu.show, .btn-primary').length) {
      $dropdown.fadeOut(300, function () {
        $(this).remove();
      });
      $(document).off('click.closeDropdown');
    }
  });
}



// View Data
$('#invoicesTable').on('click', '.btn-view', function() {
	let data = invoicesTable.row($(this).parents('tr')).data();
	$('#viewInvoiceModal #imgPreview').attr('src', data.companyLogo ? `${baseUrl}uploads/logos/${data.companyLogo}` : `${baseUrl}assets/images/company-placeholder.jpg`);
	$('#viewInvoiceModal #companyName').html(data.companyName);
	$('#viewInvoiceModal #adminId').html(data.adminName + ' | ' + data.adminEmail);
	$('#viewInvoiceModal #companyPhone').html(data.companyPhone);
	$('#viewInvoiceModal #companyStatus').html(generateStatusData([data.companyStatus]).find((d) => d.id === data.companyStatus).text);
	$('#viewInvoiceModal #companyCoordinate').html(data.companyCoordinate);
	$('#viewInvoiceModal #companyAddress').html(data.companyAddress);
	$('#viewInvoiceModal #billingAmount').html(formatToRupiah(data.billingAmount, true, false));
	$('#viewInvoiceModal #invoiceNumber').html(data.invoiceNumber ?? 'Upcoming');
	$('#viewInvoiceModal #invoiceDate').html(data.invoiceDate ? moment(data.invoiceDate).format("ddd, D MMMM YYYY") : 'Upcoming');
	$('#viewInvoiceModal #invoiceSubtotal').html(formatToRupiah(data.billingUsed, true, false));
	$('#viewInvoiceModal #invoiceStatus').html(generateStatusData([data.invoiceStatus]).find((d) => d.id === data.invoiceStatus).text);
	$('#viewInvoiceModal [name="invoiceDiscount"]').val('-');

	departmentBillsTable(data.billingId);
	treatmentsDetailsTable(data.billingId);

	$('#viewInvoiceModal #temporaryData').data('billingId', data.billingId);
	$('#viewInvoiceModal #temporaryData').data('invoiceId', data.invoiceId);
	$('#viewInvoiceModal #temporaryData').data('invoiceStatus', data.invoiceStatus);

	$('#viewInvoiceModal #btnViewInvoice').hide();
	if ([ 'paid', 'unpaid', 'free' ].includes(data.invoiceStatus)) {

		$('#viewInvoiceModal #btnViewInvoice').show();
		$('#viewInvoiceModal [name="invoiceDiscount"]').parents('.card').css('background', 'rgba(78, 78, 78, 0.17)');
		$('#viewInvoiceModal [name="invoiceDiscount"]').data('cleave').setRawValue(data.invoiceDiscount);
		$('#viewInvoiceModal [name="invoiceDiscount"]').val(formatToRupiah(data.invoiceDiscount, true, false));
		$('#viewInvoiceModal #invoiceTotalBill').html(formatToRupiah(data.invoiceTotalBill, true, false));

	} else if (data.invoiceStatus === 'upcoming') {

		$('#viewInvoiceModal [name="invoiceDiscount"]').prop('disabled', true);
		$('#viewInvoiceModal [name="invoiceDiscount"]').parents('.card').css('background', 'rgba(78, 78, 78, 0.17)');

	}

	$('#viewInvoiceModal #btnViewInvoice').off('click').on('click', function() {
		$('#viewInvoicePdfModal #pdfPreview').attr('src', '');
		let viewInvoicePdfModal = new bootstrap.Modal(document.getElementById('viewInvoicePdfModal'));
		viewInvoicePdfModal.show();
		const $backdrops = $('.modal-backdrop.show');
		if ($backdrops.length >= 2) {
			$backdrops.eq(1).css('z-index', '1055');
			$('#viewInvoicePdfModal').css('z-index', '1056');
		}

		$('#viewInvoicePdfModal').on('shown.bs.modal', function() {
			const pdfUrl = `${baseUrl}uploads/invoices/${data.invoiceNumber}.pdf?t=${Date.now()}`;
			const viewerUrl = `https://mozilla.github.io/pdf.js/web/viewer.html?file=${encodeURIComponent(pdfUrl)}`;
	
			$('#viewInvoicePdfModal #pdfViewer').attr('src', viewerUrl);
		});
	});
});

$('#viewInvoiceModal').on('hidden.bs.modal', function() {
	$('#viewInvoiceModal [name="invoiceDiscount"]').val('-');
	$('#viewInvoiceModal [name="invoiceDiscount"]').prop('disabled', true);
	$('#viewInvoiceModal [name="invoiceDiscount"]').parents('.card').css('background', 'rgba(78, 78, 78, 0.17)');
	$('#viewInvoiceModal #invoiceTotalBill').html('-');
	$('#viewInvoiceModal [name="billingId"]').val('');
	$('#viewInvoiceModal [name="invoiceId"]').val('');
});



var treatmentsTable; 
function treatmentsDetailsTable(billingId) {
	if ($.fn.DataTable.isDataTable('#treatmentsTable')) {
		$('#treatmentsTable').DataTable().ajax.url(baseUrl + "company/getAllHealthHistoriesByBillingId?id=" + billingId).load();
		return;
	}
	treatmentsTable = $("#treatmentsTable").DataTable($.extend(true, {}, DataTableSettings, {
		ajax: baseUrl + "company/getAllHealthHistoriesByBillingId?id=" + billingId,
		columns: [  
			{
				data: "healthhistoryDate",
				className: 'text-start',
				render: function(data, type, row) {
					if (type === 'display') {
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
				data: "healthhistoryDoctorFee",
				className: 'text-end',
				render: function(data = 0, type, row) {
					if (type === 'display') {
						return formatToRupiah(data, true, true);
					}
					return data;
				}
			},
			{
				data: "healthhistoryMedicineFee",
				className: 'text-end',
				render: function(data = 0, type, row) {
					if (type === 'display') {
						return formatToRupiah(data, true, true);
					}
					return data;
				}
			},
			{
				data: "healthhistoryLabFee",
				className: 'text-end',
				render: function(data = 0, type, row) {
					if (type === 'display') {
						return formatToRupiah(data, true, true);
					}
					return data;
				}
			},
			{
				data: "healthhistoryActionFee",
				className: 'text-end',
				render: function(data = 0, type, row) {
					if (type === 'display') {
						return formatToRupiah(data, true, true);
					}
					return data;
				}
			},
			{
				data: "healthhistoryDiscount",
				className: 'text-end',
				render: function(data = 0, type, row) {
					if (type === 'display') {
						return `<span class="text-danger">${formatToRupiah(data, true, true)}</span>`;
					}
					return data;
				}
			},
			{
				data: "healthhistoryTotalBill",
				className: 'text-end',
				render: function(data = 0, type, row) {
					if (type === 'display') {
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
						
						if (type === 'display') {
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
						
						if (type === 'display') {
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
					return `
						<button 
								type="button"
								class="btn-view btn-primary rounded-2">
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
		]
	}));
}

var viewTreatmentsModal = new bootstrap.Modal(document.getElementById('viewTreatmentsModal'));
$('#treatmentsTable').on('click', '.btn-view', function() {
	viewTreatmentsModal.show();
	const $backdrops = $('.modal-backdrop.show');
	if ($backdrops.length >= 2) {
		$backdrops.eq(1).css('z-index', '1055');
		$('#viewTreatmentsModal').css('z-index', '1056');
	}

	let data = treatmentsTable.row($(this).parents('tr')).data();
	
	$('#viewTreatmentsModal #createdAt').html(moment(data.createdAt).format('dddd, DD MMMM YYYY HH:mm') + ' WITA');
  $('#viewTreatmentsModal #updatedAt').html(moment(data.updatedAt).format('dddd, DD MMMM YYYY HH:mm') + ' WITA');

  data.patientPhoto && $('#viewTreatmentsModal #patientPhoto').attr('src', `${baseUrl}uploads/profiles/${data.patientPhoto}`);
  $('#viewTreatmentsModal #patientNIK').html(data.patientNIK);
  $('#viewTreatmentsModal #patientName').html(data.patientName);
  $('#viewTreatmentsModal #patientDepartment').html(data.patientDepartment);
  $('#viewTreatmentsModal #patientGender').html(capitalizeWords(data.patientGender));
  $('#viewTreatmentsModal #patientBand').html(data.patientBand);
  $('#viewTreatmentsModal #patientRelationship').html(capitalizeWords(data.patientRelationship));

  let hospitalLogo = `${data.hospitalLogo ? baseUrl + "uploads/logos/" + data.hospitalLogo : baseUrl + "assets/images/hospital-placeholder.jpg"}`;
  $('#viewTreatmentsModal #hospitalName').html(`
    <span class="d-flex align-items-center gap-1">
      <img src="${hospitalLogo}" class="rounded object-fit-contain" style="width: 28px; height: 28px;">
      <div>
        ${data.hospitalName}
      </div>
    </span>
  `);

  $('#viewTreatmentsModal #healthhistoryStatus').html(generateStatusData([data.status]).find((d) => d.id === data.status).text);
  if (data.healthhistoryReferredTo) {
    $('#viewTreatmentsModal .referredInput').show();

    let referredHospitalLogo = `${data.referredHospitalLogo ? baseUrl + "uploads/logos/" + data.referredHospitalLogo : baseUrl + "assets/images/hospital-placeholder.jpg"}`;
    $('#viewTreatmentsModal #healthhistoryReferredTo').html(`
      <span class="d-flex align-items-center gap-1">
        <img src="${referredHospitalLogo}" class="rounded object-fit-contain" style="width: 28px; height: 28px;">
        <div>
          ${data.referredHospitalName}
        </div>
      </span>
    `);
  }

  $('#viewTreatmentsModal #healthhistoryDate').html(moment(data.healthhistoryDate).format('ddd, DD MMMM YYYY'));
  $('#viewTreatmentsModal #doctorName').html(data.doctorName);
  $('#viewTreatmentsModal #diseaseNames').html(data.diseaseNames);
  $('#viewTreatmentsModal #healthhistoryDescription').val(data.healthhistoryDescription);
  $('#viewTreatmentsModal #healthhistoryDoctorFee').html(formatToRupiah(data.healthhistoryDoctorFee, true, false));
  $('#viewTreatmentsModal #healthhistoryMedicineFee').html(formatToRupiah(data.healthhistoryMedicineFee, true, false));
  $('#viewTreatmentsModal #healthhistoryLabFee').html(formatToRupiah(data.healthhistoryLabFee, true, false));
  $('#viewTreatmentsModal #healthhistoryActionFee').html(formatToRupiah(data.healthhistoryActionFee, true, false));
  $('#viewTreatmentsModal #healthhistoryDiscount').html(formatToRupiah(data.healthhistoryDiscount, true, false));
  $('#viewTreatmentsModal #healthhistoryTotalBill').html(formatToRupiah(data.healthhistoryTotalBill, true, false));
});



var departmentAllocationBillsTable;
function departmentBillsTable(billingId) {
	if ($.fn.DataTable.isDataTable('#departmentAllocationBillsTable')) {
		$('#departmentAllocationBillsTable').DataTable().ajax.url(baseUrl + 'company/getDepartmentAllocationBillsByBillingId?id=' + billingId).load();
		return;
	}
	departmentAllocationBillsTable = $('#departmentAllocationBillsTable').DataTable($.extend(true, {}, DataTableSettings, {
		ajax: baseUrl + 'company/getDepartmentAllocationBillsByBillingId?id=' + billingId,
		caches: false,
    columns: [
      {
				data: 'departmentName',
				className: 'text-center'
			},
      {
				data: 'totalEmployees',
				className: 'text-center'
			},
			{
				data: 'totalFamilies',
				className: 'text-center'
			},
			{
				data: 'totalBilledTreatments',
				className: 'text-center'
			},
			{
				data: 'totalReferredTreatments',
				className: 'text-center'
			},
			{
				data: 'totalFreeTreatments',
				className: 'text-center'
			},
			{
				data: 'totalTreatments',
				className: 'text-center'
			},
			{
				data: 'departmentTotalBill',
				className: 'text-center',
				render: function (data = 0, type, row) {
					if (type === 'display' || type === 'filter') {
						return formatToRupiah(data, true, false);
					}
					return data;
        }
			},
    ],
		order: [[7, 'desc']],
		fixedColumns: {
			leftColumns: 0,
			rightColumns: 0,
		},
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
		]
  }));
}