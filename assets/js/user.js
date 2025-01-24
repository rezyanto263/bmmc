// Configuration
var DataTableSettings = {
    processing: true,
    columnDefs: [
        {width: '70px', target: 0},
    ],
    buttons: [
        {
            extend: 'copyHtml5',
            text: 'Copy',
            exportOptions: {
                columns: ':visible:not(.no-export)'
            }
        },
        {
            extend: 'excelHtml5',
            text: 'Excel',
            exportOptions: {
                columns: ':visible:not(.no-export)'
            }
        },
        {
            extend: 'pdfHtml5',
            text: 'PDF',
            orientation: 'portrait',
            pageSize: 'A4',
            exportOptions: {
                columns: ':visible:not(.no-export)'
            },
            customize: function (doc) {
                doc.content[1].table.widths = 
                    Array(doc.content[1].table.body[0].length + 1).join('*').split('');
            }
        }
    ],
    layout: {
        topStart: 'buttons',
        topEnd: {
            pageLength: {
                menu: [10, 20, 50, 100]
            },
            search: {
                placeholder: 'Search'
            },
        },
        bottomStart: 'info',
        bottomEnd: 'paging',
    },
    paging: true,
    searching: true,
    ordering: true,
}

var userHistoryTable = $('#userHistoryTable').DataTable($.extend(true, {}, DataTableSettings, {
    ajax: baseUrl + 'user/getUserHistories', 
    columns: [
        {
            data: null,
            className: 'text-start',
            render: function (data, type, row, meta) {
                return meta.row + 1;
            }
        },
        {
            data: 'historyhealthRole',
            render: function (data, type, row) {
                if (data === 'employee') {
                    return row.employeeName;
                } else {
                    return row.familyName;
                }
            }
        },
        {data: 'hospitalName'},
        {data: 'doctorName'},
        {
            data: 'diseaseName',
            name: 'diseaseName',
            render: function (data, type, row) {
                if (row.historyhealthTotalBill == 0 && row.historyhealthDiscount == 0) {
                    return 'Referred';
                } else {
                    return data;
                }
            }
        },
        {
            data: 'historyhealthTotalBill',
            render: function (data) {
                return 'Rp ' + parseFloat(data).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            }
        },
        {
            data: 'historyhealthDate',
            render: function (data, type, row) {
                if (type === 'display' || type === 'filter') {
                    if (data) {
                        return moment(data).format('DD MMMM YYYY');
                    } else {
                        return '';
                    }
                }
                return data;
            }
        },
        {
            data: null,
            className: 'text-end user-select-none no-export',
            orderable: false,
            defaultContent: `
                <button 
                    type="button" 
                    class="btn-view btn-primary rounded-2 ms-1 mx-0 px-4 d-inline-block my-1" 
                    data-bs-toggle="modal" 
                    data-bs-target="#detailHistoryModal"
                    title="View History">
                    <i class="fa-regular fa-eye"></i>
                </button>
            `
        }
    ],
    columnDefs: [
        {width: '180px', target: 1}
    ]
}));

document.addEventListener("DOMContentLoaded", function () {
    $.ajax({
        url: baseUrl + 'landing/getActiveHospitalDatas',
        method: 'GET',
        success: function(response) {
            var res = JSON.parse(response);
            if (res.status === 'success') {
                var hospitals = res.data;
                var htmlNormal = '';
                var htmlReverse = '';

                $.each(hospitals, function(index, hospital) {
                    var logo = hospital.hospitalLogo ? baseUrl + 'uploads/logos/' + hospital.hospitalLogo : baseUrl + 'assets/images/user-placeholder.png';

                    htmlNormal += '<div class="splide__slide d-flex align-items-center">';
                    htmlNormal += '<img src="' + logo + '" alt="" class="img-mitra" loading="lazy">';
                    htmlNormal += '</div>';

                    htmlReverse += '<div class="splide__slide d-flex align-items-center">';
                    htmlReverse += '<img src="' + logo + '" alt="" class="img-mitra" loading="lazy">';
                    htmlReverse += '</div>';
                });

                $('.splide.normal .splide__list.partner-normal').html(htmlNormal);
                $('.splide.reverse .splide__list.partner-reverse').html(htmlReverse);

                new Splide(".normal", {
                    type: "loop",
                    drag: "free",
                    focus: "center",
                    pagination: false,
                    arrows: false,
                    perPage: 5,
                    autoScroll: {
                        speed: 0.5,
                    },
                    breakpoints: {
                        768: {
                            perPage: 3,
                        },
                        640: {
                            perPage: 2,
                        },
                    },
                }).mount(window.splide.Extensions);

                new Splide(".reverse", {
                    type: "loop",
                    drag: "free",
                    focus: "center",
                    pagination: false,
                    arrows: false,
                    perPage: 5,
                    autoScroll: {
                        speed: -0.5,
                    },
                    breakpoints: {
                        768: {
                            perPage: 3,
                        },
                        640: {
                            perPage: 2,
                        },
                    },
                }).mount(window.splide.Extensions);
            } else if (res.status === 'failed') {
                displayAlert(res.failedMsg);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
            displayAlert('Failed to load hospital data.');
        }
    });
});