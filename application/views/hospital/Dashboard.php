<div class="content-body py-3">
    <div class="row gy-4">
        <div class="col-12 col-lg-6 d-flex justify-content-center align-items-center order-0 order-lg-0">
            <div class="row gy-4">
                <div class="col-12 d-flex flex-column justify-content-center align-items-center">
                    <div class="imgContainer">
                        <img src="<?= base_url('uploads/logos/' . $company['companyLogo']); ?>" data-originalsrc="<?= base_url('uploads/logos/' . $company['companyLogo']); ?>" alt="Company Logo" draggable="false" id="imgPreview" data-bs-toggle="tooltip" data-bs-title="Company Logo">
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group p-0">
                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company Name">
                            <i class="las la-building fs-4"></i>
                        </span>
                        <input class="form-control" type="text" placeholder="Name" name="companyName" value="<?= $company['companyName'] ?? 'Company Name' ?>" disabled>
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group p-0">
                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Admin Account">
                            <i class="las la-user-cog fs-4"></i>
                        </span>
                        <input class="form-control" type="text" placeholder="Admin Account" name="adminId" value="<?= $admin['adminId'] ?? 'Admin Account' ?>" disabled>
                    </div>
                </div>
                <div class="col-12 col-lg-7 col-xl-6">
                    <div class="input-group p-0">
                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company Phone">
                            <i class="las la-phone fs-4"></i>
                        </span>
                        <input class="form-control phone-input" type="text" placeholder="Phone Number" name="companyPhone" value="<?= $company['companyPhone'] ?? 'Phone Number' ?>" disabled>
                    </div>
                </div>
                <div class="col-12 col-lg-5 col-xl-6">
                    <div class="input-group p-0">
                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company Status">
                            <i class="las la-tag fs-4"></i>
                        </span>
                        <div class="form-control" placeholder="Company Status" id="companyStatus"><?= $company['companyStatus'] ?? 'Company Status' ?></div>
                    </div>
                </div>
                <div class="col-12">   
                    <div class="input-group p-0">
                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company Address">
                            <i class="las la-map fs-4"></i>
                        </span>
                        <input class="form-control" type="text" placeholder="Company Address" name="companyAddress" value="<?= $company['companyAddress'] ?? 'Company Address' ?>" disabled>
                    </div>
                </div>
                <div class="col-12">   
                    <div class="input-group p-0">
                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company Coordinate">
                            <i class="las la-map-marker fs-4"></i>
                        </span>
                        <input class="form-control" type="text" placeholder="Location Coordinate" name="companyCoordinate" value="<?= $company['companyCoordinate'] ?? 'Location Coordinate' ?>" disabled>
                    </div>
                    <button class="btn btn-primary btn-edit w-100 mt-3" data-bs-toggle="modal" data-bs-target="#editHotelModal"><i class="las la-edit fs-4"></i><span>Edit</span></button> 
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 d-flex justify-content-center align-items-center order-4 order-lg-1">
            <div id="map" class="w-100 h-100" style="min-height:450px"></div>
        </div>
        <div class="col-12 order-1 order-lg-2">
            <div class="row g-4">
                <div class="col-12 col-lg-3">
                    <div class="card bg-transparent box-total">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <h5 class="card-title text-center">TOTAL INVOICES</h5>
                            <h1 class="text-center fw-bold" id="totalInvoices"><?= $invoices['total'] ?? 0 ?></h1>
                            <div class="card-text text-center">
                                <hr>
                                <div class="d-flex justify-content-around">
                                    <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Paid">
                                        <i class="las la-file-invoice-dollar text-success fs-4"></i>
                                        <span id="totalPaidInvoices"><?= $invoices['paid'] ?? 0 ?></span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Unpaid">
                                        <i class="las la-file-invoice-dollar text-danger fs-4"></i>
                                        <span id="totalUnpaidInvoices"><?= $invoices['unpaid'] ?? 0 ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-3">
                    <div class="card bg-transparent box-total">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <h5 class="card-title text-center">TOTAL EMPLOYEES</h5>
                            <h1 class="text-center fw-bold" id="totalEmployees"><?= $employees['total'] ?? 0 ?></h1>
                            <div class="card-text text-center">
                                <hr>
                                <div class="d-flex justify-content-around">
                                    <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Unverified">
                                        <i class="las la-user-tie text-secondary-subtl fs-4"></i>
                                        <span id="totalUnverifiedEmployees"><?= $employees['unverified'] ?? 0 ?></span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Active">
                                        <i class="las la-user-tie text-success fs-4"></i>
                                        <span id="totalActiveEmployees"><?= $employees['active'] ?? 0 ?></span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="On Hold">
                                        <i class="las la-user-tie text-warning fs-4"></i>
                                        <span id="totalOnHoldEmployees"><?= $employees['onHold'] ?? 0 ?></span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Discontinued">
                                        <i class="las la-user-tie text-secondary fs-4"></i>
                                        <span id="totalDiscontinuedEmployees"><?= $employees['discontinued'] ?? 0 ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-3">
                    <div class="card bg-transparent box-total">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <h5 class="card-title text-center">TOTAL FAMILY MEMBERS</h5>
                            <h1 class="text-center fw-bold" id="totalFamilyMembers"><?= $familyMembers['total'] ?? 0 ?></h1>
                            <div class="card-text text-center">
                                <hr>
                                <div class="d-flex justify-content-around">
                                    <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Unverified">
                                        <i class="las la-users text-secondary-subtl fs-4"></i>
                                        <span id="totalUnverifiedFamilyMembers"><?= $familyMembers['unverified'] ?? 0 ?></span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Active">
                                        <i class="las la-users text-success fs-4"></i>
                                        <span id="totalActiveFamilyMembers"><?= $familyMembers['active'] ?? 0 ?></span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="On Hold">
                                        <i class="las la-users text-warning fs-4"></i>
                                        <span id="totalOnHoldFamilyMembers"><?= $familyMembers['onHold'] ?? 0 ?></span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Archived">
                                        <i class="las la-users text-secondary fs-4"></i>
                                        <span id="totalArchivedFamilyMembers"><?= $familyMembers['archived'] ?? 0 ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-3">
                    <div class="card bg-transparent box-total">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <h5 class="card-title text-center">BILLING REMAINING</h5>
                            <!-- <h4 class="text-center fw-bold"  id="totalBillingRemaining">Rp <?= number_format($billing['remaining'] ?? 0, 2, ',', '.') ?></h4>
                            <span class="text-center" style="font-size: 0.8rem;" id="billingDate" data-bs-toggle="tooltip" data-bs-title="Billing Start - Billing End">
                                <?= date('d M Y', strtotime($billing['start'])) ?> - <?= date('d M Y', strtotime($billing['end'])) ?>
                            </span>
                            <div class="card-text text-center">
                                <hr class="mt-0">
                                <div class="d-flex justify-content-around">
                                    <div class="d-inline-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Billing Used">
                                        <i class="las la-credit-card text-danger fs-4"></i>
                                        <span style="font-size: 0.8rem;" id="totalBillingUsed"><?= number_format($billing['used'] ?? 0, 2, ',', '.') ?></span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Billing Amount">
                                        <i class="las la-credit-card text-info fs-4"></i>
                                        <span style="font-size: 0.8rem;" id="totalBillingAmount"><?= number_format($billing['amount'] ?? 0, 2, ',', '.') ?></span> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal for Editing Hotel -->
        <div class="modal fade" id="editHotelModal" tabindex="-1" aria-labelledby="editHotelModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editHotelModalLabel">Edit Data Hotel</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editHotelForm" action="<?= base_url('company/dashboard/editCompany') ?>" method="post" enctype="multipart/form-data">
                            <!-- Logo -->
                            <div class="d-flex flex-column justify-content-center align-items-center mb-3">
                                <div class="imgContainer">
                                    <img src="<?= base_url('uploads/logos/' . ($company['companyLogo'] ?? 'default_logo.jpg')); ?>" alt="Hotel Logo" id="hotelLogoPreview" class="img-thumbnail" style="max-width: 150px;">
                                </div>
                                <label class="btn btn-warning mt-3 text-center w-50" for="uploadHotelLogo">UPLOAD LOGO</label>
                                <input type="file" accept="image/jpg, image/jpeg, image/png" name="companyLogo" id="uploadHotelLogo" hidden>
                            </div>
                            <!-- Hotel ID (hidden) -->
                            <input type="hidden" name="companyId" value="<?= $company['companyId'] ?? '' ?>">
                            <!-- Hotel Name -->
                            <div class="form-group mb-3">
                                <label for="hotelName">Nama Hotel</label>
                                <input type="text" class="form-control" id="hotelName" name="companyName" value="<?= $company['companyName'] ?? 'Hotel Name' ?>" required>
                            </div>
                            <!-- Address -->
                            <div class="form-group mb-3">
                                <label for="hotelAddress">Alamat</label>
                                <textarea class="form-control" id="hotelAddress" name="companyAddress" rows="2" required><?= $company['companyAddress'] ?? 'Jalan Contoh No.123, Kota ABC' ?></textarea>
                            </div>
                            <!-- Phone -->
                            <div class="form-group mb-3">
                                <label for="hotelPhone">Telepon</label>
                                <input type="text" class="form-control" id="hotelPhone" name="companyPhone" value="<?= $company['companyPhone'] ?? 'companyPhone' ?>" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">CANCEL</button>
                        <button type="submit" class="btn btn-primary" form="editHotelForm">SAVE</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Edit Data Company
    $('#editHotelModal').on('show.bs.modal', function() {
        var data = {
            companyLogo: '<?= $company['companyLogo'] ?? 'default_logo.jpg' ?>',
            companyId: '<?= $company['companyId'] ?? '' ?>',
            companyName: '<?= $company['companyName'] ?? 'Hotel Name' ?>',
            companyPhone: '<?= $company['companyPhone'] ?? '' ?>',
            companyAddress: '<?= $company['companyAddress'] ?? '' ?>',
            adminId: '<?= $company['adminId'] ?? '' ?>',
            adminName: '<?= $company['adminName'] ?? '' ?>',
            adminEmail: '<?= $company['adminEmail'] ?? '' ?>'
        };

        if (data.companyLogo) {
            $('#editHotelForm #hotelLogoPreview').attr('src', baseUrl + 'uploads/logos/' + data.companyLogo);
        }
        $('#editHotelForm [name="companyId"]').val(data.companyId);
        $('#editHotelForm [name="companyName"]').val(data.companyName);
        $('#editHotelForm [name="companyPhone"]').val(data.companyPhone);
        $('#editHotelForm [name="companyAddress"]').val(data.companyAddress);

        var selectedAdmin = '';
        if (data.adminId) {
            selectedAdmin = '<option value="'+data.adminId+'">'+data.adminName+' | '+data.adminEmail+'</option>';
        }

        $('#editHotelForm select#adminId').html(selectedAdmin);
        $('#editHotelForm select#adminId').select2({
            placeholder: 'Choose Admin',
            allowClear: true,
            dropdownParent: $('#editHotelModal .modal-body'),
        });

        $.ajax({
            url: baseUrl + 'dashboard/getAllUnconnectedCompanyAdminsDatas',
            method: 'GET',
            success: function(response) {
                var res = JSON.parse(response);
                let optionList = [selectedAdmin];
                $.each(res.data, function(index, data) {
                    optionList += '<option value="'+data.adminId+'">'+data.adminName+' | '+data.adminEmail+'</option>';
                });

                $('#editHotelForm select#adminId').html(optionList);
                $('#editHotelForm select#adminId').val(data.adminId).trigger('change');
            }
        });
    });

    // Handle form submission
    $('#editHotelForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: baseUrl + 'dashboard/companies/editCompany',
            method: 'POST',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function(response) {
                var res = JSON.parse(response);
                if (res.status === 'success') {
                    $('#editHotelModal').modal('hide');
                    reloadTableData(companiesTable);
                    displayAlert('edit success');
                } else if (res.status === 'failed') {
                    $('.error-message').remove();
                    $('.is-invalid').removeClass('is-invalid');
                    displayAlert(res.failedMsg, res.errorMsg ?? null);
                } else if (res.status === 'invalid') {
                    displayFormValidation('#editHotelForm', res.errors);
                }
            }
        });
    });
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Ambil koordinat perusahaan yang ada di session
    var companyCoordinates = "<?php echo $company['companyCoordinate']; ?>";

    // Pastikan koordinat valid
    if (companyCoordinates) {
        var coordsArray = companyCoordinates.split(',');
        var latitude = parseFloat(coordsArray[0].trim());
        var longitude = parseFloat(coordsArray[1].trim());

        if (!isNaN(latitude) && !isNaN(longitude)) {
            // Inisialisasi peta
            var map = L.map('map').setView([latitude, longitude], 13); // Pusatkan peta pada koordinat perusahaan
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Gunakan json_encode untuk menghindari masalah dengan tanda kutip atau karakter khusus
            var companyName = <?php echo json_encode($company['companyName']); ?>;

            // Tambahkan marker pada peta
            var marker = L.marker([latitude, longitude]).addTo(map)
                .bindPopup('Perusahaan: ' + companyName)
                .openPopup();
        } else {
            console.error('Koordinat tidak valid: ' + companyCoordinates);
        }
    } else {
        console.error('Koordinat tidak ditemukan.');
    }
});
</script>

