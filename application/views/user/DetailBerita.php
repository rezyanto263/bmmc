<body class="position-relative">
  <!-- bagian utama -->
  <div
    class="d-flex justify-content-between flex-column flex-lg-row container"
  >
    <!-- berita detail -->
    <section class="mt-5 pt-5 berita-detail p-1">
      <!-- judul -->
      <div class="w-100 my-3">
        <h1 class="fw-bold">Lorem ipsum dolor sit amet.</h1>
        <!-- tambahan -->
        <div class="d-flex align-items-center flex-wrap">
          <!-- bagian waktu -->
          <div
            class="d-flex align-items-center bg-danger rounded-pill text-white my-2 my-lg-0 me-2 me-lg-0"
            style="height: 30px"
          >
            <i class="fa-solid fa-clock-rotate-left mx-2">
              <span class="fw-normal ms-1">2 Bulan yang lalu</span>
            </i>
          </div>

          <!-- bagian jenis -->
          <div
            class="mx-lg-1 d-flex align-items-center bg-success rounded-pill text-white me-lg-0"
            style="height: 30px"
          >
            <i class="fa-solid fa-circle-exclamation mx-2">
              <span class="fw-normal ms-1">Berita</span>
            </i>
          </div>

          <!-- bagian kategori -->
          <div
            class="mx-lg-1 d-flex align-items-center bg-primary rounded-pill text-white"
            style="height: 30px"
          >
            <i class="fa-solid fa-copyright mx-2">
              <span class="fw-normal ms-1">Kerjasama</span>
            </i>
          </div>
        </div>
      </div>

      <!-- gambar -->
      <div class="w-100 d-flex justify-content-center mb-3">
        <img
          src="<?= base_url('assets/images/test1.jpg');?>"
          class="object-fit-cover img-fluid"
          alt=""
        />
      </div>

      <!-- bagian deskripsi -->
      <div class="w-100" style="text-align: justify">
        <p>
          Lorem ipsum dolor sit amet consectetur, adipisicing elit. Aliquam
          sit eaque quasi cum! Atque fugiat inventore quasi quae ab maiores,
          perferendis sequi. Eius hic recusandae cupiditate iste vero
          voluptatem, obcaecati laudantium, autem odit facilis impedit
          veritatis similique totam suscipit officia quis sequi illum
          excepturi est natus ad amet sit? Excepturi?
        </p>

        <p>
          Lorem ipsum dolor sit amet consectetur, adipisicing elit. Unde quam
          veritatis sunt, deleniti architecto iure, quaerat quidem tempora
          rem, pariatur ratione itaque minima voluptatum voluptatem!
          Temporibus nihil in enim. Quaerat voluptates cumque quasi aspernatur
          placeat vel assumenda temporibus aperiam iure. In blanditiis
          aspernatur deleniti fugiat facere placeat dignissimos? Pariatur qui
          rerum totam cumque facilis unde eos hic aspernatur iusto rem
          consequuntur dolores modi obcaecati, quisquam facere nobis, labore
          ratione alias quos incidunt. Ipsam quaerat cum neque alias, sed
          distinctio qui voluptate repudiandae veritatis nihil accusamus,
          sapiente dolorum illum earum molestiae et porro excepturi eos velit
          fugiat laudantium minima exercitationem vero ex! Magnam at, numquam
          exercitationem minima mollitia nam hic quas expedita omnis atque
          earum dolore, quos recusandae dolorum accusantium tempore sunt sint
          perspiciatis sed ad beatae facere aliquid ipsam suscipit! Possimus
          porro quis qui voluptas nemo sequi atque quo, unde corporis? Quis
          natus, a beatae vitae optio eligendi nesciunt quasi impedit odit,
          sit illum voluptatem soluta officiis? Ducimus laudantium quaerat vel
          molestiae praesentium laborum, aut mollitia corrupti id eius impedit
          aliquid incidunt nostrum, temporibus maxime, distinctio enim
          doloribus omnis ullam harum consequatur? Commodi voluptates odio
          numquam exercitationem, nisi totam! Perspiciatis ut dignissimos
          similique alias quis ratione, vel ipsam eveniet debitis nam
          doloribus rem optio incidunt dolore voluptatum laborum? Blanditiis
          explicabo corporis laboriosam eaque ab magni non, quod voluptatibus
          esse quia animi voluptate similique aperiam saepe. Molestiae dolorem
          architecto molestias earum eius officiis repellendus iusto
          consequatur laboriosam nobis, atque non, quasi esse! Optio quos
          libero quia dolor voluptate provident natus laborum omnis. Numquam,
          expedita consectetur! Facere, sequi doloribus amet, quia aliquam
          delectus autem maxime at suscipit, soluta corporis nisi. Excepturi,
          dicta quibusdam placeat suscipit neque at aliquid. Rerum saepe
          labore magnam quod blanditiis earum dolorum nihil, consectetur
          praesentium animi vero illum quasi dolorem perferendis ratione quia.
          Harum, ex. Labore, iure voluptatum? Molestias, saepe? Excepturi quis
          in exercitationem delectus expedita soluta ex necessitatibus nostrum
          assumenda deleniti explicabo illo vero at omnis accusantium nam ea,
          quas porro debitis esse repellendus ipsa illum maxime laborum?
          Voluptatibus excepturi, quasi tenetur dolorum sunt temporibus ad,
          cupiditate quam esse perferendis eius id iure suscipit minus
          blanditiis, nam numquam eos laborum officia ratione ullam
          distinctio? Repellat, reiciendis velit, consequatur repudiandae,
          voluptas libero neque a fugiat aut atque sit architecto aperiam
          sequi dolorum similique repellendus praesentium amet voluptates fuga
          iusto? At accusamus nemo odit qui ex modi cum non, dolore doloremque
          beatae dolor culpa accusantium quisquam sequi exercitationem
          perspiciatis?
        </p>
      </div>

      <!-- tombol back -->
      <div class="mb-3 mt-4 button-berita-all shadow">
        <i class="fa-solid fa-arrow-left ms-3 me-2"></i>
        <a class="" href="<?=base_url('user/ListBerita');?>" role="button">Kembali</a>
      </div>
    </section>

    <!-- rekomendasi -->
    <div class="rekomendasi mt-3 mt-lg-5 pt-lg-5 px-2">
      <h3 class="fw-bold mt-3 border-bottom border-secondary pb-3">
        Info Sejenis
      </h3>

      <!-- card -->
      <div class="border-bottom border-secondary pb-1 mb-2">
        <!-- icon -->
        <div
          class="d-flex align-items-center text-secondary"
          style="height: 30px"
        >
          <i class="fa-solid fa-clock-rotate-left me-2">
            <span class="fw-normal ms-1">2 Bulan yang lalu</span>
          </i>
        </div>

        <!-- body card -->
        <div class="d-flex justify-content-between">
          <div class="w-50">
            <img
              src="<?= base_url('assets/images/test2.jpg');?>"
              alt=""
              class="img-fluid object-fit-cover"
            />
          </div>
          <span class="ms-1">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit.
            Quibusdam, soluta.
          </span>
        </div>
      </div>

      <!-- card -->
      <div class="border-bottom border-secondary pb-1 mb-2">
        <!-- icon -->
        <div
          class="d-flex align-items-center text-secondary"
          style="height: 30px"
        >
          <i class="fa-solid fa-clock-rotate-left me-2">
            <span class="fw-normal ms-1">2 Bulan yang lalu</span>
          </i>
        </div>

        <!-- body card -->
        <div class="d-flex justify-content-between">
          <div class="w-50">
            <img
              src="<?= base_url('assets/images/test2.jpg');?>"
              alt=""
              class="img-fluid object-fit-cover"
            />
          </div>
          <span class="ms-1">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit.
            Quibusdam, soluta.
          </span>
        </div>
      </div>

      <!-- card -->
      <div class="border-bottom border-secondary pb-1 mb-2">
        <!-- icon -->
        <div
          class="d-flex align-items-center text-secondary"
          style="height: 30px"
        >
          <i class="fa-solid fa-clock-rotate-left me-2">
            <span class="fw-normal ms-1">2 Bulan yang lalu</span>
          </i>
        </div>

        <!-- body card -->
        <div class="d-flex justify-content-between">
          <div class="w-50">
            <img
              src="<?= base_url('assets/images/test2.jpg');?>"
              alt=""
              class="img-fluid object-fit-cover"
            />
          </div>
          <span class="ms-1">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit.
            Quibusdam, soluta.
          </span>
        </div>
      </div>

      <!-- card -->
      <div class="border-bottom border-secondary pb-1 mb-2">
        <!-- icon -->
        <div
          class="d-flex align-items-center text-secondary"
          style="height: 30px"
        >
          <i class="fa-solid fa-clock-rotate-left me-2">
            <span class="fw-normal ms-1">2 Bulan yang lalu</span>
          </i>
        </div>

        <!-- body card -->
        <div class="d-flex justify-content-between">
          <div class="w-50">
            <img
              src="<?= base_url('assets/images/test2.jpg');?>"
              alt=""
              class="img-fluid object-fit-cover"
            />
          </div>
          <span class="ms-1">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit.
            Quibusdam, soluta.
          </span>
        </div>
      </div>

      <!-- card -->
      <div class="border-bottom border-secondary pb-1 mb-2">
        <!-- icon -->
        <div
          class="d-flex align-items-center text-secondary"
          style="height: 30px"
        >
          <i class="fa-solid fa-clock-rotate-left me-2">
            <span class="fw-normal ms-1">2 Bulan yang lalu</span>
          </i>
        </div>

        <!-- body card -->
        <div class="d-flex justify-content-between">
          <div class="w-50">
            <img
              src="<?= base_url('assets/images/test2.jpg');?>"
              alt=""
              class="img-fluid object-fit-cover"
            />
          </div>
          <span class="ms-1">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit.
            Quibusdam, soluta.
          </span>
        </div>
      </div>

      <!-- card -->
      <div class="border-bottom border-secondary pb-1 mb-2">
        <!-- icon -->
        <div
          class="d-flex align-items-center text-secondary"
          style="height: 30px"
        >
          <i class="fa-solid fa-clock-rotate-left me-2">
            <span class="fw-normal ms-1">2 Bulan yang lalu</span>
          </i>
        </div>

        <!-- body card -->
        <div class="d-flex justify-content-between">
          <div class="w-50">
            <img
              src="<?= base_url('assets/images/test2.jpg');?>"
              alt=""
              class="img-fluid object-fit-cover"
            />
          </div>
          <span class="ms-1">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit.
            Quibusdam, soluta.
          </span>
        </div>
      </div>

      <!-- card -->
      <div class="border-bottom border-secondary pb-1 mb-2">
        <!-- icon -->
        <div
          class="d-flex align-items-center text-secondary"
          style="height: 30px"
        >
          <i class="fa-solid fa-clock-rotate-left me-2">
            <span class="fw-normal ms-1">2 Bulan yang lalu</span>
          </i>
        </div>

        <!-- body card -->
        <div class="d-flex justify-content-between">
          <div class="w-50">
            <img
              src="<?= base_url('assets/images/test2.jpg');?>"
              alt=""
              class="img-fluid object-fit-cover"
            />
          </div>
          <span class="ms-1">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit.
            Quibusdam, soluta.
          </span>
        </div>
      </div>

      <!-- card -->
      <div class="border-bottom border-secondary pb-1 mb-2">
        <!-- icon -->
        <div
          class="d-flex align-items-center text-secondary"
          style="height: 30px"
        >
          <i class="fa-solid fa-clock-rotate-left me-2">
            <span class="fw-normal ms-1">2 Bulan yang lalu</span>
          </i>
        </div>

        <!-- body card -->
        <div class="d-flex justify-content-between">
          <div class="w-50">
            <img
              src="<?= base_url('assets/images/test2.jpg');?>"
              alt=""
              class="img-fluid object-fit-cover"
            />
          </div>
          <span class="ms-1">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit.
            Quibusdam, soluta.
          </span>
        </div>
      </div>
    </div>
  </div>
</body>

