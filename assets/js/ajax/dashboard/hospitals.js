// Hospitals CRUD
var hospitalsTable = $("#hospitalsTable").DataTable($.extend(true, {}, DataTableSettings, {
		ajax: baseUrl + "dashboard/getAllHospitalsDatas",
		columns: [
			{
				data: "hospitalLogo",
				className: "align-middle user-select-none no-export",
				orderable: false,
				render: function (data, type, row) {
					let logo = data
						? `${baseUrl}uploads/logos/${data}`
						: `${baseUrl}assets/images/hospital-placeholder.jpg`;
					return `
						<img class="object-fit-contain border border-secondary-subtle rounded" src="${logo}" style="width: 45px; height: 45px; object-position: center">
					`;
				},
			},
			{
				data: "hospitalName",
				className: "text-nowrap align-middle",
			},
			{
				data: "adminEmail",
				className: "align-middle",
				render: function (data, type, row) {
					return data ? data : "No Admin";
				},
			},
			{
				data: "hospitalStatus",
				className: "text-nowrap align-middle",
				render: function (data, type, row) {
					return (
						generateStatusData([data]).find((d) => d.id === data)?.text || ""
					);
				},
			},
			{
				data: "hospitalPhone",
				className: "align-middle",
			},
			{
				data: "hospitalAddress",
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
				className: "text-end user-select-none no-export no-visibility",
				orderable: false,
				defaultContent: `
                    <button 
                        type="button" 
                        class="btn-view btn-primary rounded-2" 
                        data-bs-toggle="modal" 
                        data-bs-target="#viewHospitalModal">
                        <i class="fa-regular fa-eye"></i>
                    </button>
                    <button 
                        type="button" 
                        class="btn-edit btn-warning rounded-2" 
                        data-bs-toggle="modal" 
                        data-bs-target="#editHospitalModal">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </button>
                    <button 
                        type="button" 
                        class="btn-delete btn-danger rounded-2" 
                        data-bs-toggle="modal" 
                        data-bs-target="#deleteHospitalModal">
                            <i class="fa-solid fa-trash-can"></i>
                    </button>
                `,
			},
		],
		columnDefs: [
			{ width: "120px", target: 7 },
		],
	})
);

$("#addHospitalButton, #editHospitalButton, #deleteHospitalButton").on(
	"click",
	function () {
		reloadTableData(hospitalsTable);
	}
);

$("#addHospitalModal").on("shown.bs.modal", function () {
	$(this)
		.find('select[name="adminId"]')
		.select2({
			width: '1%',
			ajax: {
				url: baseUrl + "dashboard/getAllUnconnectedHospitalAdminsDatas",
				type: "GET",
				dataType: "json",
				delay: 250,
				processResults: function (response, params) {
					const searchTerm = params.term ? params.term.toLowerCase() : "";
					return {
						results: response.data
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
							}),
					};
				},
				cache: true,
			},
			minimumInputLength: 0,
			placeholder: "Choose Admin",
			allowClear: true,
			dropdownParent: $("#addHospitalModal .modal-body"),
			escapeMarkup: function (markup) {
				return markup;
			},
		});
});

// Add Data Hospital
$("#addHospitalForm").on("submit", function (e) {
	e.preventDefault();
	removeCleaveFormat();
	var formData = new FormData(this);
	$.ajax({
		url: baseUrl + "dashboard/hospitals/addHospital",
		method: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function (response) {
			var res = JSON.parse(response);
			res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
			if (res.status === "success") {
				reloadTableData(hospitalsTable);
				displayAlert("add success");
			} else if (res.status === "failed") {
				$(".error-message").remove();
				$(".is-invalid").removeClass("is-invalid");
				displayAlert(res.failedMsg, res.errorMsg ?? null);
				formatPhoneInput();
			} else if (res.status === "invalid") {
				displayFormValidation("#addHospitalForm", res.errors);
				formatPhoneInput();
			}
		},
	});
});

// View Data Hospital
$("#hospitalsTable").on("click", ".btn-view", function () {
	var data = hospitalsTable.row($(this).parents("tr")).data();
	let imageFilePath = `${baseUrl}assets/images/hospital-placeholder.jpg`;

	data.hospitalPhoto
		? (imageFilePath = `${baseUrl}uploads/photos/${data.hospitalPhoto}`)
		: data.hospitalLogo
		? (imageFilePath = `${baseUrl}uploads/logos/${data.hospitalLogo}`)
		: "";
	data.hospitalLogo &&
		$("#viewHospitalModal #imgPreview").attr(
			"src",
			`${baseUrl}uploads/logos/${data.hospitalLogo}`
		);
	$('#viewHospitalModal [name="hospitalId"]').val(data.hospitalId);
	$('#viewHospitalModal [name="hospitalName"]').val(data.hospitalName);
	$('#viewHospitalModal #hospitalAddress').html(data.hospitalAddress);
	$('#viewHospitalModal [name="hospitalCoordinate"]').val(
		data.hospitalCoordinate
	);
	$('#viewHospitalModal [name="hospitalPhone"]').val(data.hospitalPhone);
	adminData = data.adminName
		? `${data.adminName} | ${data.adminEmail}`
		: "No Admin";
	$('#viewHospitalModal [name="adminId"]').val(adminData);

	formatPhoneInput();

	$("#viewHospitalModal div#hospitalStatus").html(
		generateStatusData([data.hospitalStatus]).find(
			(d) => d.id === data.hospitalStatus
		)?.text || ""
	);

	$("#viewHospitalModal").on("shown.bs.modal", function () {
		var coordsArray = data.hospitalCoordinate.split(",");
		var latitude = parseFloat(coordsArray[0].trim());
		var longitude = parseFloat(coordsArray[1].trim());

		initializeMap(latitude, longitude, imageFilePath);
	});

	$.ajax({
		url: baseUrl + "dashboard/getHospitalDetailsByHospitalId?id=" + data.hospitalId,
		method: "GET",
		success: function (response) {
			var res = JSON.parse(response).data[0];
			console.log(res);
			for (const key in res) {
				if (res.hasOwnProperty(key)) {
					$(`#viewHospitalModal #${key}`).html(res[key]);
				}
			}
		},
	});
});

// Edit Data Hospital
$("#hospitalsTable").on("click", ".btn-edit", function () {
	var d = hospitalsTable.row($(this).parents("tr")).data();

	d.hospitalLogo && $("#editHospitalForm #imgPreview").attr("src", baseUrl + "uploads/logos/" + d.hospitalLogo);
	d.hospitalPhoto && $("#editHospitalForm #imgPreview2").attr("src", baseUrl + "uploads/photos/" + d.hospitalPhoto);
	$('#editHospitalForm [name="hospitalId"]').val(d.hospitalId);
	$('#editHospitalForm [name="hospitalName"]').val(d.hospitalName);
	$('#editHospitalForm [name="hospitalAddress"]').val(d.hospitalAddress);
	$('#editHospitalForm [name="hospitalPhone"]').val(d.hospitalPhone);

	formatPhoneInput();

    $('#editHospitalForm [name="adminId"]').empty().select2({
				width: '1%',
        placeholder: "Choose Admin",
        ajax: {
            url: baseUrl + "dashboard/getAllUnconnectedHospitalAdminsDatas",
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
                                        text: `${d.adminEmail} | ${d.adminName} | ${
                                                generateStatusData(["current"]).find(
                                                        (a) => a.id === "current"
                                                ).text
                                        }`,
                                        selected: true,
                                },
                        ]
                        : [];

                const allData = selectedData.concat(
                    response.data.map(function (data) {
                        return {
                            id: data.adminId,
                            text: `${data.adminEmail} | ${data.adminName} | ${
                                generateStatusData(["not linked"]).find(
                                    (a) => a.id === "not linked"
                                ).text
                            }`,
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
        allowClear: true,
        dropdownParent: $("#editHospitalModal .modal-body"),
        escapeMarkup: function (markup) {
            return markup;
        },
    });

	if (d.adminId) {
		var preselectedOption = new Option(
			`${d.adminEmail} | ${d.adminName} | ${generateStatusData(["current"]).find((d) => d.id === "current").text}`,
			d.adminId,
			true,
			true
		);
		$('#editHospitalForm [name="adminId"]').append(preselectedOption).trigger("change");
	}

	isRestrictedStatus = d.hospitalStatus === "unverified" || d.hospitalStatus === "independent";
	$('#editHospitalForm [name="hospitalStatus"]').select2({
		placeholder: "Choose Status",
		data: isRestrictedStatus
			? generateStatusData([d.hospitalStatus])
			: generateStatusData(["Active", "On Hold", "Discontinued"]),
		disabled: isRestrictedStatus,
		dropdownParent: $("#editHospitalModal .modal-body"),
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
	$('#editHospitalForm [name="hospitalStatus"]').val(d.hospitalStatus).trigger("change");
	isRestrictedStatus && $('#editHospitalForm [name="hospitalStatus"]').parents(".col-12").find(".warning-message").show();

    let previousStatus = isRestrictedStatus ? generateStatusData([d.hospitalStatus]) : generateStatusData(["Active", "On Hold", "Discontinued"]);
    $('#editHospitalForm [name="adminId"]').on('change', function() {
        let adminId = $(this).val();
        let hospitalStatusSelect = $('#editHospitalForm [name="hospitalStatus"]');

        hospitalStatusSelect.empty();
        if (adminId && adminId === d.adminId && previousStatus) {
            hospitalStatusSelect.prop('disabled', false);
            previousStatus.forEach(function(status) {
                if (status.id === d.hospitalStatus) {
                    let option = new Option(status.text, status.id, true, true);
                    hospitalStatusSelect.append(option);
                } else {
                    let option = new Option(status.text, status.id, false, false);
                    hospitalStatusSelect.append(option);
                }
            });
        } else if (adminId && adminId != d.adminId) {
            hospitalStatusSelect.prop('disabled', true);
            let optionData = generateStatusData(['unverified']).find((data) => data.id === 'unverified');
            if (optionData) {
                hospitalStatusSelect.append(new Option(optionData.text, 'unverified', true, true));
            }
        } else if (!adminId) {
            hospitalStatusSelect.prop('disabled', true);
            let optionData = generateStatusData(['independent']).find((data) => data.id === 'independent');
            if (optionData) {
                hospitalStatusSelect.append(new Option(optionData.text, 'independent', true, true));
            }
        }
        hospitalStatusSelect.trigger('change');
    });
});

$("#editHospitalForm").on("submit", function (e) {
	e.preventDefault();
	removeCleaveFormat();
	$.ajax({
		url: baseUrl + "dashboard/hospitals/editHospital",
		method: "POST",
		data: new FormData(this),
		contentType: false,
		processData: false,
		success: function (response) {
			var res = JSON.parse(response);
			res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
			if (res.status === "success") {
				reloadTableData(hospitalsTable);
				displayAlert("edit success");
			} else if (res.status === "failed") {
				$(".error-message").remove();
				$(".is-invalid").removeClass("is-invalid");
				displayAlert(res.failedMsg, res.errorMsg ?? null);
				formatPhoneInput();
			} else if (res.status === "invalid") {
				displayFormValidation("#editHospitalForm", res.errors);
				formatPhoneInput();
			}
		},
	});
});

// Delete Hospital
$("#hospitalsTable").on("click", ".btn-delete", function () {
	var data = hospitalsTable.row($(this).parents("tr")).data();
	$("#deleteHospitalForm #hospitalName").html(data.hospitalName);
	$('#deleteHospitalForm [name="hospitalId"]').val(data.hospitalId);
});

$("#deleteHospitalForm").on("submit", function (e) {
	e.preventDefault();
	$.ajax({
		url: baseUrl + "dashboard/hospitals/deleteHospital",
		method: "POST",
		data: $(this).serialize(),
		success: function (response) {
			var res = JSON.parse(response);
			res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
			if (res.status === "success") {
				reloadTableData(hospitalsTable);
				displayAlert("delete success");
			} else if (res.status === "failed") {
				displayAlert(res.failedMsg);
			}
		},
	});
});
