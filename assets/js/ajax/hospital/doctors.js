// CRUD Data Doctors
var doctorsTable = $("#doctorsTable").DataTable(
	$.extend(true, {}, DataTableSettings, {
		ajax: baseUrl + "hospital/getAllDoctorsByHospitalId",
		columns: [
			{ data: "doctorName" },
			{ data: "doctorSpecialization" },
			{
				data: "doctorDateOfBirth",
				className: 'text-start',
				render: function (data, type, row) {
					if (type === "display" || type === "filter") {
						return moment(data).format("ddd, D MMMM YYYY");
					}
					return data;
				},
			},
			{
				data: "doctorStatus",
				render: function (data, type, row) {
					if (type === 'display' || type === 'filter') {
						return generateStatusData([data]).find((d) => d.id === data).text;
					}
					return data;
				},
			},
			{ 
				data: "doctorAddress",
				className: 'text-wrap',
				render: function(data, type) {
						if (type === 'display' || type === 'filter') {
								return `<div class="text-2-row" style="width: 250px;">${data}</div>`;
						}
						return data;
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
                  class="btn-edit btn-warning rounded-2" 
                  data-bs-toggle="modal" 
                  data-bs-target="#editDoctorModal" title="Edit Doctor">
                      <i class="fa-regular fa-pen-to-square"></i>
              </button>
              <button 
                  type="button" 
                  class="btn-delete btn-danger rounded-2" 
                  data-bs-toggle="modal" 
                  data-bs-target="#deleteDoctorModal" title="Delete Doctor">
                      <i class="fa-solid fa-trash-can"></i>
              </button>
          `,
			},
		],
		order: [[3, 'asc']],
		columnDefs: [{ width: "80px", targets: 5 }],
	})
);

$("#addDoctorButton, #editDoctorButton, #deleteDoctorButton").on(
	"click",
	function () {
		reloadTableData(doctorsTable);
	}
);


// Add Data Doctor
$("#addDoctorForm").on("submit", function (e) {
	e.preventDefault();
	$.ajax({
		url: baseUrl + 'hospital/doctors/addDoctor',
		method: "POST",
		data: $(this).serialize(),
		success: function (response) {
			console.log(response);
			let res = JSON.parse(response);
			res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
			if (res.status === "success") {
				reloadTableData(doctorsTable);
				displayAlert("add success");
			} else if (res.status === "failed") {
				$(".error-message").remove();
				$(".is-invalid").removeClass("is-invalid");
				displayAlert(res.failedMsg, res.errorMsg ?? null);
			} else if (res.status === "invalid") {
				displayFormValidation("#addDoctorForm", res.errors);
			}
		},
	});
});

$("#addDoctorModal").on("show.bs.modal", function () {
	$('#addDoctorForm [name="doctorStatus"]').select2({
		placeholder: "Choose Status",
		data: generateStatusData(['active', 'disabled']),
		dropdownParent: $("#addDoctorModal .modal-body"),
		escapeMarkup: function (markup) {
			return markup;
		}
	});

	$('#addDoctorForm [name="doctorSpecialization[]"]').select2({
		placeholder: "Choose or Create Specialization",
		tags: true,
		ajax: {
			url: baseUrl + 'hospital/getAllDoctorSpecialization',
      type: 'GET',
      dataType: 'json',
      delay: 250,
      processResults: function (response, params) {
				let searchTerm = params.term? params.term.toLowerCase() : '';
        return {
          results: response.data
						.filter((d) => d.toLowerCase().includes(searchTerm))
						.map((d) => ({
							id: d,
              text: d
						}))
        };
      },
    },
		minimumInputLength: 0,
		dropdownParent: $("#addDoctorModal .modal-body")
	});
	setTimeout(() => {
		$('.select2-selection--multiple textarea').scrollTop(3.5);
	}, 200);
});



// Edit Data Doctor
$("#doctorsTable").off('click').on("click", ".btn-edit", function () {
	var data = doctorsTable.row($(this).parents("tr")).data();
	$('#editDoctorForm [name="doctorId"]').val(data.doctorId);
	$('#editDoctorForm [name="doctorName"]').val(data.doctorName);
	$('#editDoctorForm [name="doctorAddress"]').val(data.doctorAddress);
	$('#editDoctorForm [name="doctorDateOfBirth"]')[0]._flatpickr.setDate(data.doctorDateOfBirth);
	$('#editDoctorForm [name="doctorSpecialization"]').val(data.doctorSpecialization);

	$('#editDoctorForm [name="doctorStatus"]').select2({
		placeholder: "Choose Status",
		data: generateStatusData(['active', 'disabled']),
		dropdownParent: $("#editDoctorModal .modal-body"),
		escapeMarkup: function (markup) {
			return markup;
		}
	});
	$('#editDoctorForm [name="doctorStatus"]').val(data.doctorStatus).trigger('change');

	$('#editDoctorForm [name="doctorSpecialization[]"]').empty().select2({
		placeholder: "Choose or Create Specialization",
		tags: true,
		ajax: {
			url: baseUrl + 'hospital/getAllDoctorSpecialization',
			type: 'GET',
			dataType: 'json',
			delay: 250,
			processResults: function (response, params) {
				const searchTerm = params.term? params.term.toLowerCase() : '';
				return {
					results: response.data
						.filter((d) => d.toLowerCase().includes(searchTerm))
						.map((d) => ({
							id: d,
							text: d
						}))
				};
			},
		},
		dropdownParent: $("#editDoctorModal .modal-body")
	});

	$.ajax({
		url: baseUrl + 'hospital/getAllDoctorSpecialization',
		type: 'GET',
		success: function(response) {
			let res = JSON.parse(response);
			res.data.forEach(function(d) {
				if(data.doctorSpecialization.split(', ').includes(d)) {
					$('#editDoctorForm [name="doctorSpecialization[]"]').append(new Option(d, d, true, true)).trigger('change');
				}
			});
		}
	});
	setTimeout(() => {
		$('.select2-selection--multiple textarea').scrollTop(3.5);
	}, 200);
});

$("#editDoctorForm").on("submit", function (e) {
	e.preventDefault();
	$.ajax({
		url: baseUrl + "hospital/doctors/editDoctor",
		method: "POST",
		data: $(this).serialize(),
		success: function (response) {
			let res = JSON.parse(response);
			res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
			if (res.status === "success") {
				reloadTableData(doctorsTable);
				displayAlert("edit success");
			} else if (res.status === "failed") {
				$(".error-message").remove();
				$(".is-invalid").removeClass("is-invalid");
				displayAlert(res.failedMsg);
			} else if (res.status === "invalid") {
				displayFormValidation("#editDoctorForm", res.errors);
			}
		},
	});
});



// Delete Data Doctor
$("#doctorsTable").on("click", ".btn-delete", function () {
	var data = doctorsTable.row($(this).parents("tr")).data();
	$('#deleteDoctorForm #doctorName').text(data.doctorName);
	$('#deleteDoctorForm [name="doctorId"]').val(data.doctorId);
});

$("#deleteDoctorForm").on("submit", function (e) {
	e.preventDefault();
	$.ajax({
		url: baseUrl + "hospital/doctors/deleteDoctor",
		method: "POST",
		data: $(this).serialize(),
		success: function (response) {
			var res = JSON.parse(response);
			res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
			if (res.status === "success") {
				displayAlert("delete success");
				reloadTableData(doctorsTable);
			} else if (res.status === "failed") {
				displayAlert(res.failedMsg);
			}
		},
	});
});