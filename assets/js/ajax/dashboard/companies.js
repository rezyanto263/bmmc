// Companies Datatable
var companiesTable = $("#companiesTable").DataTable(
	$.extend(true, {}, DataTableSettings, {
		ajax: baseUrl + "dashboard/getAllCompaniesDatas",
		columns: [
			{
				data: "companyLogo",
				className: "align-middle user-select-none no-export",
				// orderable: false,
				render: function (data, type, row) {
					let logo = data
						? `${baseUrl}uploads/logos/${data}`
						: `${baseUrl}assets/images/company-placeholder.jpg`;
					return `
						<img class="object-fit-contain border border-secondary-subtle rounded" src="${logo}" style="width: 45px; height: 45px; object-position: center">
					`;
				},
			},
			{
				data: "companyName",
				className: "align-middle text-nowrap",
			},
			{
				data: "billingUsed",
				className: "align-middle",
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
				data: "companyStatus",
				className: "align-middle text-nowrap",
				render: function (data, type, row) {
					return (
						generateStatusData([data]).find((d) => d.id === data)?.text || ""
					);
				},
			},
			{
				data: "adminEmail",
				className: "align-middle",
			},
			{
				data: "companyPhone",
				className: "align-middle",
			},
			{
				data: "companyAddress",
				className: 'text-wrap',
				render: function(data, type) {
						if (type === 'display' || type === 'filter') {
								return `<div class="text-2-row" style="width: 250px;">${data}</div>`;
						}
						return data;
				}
			},
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
				className:
					"text-end user-select-none no-export no-visibility",
				orderable: false,
				defaultContent: `
					<button 
							type="button" 
							class="btn-view btn-primary rounded-2" 
							data-bs-toggle="modal" 
							data-bs-target="#viewCompanyModal">
							<i class="fa-regular fa-eye"></i>
					</button>
					<button 
							type="button" 
							class="btn-edit btn-warning rounded-2" 
							data-bs-toggle="modal" 
							data-bs-target="#editCompanyModal">
							<i class="fa-regular fa-pen-to-square"></i>
					</button>
					<button 
							type="button" 
							class="btn-delete btn-danger rounded-2" 
							data-bs-toggle="modal" 
							data-bs-target="#deleteCompanyModal">
									<i class="fa-solid fa-trash-can"></i>
					</button>
			`,
			},
		],
		columnDefs: [
			{ width: "120px", target: 9 },
			{ orderable: false, targets: 0 }
		],
	})
);

$("#addCompanyButton, #editCompanyButton, #deleteCompanyButton").on(
	"click",
	function () {
		reloadTableData(companiesTable);
	}
);

// Add Data
$("#addCompanyModal").on("show.bs.modal", function () {
	$(this)
		.find('select[name="adminId"]')
		.select2({
			width: '1%',
			ajax: {
				url: baseUrl + "dashboard/getAllUnconnectedCompanyAdminsDatas",
				type: "GET",
				dataType: "json",
				delay: 250,
				processResults: function (response, params) {
					const searchTerm = params.term ? params.term.toLowerCase() : "";
					return {
						results:
							response.data
								.filter(function (data) {
									const emailMatch = data.adminEmail
										.toLowerCase()
										.includes(searchTerm);
									const nameMatch = data.adminName
										.toLowerCase()
										.includes(searchTerm);
									return emailMatch || nameMatch;
								})
								.map(function (data) {
									return {
										id: data.adminId,
										text: `
												${data.adminEmail} | 
												${data.adminName} | 
												${generateStatusData(["not linked"]).find((d) => d.id === "not linked").text}
										`,
									};
								}) ?? [],
					};
				},
				cache: true,
			},
			minimumInputLength: 0,
			placeholder: "Choose Admin",
			allowClear: true,
			dropdownParent: $("#addCompanyModal .modal-body"),
			escapeMarkup: function (markup) {
				return markup;
			},
		});
});

$("#addCompanyForm").on("submit", function (e) {
	e.preventDefault();
	removeCleaveFormat();
	var formData = new FormData(this);
	$.ajax({
		url: baseUrl + "dashboard/companies/addCompany",
		method: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function (response) {
			var res = JSON.parse(response);
			res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
			if (res.status === "success") {
				reloadTableData(companiesTable);
				displayAlert("add success");
			} else if (res.status === "failed") {
				$(".error-message").remove();
				$(".is-invalid").removeClass("is-invalid");
				displayAlert(res.failedMsg, res.errorMsg ?? null);
				formatPhoneInput();
				formatCurrencyInput();
			} else if (res.status === "invalid") {
				displayFormValidation("#addCompanyForm", res.errors);
				formatPhoneInput();
				formatCurrencyInput();
			}
		},
	});
});

// View Data
$("#companiesTable").on("click", ".btn-view", function () {
	var data = companiesTable.row($(this).parents("tr")).data();
	$('#viewCompanyModal #createdAt').html(moment(data.createdAt).format('ddd, D MMMM YYYY HH:mm') +' WITA');
	$('#viewCompanyModal #updatedAt').html(moment(data.updatedAt).format('ddd, D MMMM YYYY HH:mm') +' WITA');

	let imageFilePath = baseUrl + "assets/images/company-placeholder.jpg";

	data.companyPhoto
		? (imageFilePath = baseUrl + "uploads/photos/" + data.companyPhoto)
		: data.companyLogo
		? (imageFilePath = baseUrl + "uploads/logos/" + data.companyLogo)
		: imageFilePath;
	data.companyLogo &&
		$("#viewCompanyModal #imgPreview").attr(
			"src",
			baseUrl + "uploads/logos/" + data.companyLogo
		);
	$('#viewCompanyModal [name="companyName"]').val(data.companyName);
	$('#viewCompanyModal #companyAddress').html(data.companyAddress);
	$('#viewCompanyModal [name="companyCoordinate"]').val(data.companyCoordinate);
	$('#viewCompanyModal [name="companyPhone"]').val(data.companyPhone);
	$('#viewCompanyModal [name="adminId"]').val(
		`${data.adminName} | ${data.adminEmail}`
	);

	formatPhoneInput();

	$("#viewCompanyModal div#companyStatus").html(
		generateStatusData([data.companyStatus]).find(
			(d) => d.id === data.companyStatus
		)?.text || ""
	);

	$("#viewCompanyModal").on("shown.bs.modal", function () {
		var coordsArray = data.companyCoordinate.split(",");
		var latitude = parseFloat(coordsArray[0].trim());
		var longitude = parseFloat(coordsArray[1].trim());

		initializeMap(latitude, longitude, imageFilePath);
	});

	$.ajax({
		url: baseUrl + "dashboard/getCompanyDetails?id=" + data.companyId,
		method: "GET",
		success: function (response) {
			var res = JSON.parse(response).data;
			for (const key in res) {
				if (res.hasOwnProperty(key)) {
					$(`#viewCompanyModal #${key}`).html(res[key]);
				}
			}
		},
	});

	let billingRemaining = data.billingAmount - data.billingUsed;
	var percentage =
		billingRemaining != 0
			? parseInt((billingRemaining / data.billingAmount) * 100)
			: 0;
	var textColor;
	if (percentage >= 50) {
		textColor = "text-success";
	} else if (50 > percentage && percentage >= 20) {
		textColor = "text-warning";
	} else {
		textColor = "text-danger";
	}
	$("#viewCompanyModal #totalBillingAmount").html(
		formatToRupiah(data.billingAmount, false, false)
	);
	$("#viewCompanyModal #totalBillingUsed").html(
		formatToRupiah(data.billingUsed, false, false)
	);
	$("#viewCompanyModal #totalBillingRemaining").html(
		`<span class="${textColor}">${formatToRupiah(billingRemaining)}</span>`
	);
	$("#viewCompanyModal #billingDate").html(
		moment(data.billingStartedAt).format("D MMM YYYY") +
			" - " +
			moment(data.billingEndedAt).format("D MMM YYYY")
	);
});

// Edit Data
$("#companiesTable").on("click", ".btn-edit", function () {
	var d = companiesTable.row($(this).parents("tr")).data();

	d.companyLogo &&
		$("#editCompanyForm #imgPreview").attr(
			"src",
			baseUrl + "uploads/logos/" + d.companyLogo
		);
	d.companyPhoto &&
		$("#editCompanyForm #imgPreview2").attr(
			"src",
			baseUrl + "uploads/photos/" + d.companyPhoto
		);
	$('#editCompanyForm [name="companyId"]').val(d.companyId);
	$('#editCompanyForm [name="companyName"]').val(d.companyName);
	$('#editCompanyForm [name="companyAddress"]').val(d.companyAddress);

	$('#editCompanyForm [name="companyPhone"]').val(d.companyPhone);
	formatPhoneInput();

	$('#editCompanyForm [name="billingId"]').val(d.billingId);
	var isUnverified = d.companyStatus == "unverified";
	$('#editCompanyForm [name="companyStatus"]').select2({
		placeholder: "Choose Status",
		data: isUnverified
			? generateStatusData([d.companyStatus])
			: generateStatusData(["Active", "On Hold", "Discontinued"]),
		dropdownParent: $("#editCompanyModal .modal-body"),
		disabled: isUnverified,
		escapeMarkup: function (markup) {
			return markup;
		},
		templateResult: function (data) {
			return data.text ? $(data.text) : data.text;
		},
		templateSelection: function (data) {
			return data.text ? $(data.text) : data.text;
		},
	});
	$('#editCompanyForm [name="companyStatus"]')
		.val(d.companyStatus)
		.trigger("change");
	isUnverified &&
		$('#editCompanyForm [name="companyStatus"]')
			.parents(".col-12")
			.find(".warning-message")
			.show();

	$('#editCompanyForm [name="adminId"]')
		.empty()
		.select2({
			width: '1%',
			placeholder: "Choose Admin",
			ajax: {
				url: baseUrl + "dashboard/getAllUnconnectedCompanyAdminsDatas",
				method: "GET",
				dataType: "json",
				delay: 250,
				processResults: function (response, params) {
					const searchTerm = params.term ? params.term.toLowerCase() : "";
					const selectedData =
						d && d.adminId
							? [
                                {
                                    id: d.adminId,
                                    text: `
                                            ${d.adminEmail} | 
                                            ${d.adminName} | 
                                            ${generateStatusData(["current"]).find((a) => a.id === "current").text}
                                        `,
                                    selected: true,
                                },
                            ]
							: [];

					const allData = selectedData.concat(
						response.data.map(function (data) {
							return {
								id: data.adminId,
								text: `
                                    ${data.adminEmail} | 
                                    ${data.adminName} | 
                                    ${generateStatusData(["not linked"]).find((a) => a.id === "not linked").text}
                                `,
							};
						})
					);

					const filteredData = allData.filter(function (data) {
						const searchText = data.text.toLowerCase();
						return searchText.includes(searchTerm);
					});

					return {
						results: filteredData,
					};
				},
				error: function (err) {
					console.error("Error fetching admin data:", err);
				},
			},
			dropdownParent: $("#editCompanyModal .modal-body"),
			escapeMarkup: function (markup) {
				return markup;
			},
		});

	if (d.adminId) {
		var preselectedOption = new Option(
			`${d.adminEmail} | ${d.adminName} | ${
				generateStatusData(["current"]).find((d) => d.id === "current").text
			}`,
			d.adminId,
			true,
			true
		);
		$('#editCompanyForm [name="adminId"]')
			.append(preselectedOption)
			.trigger("change");
	}
});

$("#changeBillingAmountInput").hide();
$("#newBillingAmountCheck").change(function () {
	$("#changeBillingAmountInput").toggle();
	$("#changeBillingAmountInput").find("input").val("");
	$(".error-message").remove();
	$(".is-invalid").removeClass("is-invalid");
});

$("#editCompanyForm").on("submit", function (e) {
	e.preventDefault();
	removeCleaveFormat();
	$.ajax({
		url: baseUrl + "dashboard/companies/editCompany",
		method: "POST",
		data: new FormData(this),
		contentType: false,
		processData: false,
		success: function (response) {
			console.log(response);
			var res = JSON.parse(response);
			res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
			if (res.status === "success") {
				reloadTableData(companiesTable);
				displayAlert("edit success");
			} else if (res.status === "failed") {
				$(".error-message").remove();
				$(".is-invalid").removeClass("is-invalid");
				formatPhoneInput();
				displayAlert(res.failedMsg, res.errorMsg ?? null);
			} else if (res.status === "invalid") {
				formatPhoneInput();
				displayFormValidation("#editCompanyForm", res.errors);
			}
		},
	});
});

// Delete Data
$("#companiesTable").on("click", ".btn-delete", function () {
	var data = companiesTable.row($(this).parents("tr")).data();
	$("#deleteCompanyForm #companyName").html(data.companyName);
	$('#deleteCompanyForm [name="companyId"]').val(data.companyId);
});

$("#deleteCompanyForm").on("submit", function (e) {
	e.preventDefault();
	$.ajax({
		url: baseUrl + "dashboard/companies/deleteCompany",
		method: "POST",
        cache: false,
		data: $(this).serialize(),
		success: function (response) {
			var res = JSON.parse(response);
			res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
			if (res.status === "success") {
				reloadTableData(companiesTable);
				displayAlert("delete success");
			} else if (res.status === "failed") {
				displayAlert(res.failedMsg);
			}
		},
	});
});
