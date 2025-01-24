<div class="content-body py-3">
    <div class="row gy-4">
        <div class="col-12 col-lg-12 d-flex justify-content-center align-items-center order-0 order-lg-0">
            <div class="row gy-4">
                <div class="col-12 d-flex flex-column justify-content-center align-items-center position-relative bg-dark bg-opacity-50"
                    style="background-image: url('<?= base_url('uploads/logos/' . $hospital['hospitalPhoto']); ?>'); background-size: cover; 
                            background-position: center; background-repeat: no-repeat; height: 300px; border-radius: 10px;">
                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 rounded"></div>
                    <div class="imgContainer position-relative">
                        <img src="<?= base_url('uploads/logos/' . $hospital['hospitalLogo']); ?>"
                            data-originalsrc="<?= base_url('uploads/logos/' . $hospital['hospitalLogo']); ?>"
                            alt="Hospital Logo" draggable="false" id="imgPreview" data-bs-toggle="tooltip"
                            data-bs-title="Hospital Logo" class="position-relative">
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group p-0">
                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip"
                            data-bs-title="Hospital Name">
                            <i class="las la-building fs-4"></i>
                        </span>
                        <input class="form-control" type="text" placeholder="Name" name="hospitalName"
                            value="<?= $hospital['hospitalName'] ?? 'Hospital Name' ?>" disabled>
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group p-0">
                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip"
                            data-bs-title="Admin Account">
                            <i class="las la-user-cog fs-4"></i>
                        </span>
                        <input class="form-control" type="text" placeholder="Admin Account" name="adminName"
                            value="<?= $admin['adminName'] ?? 'Admin Account' ?>" disabled>
                    </div>
                </div>
                <div class="col-12 col-lg-7 col-xl-6">
                    <div class="input-group p-0">
                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip"
                            data-bs-title="Hospital Phone">
                            <i class="las la-phone fs-4"></i>
                        </span>
                        <input class="form-control phone-input" type="text" placeholder="Phone Number"
                            name="hospitalPhone" value="<?= $hospital['hospitalPhone'] ?? 'Phone Number' ?>" disabled>
                    </div>
                </div>
                <div class="col-12 col-lg-5 col-xl-6">
                    <div class="input-group p-0">
                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip"
                            data-bs-title="Hospital Status">
                            <i class="las la-tag fs-4"></i>
                        </span>
                        <div class="form-control" placeholder="Hospital Status" id="hospitalStatus">
                            <?= $hospital['hospitalStatus'] ?? 'Hospital Status' ?></div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group p-0">
                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip"
                            data-bs-title="Hospital Address">
                            <i class="las la-map fs-4"></i>
                        </span>
                        <input class="form-control" type="text" placeholder="Hospital Address" name="hospitalAddress"
                            value="<?= $hospital['hospitalAddress'] ?? 'Hospital Address' ?>" disabled>
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group p-0">
                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip"
                            data-bs-title="Hospital Coordinate">
                            <i class="las la-map-marker fs-4"></i>
                        </span>
                        <input class="form-control" type="text" placeholder="Location Coordinate"
                            name="hospitalCoordinate"
                            value="<?= $hospital['hospitalCoordinate'] ?? 'Location Coordinate' ?>" disabled>
                    </div>
                    <button class="btn btn-primary btn-edit w-100 mt-3" data-bs-toggle="modal"
                        data-bs-target="#editHospitalModal"><i class="las la-edit fs-4"></i><span>Edit</span></button>
                </div>
            </div>
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
                                    <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip"
                                        data-bs-title="Paid">
                                        <i class="las la-file-invoice-dollar text-success fs-4"></i>
                                        <span id="totalPaidInvoices"><?= $invoices['paid'] ?? 0 ?></span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip"
                                        data-bs-title="Unpaid">
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
                                    <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip"
                                        data-bs-title="Unverified">
                                        <i class="las la-user-tie text-secondary-subtl fs-4"></i>
                                        <span id="totalUnverifiedEmployees"><?= $employees['unverified'] ?? 0 ?></span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip"
                                        data-bs-title="Active">
                                        <i class="las la-user-tie text-success fs-4"></i>
                                        <span id="totalActiveEmployees"><?= $employees['active'] ?? 0 ?></span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip"
                                        data-bs-title="On Hold">
                                        <i class="las la-user-tie text-warning fs-4"></i>
                                        <span id="totalOnHoldEmployees"><?= $employees['onHold'] ?? 0 ?></span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip"
                                        data-bs-title="Discontinued">
                                        <i class="las la-user-tie text-secondary fs-4"></i>
                                        <span
                                            id="totalDiscontinuedEmployees"><?= $employees['discontinued'] ?? 0 ?></span>
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
                            <h1 class="text-center fw-bold" id="totalFamilyMembers"><?= $familyMembers['total'] ?? 0 ?>
                            </h1>
                            <div class="card-text text-center">
                                <hr>
                                <div class="d-flex justify-content-around">
                                    <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip"
                                        data-bs-title="Unverified">
                                        <i class="las la-users text-secondary-subtl fs-4"></i>
                                        <span
                                            id="totalUnverifiedFamilyMembers"><?= $familyMembers['unverified'] ?? 0 ?></span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip"
                                        data-bs-title="Active">
                                        <i class="las la-users text-success fs-4"></i>
                                        <span id="totalActiveFamilyMembers"><?= $familyMembers['active'] ?? 0 ?></span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip"
                                        data-bs-title="On Hold">
                                        <i class="las la-users text-warning fs-4"></i>
                                        <span id="totalOnHoldFamilyMembers"><?= $familyMembers['onHold'] ?? 0 ?></span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip"
                                        data-bs-title="Archived">
                                        <i class="las la-users text-secondary fs-4"></i>
                                        <span
                                            id="totalArchivedFamilyMembers"><?= $familyMembers['archived'] ?? 0 ?></span>
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
<div class="col-12 col-lg-12 d-flex justify-content-center align-items-center order-4 order-lg-1 mx-3">
    <div id="map" class="w-100 h-100" style="min-height:450px"></div>
</div>

<!-- Modal for Editing Hospital -->
<div class="modal fade" id="editHospitalModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="editHospitalForm" enctype="multipart/form-data">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">EDIT HOSPITAL</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    <div class="row gy-4">
                        <input type="hidden" name="hospitalId">
                        <div class="col-12 col-lg-6 d-flex flex-column justify-content-center align-items-center">
                            <div class="imgContainer">
                                <img src="<?= base_url('assets/images/hospital-placeholder.jpg'); ?>" data-originalsrc="<?= base_url('assets/images/hospital-placeholder.jpg'); ?>" alt="Hospital Logo" draggable="false" id="imgPreview" data-bs-toggle="tooltip" data-bs-title="Hospital Logo">
                            </div>
                            <label class="btn-warning mt-3 text-center w-50" for="editImgFile">UPLOAD LOGO</label>
                            <input type="file" accept="image/jpg, image/jpeg, image/png" name="hospitalLogo" class="imgFile" id="editImgFile" hidden>
                        </div>
                        <div class="col-12 col-lg-6 d-flex flex-column justify-content-center align-items-center">
                            <div class="imgContainer">
                                <img src="<?= base_url('assets/images/hospital-placeholder.jpg'); ?>" data-originalsrc="<?= base_url('assets/images/hospital-placeholder.jpg'); ?>" alt="Hospital Photo" draggable="false" id="imgPreview2" data-bs-toggle="tooltip" data-bs-title="Hospital Photo">
                            </div>
                            <label class="btn-warning mt-3 text-center w-50" for="editImgFile2">UPLOAD PHOTO</label>
                            <input type="file" accept="image/jpg, image/jpeg, image/png" name="hospitalPhoto" class="imgFile" id="editImgFile2" hidden>
                        </div>
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Hospital Name">
                                    <i class="las la-hospital fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Name" name="hospitalName">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">   
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Hospital Phone">
                                    <i class="las la-phone fs-4"></i>
                                </span>
                                <input class="form-control phone-input" type="text" placeholder="Phone Number" name="hospitalPhone">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">   
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Hospital Status">
                                    <i class="las la-tag fs-4"></i>
                                </span>
                                <select class="form-control" name="hospitalStatus">
                                    <option hidden></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Admin Account">
                                    <i class="las la-user-cog fs-4"></i>
                                </span>
                                <select class="form-control" data-live-search="true" title="Choose Admin" name="adminId">
                                    <option hidden></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">   
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Hospital Address">
                                    <i class="las la-map fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Address" name="hospitalAddress">
                            </div>
                        </div>
                        <div class="col-12">
                            <input class="form-check-input" type="checkbox" id="newCoordinateCheck" data-bs-toggle="tooltip" data-bs-title="Change Coordinate Checkbox">
                            <label class="form-check-label">Change coordinate?</label>
                        </div>
                        <div class="col-12" id="changeCoordinateInput">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Hospital Coordinate">
                                    <i class="las la-map-marker fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Location Coordinate" name="hospitalCoordinate">
                            </div>
                        </div>
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn-danger" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn-primary" id="editHospitalButton">SAVE</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Edit Data Hospital
    $('#editHospitalModal').on('show.bs.modal', function () {
        var data = {
            hospitalLogo: '<?= $hospital['hospitalLogo'] ?? 'default_logo.jpg' ?>',
            hospitalId: '<?= $hospital['hospitalId'] ?? '' ?>',
            hospitalName: '<?= $hospital['hospitalName'] ?? 'Hospital Name' ?>',
            hospitalPhone: '<?= $hospital['hospitalPhone'] ?? '' ?>',
            hospitalAddress: '<?= $hospital['hospitalAddress'] ?? '' ?>',
            adminId: '<?= $hospital['adminId'] ?? '' ?>',
            adminName: '<?= $hospital['adminName'] ?? '' ?>',
            adminEmail: '<?= $hospital['adminEmail'] ?? '' ?>'
        };

        if (data.hospitalLogo) {
            $('#editHospitalForm #hotelLogoPreview').attr('src', baseUrl + 'uploads/logos/' + data.hospitalLogo);
        }
        $('#editHospitalForm [name="hospitalId"]').val(data.hospitalId);
        $('#editHospitalForm [name="hospitalName"]').val(data.hospitalName);
        $('#editHospitalForm [name="hospitalPhone"]').val(data.hospitalPhone);
        $('#editHospitalForm [name="hospitalAddress"]').val(data.hospitalAddress);

        var selectedAdmin = '';
        if (data.adminId) {
            selectedAdmin = '<option value="' + data.adminId + '">' + data.adminName + ' | ' + data.adminEmail + '</option>';
        }

        $('#editHospitalForm select#adminId').html(selectedAdmin);
        $('#editHospitalForm select#adminId').select2({
            placeholder: 'Choose Admin',
            allowClear: true,
            dropdownParent: $('#editHospitalModal .modal-body'),
        });

        $.ajax({
            url: baseUrl + 'dashboard/getAllUnconnectedHospitalAdminsDatas',
            method: 'GET',
            success: function (response) {
                var res = JSON.parse(response);
                let optionList = [selectedAdmin];
                $.each(res.data, function (index, data) {
                    optionList += '<option value="' + data.adminId + '">' + data.adminName + ' | ' + data.adminEmail + '</option>';
                });

                $('#editHospitalForm select#adminId').html(optionList);
                $('#editHospitalForm select#adminId').val(data.adminId).trigger('change');
            }
        });
    });

    // Handle form submission
    $('#editHospitalForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: baseUrl + 'dashboard/companies/editHospital',
            method: 'POST',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (response) {
                var res = JSON.parse(response);
                if (res.status === 'success') {
                    $('#editHospitalModal').modal('hide');
                    reloadTableData(companiesTable);
                    displayAlert('edit success');
                } else if (res.status === 'failed') {
                    $('.error-message').remove();
                    $('.is-invalid').removeClass('is-invalid');
                    displayAlert(res.failedMsg, res.errorMsg ?? null);
                } else if (res.status === 'invalid') {
                    displayFormValidation('#editHospitalForm', res.errors);
                }
            }
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var hospitalCoordinates = "<?php echo $hospital['hospitalCoordinate']; ?>";

        if (hospitalCoordinates) {
            var coordsArray = hospitalCoordinates.split(',');
            var latitude = parseFloat(coordsArray[0].trim());
            var longitude = parseFloat(coordsArray[1].trim());

            if (!isNaN(latitude) && !isNaN(longitude)) {
                // Inisialisasi peta
                var map = L.map('map').setView([latitude, longitude], 13); // Pusatkan peta pada koordinat perusahaan
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                // Gunakan json_encode untuk menghindari masalah dengan tanda kutip atau karakter khusus
                var hospitalName = <?php echo json_encode($hospital['hospitalName']); ?>;

                // Tambahkan marker pada peta
                var marker = L.marker([latitude, longitude]).addTo(map)
                    .bindPopup('Perusahaan: ' + hospitalName)
                    .openPopup();
            } else {
                console.error('Koordinat tidak valid: ' + hospitalCoordinates);
            }
        } else {
            console.error('Koordinat tidak ditemukan.');
        }
    });
</script>