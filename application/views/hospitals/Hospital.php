<!-- logo RS -->
<div class="content-body py-3">
  <img src="https://th.bing.com/th/id/OIP.4Z-WeCh-EKNnE9eK8Q8j7wHaHd?rs=1&pid=ImgDetMain" class="img-thumbnail" style="width: 300px; height: 300px;">
</div>

<!-- informasi RS -->
<div class="mb-3">
  <label for="formGroupExampleInput" class="form-label">Nama Rumah Sakit</label>
  <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Example input placeholder" value="RSUD Kota Medan" readonly>
</div>
<div class="mb-3">
  <label for="formGroupExampleInput2" class="form-label">Alamat</label>
  <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="Another input placeholder" value="Jl. Sudirman No.123" readonly>
</div>

<!-- Embed Google Maps -->
<div class="mb-3">
  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.2416548638334!2d118.16360277477808!3d1.6108130983741944!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x320ce27bc5516d37%3A0x11637535911b3e5e!2sRumah%20Sakit%20Umum%20Daerah%20Talisayan!5e0!3m2!1sid!2sid!4v1733232246243!5m2!1sid!2sid"
    width="50%" 
    height="300" 
    style="border:0;" 
    allowfullscreen="" 
    loading="lazy" 
    referrerpolicy="no-referrer-when-downgrade">
  </iframe>
</div>

<!-- button edit -->
<div class="d-grid gap-2 col-6 mx-auto">
  <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#editHospitalModal">Edit</button>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editHospitalModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form id="editHospitalForm">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">Edit Rumah Sakit</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    <input type="text" id="HospitalEIN" name="HospitalEIN" hidden>
                    <div class="row gy-4">
                        <!-- Nama Rumah Sakit -->
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Nama Rumah Sakit">
                                    <i class="las la-hospital fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Nama Rumah Sakit" name="HospitalName" value="RSUD Kota Medan">
                            </div>
                        </div>
                        <!-- Alamat Rumah Sakit -->
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Alamat Rumah Sakit">
                                    <i class="las la-map fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Alamat Rumah Sakit" name="HospitalAddress" value="Jl. Sudirman No.123">
                            </div>
                        </div>
                        <div class="modal-footer border-0 d-flex flex-column align-items-stretch">
                              <button type="button" class="btn btn-danger mb-2" data-bs-dismiss="modal">BATAL</button>
                              <button type="submit" class="btn btn-primary" id="editButton">SIMPAN</button>
                        </div>
            </form>
        </div>
    </div>
</div>