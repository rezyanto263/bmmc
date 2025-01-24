<div class="content-body py-3">
    <div class="container mt-5">
        <!-- Hospital Card -->
        <div class="text-center">
            <!-- Logo Rumah Sakit -->
            <img src="https://th.bing.com/th/id/OIP.4Z-WeCh-EKNnE9eK8Q8j7wHaHd?rs=1&pid=ImgDetMain" 
                alt="Hospital Logo" 
                class="img-fluid mb-3 w-25">
            <h4>RSUD Kota Medan</h4>
        </div>
        <div class="d-flex justify-content-center">
            <table class="table">
                <tbody>
                    <tr>
                        <th>Alamat:</th>
                        <td>Jl. Sudirman No.123</td>
                    </tr>
                    <tr>
                        <th>Telepon:</th>
                        <td>+62 123 4567 890</td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td>info@rsudmedan.com</td>
                    </tr>
                    <tr>
                        <th>Koordinat:</th>
                        <td>1.610813, 118.163603</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="text-center mt-3">
            <button class="btn btn-primary w-25" data-bs-toggle="modal" data-bs-target="#editHospitalModal">Edit</button>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editHospitalModal" tabindex="-1" aria-labelledby="editHospitalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editHospitalModalLabel">Edit Data Rumah Sakit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <!-- Logo -->
                    <div class="text-center mb-3">
                        <img src="https://th.bing.com/th/id/OIP.4Z-WeCh-EKNnE9eK8Q8j7wHaHd?rs=1&pid=ImgDetMain" 
                            alt="Hospital Logo" 
                            class="img-thumbnail" 
                            style="max-width: 150px;">
                        <div class="mt-2">
                            <label class="btn btn-warning" for="uploadHospitalLogo">Upload Logo</label>
                            <input type="file" accept="image/*" id="uploadHospitalLogo" hidden>
                        </div>
                    </div>
                    <!-- Nama Rumah Sakit -->
                    <div class="mb-3">
                        <label for="hospitalName" class="form-label">Nama Rumah Sakit</label>
                        <input type="text" class="form-control" id="hospitalName" value="RSUD Kota Medan">
                    </div>
                    <!-- Alamat -->
                    <div class="mb-3">
                        <label for="hospitalAddress" class="form-label">Alamat</label>
                        <textarea class="form-control" id="hospitalAddress" rows="2">Jl. Sudirman No.123</textarea>
                    </div>
                    <!-- Telepon -->
                    <div class="mb-3">
                        <label for="hospitalPhone" class="form-label">Telepon</label>
                        <input type="text" class="form-control" id="hospitalPhone" value="+62 123 4567 890">
                    </div>
                    <!-- Email -->
                    <div class="mb-3">
                        <label for="hospitalEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="hospitalEmail" value="info@rsudmedan.com">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
