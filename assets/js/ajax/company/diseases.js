// Diseases CRUD
var diseasesTable = $("#diseasesTable").DataTable($.extend(true, {}, DataTableSettings, {
  ajax: baseUrl + "company/getCompanyDiseases",
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
              return `<div class="text-2-row" style="min-width: 250px;">${data}</div>`;
          }
          return data;
      }
    },
    {
      data: 'diseaseId',
      className:"text-end user-select-none no-export no-visibility text-center",
      render: function(data, type, row) {
        if (type === 'sort') {
          return row.diseaseStatus;
        }
        let checked = row.diseaseStatus == 1 ? 'checked' : '';
        let coverage = row.diseaseStatus == 1 ? 'Covered' : 'Not Covered';
        return `
            <div class="form-check form-switch px-0 d-flex justify-content-center" title="${coverage}">
              <input class="form-check-input mx-0" type="checkbox" role="switch" ${checked} style="width: 3rem; height: 1.5rem;">
            </div>
        `
      }
    },
  ],
  columnDefs: [{ width: "80px", targets: 2 }],
  order: [[2, 'asc']],
}));


$('#diseasesTable').off('change').on('change', '.form-check-input[type="checkbox"][role="switch"]', function() {
  let diseaseId = diseasesTable.row($(this).parents('tr')).data().diseaseId;
  let status = $(this).is(':checked');
  let csrfToken = $('input[name="' + csrfName + '"]').val();
  let url = status ? baseUrl + "company/diseases/deleteDisabledDisease" : baseUrl + "company/diseases/addDisabledDisease";

  $.ajax({
      url: url,
      method: 'POST',
      global: false,
      data: { 
        diseaseId: diseaseId,
        [csrfName]: csrfToken
      },
      beforeSend: function() {
        $('.form-check-input[type="checkbox"][role="switch"]').css('pointer-events', 'none');
      },
      success: function(response) {
        let res = JSON.parse(response);
        res.csrfToken && $('input[name="' + csrfName + '"]').val(res.csrfToken);
        if (res.status === 'success') {
          displayAlert('edit success');
          reloadTableData(diseasesTable);
        }
      }
  });
});