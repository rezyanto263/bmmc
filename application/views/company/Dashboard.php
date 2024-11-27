<div class="content-body py-3">
    <div class="container mt-5">
        <!-- Hotel Card -->
        <div class="card">
            <div class="card-header text-center">
                <!-- Logo Hotel -->
                <img src="<?= base_url('uploads/logos/' . $company['companyLogo']); ?>" alt="Hotel Logo" class="img-fluid mb-3" style="max-height: 150px;">
                <h4><?= $company['companyName'] ?? 'Hotel Name' ?></h4>
            </div>
            <div class="card-body">
                <table class="table">
                    <tbody>
                        <tr>
                            <th>Alamat:</th>
                            <td><?= $company['companyAddress'] ?? 'Jalan Contoh No.123, Kota ABC' ?></td>
                        </tr>
                        <tr>
                            <th>Telepon:</th>
                            <td><?= $company['companyPhone'] ?? '+62 123 4567 890' ?></td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td><?= $company['adminEmail'] ?? 'info@hotel.com' ?></td>
                        </tr>
                        <tr>
                            <th>Fasilitas:</th>
                            <td><?= $company['companyFacilities'] ?? 'WiFi, Kolam Renang, Restoran, Gym' ?></td>
                        </tr>
                    </tbody>
                </table>
                <button class="btn btn-primary btn-edit" data-bs-toggle="modal" data-bs-target="#editHotelModal">Edit</button>
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
