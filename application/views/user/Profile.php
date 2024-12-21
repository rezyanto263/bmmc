<body>
  <div class="container">
    <!-- bagian atas -->
    <section class="bg-biru pt-3 pb-4 m-1 rounded">
      <div class="d-flex justify-content-center">
        <img src="<?= base_url('assets/images/logo.png')?>" class="img-logo-profile" alt="" />
      </div>
      <div class="text-center fw-bold text-white title-profile">
        Selamat Datang Angga Prayoga
      </div>
      <div class="d-flex justify-content-center align-items-center">
        <button
          type="button"
          class="bg-transparent border-0 me-2"
          data-bs-toggle="modal"
          data-bs-target="#staticBackdrop"
        >
          <i
            class="fa-solid fa-pen-to-square text-success logout text-decoration-underline"
          >
            Update</i
          >
        </button>

        <a href="<?=base_url('user/LandingPage');?>" class="text-danger logout ms-2"
          ><i
            class="fa-solid fa-right-from-bracket text-decoration-underline"
          >
            Logout</i
          ></a
        >
      </div>
    </section>

    <!-- bagian qr -->
    <section class="pt-5 mt-2 pb-5 position-relative">
      <!-- ornamen -->
      <img
        src="<?= base_url('assets/images/Ellipse ')?>48.png"
        class="position-absolute top-0 d-none d-lg-block"
        style="width: 100px"
        alt=""
      />

      <img
        src="<?= base_url('assets/images/Vector.p')?>ng"
        class="position-absolute top-0 d-none d-lg-block"
        style="width: 100px; left: 200px"
        alt=""
      />

      <img
        src="<?= base_url('assets/images/Ellipse ')?>48.png"
        class="position-absolute bottom-0 end-0 d-none d-lg-block"
        style="width: 100px"
        alt=""
      />

      <img
        src="<?= base_url('assets/images/Vector.p')?>ng"
        class="position-absolute bottom-0 d-none d-lg-block"
        style="width: 100px; right: 200px"
        alt=""
      />

      <!-- gambar qr -->
      <div class="d-flex justify-content-center">
        <img src="<?= base_url('assets/images/qr.png" ')?>class="img-qr" alt="" />
      </div>

      <h2 class="text-center fs-5">Barcode Keluarga Anda!</h2>
    </section>

    <!-- bagian data keluarga -->
    <section class="mt-5">
      <!-- haader -->
      <p class="me-3 fw-bold fs-5 text-lg-start text-center">
        Daftar Anggota Keluarga
      </p>

      <div
        class="d-flex justify-content-between flex-wrap flex-column flex-lg-row"
      >
        <!-- card -->
        <div class="card shadow-lg rounded mb-2 p-3 pt-4">
          <div
            class="d-flex align-items-center justify-content-lg-start flex-lg-row flex-column"
          >
            <!-- gambar -->
            <div class="me-4">
              <img
                src="<?= base_url('assets/images/pria.png')?>"
                class="rounded-circle border border-white shadow-sm bg-hijau"
                alt="Profile Picture"
                style="width: 100px; height: 100px; object-fit: cover"
              />
            </div>

            <!-- data-data -->
            <div>
              <table
                class="table table-borderless mt-3 mt-lg-0 d-flex justify-content-center align-items-center"
              >
                <tbody>
                  <tr>
                    <td class="fw-bold">NIK</td>
                    <td>:</td>
                    <td>51727273810231031</td>
                  </tr>
                  <tr>
                    <td class="fw-bold">Nama</td>
                    <td>:</td>
                    <td>I Gede Angga Prayoga</td>
                  </tr>
                  <tr>
                    <td class="fw-bold">Tanggal Lahir</td>
                    <td>:</td>
                    <td>22 November 1999</td>
                  </tr>
                  <tr>
                    <td class="fw-bold">Kelamin</td>
                    <td>:</td>
                    <td>Laki - Laki</td>
                  </tr>
                  <tr>
                    <td class="fw-bold">Alamat</td>
                    <td>:</td>
                    <td>
                      Jl. Tukad Balian No.126, Renon, Denpasar Selatan, Kota
                      Denpasar, Bali 80225
                    </td>
                  </tr>
                  <tr>
                    <td class="fw-bold">Telepon</td>
                    <td>:</td>
                    <td>0812-3456-7890</td>
                  </tr>
                  <tr>
                    <td class="fw-bold">Email</td>
                    <td>:</td>
                    <td>igedeangga@gmail.com</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- card -->
        <div class="card shadow-lg p-3 pt-4 rounded mb-2">
          <div
            class="d-flex align-items-center justify-content-lg-start flex-lg-row flex-column"
          >
            <!-- gambar -->
            <div class="me-4">
              <img
                src="<?= base_url('assets/images/wanita.p')?>ng"
                class="rounded-circle border border-white shadow-sm bg-biru"
                alt="Profile Picture"
                style="width: 100px; height: 100px; object-fit: cover"
              />
            </div>

            <!-- data-data -->
            <div>
              <table
                class="table table-borderless mt-3 mt-lg-0 d-flex justify-content-center align-items-center"
              >
                <tbody>
                  <tr>
                    <td class="fw-bold">NIK</td>
                    <td>:</td>
                    <td>51727273810231031</td>
                  </tr>
                  <tr>
                    <td class="fw-bold">Nama</td>
                    <td>:</td>
                    <td>Kevin Bin Susanti</td>
                  </tr>
                  <tr>
                    <td class="fw-bold">Tanggal Lahir</td>
                    <td>:</td>
                    <td>22 November 1999</td>
                  </tr>
                  <tr>
                    <td class="fw-bold">Kelamin</td>
                    <td>:</td>
                    <td>Perempuan</td>
                  </tr>
                  <tr>
                    <td class="fw-bold">Alamat</td>
                    <td>:</td>
                    <td>
                      Jl. Tukad Balian No.126, Renon, Denpasar Selatan, Kota
                      Denpasar, Bali 80225
                    </td>
                  </tr>
                  <tr>
                    <td class="fw-bold">Telepon</td>
                    <td>:</td>
                    <td>0812-3456-7890</td>
                  </tr>
                  <tr>
                    <td class="fw-bold">Email</td>
                    <td>:</td>
                    <td>igedeangga@gmail.com</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- card -->
        <div class="card shadow-lg p-3 pt-4 rounded mb-2">
          <div
            class="d-flex align-items-center justify-content-lg-start flex-lg-row flex-column"
          >
            <!-- gambar -->
            <div class="me-4">
              <img
                src="<?= base_url('assets/images/wanita.p')?>ng"
                class="rounded-circle border border-white shadow-sm bg-biru"
                alt="Profile Picture"
                style="width: 100px; height: 100px; object-fit: cover"
              />
            </div>

            <!-- data-data -->
            <div>
              <table
                class="table table-borderless mt-3 mt-lg-0 d-flex justify-content-center align-items-center"
              >
                <tbody>
                  <tr>
                    <td class="fw-bold">NIK</td>
                    <td>:</td>
                    <td>51727273810231031</td>
                  </tr>
                  <tr>
                    <td class="fw-bold">Nama</td>
                    <td>:</td>
                    <td>Wiriawan Bin Meimei</td>
                  </tr>
                  <tr>
                    <td class="fw-bold">Tanggal Lahir</td>
                    <td>:</td>
                    <td>22 November 1999</td>
                  </tr>
                  <tr>
                    <td class="fw-bold">Kelamin</td>
                    <td>:</td>
                    <td>Perempuan</td>
                  </tr>
                  <tr>
                    <td class="fw-bold">Alamat</td>
                    <td>:</td>
                    <td>
                      Jl. Tukad Balian No.126, Renon, Denpasar Selatan, Kota
                      Denpasar, Bali 80225
                    </td>
                  </tr>
                  <tr>
                    <td class="fw-bold">Telepon</td>
                    <td>:</td>
                    <td>0812-3456-7890</td>
                  </tr>
                  <tr>
                    <td class="fw-bold">Email</td>
                    <td>:</td>
                    <td>igedeangga@gmail.com</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- card -->
        <div class="card shadow-lg p-3 pt-4 rounded mb-2">
          <div
            class="d-flex align-items-center justify-content-lg-start flex-lg-row flex-column"
          >
            <!-- gambar -->
            <div class="me-4">
              <img
                src="<?= base_url('assets/images/pria.png')?>"
                class="rounded-circle border border-white shadow-sm bg-hijau"
                alt="Profile Picture"
                style="width: 100px; height: 100px; object-fit: cover"
              />
            </div>

            <!-- data-data -->
            <div>
              <table
                class="table table-borderless mt-3 mt-lg-0 d-flex justify-content-center align-items-center"
              >
                <tbody>
                  <tr>
                    <td class="fw-bold">NIK</td>
                    <td>:</td>
                    <td>51727273810231031</td>
                  </tr>
                  <tr>
                    <td class="fw-bold">Nama</td>
                    <td>:</td>
                    <td>Sagita Bin Juno</td>
                  </tr>
                  <tr>
                    <td class="fw-bold">Tanggal Lahir</td>
                    <td>:</td>
                    <td>22 November 1999</td>
                  </tr>
                  <tr>
                    <td class="fw-bold">Kelamin</td>
                    <td>:</td>
                    <td>Laki - Laki</td>
                  </tr>
                  <tr>
                    <td class="fw-bold">Alamat</td>
                    <td>:</td>
                    <td>
                      Jl. Tukad Balian No.126, Renon, Denpasar Selatan, Kota
                      Denpasar, Bali 80225
                    </td>
                  </tr>
                  <tr>
                    <td class="fw-bold">Telepon</td>
                    <td>:</td>
                    <td>0812-3456-7890</td>
                  </tr>
                  <tr>
                    <td class="fw-bold">Email</td>
                    <td>:</td>
                    <td>igedeangga@gmail.com</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- bagian total total -->
    <div
      class="d-flex flex-column flex-lg-row justify-content-lg-between mt-5"
    >
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
              <td>Rp. 50.000.000,00</td>
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

    <!-- riwayat -->
    <div class="mt-5 mb-5">
      <h3 class="fs-5 fw-bold">Riwayat</h3>
      <div class="w-100">
        <div class="table-responsive">
          <table class="table table-hover table-bordered w-100">
            <thead>
              <tr>
                <th scope="col" class="bg-info-subtle text-nowrap">No</th>
                <th
                  scope="col"
                  class="bg-info-subtle text-nowrap"
                  style="padding-right: 400px"
                >
                  Jenis Tindakan
                </th>
                <th scope="col" class="bg-info-subtle text-nowrap">Nama</th>
                <th scope="col" class="bg-info-subtle text-nowrap">
                  Tanggal
                </th>
                <th scope="col" class="bg-info-subtle text-nowrap">Dokter</th>
                <th scope="col" class="bg-info-subtle text-nowrap">Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td scope="row">1</td>
                <td class="align-middle">
                  Tangan Pegal Akibat Joki Tangan Pegal Akibat Joki Tangan
                  Pegal Akibat Joki
                </td>
                <td class="text-nowrap align-middle">I Gede Angga Prayoga</td>
                <td class="text-nowrap align-middle">22 November 2020</td>
                <td class="text-nowrap align-middle">
                  Willy Calvin Candra Lay
                </td>
                <td class="text-nowrap align-middle">Berhasil Terobati</td>
              </tr>
              <tr>
                <td scope="row">2</td>
                <td class="align-middle">
                  Tangan Pegal Dan Hampir Patah Akibat Coli
                </td>
                <td class="text-nowrap align-middle">Kevin Bin Susanti</td>
                <td class="text-nowrap align-middle">25 November 2020</td>
                <td class="text-nowrap align-middle">Anak Agung Dwitya</td>
                <td class="text-nowrap align-middle">Gagal Terobati</td>
              </tr>
              <tr>
                <td scope="row">3</td>
                <td class="align-middle">
                  Hampir Meninggal, Akibat Halu Masuk Isekai
                </td>
                <td class="text-nowrap align-middle">Wiriawan Bin Meimei</td>
                <td class="text-nowrap align-middle">30 November 2020</td>
                <td class="text-nowrap align-middle">Anak Agung Dwitya</td>
                <td class="text-nowrap align-middle">Berhasil Terobati</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div
    class="modal fade"
    id="staticBackdrop"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Update Akun</h1>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="mb-3">
              <label for="email" class="col-form-label">Email</label>
              <input
                type="email"
                class="form-control"
                id="email"
                value="igedeangga@gmail.com"
              />
            </div>
            <div class="mb-3">
              <label for="password" class="col-form-label"
                >Change Passowrd</label
              >
              <input
                type="password"
                class="form-control"
                id="password"
                placeholder="**********"
              />
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal"
          >
            Close
          </button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
</body>
