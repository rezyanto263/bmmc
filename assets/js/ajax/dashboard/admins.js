// Admins CRUD
var adminsTable = $("#adminsTable").DataTable(
	$.extend(true, {}, DataTableSettings, {
		ajax: baseUrl + "dashboard/getAllAdminsDatas",
		columns: [
			{
				data: "adminName",
				className: "align-middle",
			},
			{
				data: "adminEmail",
				className: "align-middle",
			},
			{
				data: "adminRole",
				className: "align-middle",
				render: function (data, type, row) {
					return capitalizeWords(data);
				},
			},
			{
				data: "status",
				className: "text-nowrap align-middle",
				render: function (data, type, row) {
					if (!data) {
						data = row.adminRole == "admin" ? "not partner" : "not linked";
					}
					return (
						`<div class="${statusColor(data)} status-circle"></div>  ` +
						capitalizeWords(data)
					);
				},
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
				className:"text-end user-select-none no-export no-visibility",
				orderable: false,
				defaultContent: `
              <button 
                  type="button" 
                  class="btn-edit btn-warning rounded-2" 
                  data-bs-toggle="modal" 
                  data-bs-target="#editAdminModal">
                  <i class="fa-regular fa-pen-to-square"></i>
              </button>
              <button 
                  type="button" 
                  class="btn-delete btn-danger rounded-2" 
                  data-bs-toggle="modal" 
                  data-bs-target="#deleteAdminModal">
                      <i class="fa-solid fa-trash-can"></i>
              </button>
          `,
			},
		],
		columnDefs: [{ width: "80px", target: 6 }],
	})
);

// Add Data
$("#addAdminForm").on("submit", function (e) {
	e.preventDefault();
	$.ajax({
		url: baseUrl + "dashboard/admins/addAdmin",
		method: "POST",
		data: $(this).serialize(),
		success: function (response) {
			var res = JSON.parse(response);
			res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
			if (res.status === "success") {
				reloadTableData(adminsTable);
				displayAlert("add success");
			} else if (res.status === "failed") {
				$(".error-message").remove();
				$(".is-invalid").removeClass("is-invalid");
				displayAlert(res.failedMsg);
			} else if (res.status === "invalid") {
				displayFormValidation("#addAdminForm", res.errors);
			}
		},
	});
});

$("#addAdminModal").on("show.bs.modal", function () {
	$(this)
		.find('select[name="adminRole"]')
		.select2({
			placeholder: "Choose Role",
			dropdownParent: $("#addAdminModal .modal-body"),
		});
});

// Edit Data
$("#adminsTable").on("click", ".btn-edit", function () {
	var data = adminsTable.row($(this).parents("tr")).data();
	$('#editAdminForm [name="adminId"]').val(data.adminId);
	$('#editAdminForm [name="adminName"]').val(data.adminName);
	$('#editAdminForm [name="adminEmail"]').val(data.adminEmail);

	isLinked = data.status ? true : false;
	isAdmin = data.adminRole == "admin";
	const disableRoleSelect = isAdmin ? false : isLinked;

	$('#editAdminForm [name="adminRole"]').select2({
		placeholder: "Choose Role",
		dropdownParent: $("#editAdminModal .modal-body"),
		disabled: disableRoleSelect,
	});
	disableRoleSelect &&
		$('#editAdminForm [name="adminRole"]')
			.parents(".col-12")
			.find(".warning-message")
			.show();

	$('#editAdminForm [name="adminRole"]').val(data.adminRole).trigger("change");
});

$("#editAdminForm").on("submit", function (e) {
	e.preventDefault();
	$.ajax({
		url: baseUrl + "dashboard/admins/editAdmin",
		method: "POST",
		data: $(this).serialize(),
		success: function (response) {
			var res = JSON.parse(response);
			res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
			if (res.status === "success") {
				displayAlert("edit success");
				reloadTableData(adminsTable);
			} else if (res.status === "failed") {
				$(".error-message").remove();
				$(".is-invalid").removeClass("is-invalid");
				displayAlert(res.failedMsg);
			} else if (res.status === "invalid") {
				displayFormValidation("#editAdminForm", res.errors);
			}
		},
	});
});

// Delete Data
$("#adminsTable").on("click", ".btn-delete", function () {
	var data = adminsTable.row($(this).parents("tr")).data();
	$("#deleteAdminForm #adminName").html(data.adminName);
	$('#deleteAdminForm [name="adminId"]').val(data.adminId);
});

$("#deleteAdminForm").on("submit", function (e) {
	e.preventDefault();
	$.ajax({
		url: baseUrl + "dashboard/admins/deleteAdmin",
		method: "POST",
		data: $(this).serialize(),
		success: function (response) {
			var res = JSON.parse(response);
			res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
			if (res.status === "success") {
				displayAlert("delete success");
				reloadTableData(adminsTable);
			} else if (res.status === "failed") {
				displayAlert(res.failedMsg);
			}
		},
	});
});
