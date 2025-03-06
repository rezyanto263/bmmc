// Diseases CRUD
var diseasesTable = $("#diseasesTable").DataTable($.extend(true, {}, DataTableSettings, {
		ajax: baseUrl + "dashboard/getAllDiseasesDatas",
		columns: [
			{
				data: "diseaseName",
				className: "align-middle",
			},
			{
				data: "diseaseInformation",
				className: 'text-wrap',
				render: function(data, type) {
						if (type === 'display' || type === 'filter') {
								return `<div class="text-2-row">${data}</div>`;
						}
						return data;
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
                  data-bs-target="#editDiseaseModal">
                  <i class="fa-regular fa-pen-to-square"></i>
              </button>
              <button 
                  type="button" 
                  class="btn-delete btn-danger rounded-2" 
                  data-bs-toggle="modal" 
                  data-bs-target="#deleteDiseaseModal">
                      <i class="fa-solid fa-trash-can"></i>
              </button>
          `,
			},
		],
		columnDefs: [{ width: "80px", target: 2 }],
	})
);



// Add Data
$('#addDiseaseForm').on('submit', function(e) {
	e.preventDefault();
	$.ajax({
		url: baseUrl + "dashboard/diseases/addDisease",
		method: 'POST',
		data: $(this).serialize(),
		success: function(response) {
			let res = JSON.parse(response);
			res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
			if (res.status === 'success') {
				reloadTableData(diseasesTable);
				displayAlert("add success");
			} else if (res.status === "failed") {
				$(".error-message").remove();
				$(".is-invalid").removeClass("is-invalid");
				displayAlert(res.failedMsg);
			} else if (res.status === "invalid") {
				displayFormValidation("#addDiseaseForm", res.errors);
			}
		}
	})
});



// Edit Data
$('#diseasesTable').on('click', '.btn-edit', function() {
	let data = diseasesTable.row($(this).parents('tr')).data();
	$('#editDiseaseForm [name="diseaseId"]').val(data.diseaseId);
	$('#editDiseaseForm [name="diseaseName"]').val(data.diseaseName);
	$('#editDiseaseForm [name="diseaseInformation"]').val(data.diseaseInformation);
})

$('#editDiseaseForm').on('submit', function(e) {
	e.preventDefault();
	$.ajax({
		url: baseUrl + "dashboard/diseases/editDisease",
		method: 'POST',
		data: $(this).serialize(),
		success: function(response) {
			let res = JSON.parse(response);
			res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
			if (res.status === 'success') {
				reloadTableData(diseasesTable);
				displayAlert("edit success");
			} else if (res.status === "failed") {
				$(".error-message").remove();
				$(".is-invalid").removeClass("is-invalid");
				displayAlert(res.failedMsg);
			} else if (res.status === "invalid") {
				displayFormValidation("#editDiseaseForm", res.errors);
			}
		}
	});
});



// Delete Data
$('#diseasesTable').on('click', '.btn-delete', function() {
	let data = diseasesTable.row($(this).parents('tr')).data();
	$('#deleteDiseaseForm #diseaseName').html(data.diseaseName);
	$('#deleteDiseaseForm [name="diseaseId"]').val(data.diseaseId);
});

$('#deleteDiseaseForm').on('submit', function(e) {
	e.preventDefault();
	$.ajax({
		url: baseUrl + "dashboard/diseases/deleteDisease",
		method: 'POST',
		data: $(this).serialize(),
		success: function(response) {
			let res = JSON.parse(response);
			res.csrfToken && $(`input[name="${csrfName}"]`).val(res.csrfToken);
			if (res.status === 'success') {
				reloadTableData(diseasesTable);
				displayAlert("delete success");
			} else if (res.status === "failed") {
				displayAlert(res.failedMsg);
			}
		}
	});
});