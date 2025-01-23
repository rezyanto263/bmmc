<body>
  <div class="container">
    <!-- bagian atas -->
    <section class="bg-biru pt-3 pb-4 m-1 rounded">
      <div class="d-flex justify-content-center">
        <img src="<?= base_url("assets/images/logo.p") ?>ng" class="img-logo-profile" alt="" />
      </div>
      <div class="text-center fw-bold text-white title-profile">
        Selamat Datang
        <?= isset($employeeDatas['employeeName']) && $employeeDatas['employeeName'] ? $employeeDatas['employeeName'] : (isset($employeeDatas['familyName']) ? $employeeDatas['familyName'] : '') ?>
      </div>
      <div class="d-flex justify-content-center align-items-center">
        <button type="button" class="bg-transparent border-0 me-2" data-bs-toggle="modal"
          data-bs-target="#staticBackdrop">
          <i class="fa-solid fa-pen-to-square text-success logout text-decoration-underline">
            Update</i>
        </button>

        <a href="./logout" class="text-danger logout ms-2"><i
            class="fa-solid fa-right-from-bracket text-decoration-underline">
            Logout</i></a>
      </div>
    </section>

    <!-- bagian qr -->
    <section class="pt-5 mt-2 pb-5 position-relative">
      <!-- ornamen -->
      <img src="<?= base_url("assets/images/Ellips") ?>e 48.png" class="position-absolute top-0 d-none d-lg-block"
        style="width: 100px" alt="" />

      <img src="<?= base_url("assets/images/Vector") ?>.png" class="position-absolute top-0 d-none d-lg-block"
        style="width: 100px; left: 200px" alt="" />

      <img src="<?= base_url("assets/images/Ellips") ?>e 48.png"
        class="position-absolute bottom-0 end-0 d-none d-lg-block" style="width: 100px" alt="" />

      <img src="<?= base_url("assets/images/Vector") ?>.png" class="position-absolute bottom-0 d-none d-lg-block"
        style="width: 100px; right: 200px" alt="" />

      <!-- gambar qr -->
      <div class="d-flex justify-content-center">
        <img src="<?= base_url("assets/images/qr.png") ?>" class="img-qr" alt="" />
      </div>

      <h2 class="text-center fs-5">Barcode Keluarga Anda!</h2>
    </section>

    <!-- bagian data keluarga -->
    <section class="mt-5">
      <!-- haader -->
      <p class="me-3 fw-bold fs-5 text-lg-start text-center">
        Daftar Anggota Keluarga
      </p>

      <div class="d-flex justify-content-between flex-wrap flex-column flex-lg-row">
        <!-- card -->
        <div class="card shadow-lg rounded mb-2 p-3 pt-4">
          <?php if (!empty($employeeDatas['employeeName'])): ?>
            <p class="fw-bold text-secondary text-center text-lg-start">
              Penanggung Jawab
            </p>
          <?php else: ?>
            <p class="fw-bold text-secondary text-center text-lg-start">
              Keluarga
            </p>
          <?php endif; ?>
          <div class="d-flex align-items-center justify-content-lg-start flex-lg-row flex-column">
            <!-- gambar -->
            <div class="me-4">
              <?php if (isset($employeeDatas['employeePhoto']) && $employeeDatas['employeePhoto'] != ''): ?>
                <img src="<?= base_url('uploads/logos/' . $employeeDatas['employeePhoto']) ?>"
                  alt="Employee Photo" class="rounded-circle border border-white shadow-sm bg-hijau"
                  alt="Profile Picture" style="width: 100px; height: 100px; object-fit: cover" />
              <?php else: ?>
                <img src="<?= base_url('uploads/logos/' . $employeeDatas['familyPhoto']) ?>" alt="Default Photo"
                  class="rounded-circle border border-white shadow-sm bg-hijau" alt="Profile Picture"
                  style="width: 100px; height: 100px; object-fit: cover" />
              <?php endif; ?>
            </div>

            <!-- data-data -->
            <div>
              <table class="table table-borderless mt-3 mt-lg-0 d-flex justify-content-center align-items-center">
                <tbody>
                  <tr>
                    <td class="fw-bold">NIK</td>
                    <td>:</td>
                    <td>
                      <?= isset($employeeDatas['familyNIK']) && $employeeDatas['familyNIK'] ? $employeeDatas['familyNIK'] : (isset($employeeDatas['employeeNIK']) ? $employeeDatas['employeeNIK'] : '') ?>
                    </td>
                  </tr>
                  <tr>
                    <td class="fw-bold">Nama</td>
                    <td>:</td>
                    <td>
                      <?= isset($employeeDatas['employeeName']) && $employeeDatas['employeeName'] ? $employeeDatas['employeeName'] : (isset($employeeDatas['familyName']) ? $employeeDatas['familyName'] : '') ?>
                    </td>
                  </tr>
                  <tr>
                    <td class="fw-bold">Tanggal Lahir</td>
                    <td>:</td>
                    <td>
                      <?= isset($employeeDatas['employeeBirth']) && $employeeDatas['employeeBirth'] ? $employeeDatas['employeeBirth'] : (isset($employeeDatas['familyBirth']) ? $employeeDatas['familyBirth'] : '') ?>
                    </td>
                  </tr>
                  <tr>
                    <td class="fw-bold">Kelamin</td>
                    <td>:</td>
                    <td>
                      <?= isset($employeeDatas['employeeGender']) && $employeeDatas['employeeGender'] ? $employeeDatas['employeeGender'] : (isset($employeeDatas['familyGender']) ? $employeeDatas['familyGender'] : '') ?>
                    </td>
                  </tr>
                  <tr>
                    <td class="fw-bold">Alamat</td>
                    <td>:</td>
                    <td>
                      <?= isset($employeeDatas['employeeAddress']) && $employeeDatas['employeeAddress'] ? $employeeDatas['employeeAddress'] : (isset($employeeDatas['familyAddress']) ? $employeeDatas['familyAddress'] : '') ?>
                    </td>
                  </tr>
                  <tr>
                    <td class="fw-bold">Telepon</td>
                    <td>:</td>
                    <td>
                      <?= isset($employeeDatas['employeePhone']) && $employeeDatas['employeePhone'] ? $employeeDatas['employeePhone'] : (isset($employeeDatas['familyPhone']) ? $employeeDatas['familyPhone'] : '') ?>
                    </td>
                  </tr>
                  <tr>
                    <td class="fw-bold">Email</td>
                    <td>:</td>
                    <td>
                      <?= isset($employeeDatas['employeeEmail']) && $employeeDatas['employeeEmail'] ? $employeeDatas['employeeEmail'] : (isset($employeeDatas['familyEmail']) ? $employeeDatas['familyEmail'] : '') ?>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- card -->
        <?php if (!empty($familyMembers) && is_array($familyMembers)): ?>
          <?php foreach ($familyMembers as $index => $member): ?>
            <div class="card shadow-lg p-3 pt-4 rounded mb-2">
              <p class="fw-bold text-secondary text-center text-lg-start">
                Keluarga
              </p>
              <div class="d-flex align-items-center justify-content-lg-start flex-lg-row flex-column">
                <!-- Gambar -->
                <div class="me-4">
                  <?php
                  // Menentukan gambar berdasarkan gender
                  $image = $member['familyGender'] == 'male' ? base_url('uploads/logos/pria.png') : base_url('assets/images/wanita.png');
                  ?>
                  <img src="<?= $image; ?>"
                    class="rounded-circle border border-white shadow-sm <?= $member['familyGender'] == 'Laki-Laki' ? 'bg-hijau' : 'bg-biru'; ?>"
                    alt="Profile Picture" style="width: 100px; height: 100px; object-fit: cover" />
                </div>

                <!-- Data anggota keluarga -->
                <div>
                  <table class="table table-borderless mt-3 mt-lg-0 d-flex justify-content-center align-items-center">
                    <tbody>
                      <tr>
                        <td class="fw-bold">NIK</td>
                        <td>:</td>
                        <td><?= $member['familyNIK']; ?></td>
                      </tr>
                      <tr>
                        <td class="fw-bold">Nama</td>
                        <td>:</td>
                        <td><?= $member['familyName']; ?></td>
                      </tr>
                      <tr>
                        <td class="fw-bold">Tanggal Lahir</td>
                        <td>:</td>
                        <td><?= $member['familyBirth']; ?></td>
                      </tr>
                      <tr>
                        <td class="fw-bold">Kelamin</td>
                        <td>:</td>
                        <td><?= $member['familyGender']; ?></td>
                      </tr>
                      <tr>
                        <td class="fw-bold">Alamat</td>
                        <td>:</td>
                        <td><?= $member['familyAddress']; ?></td>
                      </tr>
                      <tr>
                        <td class="fw-bold">Telepon</td>
                        <td>:</td>
                        <td><?= $member['familyStatus']; ?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
        <?php endif; ?>
      </div>
    </section>

    <!-- bagian total total -->
    <div class="d-flex flex-column flex-lg-row justify-content-lg-between mt-5">
      <!-- bagian kiri -->
      <div class="div-total me-lg-2">
        <h3 class="fw-bold fs-5">Total Tanggungan</h3>
        <table class="table table-bordered text-center w-100">
          <thead>
            <tr>
              <th class="bg-info-subtle">Jumlah Tanggungan</th>
            </tr>
          </thead>
          <tbody>
            <tr>
            <td><?php if (!empty($insuranceData) && is_array($insuranceData)): ?>
                <p>Rp. <?php echo number_format($insuranceData['insuranceAmount'], 2, ',', '.'); ?></p>
              <?php else: ?>
                  <p>Insurance data tidak tersedia.</p>
              <?php endif; ?>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <!-- bagian kanan -->
      <div class="div-total mt-4 mt-lg-0 ms-lg-2">
        <h3 class="fw-bold fs-5">Total Tanggungan Bulan Ini</h3>
        <table class="table table-bordered text-center w-100">
          <thead>
            <tr>
              <th class="bg-info-subtle">Jumlah Tanggungan Bulan Ini</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Rp. 50.000.000,00</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- riwayat -->
  <div class="content-body py-3">
    <div class="d-flex justify-content-between align-items-end p-0 mt-4">
      <h3 class="my-0">Riwayat Berobat</h3>
    </div>
    <div class="content-body py-3">
      <div id="#crudAlert" data-flashdata="" data-errorflashdata=""></div>
      <table class="table" id="riwayatTable" style="width:100%">
        <thead>
          <tr>
            <th>#</th>
            <th>Patient Name</th>
            <th>Doctor Name</th>
            <th>Bill</th>
            <th>Date</th>
            <th>History Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>#</th>
            <th>Patient Name</th>
            <th>Doctor Name</th>
            <th>Bill</th>
            <th>Date</th>
            <th>History Status</th>
            <th>Actions</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Update Akun</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="mb-3">
              <label for="email" class="col-form-label">Email</label>
              <input type="email" class="form-control" id="email" value="igedeangga@gmail.com" />
            </div>
            <div class="mb-3">
              <label for="password" class="col-form-label">Change Password</label>
              <input type="password" class="form-control" id="password" placeholder="**********" />
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            Close
          </button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
</body>